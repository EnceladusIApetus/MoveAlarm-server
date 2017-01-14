<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	protected $table = 'users';
	protected $hidden = array('password', 'remember_token', 'created_at', 'updated_at');
	protected $guarded = array('firstName', 'lastName', 'gender', 'facebookLastName', 'password');

	public function	__constructor($params) {
		$this->facebookFirstName = $params['facebookFirstName'];
		$this->facebook_id = $params['facebookId'];
		$this->group_id = 1;
		$this->updateData($params);
	}

	public function	group() { return $this->belongsTo('Group'); }
	public function	weekly_progress() { return $this->hasOne('UserWeeklyProgress'); }
	public function	daily_progress() { return $this->hasOne('UserDailyProgress'); }

	public function updateData($data) {
		$this->score = (isset($data['score'])) ? $data['score'] : $this->score;
		$this->age = (isset($data['age'])) ? $data['age'] : $this->age;
		$this->height = (isset($data['height'])) ? $data['height'] : $this->height;
		$this->weight = (isset($data['weight'])) ? $data['weight'] : $this->weight;
		$this->waistline = (isset($data['waistline'])) ? $data['waistline'] : $this->waistline;
		$this->bmi = (isset($data['bmi'])) ? $data['bmi'] : $this->bmi;
		$this->birthdate = (isset($data['birthdate'])) ? $data['birthdate'] : $this->birthdate;
		$this->save();
		if(isset($data['daily_progress']))
			$this->daily_progress()->get()->first()->updateData($data['daily_progress']);
		if(isset($data['weekly_progress']))
			$this->weekly_progress()->get()->first()->updateData($data['weekly_progress']);
	}

	/*public function getFNameAttribute() {
		return $this->firstName;
	}

	public function setFNameAttribute($value) {
		$this->firstName = $value;
	}*/
}
