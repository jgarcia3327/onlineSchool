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
 * @property int $user_id
 * @property int $schedule_id
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Buycredit extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'quantity' => 'int',
		'activate_by' => 'int'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'quantity',
		'status',
		'activate_by',
		'create_date',
		'modify_date'
	];
}
