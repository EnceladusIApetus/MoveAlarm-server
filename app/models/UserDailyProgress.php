<?php

class UserDailyProgress extends Eloquent
{
	protected $table = "user_daily_progress";

	public function user() { return $this->belongsTo('User'); }

	public function updateData($data)
	{
		$this->exercise_time = (isset($data['exercise_time'])) ? $data['exercise_time'] : $this->exercise_time;
		$this->accept = (isset($data['accept'])) ? $data['accept'] : $this->accept;
		$this->total_activity = (isset($data['total_activity'])) ? $data['total_activity'] : $this->total_activity;
		$this->neck = (isset($data['neck'])) ? $data['neck'] : $this->neck;
		$this->shoulder = (isset($data['shoulder'])) ? $data['shoulder'] : $this->shoulder;
		$this->chest_back = (isset($data['chest_back'])) ? $data['chest_back'] : $this->chest_back;
		$this->wrist = (isset($data['wrist'])) ? $data['wrist'] : $this->wrist;
		$this->waist = (isset($data['waist'])) ? $data['waist'] : $this->waist;
		$this->hip_leg_calf = (isset($data['hip_leg_calf'])) ? $data['hip_leg_calf'] : $this->hip_leg_calf;
		return $this->save();
	}
}