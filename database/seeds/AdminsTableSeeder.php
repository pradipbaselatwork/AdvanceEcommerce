<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
      ['id'=>1, 'name'=>'admin', 'type'=>'admin', 'mobile'=>'9827135336', 'email'=>'admin@admin.com', 'password'=>'$2y$10$yRUoOM/hN0t030qFFNkGnO7ubchxqVRmfWfNHjd58Ul3pBEK7JGX6', 'image'=>'', 'status'=>1],
        ];

        foreach ($adminRecords as $key => $record) {
            \App\Admin::create($record);
        }
    }
}
