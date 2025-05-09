<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('store_website')->truncate();
        
        DB::table('store_website')->insert([
            [
                'website_id' => 0,
                'code' => 'admin',
                'name' => 'Admin'
            ],
            [
                'website_id' => 1,
                'code' => 'es',
                'name' => 'Península y Baleares'
            ],
            [
                'website_id' => 2,
                'code' => 'pt',
                'name' => 'Portugal'
            ],
            [
                'website_id' => 3,
                'code' => 'it',
                'name' => 'Italia'
            ],
            [
                'website_id' => 4,
                'code' => 'fr',
                'name' => 'Francia'
            ],
            [
                'website_id' => 5,
                'code' => 'ea',
                'name' => 'Ceuta y Melilla'
            ],
            [
                'website_id' => 6,
                'code' => 'ic',
                'name' => 'Islas Canarias'
            ],
        ]);
    }
}
