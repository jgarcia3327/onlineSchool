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
 * @property float $amount
 * @property bool $status
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Deposit extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float',
		'active' => 'bool'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'amount'
	];
}
