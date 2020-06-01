<?php

namespace Metrotel;

class Config {
	private static $config = [];

	public static function set(string $key, $value = null) {
		self::$config[$key] = $value;
	}

    public static function get(string $key, $default_value = null) {
		return (isset(self::$config[$key])) ? self::$config[$key] : $default_value;
	}
}
