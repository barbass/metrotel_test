<?php

/**
 * Автозагрузка классов по стандарту PSR-4
 * @descr Загружаем только из каталога application/models/app
 */
function splAutoLoadRegister() {
	// Only Autoload PHP Files
	spl_autoload_extensions('.php');

	spl_autoload_register(function($classname) {
		if (stripos($classname, 'metrotel') !== FALSE) {
			$path = SYSTEMPATH;
		} else {
			$path = SRCPATH;
		}

		$classfile = str_replace('\\', '/', $classname);
		$class_list = explode('/', $classfile);
		$class_name = array_pop($class_list);
		
		$class_path = implode($class_list, '/');
		$class_path = strtolower($class_path);

		if ($classname[0] !== '/') {
			$classfile = $path . '/' . $class_path . '/' . $class_name . '.php';
		}
		require_once($classfile);
	});
}
