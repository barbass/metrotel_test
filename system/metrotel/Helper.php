<?php

class Helper {
	public static function SplAutoLoadRegister() {
		// Only Autoload PHP Files
		spl_autoload_extensions('.php');

		spl_autoload_register(function($classname) {
			if (strpos($classname, 'app') !== 0) {
				return;
			}

			// Namespaced Classes
			$classfile = str_replace('\\', '/', $classname);

			if ($classname[0] !== '/') {
				$classfile = APPPATH . 'models/' . $classfile . '.php';
			}
			require_once($classfile);
		});
	}
}
