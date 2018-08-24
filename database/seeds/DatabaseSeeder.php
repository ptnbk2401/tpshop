<?php

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
        $this->call(DBCat::class);
        $this->call(DBGift::class);
    }
}

class DBPost extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post')->insert([
            'name' 		=> str_random(10),
            'id_cat'	=> rand(1,10),
            'id_gift'	=> rand(1,10),
            'price-old'	=> rand(100,1000),
            'price-new'	=> rand(50,1000),
            'picture'	=> str_random(10).'.jpg',
        ]);
    }
}

class DBCat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'name_cat' 	=> str_random(10),
            'id_parent'	=> rand(1,10),
        ]);
    }
}

class DBGift extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gift')->insert([
            'name_gift' 	=> str_random(10),
            'picture'		=> str_random(10).'.jpg',
        ]);
    }
}