<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  $results = [];

  $results[] = [
    'title' => 'Langrenn Gutter 8-13 år',
    'standings' => [
      'Mikkel Olsen 02:30',
      'Marcus Olsen 02:33',
    ],
  ];

  $results[] = [
    'title' => 'Langrenn Gutter 0-8 år',
    'standings' => [
      'Ole Olsen 02:30',
      'Emilian Bekkevold 02:33',
    ],
  ];

  return view('results')->with('results', $results);
});
