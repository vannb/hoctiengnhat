<?php

function hidden($name, $value = '') {
    if (strpos($value, '"') !== FALSE) {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value=\'' . $value . '\' />';
    } else {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
    }
}

function redirect_post($url, $arr_post) {
    $html = '<html><head></head><body>';
    $html .= '<form name="redirect_post" action="' . $url . '" method="POST">';

    foreach ($arr_post as $key => $val) {
        $html .= View::hidden($key, $val);
    }

    $html .= '</form>';
    $html .= '<script type="text/javascript">document.redirect_post.submit();</script>';
    $html .= '</body></html>';

    echo $html;
    exit;
}

function redirect_popup_msg($url, $message) {
    redirect_post($url, array('popup_msg' => $message));
}

function get_post_var($html_object_name, $default_value = null, $is_replace_bad_char = TRUE) {
    $var = isset($_POST[$html_object_name]) ? $_POST[$html_object_name] : $default_value;
    if (!$is_replace_bad_char || $default_value === null) {
        return $var;
    }
    if (is_string($var)) {
        return htmlspecialchars($var);
    } elseif (is_array($var)) {
        array_walk_recursive($var, function(&$value) {
            htmlspecialchars($value);
        });
    }
    return $var;
}

function translate($text,$force_language = false){
    return MultiLang::translate($text);
}
?>