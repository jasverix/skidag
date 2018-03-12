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

use Illuminate\Http\Request;

Route::get('/', function () {
  $data = \App\Result::all();
  $index = [];

  foreach ($data as $result) {
    switch ($result->gender) {
      case 0:
        $gender = 'Gutter';
        break;

      case 1:
        $gender = 'Jenter';
        break;

      default:
        continue 2; // don't display this person - modify the data first
    }

    if ($result->age < 1) {
      continue; // don't display this person - modify the data first
    }

    if ($result->age < 8) {
      $ageGroup = '0-8';
    } elseif ($result->age < 13) {
      $ageGroup = '8-13';
    } else {
      continue; // don't display this person
    }

    $key = $result->type . ' ' . $gender . ' ' . $ageGroup . ' år';

    $index[$key][] = $result;
  }

  $results = [];

  foreach ($index as $title => $persons) {
    usort($persons, function ($p1, $p2) {
      /** @var $p1 \App\Result */
      /** @var $p2 \App\Result */

      switch ($p1->type) {
        case 'Hopp':
          return $p2->seconds - $p1->seconds;

        default:
          return $p1->seconds - $p2->seconds;
      }
    });

    $persons = array_slice($persons, 0, 5);

    $standings = [];
    foreach ($persons as $person) {
      /** @var $person \App\Result */
      switch ($person->type) {
        case 'Hopp':
          $score = ((int)$person->seconds) . ' meter';
          break;

        default:
          if ($person->seconds < 60) {
            $score = $person->seconds . ' sekunder';
          } else {
            $seconds = $person->seconds;
            $minutes = 0;
            while ($person->seconds >= 60) {
              $seconds -= 60;
              ++$minutes;
            }

            if ($minutes > 0) {
              $score = $minutes . ' minutter ' . $seconds . ' sekunder';
            } else {
              $score = $person->seconds . ' s';
            }
          }
          break;
      }

      $standings[] = [
        'name' => $person->name,
        'score' => $score,
      ];
    }

    $results[] = [
      'title' => $title,
      'standings' => $standings,
    ];
  }

  return view('results')->with('results', $results);
});

$types = [
  'Langrenn', 'Hopp', 'Skiskyting',
];

foreach ($types as $type) {
  $scoreTitle = 'Sekunder';
  $scoreSuffix = 'sekunder';
  if ($type === 'Hopp') {
    $scoreTitle = 'Lengde';
    $scoreSuffix = 'meter';
  }

  $routeUrl = '/' . strtolower($type) . '/add';

  Route::get($routeUrl, function () use ($type, $scoreTitle, $scoreSuffix) {
    return view('form')->with('type', $type)->with('scoreTitle', $scoreTitle)->with('scoreSuffix', $scoreSuffix);
  });

  Route::post($routeUrl, function (Request $request) use ($routeUrl) {
    $data = $request->validate([
      'name' => 'required|max:100',
      'seconds' => 'required',
    ]);

    tap(new \App\Result($data))->save();

    return redirect($routeUrl);
  });
}
