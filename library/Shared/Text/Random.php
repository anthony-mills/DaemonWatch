<?php

class Shared_Text_Random {

    public static function alphanumeric($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
			$num = rand() % 33;
            $tmp = substr($characters, $num, 1);
            $string .= $tmp;
        }

        return $string;
    }

}