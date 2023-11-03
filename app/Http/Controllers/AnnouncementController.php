<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Announcement;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        // new announcement
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['image'] = $fileName;
        $data['publicity'] = $request->publicity;
        $data['announced_block'] = $request->announced_block;
        $data['announced_gender'] = $request->announced_gender;

        if($request->email_notification !== null) {
            //
        }
        
        $newAnnouncement = Announcement::create($data);

        return redirect(route('admin-announcementDetails', ['id'=>$newAnnouncement->announcement_id]))->with("success", "New announcement has been added successfully!");
    }

    function announcementList(){
        // get announcements
        $announcements = Announcement::orderBy('announcement_id', 'desc')
                                     ->get();
                        
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

        return view('admin/announcement/announcementDetails', ['announcement' => $announcement, 'comments' => $comments]);
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
            //
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
}
