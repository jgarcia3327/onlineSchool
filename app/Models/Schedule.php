<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Schedule
 * 
 * @property int $id
 * @property int $teacher_id
 * @property \Carbon\Carbon $date_time
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Schedule extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'teacher_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'date_time',
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'teacher_id',
		'date_time',
		'active',
		'create_date',
		'modify_date'
	];
}
