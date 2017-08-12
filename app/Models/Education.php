<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Auth;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Education
 *
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property string $school_name
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $degree
 * @property string $description
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Education extends Eloquent
{
	protected $table = 'educations';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'start_date',
		'end_date',
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'school_name',
		'start_date',
		'end_date',
		'degree',
		'description',
		'active',
		'create_date',
		'modify_date'
	];

	// Mutator
	public function setUserIdAttribute($value) {
		$this->attributes['user_id'] = Auth::user()->id;
	}
}
