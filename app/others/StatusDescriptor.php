<?php

class StatusDescriptor {

	public static function createProcessStatus(...$params)
    {
        $processStatus = array();
        $processStatus['status'] = $params[0];
        if(isset($params[1]))
        	$processStatus['description'] = $params[1];
        return $processStatus;
    }
}