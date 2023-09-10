<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Semester;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function payment($id)
    {
        $registration = Registration::find($id);
        $semester = Semester::where('semester_id', $registration->semester_id)
                            ->select('price')
                            ->first();
        $amount = $semester->price;

        if(auth()->user()->role === 0) {
            return view('non-resident/payment/payment', compact('id', 'amount'));
        } else {
            return view('resident/payment/payment', compact('id', 'amount'));
        }
    }

    public function paymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $id = $request->id;
        $amount = $request->amount;

        if ($request->payment_method == "Card") {
            if(auth()->user()->role === 0) {
                return view('non-resident/payment/cardPayment', compact('id', 'amount'));
            } else {
                return view('resident/payment/cardPayment', compact('id', 'amount'));
            }
        } else if ($request->payment_method == "Online Banking") {
            if(auth()->user()->role === 0) {
                return view('non-resident/payment/onlineBanking', compact('id', 'amount'));
            } else {
                return view('resident/payment/onlineBanking', compact('id', 'amount'));
            }
        } else {
            if(auth()->user()->role === 0) {
                return view('non-resident/payment/ewallet', compact('id', 'amount'));
            } else {
                return view('resident/payment/ewallet', compact('id', 'amount'));
            }
        }
    }

    public function completePayment(Request $request)
    {
        
        $payment_data['registration_id'] = $request->id;
        $payment_data['payment_method'] = $request->payment_method;
        $payment_data['amount'] = $request->amount;
        $payment = Payment::create($payment_data);

        $receipt_no = 'R-'. str_pad($payment->payment_id, 6, '0', STR_PAD_LEFT);
        $payment->update(['receipt_no' => $receipt_no]);

        $registration = Registration::find($request->id);
        
        if(auth()->user()->role === 0) {
            $registration->update(['status' => "Payment Completed"]);
            return redirect(route('non-resident-approval', ['id'=>$request->id]))->with("success", "Payment Successfully");
        } else {
            //status direct become checked in if is extension registration
            $registration->update(['status' => "Checked In"]);

            $prevRegistration = Registration::where('student_id', $registration->student_id)
                              ->orderBy('registration_id', 'desc')
                              ->skip(1) // Skip the first registration (newest)
                              ->take(1) // Take only one registration (second newest)
                              ->first();
            
            $prevRegistration->update(['status' => "Extended"]);

            return redirect(route('resident-registrationDetails', ['id'=>$request->id]))->with("success", "Payment Successfully");
        }
    }

    public function generateReceipt($id) 
    {
        $payment = Payment::where('payments.registration_id', $id)
                 ->join('registrations', 'registrations.registration_id', '=', 'payments.registration_id')
                 ->join('students', 'registrations.student_id', '=', 'students.student_id')
                 ->join('users', 'students.user_id', '=', 'users.id')
                 ->select('payments.receipt_no as receipt_no',
                          'payments.amount as amount',
                          'payments.payment_method as payment_method',
                          'payments.created_at as payment_date',
                          'registrations.registration_type as description', 
                          'users.name as name')
                ->first();

        return view('receipt', compact('payment'));
    }
}
