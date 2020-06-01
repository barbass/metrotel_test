<?php

namespace Metrotel;

use Metrotel\Config;

class View {
    /**
     *
     * @var Metrotel\View
     */
    private static $instance;

    public function __construct() {
		$this->config = Config::get('route');
	}

    public static function base_url(string $path = '') {
        return self::$instance->config['base_url'].$path;
    }

    public static function getInstance(): View {
        if (!isset(self::$instance)) {
            self::$instance = new self();
       }

        return self::$instance;
    }

	public static function render(string $file, array $data = [], $render = true) {
		$template = SRCPATH.'/View/'.$file.'.php';
		extract($data);

		ob_start();
		require_once($template);
		$ob = ob_get_clean();

		if ($render) {
			echo $ob;
		} else {
			return $ob;
		}
	}
}
