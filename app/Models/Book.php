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
 * @property int $teacher_id
 * @property string $title
 * @property string $description
 * @property string $path
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Book extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'teacher_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'title',
		'description',
		'file_name',
		'active',
		'create_date',
		'modify_date'
	];
}
