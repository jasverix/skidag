<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('results', function (Blueprint $table) {
      $table->integer('id', true, true);
      // $table->primary('id');
      /** @noinspection PhpUndefinedMethodInspection */
      $table->string('name', 100)->index();
      $table->decimal('seconds', 10, 2);
      $table->integer('age', false, true);
      $table->integer('gender');
      /** @noinspection PhpUndefinedMethodInspection */
      $table->string('type', 50)->index();
      /** @noinspection PhpUndefinedMethodInspection */
      $table->boolean('approved')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('results');
  }
}
