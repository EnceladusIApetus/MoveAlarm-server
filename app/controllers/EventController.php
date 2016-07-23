<?php

class EventController extends BaseController {

	public function getEvent() {
		$data = array();
		$data['time'] = date("d-m-Y h:i:s");
		$data['postureList'] = "5555";
		return $data;
	}
}
