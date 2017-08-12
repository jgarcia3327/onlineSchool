<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Work
 * 
 * @property int $id
 * @property int $teacher_id
 * @property int $student_id
 * @property string $company
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $position
 * @property string $description
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Work extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'teacher_id' => 'int',
		'student_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'start_date',
		'end_date',
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'teacher_id',
		'student_id',
		'company',
		'start_date',
		'end_date',
		'position',
		'description',
		'active',
		'create_date',
		'modify_date'
	];
}
