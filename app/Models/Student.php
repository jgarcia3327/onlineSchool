<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 30 Jul 2017 11:26:36 +0000.
 */

namespace App\Models;

use Auth;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Student
 *
 * @property int $id
 * @property int $user_id
 * @property string $fname
 * @property string $mname
 * @property string $lname
 * @property string $nname
 * @property \Carbon\Carbon $dob
 * @property string $gender
 * @property string $skype
 * @property string $contact
 * @property string $address
 * @property string $country
 * @property string $photo
 * @property string $audio
 * @property bool $active
 * @property \Carbon\Carbon $create_date
 * @property \Carbon\Carbon $modify_date
 *
 * @package App\Models
 */
class Student extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'active' => 'bool'
	];

	protected $dates = [
		'dob',
		'create_date',
		'modify_date'
	];

	protected $fillable = [
		'user_id',
		'fname',
		//'mname',
		'lname',
		'nname',
		'dob',
		'gender',
		'skype',
		'contact',
		'address',
		'country',
		/*
		'photo',
		'audio',
		'active',
		'create_date',
		'modify_date'*/
	];

	// Mutator
	public function setUserIdAttribute($value) {
		$this->attributes['user_id'] = Auth::user()->id;
	}

	// Setter
	public function getIdAttribute($value) {
		return $this->attributes['id'];
	}

}
