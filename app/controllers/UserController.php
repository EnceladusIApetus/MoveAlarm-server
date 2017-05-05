<?php

class UserController extends BaseController {
	
	public function create() {
		$user = new User;
		$user->facebookFirstName = Input::get('facebookFirstName');
		$user->facebook_id = Input::get('facebookId');
		$user->group_id = null;
		$user->save();
		$daily_progress = new UserDailyProgress;
		$daily_progress->user()->associate($user);
		$daily_progress->save();
		$weekly_progress = new UserWeeklyProgress;
		$weekly_progress->user()->associate($user);
		$weekly_progress->save();
		return $user;
	}

	public function login() {
		$log = new ClientInputLog;
		$log->title = "on user logine";
		$log->details = json_encode(Input::all());
		$log->save();
		$user = User::where('facebook_id', '=', Input::get('facebook_id'))->get()->first();
		if(empty($user)) {
			$user = new User;
			$user->facebook_id = Input::get('facebook_id');
			$user->facebookFirstName = Input::get('facebook_firstName');
			$user->group_id = null;
			$user->save();
			$daily_progress = new UserDailyProgress;
			$daily_progress->user()->associate($user);
			$daily_progress->save();
			$weekly_progress = new UserWeeklyProgress;
			$weekly_progress->user()->associate($user);
			$weekly_progress->save();
		}
		$user->daily_progress = $user->daily_progress()->get()->first();
		$user->weekly_progress = $user->weekly_progress()->get()->first();
		return $user;
	}

	public function tempLogin() {
		$user = User::where('facebook_id', '=', Input::get('facebookID'))->first();
		$response = StatusDescriptor::createProcessStatus(true);
		if(empty($user)) {
			$user = new User;
			$user->facebook_id = Input::get('facebookID');
			$user->facebookFirstName = Input::get('facebookFirstName');
			$user->save();
		}

		$user['facebookID'] = $user['facebook_id'];
		$user['groupID'] = $user['group_id'];
		$response['user'] = $user;
		return $response;
	}

	public function update()
	{
		$log = new ClientInputLog;
		$log->title = "on user update";
		$log->details = json_encode(Input::all());
		$log->save();
		$user = User::find(intval(Input::get('id')));
		$user->updateData(Input::all());
		return StatusDescriptor::createProcessStatus(true);
	}

	public function getTopRank()
	{
		$users = User::orderBy('score', 'desc')->take(intval(Input::get('max')))->get();
        return $users;
	}

	public function getRank()
    {
        return User::where('id', '!=', Input::get('id'))->where('score', '>', Input::get('score'))->get()->count() + 1;
    }
}