<?php

class UserProgressController extends BaseController {

	public function clearDailyProgress()
	{
		$users = User::all();
		foreach ($users as $user) {
			$daily_progress = $user->daily_progress()->get()->first();
			$weekly_progress = $user->weekly_progress()->get()->first();
			$weekly_progress->exercise_time += $daily_progress->exercise_time;
			$weekly_progress->total_activity += $daily_progress->total_activity;
			$weekly_progress->accept += $daily_progress->accept;
			$weekly_progress->neck += $daily_progress->neck;
			$weekly_progress->shoulder += $daily_progress->shoulder;
			$weekly_progress->chest_back += $daily_progress->chest_back;
			$weekly_progress->wrist += $daily_progress->wrist;
			$weekly_progress->waist += $daily_progress->waist;
			$weekly_progress->hip_leg_calf += $daily_progress->hip_leg_calf;
			$weekly_progress->save();
			$daily_progress->resetData();
		}
		return "success";
	}
}