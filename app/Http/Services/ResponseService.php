<?php

namespace App\Http\Services;


class ResponseService
{
	public static $response = ['status' => false];

	public static function set(array $arrays)
	{
		if(!blank($arrays)) {
			if(count($arrays) > 1) {
				foreach ($arrays as $key => $array) {
					self::$response[$key] = $array;
				}
			} else {
				self::$response[array_key_first($arrays)] = $arrays[array_key_first($arrays)];
			}
		}
	}

	public static function response()
	{
		if(isset(self::$response['status']) && self::$response['status'] == false && !isset(self::$response['message'])) {
			self::$response['message'] = 'something wrong';
		}

	    return (object) self::$response;
	}

}
