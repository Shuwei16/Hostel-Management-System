<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dummy data for public announcement
        for($i=1; $i <= 5; $i++) {
            Announcement::create([
                'title' => "Sample Public Announcement ".$i,
                'content' => "Any description here...",
                'image' => "announcement_1700661078.jpg",
                'announced_block' => "All",
                'announced_gender' => "All",
                'publicity' => "Public"
            ]);
        }

        //dummy data for private announcement
        for($i=1; $i <= 20; $i++) {

            Announcement::create([
                'title' => "Sample Private Announcement ".$i,
                'content' => "Any description here...",
                'image' => "announcement_1700661078.jpg",
                'announced_block' => "All",
                'announced_gender' => "All",
                'publicity' => "Private"
            ]);
        }
    }
}
