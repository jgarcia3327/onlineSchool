<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Setting extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'name',
		'content',
		'create_date',
		'modify_date'
	];
}
