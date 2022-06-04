<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        \Spatie\Permission\Models\Role::create(['name'=>'Super Admin','guard_name'=>'web']);
        \App\Models\DocumentType::create(['document_type'=>'DNI']);
        \App\Models\DocumentType::create(['document_type'=>'RUC']);
        \App\Models\Status::create(['status'=>'INACTIVE','weighting'=>0]);
        \App\Models\Status::create(['status'=>'ACTIVE','weighting'=>1]);
        \App\Models\Status::create(['status'=>'DELETED','weighting'=>-3]);
        \App\Models\Status::create(['status'=>'STAND BY','weighting'=>-1]);
        \App\Models\Status::create(['status'=>'CANCELED','weighting'=>-3]);
        \App\Models\Status::create(['status'=>'IN PROGRES','weighting'=>2]);
        \App\Models\Status::create(['status'=>'FINISHED','weighting'=>3]);
    }
}
