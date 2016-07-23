<?php

class GroupProgress extends Eloquent {
	protected $table = "group_progress";

    public function group() { return $this->belongsTo('Group'); }

    public function updateData($data)
	{
		$this->exercise_time = (isset($data['exerciseTime'])) ? $data['exerciseTime'] : $this->exercise_time;
		$this->accept = (isset($data['accept'])) ? $data['accept'] : $this->accept;
		$this->total_activity = (isset($data['totalActivity'])) ? $data['totalActivity'] : $this->total_activity;
		$this->neck = (isset($data['neck'])) ? $data['neck'] : $this->neck;
		$this->shoulder = (isset($data['shoulder'])) ? $data['shoulder'] : $this->shoulder;
		$this->chest_back = (isset($data['chestBack'])) ? $data['chestBack'] : $this->chest_back;
		$this->wrist = (isset($data['wrist'])) ? $data['wrist'] : $this->wrist;
		$this->waist = (isset($data['waist'])) ? $data['waist'] : $this->waist;
		$this->hip_leg_calf = (isset($data['hipLegCalf'])) ? $data['hipLegCalf'] : $this->hip_leg_calf;
		return $this->save();
	}
}