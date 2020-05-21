<?php

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance')->truncate();
        DB::table('attendance')->insert([
            [
                'user_id'           => 1,
                'start_time'        => '2020-05-10 10:00:00',
                'end_time'          => '2020-05-10 15:20:00',
                'absent_content'    => 'hogehoge',
                'modify_content'    => 'piyopiyo',
                'date'              => '2020-05-10'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-05-15 10:00:00',
                'end_time'          => null,
                'absent_content'    => null,
                'modify_content'    => null,
                'date'              => '2020-05-15'
            ],
            [
                'user_id'           => 4,
                'start_time'        => null,
                'end_time'          => null,
                'absent_content'    => 'ewgfiugfiugwighwi',
                'modify_content'    => null,
                'date'              => '2020-03-12'
            ],
            [
                'user_id'           => 4,
                'start_time'        => null,
                'end_time'          => null,
                'absent_content'    => null,
                'modify_content'    => 'skhkugiugih',
                'date'              => '2019-12-26'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-01-16 09:40:00',
                'end_time'          => '2020-01-16 12:20:00',
                'absent_content'    => null,
                'modify_content'    => null,
                'date'              => '2020-01-16'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-01-24 10:00:00',
                'end_time'          => null,
                'absent_content'    => 'ewfuwegfgwigwe',
                'modify_content'    => null,
                'date'              => '2020-01-24'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-04-05 10:00:00',
                'end_time'          => null,
                'absent_content'    => null,
                'modify_content'    => 'lihiooihknge',
                'date'              => '2020-04-05'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-04-27 10:00:00',
                'end_time'          => '2020-04-28 05:00:00',
                'absent_content'    => 'NULL',
                'modify_content'    => null,
                'date'              => '2020-04-27'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2020-02-01 10:00:00',
                'end_time'          => '2020-02-01 12:00:00',
                'absent_content'    => null,
                'modify_content'    => 'NULL',
                'date'              => '2020-02-01'
            ],
            [
                'user_id'           => 4,
                'start_time'        => '2019-06-16 10:00:00',
                'end_time'          => '2019-06-16 12:00:00',
                'absent_content'    => 'viuiuureuhki',
                'modify_content'    => 'lihiooihknge',
                'date'              => '2019-06-16'
            ],
            [
                'user_id'           => 4,
                'start_time'        => null,
                'end_time'          => null,
                'absent_content'    => 'viuiuureuhki',
                'modify_content'    => 'lihiooihknge',
                'date'              => '2018-01-05'
            ]
        ]);
    }
}
