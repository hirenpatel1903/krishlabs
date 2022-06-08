<?php
namespace App\Libraries;

class MyString
{
    public static function code($id, $length = 8)
    {
        $joinStr     = $id . rand(0, 9);
        $leadingZero = $length - strlen($joinStr);
        if ($leadingZero === 0) {
            $length++;
            MyString::code($id, $length);
        }

        $string = '';
        for ($i = 1; $i <= $leadingZero; $i++) {
            $string .= 0;
        }
        return $string . $joinStr;
    }

    public static function strReplace($find, $set, $string)
    {
        return str_replace($find, $set, $string);
    }

    public static function strReplaceEnd($find, $set, $string)
    {
        return preg_replace('/' . preg_quote($find, '/') . '$/', $set, $string);
    }

    public static function version($string)
    {
        $explode = explode(':', base64_decode($string));
        if (!blank($explode)) {
            return $explode[0];
        }
        return '';
    }

    public static function hashVersion($string)
    {
        return base64_encode($string);
    }

    public static function setOrderID($id)
    {
        return rand(10000, 99999) . $id;
    }

    public static function getOrderID($id)
    {
        return substr($id, 5);
    }

    public static function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }

    public static function set_slash( $link )
    {
        return rtrim($link, '/') . '/';
    }
}
