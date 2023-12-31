<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\User;
use App\Models\Student;
use App\Models\Registration;
use App\Models\Room;
use App\Mail\AnnouncementMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    function addAnnouncement(){
        $blocks = Block::get();
        return view('admin/announcement/addAnnouncement', ['blocks' => $blocks]);
    }

    function addAnnouncementPost(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'publicity' => 'required',
            'announced_block' => 'required',
            'announced_gender' => 'required'
        ]);

        // Store the uploaded file
        $directoryPath = public_path('images/announcement');
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $fileName = 'announcement_' . time() . '.' . $extension;
        $file->move($directoryPath, $fileName);

        // send email notification if required
        if($request->has('email_notification')) {
            // send to all residents at certain block
            if ($request->announced_block != 'All') {
                $emails = User::join('students', 'students.user_id', '=', 'users.id')
                              ->join('registrations', 'registrations.student_id', '=', 'students.student_id')
                              ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                              ->join('blocks', 'blocks.block_id', '=', 'rooms.block_id')
                              ->where('blocks.block_name', '=', $request->announced_block)
                              ->pluck('users.email as email')
                              ->toArray();

            // sent to all residents with certain gender
            } else if ($request->announced_gender != 'All') {
                $emails = User::join('students', 'students.user_id', '=', 'users.id')
                              ->where('students.gender', '=', $request->announced_gender)
                              ->pluck('users.email as email')
                              ->toArray();

            // send to all residents
            } else {
                $emails = User::where('role', '=', '1')->pluck('email')->toArray();
            }

            if($emails) {
                $data = [
                        "subject"=>"New Announcement from TARUMT Hostel",
                        "title"=>$request->title,
                        "content"=>$request->content,
                        ];

                // Assuming $emails is an array of email addresses
                $batchSize = 50; // Adjust this value based on the maximum recipients allowed by your email provider

                $chunks = array_chunk($emails, $batchSize);

                foreach ($chunks as $chunk) {
                    Mail::to($chunk)->send(new AnnouncementMail($data));
                    
                    // Add a delay between batches to avoid rate limiting
                    usleep(500000); // Sleep for 0.5 seconds (adjust as needed)
                }
            }
        }
        
        // new announcement
        $newAnnouncement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $fileName,
            'publicity' => $request->publicity,
            'announced_block' => $request->announced_block,
            'announced_gender' => $request->announced_gender,
        ]);

        return redirect(route('admin-announcementDetails', ['id'=>$newAnnouncement->announcement_id]))->with("success", "New announcement has been added successfully!");
    }

    function announcementList(){
        // get announcements
        $announcements = Announcement::orderBy('announcement_id', 'desc')
                                     ->paginate(10);
                        
        return view('admin/announcement/announcement', ['announcements' => $announcements]);
    }

    function searchAnnouncement(Request $request) {
        // get announcements
        $announcements = Announcement::where('title', 'like', '%' . $request->search . '%')
                                     ->orWhere('publicity', 'like', '%' . $request->search . '%')
                                     ->orderBy('announcement_id', 'desc')
                                     ->paginate(10);
                        
        return view('admin/announcement/announcement', ['announcements' => $announcements]);
    }

    function announcementDetails($id){
        // get announcements details
        $announcement = Announcement::where('announcement_id', $id)->first();
        // get comments
        $comments = Comment::join('users', 'comments.user_id', '=', 'users.id')
                           ->where('announcement_id', $id)
                           ->select('comments.content as content', 
                                    'comments.created_at as created_at', 
                                    'users.name as name')
                           ->orderBy('comment_id', 'desc')
                           ->get();

        if(auth()->user()->role == 2) {
            return view('admin/announcement/announcementDetails', ['announcement' => $announcement, 'comments' => $comments]);
        }

        return view('resident/announcement/announcementDetails', ['announcement' => $announcement, 'comments' => $comments]);
        
    }

    function postComment(Request $request){
        $request->validate([
            'user_id' => 'required',
            'user_role' => 'required',
            'announcement_id' => 'required',
            'comment' => 'required',
        ]);

        // new comment
        $data['user_id'] = $request->user_id;
        $data['announcement_id'] = $request->announcement_id;
        $data['content'] = $request->comment;

        $newComment = Comment::create($data);

        if($request->user_role == 2){
            return redirect(route('admin-announcementDetails', ['id'=>$request->announcement_id]))->with("success", "Your comment has been posted successfully!");
        }

        return redirect(route('resident-announcementDetails', ['id'=>$request->announcement_id]))->with("success", "Your comment has been posted successfully!");
    }

    function editAnnouncement($id){
        $blocks = Block::get();
        // get announcements details
        $announcement = Announcement::where('announcement_id', $id)->first();

        return view('admin/announcement/editAnnouncement', ['announcement' => $announcement, 'blocks' => $blocks]);
    }

    function editAnnouncementPost(Request $request){
        $request->validate([
            'announcement_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'publicity' => 'required',
            'announced_block' => 'required',
            'announced_gender' => 'required'
        ]);

        $announcement = Announcement::find($request->announcement_id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'publicity' => $request->publicity,
            'announced_block' => $request->announced_block,
            'announced_gender' => $request->announced_gender
        ]);

        if($request->email_notification !== null) {
             // send to all residents at certain block
             if ($request->announced_block != 'All') {
                $emails = User::join('students', 'students.user_id', '=', 'users.id')
                              ->join('registrations', 'registrations.student_id', '=', 'students.student_id')
                              ->join('rooms', 'rooms.room_id', '=', 'registrations.room_id')
                              ->join('blocks', 'blocks.block_id', '=', 'rooms.block_id')
                              ->where('blocks.block_name', '=', $request->announced_block)
                              ->pluck('users.email as email')
                              ->toArray();

            // sent to all residents with certain gender
            } else if ($request->announced_gender != 'All') {
                $emails = User::join('students', 'students.user_id', '=', 'users.id')
                              ->where('students.gender', '=', $request->announced_gender)
                              ->pluck('users.email as email')
                              ->toArray();

            // send to all residents
            } else {
                $emails = User::where('role', '=', '1')->pluck('email')->toArray();
            }

            if($emails) {
                $data = [
                        "subject"=>"New Announcement from TARUMT Hostel",
                        "title"=>$request->title,
                        "content"=>$request->content,
                        ];

                // Assuming $emails is an array of email addresses
                $batchSize = 50; // Adjust this value based on the maximum recipients allowed by your email provider

                $chunks = array_chunk($emails, $batchSize);

                foreach ($chunks as $chunk) {
                    Mail::to($chunk)->send(new AnnouncementMail($data));
                    
                    // Add a delay between batches to avoid rate limiting
                    usleep(500000); // Sleep for 0.5 seconds (adjust as needed)
                }
            }
        }

        return redirect(route('admin-announcementDetails', ['id'=>$request->announcement_id]))->with("success", "The announcement as been updated!");
    }

    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::find($id);

        //remove file from storage
        $directoryPath = public_path('images/announcement');
        $fileToDelete = $directoryPath . '/' . $announcement->image;

        if (File::exists($fileToDelete)) {
            File::delete($fileToDelete);
        }

        //remove data from db
        $announcement->delete();

        return redirect(route('admin-announcement'))->with("success", "Announcement deleted!");
    }

    function residentAnnouncement(){
        // get resident info
        $student = Student::where('user_id', auth()->id())
                          ->select('student_id', 'gender')
                          ->first();
        $registration = Registration::where('student_id', $student->student_id)
                                    ->select('room_id')
                                    ->first();
        $block = Room::where('room_id', $registration->room_id)
                     ->join('blocks', 'blocks.block_id', '=', 'rooms.block_id')
                     ->select('block_name')
                     ->first();

        // get announcements
        $announcements = Announcement::whereIn('announced_gender', [$student->gender, 'All'])
                                     ->whereIn('announced_block', [$block->block_name, 'All'])
                                     ->orderBy('announcement_id', 'desc')
                                     ->get();
                        
        return view('resident/announcement/announcement', ['announcements' => $announcements]);
    }

    function home(){
        // get public announcements
        $announcements = Announcement::where('publicity', '=', 'Public')
                                     ->orderBy('announcement_id', 'desc')
                                     ->get();
                        
        return view('home', ['announcements' => $announcements]);
    }

    function newsDetails($id){
        // get announcements details
        $announcement = Announcement::where('announcement_id', $id)->first();

        return view('newsDetails', compact('announcement'));
        
    }
}
