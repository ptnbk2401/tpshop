<?php

use Illuminate\Database\Seeder;

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
