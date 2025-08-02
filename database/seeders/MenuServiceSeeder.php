<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_services')->insert([
            [
                'name' => 'Latte Legalizations',
                'price' => 500,
                'description' => 'Drafting of documents such as letters, special power of attorneys, promissory notes, compromise agreements, and others.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Espresso Advise',
                'price' => 500,
                'description' => 'Online consultations with the lawyer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Americano Agreements',
                'price' => 1000,
                'description' => 'Drafting of contracts; review of existing contracts and drafting of revised contract.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Barista Grind',
                'price' => 2000,
                'description' => 'Thorough research and analysis of legal issues, study of applicable laws and statutes, and provision of legal documentation and research services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Capuccino Case Files',
                'price' => 20000,
                'description' => 'Assistance with litigation of cases, including court representation and preparation of pleadings in the areas of: Labor law, Marriage and family relations, Property law, Corporate law, Immigration law.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
