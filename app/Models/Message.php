<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Message
 * 
 * @property int $id
 * @property int $message_to
 * @property int $message_from
 * @property string $title
 * @property string $message
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Message extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'message_to' => 'int',
		'message_from' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'message_to',
		'message_from',
		'title',
		'message',
		'active',
		'create_date',
		'modify_date'
	];
}
