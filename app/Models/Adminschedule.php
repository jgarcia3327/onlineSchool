<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 08:40:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Book
 *
 * @property int $id
 * @property int $schedule_id
 * @property int $action
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Adminschedule extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'schedule_id' => 'int',
		'action' => 'int'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'schedule_id',
		'action',
		'create_date',
		'modify_date'
	];
}
