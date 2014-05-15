<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

class MultiLang {

    CONST DEFAULT_LANGUAGE = 'vn';

    protected static $_arr_dictionary = array();

    static function set_language($lang) {
        Cookie::set('language', $lang);
        static::load($lang);
    }

    static function get_language() {
        return (Cookie::get('language') ? Cookie::get('language') : static::DEFAULT_LANGUAGE);
    }

    public static function load($lang) {
        $v_xml_lang_file = SERVER_ROOT . 'langs' . DS . $lang . '.lang.xml';
        if (!file_exists($v_xml_lang_file)) {
            trigger_error($v_xml_lang_file . ' khong ton tai');
            return;
        }
        static::_get_cache($lang);
    }

    protected static function _get_cache($lang) {
        $v_xml = SERVER_ROOT . 'langs' . DS . $lang . '.lang.xml';
        $v_cache = SERVER_ROOT . 'langs' . DS . 'cache' . DS . "{$lang}.cache";

        $is_up_to_date = false;
        $is_up_to_date = file_exists($v_cache) ? filemtime($v_xml) < filemtime($v_cache) : false;
        if (!$is_up_to_date) {
            $dom = simplexml_load_file($v_xml);
            if (!$dom) {
                return array();
            }
            foreach ($dom->xpath('//text') as $dom_text) {
                $key = strval($dom_text->attributes()->name);
                $val = strval($dom_text);
                if (isset(static::$_arr_dictionary[$key])) {
                    trigger_error('XML ngon ngu trung lap tu khoa ' . $v_xml);
                }
                static::$_arr_dictionary[$key] = $val;
            }
            if (!is_dir(dirname($v_cache))) {
                mkdir(dirname($v_cache), 0777, true);
            }
            file_put_contents($v_cache, serialize(static::$_arr_dictionary));
        } else {
            static::$_arr_dictionary = unserialize(file_get_contents($v_cache));
        }
    }

    public static function translate($text, $force_language = false) {
        return $text;
//        if (!isset(static::$_arr_dictionary[strval($text_key)]))
//        {
//            trigger_error('Thieu ngon ngu cho ' . $text_key);
//            return "[[$text_key]]";
//        }
//        $string = static::$_arr_dictionary[strval($text_key)];
//        $arr_search = array();
//        $params = array_values($params);
//        for ($i = 0; $i < count($params); $i++)
//        {
//            $arr_search[] = '$' . ($i + 1);
//        }
//        return str_replace($arr_search, $params, $string);
    }

}

/**
 * Dịch ra ngôn ngữ
 * @param string $text
 * @return string
 */
function __($text, $params = array()) {
    return Lang::translate($text, $params);
}
