<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 08:40:23 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Feedback
 *
 * @property int $id
 * @property int $user_id
 * @property text $remark
 * @property tinyint $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Feedback extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'reply_by' => 'int'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'remark',
		'reply',
		'create_date',
		'modify_date'
	];
}
