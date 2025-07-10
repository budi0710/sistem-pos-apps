<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('insert', function () {
    DB::table('user')->insert([
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => md5('123456'),
        'role'=> 1
    ]);
     DB::table('setting')->insert([
        'latitude' => '-2.190540',
        'longitude' => '102.639150',
        'radius' => 150,
        'name_company'=> 'test',
        'logo'=> '-'
    ]);
})->purpose('');