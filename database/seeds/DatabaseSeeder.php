<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\User::class, 5)->create();
      factory(App\Model\Director::class, 30)->create();
      factory(App\Model\Actor::class, 30)->create();
      factory(App\Model\Movie::class, 50)->create();
      factory(App\Model\Review::class, 300)->create();
      foreach( range(1,30) as $index){
        DB::table('movie_actor')->insert(
          [
            'movie_id' => App\Model\Movie::select('id')->inRandomOrder()->first()->id,
            'actor_id' => App\Model\Actor::select('id')->inRandomOrder()->first()->id
          ]
        );
        DB::table('movie_category')->insert(
          [
            'movie_id' => App\Model\Movie::select('id')->inRandomOrder()->first()->id,
            'category_id' =>  rand(1,10)
          ]
        );
      }

    }
}
