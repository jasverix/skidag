<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @package App
 * @property string $name
 * @property int $seconds;
 * @property float $age;
 * @property int $gender;
 * @property string $type;
 * @property boolean $approved
 * @property mixed $created_at;
 * @property mixed $updated_at;
 */
class Result extends Model
{
  protected $fillable = ['name', 'seconds', 'age', 'gender', 'approved', 'type'];
}
