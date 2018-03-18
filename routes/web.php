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
  $index = [];

  $genders = ['Gutter', 'Jenter'];
  $ageGroups = ['0-7' => [0, 7], '8-12' => [8, 12]];
  $types = ['Langrenn', 'Skiskyting', 'Hopp'];

  foreach ($types as $type) {
    foreach ($genders as $genderId => $gender) {
      foreach ($ageGroups as $ageGroup => $ages) {
        [$minAge, $maxAge] = $ages;
        $key = $type . ' ' . $gender . ' ' . $ageGroup . ' år';
        $index[$key] = [];

        $query = \App\Result::query()
          ->select(['name', \Illuminate\Support\Facades\DB::raw(($type === 'Hopp' ? 'MAX' : 'MIN') . '(seconds) AS seconds')])
          ->where('approved', '=', true)
          ->where('type', '=', $type)
          ->where('gender', '=', $genderId)
          ->where('age', '<=', $maxAge)
          ->where('age', '>=', $minAge);

        switch ($type) {
          case 'Hopp':
            $query->orderByDesc('seconds');
            break;

          default:
            $query->orderBy('seconds');
            break;
        }

        $query->groupBy('name');

        $query->limit(5);

        $data = $query->get();

        foreach ($data as $result) {
          $index[$key][] = (object)[
            'type' => $type,
            'name' => $result->name,
            'seconds' => $result->seconds,
          ];
        }
      }
    }
  }

  $results = [];
  $i = 0;

  foreach ($index as $title => $persons) {
    $standings = [];

    foreach ($persons as $person) {
      /** @var $person \App\Result */
      switch ($person->type) {
        case 'Hopp':
          $score = ((float)$person->seconds) . ' meter';
          break;

        default:
          if ($person->seconds < 60) {
            $score = $person->seconds . ' sekunder';
          } else {
            $seconds = $person->seconds;
            $minutes = 0;
            while ($seconds >= 60) {
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

    if ($i > 100) {
      die('100');
    }

    ++$i;
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

  Route::post($routeUrl, function (Request $request) use ($routeUrl, $type) {
    /** @noinspection PhpUndefinedMethodInspection */
    $data = $request->validate([
      'name' => 'required|max:100',
      'seconds' => 'required',
    ]);

    $data['age'] = 0;
    $data['gender'] = -1;
    $data['type'] = $type;

    $data['seconds'] = (float)str_replace(',', '.', $data['seconds']);

    if (($name = $data['name'])) {
      /** @var \App\Result $sameName */
      $sameName = \App\Result::query()->where('name', '=', $name)->first();
      if ($sameName) {
        $data['age'] = $sameName->age;
        $data['gender'] = $sameName->gender;
      }
    }

    $data['name'] = trim($data['name']);

    tap(new \App\Result($data))->save();

    return redirect($routeUrl);
  });
}

Route::get('/admin', function () {
  $data = \App\Result::query()->where('approved', '=', false)->get();

  return view('admin-list')->with('results', $data);
});

Route::get('/admin/edit/{id}', function ($id) {
  /** @var \App\Result $result */
  $result = \App\Result::findOrFail($id);
  $type = $result->type;
  $scoreTitle = 'Sekunder';
  $scoreSuffix = 'sekunder';
  if ($type === 'Hopp') {
    $scoreTitle = 'Lengde';
    $scoreSuffix = 'meter';
  }

  return view('admin-edit')->with('result', $result)->with('type', $type)->with('scoreTitle', $scoreTitle)->with('scoreSuffix', $scoreSuffix);
});

Route::post('/admin/edit/{id}', function ($id, Request $request) {
  /** @noinspection PhpUndefinedMethodInspection */
  $data = $request->validate([
    'name' => 'required|max:100',
    'seconds' => 'required',
    'age' => 'required|between:1,100',
    'gender' => 'required|between:0,1',
    'reject' => '',
  ]);

  if ($data['reject'] ?? false) {
    \App\Result::findOrFail($id)->delete();

    return redirect('/admin');
  }
  unset($data['reject']);

  $data['id'] = $id;
  $data['approved'] = true;

  $data['seconds'] = (float)str_replace(',', '.', $data['seconds']);
  $data['name'] = trim($data['name']);

  unset($data['type']);

  /** @var \App\Result $result */
  $result = \App\Result::find($id);
  $result->fill($data);
  $result->save();

  return redirect('/admin');
});
