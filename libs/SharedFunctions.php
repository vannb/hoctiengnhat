<?php
function hidden($name, $value = '')
{
    if (strpos($value, '"') !== FALSE)
    {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value=\'' . $value . '\' />';
    }
    else
    {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
    }
}
function get_post_var($html_object_name, $default_value = null, $is_replace_bad_char = TRUE)
{
    $var = isset($_POST[$html_object_name]) ? $_POST[$html_object_name] : $default_value;
    if (!$is_replace_bad_char || $default_value === null)
    {
        return $var;
    }
    if (is_string($var))
    {
        return replace_bad_char($var);
    }
    elseif (is_array($var))
    {
        array_walk_recursive($var, function(&$value)
        {
            replace_bad_char($value);
        });
    }
    return $var;
}
?>