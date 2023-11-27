<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    function residentChat() {
        Chat::where('receiver_id', '=', auth()->id())
            ->where('status', '=', 'sent')
            ->update(['status' => 'received']);

        $messages = Chat::where('sender_id', '=', auth()->id())
                        ->orWhere('receiver_id', '=', auth()->id())
                        ->get();
        
        return view('resident/chat/chat', compact('messages'));
    }

    function residentSendMessage(Request $request) {
        Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => 1,
            'message' => $request->message,
            'status' => 'sent',
        ]);
        
        return redirect(route('resident-chat'));
    }

    function adminMessages() {
        $users = Student::join('chats', function ($join) {
            $join->on('chats.receiver_id', '=', 'students.user_id')
            ->orOn('chats.sender_id', '=', 'students.user_id');
        })
        ->distinct('user_id')
        ->pluck('students.user_id')
        ->toArray();

        $residents = Student::join('users','users.id', '=', 'students.user_id')
                            ->join('registrations', function ($join) {
                                $join->on('registrations.student_id', '=', 'students.student_id')
                                    ->where('registrations.registration_id', '=', function ($subquery) {
                                        $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                            ->from('registrations')
                                            ->whereRaw('registrations.student_id = students.student_id');
                                    });
                            })
                            ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                            ->whereIn('users.id', $users)
                            ->select('users.id as user_id',
                                     'users.name as name',
                                     'students.gender as gender',
                                     'rooms.room_code as room_code')
                            ->get();

        $chats = Chat::whereIn('receiver_id', $users)
                     ->orWhereIn('sender_id', $users)
                     ->get();

        Chat::where('receiver_id', '=', 1)
            ->where('sender_id', '=', $users[0])
            ->where('status', '=', 'sent')
            ->update(['status' => 'received']);

        $messages = Chat::where('receiver_id', '=', $users[0])
                        ->orWhere('sender_id', '=', $users[0])
                        ->get();
                        
        $user = $residents[0];
        
        return view('admin/message/messages', compact('residents', 'chats', 'messages', 'user'));
    }

    function selectUser(Request $request) {
        $users = Student::join('chats', function ($join) {
            $join->on('chats.receiver_id', '=', 'students.user_id')
            ->orOn('chats.sender_id', '=', 'students.user_id');
        })
        ->distinct('user_id')
        ->pluck('students.user_id')
        ->toArray();

        $residents = Student::join('users','users.id', '=', 'students.user_id')
                            ->join('registrations', function ($join) {
                                $join->on('registrations.student_id', '=', 'students.student_id')
                                    ->where('registrations.registration_id', '=', function ($subquery) {
                                        $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                            ->from('registrations')
                                            ->whereRaw('registrations.student_id = students.student_id');
                                    });
                            })
                            ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                            ->whereIn('users.id', $users)
                            ->select('users.id as user_id',
                                     'users.name as name',
                                     'students.gender as gender',
                                     'rooms.room_code as room_code')
                            ->get();

        $chats = Chat::whereIn('receiver_id', $users)
                     ->orWhereIn('sender_id', $users)
                     ->get();
        
        Chat::where('receiver_id', '=', 1)
            ->where('sender_id', '=',  $request->user)
            ->where('status', '=', 'sent')
            ->update(['status' => 'received']);

        $messages = Chat::where('receiver_id', '=', $request->user)
                        ->orWhere('sender_id', '=', $request->user)
                        ->get();
                        
        $user = Student::join('users','users.id', '=', 'students.user_id')
                       ->join('registrations', function ($join) {
                           $join->on('registrations.student_id', '=', 'students.student_id')
                               ->where('registrations.registration_id', '=', function ($subquery) {
                                   $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                       ->from('registrations')
                                       ->whereRaw('registrations.student_id = students.student_id');
                               });
                       })
                       ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                       ->where('users.id', '=', $request->user)
                       ->select('users.id as user_id',
                                'users.name as name',
                                'students.gender as gender',
                                'rooms.room_code as room_code')
                       ->first();
        
        return view('admin/message/messages', compact('residents', 'chats', 'messages', 'user'));
    }

    function adminSendMessage(Request $request) {
        Chat::create([
            'sender_id' => 1,
            'receiver_id' => $request->user_id,
            'message' => $request->message,
            'status' => 'sent',
        ]);
        
        $users = Student::join('chats', function ($join) {
            $join->on('chats.receiver_id', '=', 'students.user_id')
            ->orOn('chats.sender_id', '=', 'students.user_id');
        })
        ->distinct('user_id')
        ->pluck('students.user_id')
        ->toArray();

        $residents = Student::join('users','users.id', '=', 'students.user_id')
                            ->join('registrations', function ($join) {
                                $join->on('registrations.student_id', '=', 'students.student_id')
                                    ->where('registrations.registration_id', '=', function ($subquery) {
                                        $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                            ->from('registrations')
                                            ->whereRaw('registrations.student_id = students.student_id');
                                    });
                            })
                            ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                            ->whereIn('users.id', $users)
                            ->select('users.id as user_id',
                                     'users.name as name',
                                     'students.gender as gender',
                                     'rooms.room_code as room_code')
                            ->get();

        $chats = Chat::whereIn('receiver_id', $users)
                     ->orWhereIn('sender_id', $users)
                     ->get();

        $messages = Chat::where('receiver_id', '=', $request->user_id)
                        ->orWhere('sender_id', '=', $request->user_id)
                        ->get();
                        
        $user = Student::join('users','users.id', '=', 'students.user_id')
                       ->join('registrations', function ($join) {
                           $join->on('registrations.student_id', '=', 'students.student_id')
                               ->where('registrations.registration_id', '=', function ($subquery) {
                                   $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                       ->from('registrations')
                                       ->whereRaw('registrations.student_id = students.student_id');
                               });
                       })
                       ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                       ->where('users.id', '=', $request->user_id)
                       ->select('users.id as user_id',
                                'users.name as name',
                                'students.gender as gender',
                                'rooms.room_code as room_code')
                       ->first();
        
        return view('admin/message/messages', compact('residents', 'chats', 'messages', 'user'));
    }

    function searchChat(Request $request){
        $users = Student::join('chats', function ($join) {
            $join->on('chats.receiver_id', '=', 'students.user_id')
            ->orOn('chats.sender_id', '=', 'students.user_id');
        })
        ->distinct('user_id')
        ->pluck('students.user_id')
        ->toArray();

        $residents = Student::join('users','users.id', '=', 'students.user_id')
                            ->join('registrations', function ($join) {
                                $join->on('registrations.student_id', '=', 'students.student_id')
                                    ->where('registrations.registration_id', '=', function ($subquery) {
                                        $subquery->select(DB::raw('MAX(registrations.registration_id)'))
                                            ->from('registrations')
                                            ->whereRaw('registrations.student_id = students.student_id');
                                    });
                            })
                            ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                            ->where('users.name', 'like', '%' . $request->search . '%')
                            ->orWhere('rooms.room_code', 'like', '%' . $request->search . '%')
                            ->select('users.id as user_id',
                                     'users.name as name',
                                     'students.gender as gender',
                                     'rooms.room_code as room_code')
                            ->get();

        $chats = Chat::whereIn('receiver_id', $users)
                     ->orWhereIn('sender_id', $users)
                     ->get();

        if (!$residents->isEmpty()) {
            $messages = Chat::where('receiver_id', '=', $residents[0]->user_id)
                            ->orWhere('sender_id', '=', $residents[0]->user_id)
                            ->get();
            $user = $residents[0];
        } else {
            $messages = '';
            $user = '';
        }
                        
        
        
        return view('admin/message/messages', compact('residents', 'chats', 'messages', 'user'));
    }
}
