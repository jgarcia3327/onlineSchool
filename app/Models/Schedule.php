<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Auth;

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
		'teacher_user_id' => 'int',
		'student_user_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'date_time',
		'create_date',
		'modify_date'
	];

	protected $hidden = [
		'teacher_user_id',
		'called'
	];

	protected $fillable = [
		'teacher_user_id',
		'student_user_id',
		'date_time',
		'memo',
		'memo_book',
		'memo_next_page',
		'memo_comment',
		'called',
		'active',
		'create_date',
		'modify_date'
	];

	// Mutator
	public function setTeacherIdAttribute($value) {
		$this->attributes['teacher_user_id'] = Auth::user()->id;
	}

}
