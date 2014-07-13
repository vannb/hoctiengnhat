<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<?php

function hidden($name, $value = '')
{
    if (strpos($value, '"') !== FALSE)
    {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value=\'' . $value . '\' />';
    } else
    {
        return '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
    }
}

function paginator($url, $total_record)
{
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $record_per_page = DEFAULT_ROWS_PER_PAGE;
    echo "<div class='table-pagination'>";
    echo "<a " . (($page > 1) ? "href='" . $url . "&page=1'" : "class='disabled'") . ">" . translate('Trang đầu') . "</a>";
    echo "<a " . (($page > 1) ? "href='" . $url . "&page=" . ($page - 1) . "'" : "class='disabled'") . "'>" . translate('Trang trước') . "</a>";
    echo "<span>";
    $number_of_page = floor(($total_record - 1) /
            $record_per_page + 1);
    for ($i = 1; $i <= $number_of_page; $i++)
    {
        echo "<a href='" . $url . "&page=" . $i . "' class='" . (($page == $i) ? 'active' : '') . "'>" . $i . "</a>";
    }
    echo "</span>";
    echo "<a " . (($page < $number_of_page) ? "href='" . $url . "&page=" . ($page + 1) . "'" : "class='disabled'") . ">" . translate('Trang sau') . "</a>";
    echo "<a " . (($page < $number_of_page) ? "href='" . $url . "&page=" . $number_of_page . "'" : "class='disabled'") . ">" . translate('Trang cuối') . "</a>";
    echo "</div>";
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

function redirect_post($url, $arr_post)
{
    $html = '<html><head></head><body>';
    $html .= '<form name="redirect_post" action="' . $url . '" method="POST">';

    foreach ($arr_post as $key => $val)
    {
        $html .= View::hidden($key, $val);
    }

    $html .= '</form>';
    $html .= '<script type="text/javascript">document.redirect_post.submit();</script>';
    $html .= '</body></html>';

    echo $html;
    exit;
}

function redirect_popup_msg($url, $message)
{
    redirect_post($url, array('popup_msg' => $message));
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
        return htmlspecialchars($var);
    } elseif (is_array($var))
    {
        array_walk_recursive($var, function(&$value) {
            htmlspecialchars($value);
        });
    }
    return $var;
}

function get_controller_url($name)
{
    return URL . $name . '/';
}

function translate($text, $force_language = false)
{
    return MultiLang::translate($text);
}

function single_vocab($value)
{
    echo '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 term_wrap">
                <div class="single_term" data-html="true"
                rel="popover" data-trigger="hover click"
                data-placement="bottom" title="' . $value["C_JAPANESE"];
    echo (!empty($value['C_TYPE']) ? ' (' . $value["C_TYPE"] . ')' : '');
    echo '" data-content="<h4>' . translate('Ý nghĩa') . ':</h4>' . $value["C_VIETNAMESE"];
    echo ((!empty($value["C_IMAGE_LOCATION"]) && is_file($value["C_IMAGE_LOCATION"])) ? "<img src='" . $value["C_IMAGE_LOCATION"] . "'/>" : '');
    echo (!empty($value['C_EXAMPLE']) ? '<h4>' . translate('Ví dụ') . ':</h4>' . $value["C_EXAMPLE"] : '');
    echo '">
        <div class = "word japanese col-xs-3">' . $value['C_JAPANESE'] . '</div>
        <div class = "word vietnamese col-xs-7">' . $value['C_VIETNAMESE'] . '</div>
        <div class = "term_action col-xs-2">
        <a href = "javascript:;"
        onclick = "toggle_star_vocab(' . $value['PK_VOCABULARY'] . ', this)"
        class = "sel-star' . (($value['PK_STARRED']) ? ' active ' : '') . '"
        rel = "tooltip" data-container = "body"
        data-placement = "top" title = "' . translate("Đánh dấu") . '">
        <i class = "icon-star"></i>
        </a>
        <a href = "' . get_controller_url('vocabulary') . 'dsp_starred_vocabulary"
        rel = "tooltip" data-container = "body" data-placement = "top"
        title = "' . translate("Xem tất cả đánh dấu") . '"
        >(' . translate("Tất cả") . ')
        </a>
        </div>
        <div>
        </div>
        </div>
        </div>';
}

function single_kanji($value)
{
    echo '<div class="accordion-group" style="margin-right: 80px">
        <div class="pull-right" style="right: -80px;position: relative">
            <a href="javascript:;"
               onclick="toggle_star_kanji(' . $value["PK_KANJI"] . ', this)"
               class="sel-star' . (($value["PK_STARRED"]) ? " active " : "") . '"
               rel="tooltip"  data-container="body"
               data-placement="top"
               title="' . translate("Đánh dấu") . '">
                <i class="icon-star"></i>
            </a>
            <a href="' . get_controller_url('kanji') . 'dsp_starred_kanji"
               rel="tooltip"  data-container="body" data-placement="top" 
               title="' . translate("Xem tất cả đánh dấu") . '"
               >(' . translate("Tất cả") . ')
            </a>
        </div>
        <div class="accordion-heading">
            <div class="accordion-toggle" data-toggle="collapse"
            data-parent="#accordion_kanji" href="#kanji_' . $value["PK_KANJI"] . '">'
    . $value["C_CHARACTER"] . ' - ' . $value['C_SINO_VIETNAMESE']
    . '</div>
        </div>
        <div id="kanji_' . $value["PK_KANJI"] . '" class="accordion-body collapse">
            <div class="accordion-inner">
                <fieldset>';
    echo (empty($value['C_WRITE_IMAGE_LOCATION']) || !is_file('img/kanji/' . $value['C_WRITE_IMAGE_LOCATION'])) ? "" :
            "<legend>"
            . translate('Cách viết')
            . "</legend>"
            . '<img src="img/kanji/' . $value['C_WRITE_IMAGE_LOCATION'] . '" class="img-responsive">'
            . '</fieldset>
                <fieldset>';
    echo empty($value["C_ON"]) ? "" :
            "<legend>" . translate("Âm Ôn")
            . "</legend>"
            . "<p>" . nl2br($value["C_ON"]) . "</p>"
            . '</fieldset>
                <fieldset>';
    echo empty($value["C_KUN"]) ? '' :
            '<legend>'
            . translate('Âm Kun')
            . '</legend>'
            . '<p>' . nl2br($value['C_KUN']) . '</p>'
            . '</fieldset>';
    echo empty($value["C_COMPOUND_WORD"]) ? '' :
            '<legend>'
            . translate('Từ ghép')
            . '</legend>'
            . '<p>' . nl2br($value['C_COMPOUND_WORD']) . '</p>'
            . '</fieldset>
            </div>
        </div>
    </div>';
}

function single_grammar($value)
{
    echo '<div class="accordion-group" style="margin-right: 80px">
        <div class="pull-right" style="right: -80px;position: relative">
            <a href="javascript:;"
               onclick="toggle_star_grammar(' . $value["PK_GRAMMAR"] . ', this)"
               class="sel-star' . (($value["PK_STARRED"]) ? " active " : "") . '"
               rel="tooltip"  data-container="body"
               data-placement="top"
               title="' . translate("Đánh dấu") . '">
                <i class="icon-star"></i>
            </a>
            <a href="' . get_controller_url('grammar') . 'dsp_starred_grammar"
               rel="tooltip"  data-container="body" data-placement="top" 
               title="' . translate("Xem tất cả đánh dấu") . '"
               >(' . translate("Tất cả") . ')
            </a>
        </div>
        <div class="accordion-heading">
            <div class="accordion-toggle" data-toggle="collapse"
            data-parent="#accordion_grammar" href="#grammar_' . $value["PK_GRAMMAR"] . '">';
    echo $value["C_NAME"] . '
            </div>
        </div>
        <div id="grammar_' . $value["PK_GRAMMAR"] . '" class="accordion-body collapse">
            <div class="accordion-inner">
                <fieldset>';
    echo empty($value["C_GRAMMAR"]) ? "" :
            "<legend>"
            . translate("Cấu trúc")
            . "</legend>"
            . "<p>" . nl2br($value["C_GRAMMAR"]) . "</p>"
            . '</fieldset>
                <fieldset>';
    echo empty($value["C_USAGE"]) ? "" :
            "<legend>" . translate("Cách dùng")
            . "</legend>"
            . "<p>" . nl2br($value["C_USAGE"]) . "</p>"
            . '
                </fieldset>
                <fieldset>';
    echo empty($value["C_EXAMPLE"]) ? '' :
            '<legend>'
            . translate('Ví dụ')
            . '</legend>'
            . '<p>' . nl2br($value['C_EXAMPLE']) . '</p>'
            . '
                </fieldset>
            </div>
        </div>
    </div>';
}

?>