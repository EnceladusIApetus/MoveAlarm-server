<?php

class Group extends Eloquent {
	
	protected $hidden = array('created_at', 'updated_at');

	public function admin() { return $this->members()->where('id', '=', $this->admin_id)->get()->first(); }
	public function members() { return $this->hasMany('User'); }
	public function progress() { return $this->hasOne('GroupProgress'); }

	public function updateData($data)
	{
		$this->name = (isset($data['name'])) ? $data['name'] : $this->name;
		$this->status = (isset($data['status'])) ? $data['status'] : $this->status;
		$this->score = (isset($data['score'])) ? $data['score'] : $this->score;
		$this->save();
		$this->progress()->get()->first()->updateData($data['progress']);
	}
}