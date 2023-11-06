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
        Announcement::create([
            'registration_id' => 1,
            'title' => "Announcement 1",
            'content' => "Any description here...",
            'image' => "announcement_1698934957.jpg",
            'announced_block' => "All",
            'announced_gender' => "All",
            'publicity' => "Public"
        ]);

        Announcement::create([
            'registration_id' => 2,
            'title' => "Announcement 2",
            'content' => "Any description here...",
            'image' => "announcement_1699021781.jpg",
            'announced_block' => "A",
            'announced_gender' => "Female",
            'publicity' => "Private"
        ]);

        Announcement::create([
            'registration_id' => 3,
            'title' => "Announcement 3",
            'content' => "Any description here...",
            'image' => "announcement_1699021840.jpg",
            'announced_block' => "All",
            'announced_gender' => "All",
            'publicity' => "Public"
        ]);

        Announcement::create([
            'registration_id' => 4,
            'title' => "Announcement 4",
            'content' => "Any description here...",
            'image' => "announcement_1699021865.jpg",
            'announced_block' => "B",
            'announced_gender' => "All",
            'publicity' => "Private"
        ]);
    }
}
