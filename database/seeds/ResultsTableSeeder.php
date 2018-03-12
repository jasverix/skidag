<?php

use Illuminate\Database\Seeder;

class ResultsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(App\Result::class, 50)->create();
  }
}
