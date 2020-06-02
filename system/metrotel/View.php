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

    public static function redirect($url) {
        header('Refresh:0;url='.self::base_url($url));
        exit();
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

    public static function number_to_text($number): string
    {
        $number_text = ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь' ,'девять'];
		$number_text_ten = ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'];

        $number_10 = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать' , 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
        $number_20 = ['', '', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят' , 'восемьдесят', 'девяносто'];

        $number_100 = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];

        $unit = [
            ['', '', '', 1],
            ['тысяча' , 'тысячи', 'тысяч'],
            ['миллион', 'миллиона', 'миллионов'],
            ['миллиард', 'миллиарда', 'миллиардов'],
            ['триллион', 'триллиона', 'триллионов'],
        ];

        $value = (string)$number;
        $value = strrev($value);

        $result_list = [];
        $value_list = str_split($value, 3);
        foreach($value_list as $unit_key => $v) {
            $result_part = [];

            $v = strrev($v);
            $v = str_pad($v, 3, '0', STR_PAD_LEFT);

            if ((int)$v == 0) {
                continue;
            }

            list($v1, $v2, $v3) = str_split($v, 1);

            if ($v1) {
                $result_part[] = $number_100[$v1];
            }
            if ($v2) {
                if ($v3 == 1) {
                    $result_part[] = $number_10[$v2];
                } else {
                    $result_part[] = $number_20[$v2];
                }
            }
            if ($v3) {
                $result_part[] = $number_text[$v3];
            }

            $unit_declension = 2;
            if ($v3 == 1) {
                $unit_declension = 0;
            } elseif($v3 >= 2 && $v3 <= 4) {
                $unit_declension = 1;
            }

            $result_part[] = $unit[$unit_key][$unit_declension];

            $result_list[] = $result_part;
        }

        $result = '';
        $result_list = array_reverse($result_list);
        foreach($result_list as $result_part) {
            $result .= ' '.implode($result_part, ' ');
        }

        return $result;
    }
}
