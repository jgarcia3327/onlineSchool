<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Enrolment
 * 
 * @property int $id
 * @property int $schedule_id
 * @property int $student_id
 * @property bool $completed
 * @property string $learning
 * @property string $book
 * @property string $page_start
 * @property string $page_end
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Enrolment extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'schedule_id' => 'int',
		'student_id' => 'int',
		'completed' => 'bool',
		'active' => 'bool'
	];

	protected $dates = [
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'schedule_id',
		'student_id',
		'completed',
		'learning',
		'book',
		'page_start',
		'page_end',
		'active',
		'create_date',
		'modify_date'
	];
}
