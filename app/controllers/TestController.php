<?php

class TestController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		$event = new Events;
		$event->time = date("yyyy-mm-dd h:i:s");
		$event->postureList = "555";
		$event->save();
		return StatusDescriptor::createProcessStatus(true);
	}

}
