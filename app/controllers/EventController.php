<?php

class EventController extends BaseController {

	public function getEvent() {
		$event = Events::all()->last();

		$time = new DateTime((isset($event)) ? $event->time : null);
		if(empty($event) || intval($time->format('d')) < intval(date('d'))) {
			$event = new Events;
			$event->time = $this->getRandomTime();
			$event->posture_list = rand(1, 26);
			$event->save();
		}
		return $event;
	}

	private function getRandomTime()
	{
		return date('Y-m-d ') . rand(13, 16) . ':' . rand(0, 59) . ':' . rand(0, 59);
	}
}
