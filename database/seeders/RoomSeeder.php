<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Block;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create block data (A-G: Female, H-J: Male)
        $female_blocks = range('A', 'G');
        foreach ($female_blocks as $f_block) {
            Block::create([
                'block_name' => $f_block,
                'gender' => 'Female',
            ]);
        }
        $male_blocks = range('H', 'J');
        foreach ($male_blocks as $m_block) {
            Block::create([
                'block_name' => $m_block,
                'gender' => 'Male',
            ]);
        }

        //Create room data
        //10 block
        $all_blocks = ord('A');
        for($x=0; $x<10; $x++) {
            //5 floor per block
            for($y=0; $y<5; $y++) {
                //20 room per floor
                for($z=0; $z<20; $z++) {
                    $code = chr($all_blocks) . '-';
                    if($y == 0) {
                        $floor = 'G';
                    } else {
                        $floor = $y;
                    }
                    $code = $code . $floor . str_pad($z+1, 2, '0', STR_PAD_LEFT);
                    Room::create([
                        'room_code' => $code,
                        'room_no' => $z+1,
                        'floor' => $floor,
                        'block_id' => $x+1,
                        'occupied_slots' => 0,
                    ]);
                }
            }
            $all_blocks++;
        }
    }
}
