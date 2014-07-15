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
    echo '" data-content="' . $value["C_VIETNAMESE"];
    echo (!empty($value['C_EXAMPLE']) ? '<h5>' . translate('Ví dụ') . ':</h5>' . $value["C_EXAMPLE"] : '');
    echo ((!empty($value["C_IMAGE_LOCATION"]) && is_file('img/vocabulary/' . $value["C_IMAGE_LOCATION"])) ? "<h5>" . translate('Hình ảnh') . "</h5><img src='img/vocabulary/" . $value["C_IMAGE_LOCATION"] . "'/>" : '');
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
            <div class="accordion-inner">';
    echo (empty($value['C_WRITE_IMAGE_LOCATION']) || !is_file('img/kanji/' . $value['C_WRITE_IMAGE_LOCATION'])) ? "" :
            "<fieldset><legend>"
            . translate('Cách viết')
            . "</legend>"
            . '<img src="img/kanji/' . $value['C_WRITE_IMAGE_LOCATION'] . '" class="img-responsive">'
            . '</fieldset>';
    echo empty($value["C_ON"]) ? "" :
            "<fieldset>"
            . "<legend>" . translate("Âm Ôn")
            . "</legend>"
            . "<p>" . nl2br($value["C_ON"]) . "</p>"
            . '</fieldset>';
    echo empty($value["C_KUN"]) ? '' :
            '<fieldset>'
            . '<legend>'
            . translate('Âm Kun')
            . '</legend>'
            . '<p>' . nl2br($value['C_KUN']) . '</p>'
            . '</fieldset>';
    echo (empty($value["C_COMPOUND_WORD"]) || strlen($value["C_COMPOUND_WORD"]) <= 3) ? '' :
            '<fieldset>'
            . '<legend>'
            . translate('Từ ghép')
            . '</legend>'
            . '<p>' . nl2br($value['C_COMPOUND_WORD']) . '</p>'
            . '</fieldset>';
    echo '</div>
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

function single_qna_list($value)
{
    $value['COUNT_ANSWER'] = isset($value['COUNT_ANSWER']) ? $value['COUNT_ANSWER'] : 0;
    $value['COUNT_VOTE'] = isset($value['COUNT_VOTE']) ? $value['COUNT_VOTE'] : 0;
    $value['SUM_VOTE'] = isset($value['SUM_VOTE']) ? $value['SUM_VOTE'] : 0;
    $vote_up = ($value['COUNT_VOTE'] + $value['SUM_VOTE']) / 2;
    $vote_down = ($value['COUNT_VOTE'] - $value['SUM_VOTE']) / 2;
    echo '<tr>'
    . '<td class="center hidden-768">' . (isset($value['COUNT_ANSWER']) ? $value['COUNT_ANSWER'] : 0) . '</td>'
    . '<td class="center hidden-768">'
    . $value['SUM_VOTE']
    . ' (' . $vote_up . ' <i style="color:green" class="icon-arrow-up"></i>'
    . $vote_down . ' <i style="color:red" class=" icon-arrow-down"></i>)'
    . '</td>'
    . '<td><a href="' . get_controller_url('qna') . 'dsp_single_qna/' . $value['PK_QNA'] . '">' . $value['C_TITLE'] . '<a/></td>'
    . '<td>' . date_format(new DateTime($value['C_DATE_TIME']), 'H:i:s d/m/Y') . '</td>';
    if (about_user::is_admin()):
        echo '<td class="center">'
        . '<a href="' . get_controller_url('qna') . 'delete_qna/' . $value['PK_QNA'] . '">'
        . '<i class="icon-remove"></i>'
        . '</a>'
        . '</td>';
    endif;
    echo '</tr>';
}

function single_document($document)
{

    echo '<tr ' . (($document['C_SHOWN'] != 1) ? 'class="success"' : '') . '>'
    . '<td>' . $document['C_NAME'] . '.' . $document['C_EXT'] . '</td>'
    . '<td class="hidden-768">' . $document['C_UPLOADER_NAME'] . '</td>'
    . '<td class="hidden-1024">' . date_format(new DateTime($document['C_UPLOAD_DATE']), 'd-m-Y') . '</td>'
    . '<td>'
    . '<a href="' . get_controller_url('document') . 'download_document/' . $document['PK_DOCUMENT'] . '">'
    . '<i class="icon-cloud-download"></i>'
    . '</a>'
    . '</td>'
    . '<td class="hidden-768">';
    for ($i = 1; $i <= 5; $i++):
        $active = FALSE;
        if (round($document['AVG_RATING']) >= $i)
        {
            $active = true;
        }
        echo '<a style="color:' . (($active) ? '#f8a31f' : '#aaa')
        . '"rel="tooltip"  data-container="body" href="javascript:;"'
        . 'onclick="rate_document(' . $document['PK_DOCUMENT'] . ', ' . $i . ', this)"'
        . 'data-placement="top" title="' . $i . " " . translate("sao") . '">'
        . '<i class="' . (($active) ? 'icon-star' : 'icon-star-empty') . '"></i>'
        . '</a>';
    endfor;
    echo '(' . number_format($document['AVG_RATING'], 1)
    . '<i class="icon-star"></i>, '
    . (($document['COUNT_RATED_USER']) ? $document['COUNT_RATED_USER'] : 0)
    . '<i class="icon-user"></i>)'
    . '</td>';
    if (about_user::is_admin()):
        echo '<td>';
        if ($document['C_SHOWN'] != 1):
            echo '<a href="' . get_controller_url('document') . 'set_document_shown/' . $document['PK_DOCUMENT'] . '"><i class="icon-ok"></i></a>';
        endif;
        echo '</td>'
        . '<td>'
        . '<a href="' . get_controller_url('document')
        . 'delete_document/' . $document['PK_DOCUMENT'] . '">'
        . '<i class="icon-remove"></i>'
        . '</a>'
        . '</td>';
    endif;
    echo '</tr>';
}

function single_qna($value)
{
    $value['COUNT_ANSWER'] = isset($value['COUNT_ANSWER']) ? $value['COUNT_ANSWER'] : 0;
    $value['COUNT_VOTE'] = isset($value['COUNT_VOTE']) ? $value['COUNT_VOTE'] : 0;
    $value['SUM_VOTE'] = isset($value['SUM_VOTE']) ? $value['SUM_VOTE'] : 0;
    $vote_up = ($value['COUNT_VOTE'] + $value['SUM_VOTE']) / 2;
    $vote_down = ($value['COUNT_VOTE'] - $value['SUM_VOTE']) / 2;
    echo '<li class=left>'
    . '<div class="image" style="text-align: center">'
    . '<button rel="tooltip" data-container="body" data-placement="right" title="+1" class="btn" onclick="vote_qna(' . $value['PK_QNA'] . ',1,this)">'
    . '<i class="icon-arrow-up"></i>'
    . '</button>'
    . '<h3></h3>'
    . '<div style="font-size: x-large" class="sum_vote">' . $value['SUM_VOTE'] . '</div>'
    . ' <small>'
    . '(' . '<span class="vote_up">' . $vote_up . '</span>'
    . '<i style="color:green" class="icon-arrow-up"></i>'
    . '<span class="vote_down">' . $vote_down . '</span>'
    . '<i style="color:red" class=" icon-arrow-down"></i>)'
    . '</small>'
    . '<h3></h3>'
    . '<button  rel="tooltip" data-container="body" data-placement="right" title="-1" class="btn" onclick="vote_qna(' . $value['PK_QNA'] . ',-1,this)">'
    . '<i class="icon-arrow-down"></i>'
    . '</button>'
    . '</div>'
    . '<div class="message">'
    . '<span class = "name">' . $value['C_TITLE'] . '</span>'
    . '<a class="pull-right" rel="tooltip" data-container="body" data-placement="top" title="' . translate('Xóa bài đăng') . '" href="' . get_controller_url('qna') . 'delete_qna/' . $value['PK_QNA'] . '">'
    . '<i class="icon-remove"></i>'
    . '</a>'
    . '<hr>'
    . '<p>' . nl2br($value['C_CONTENT']) . '</p>'
    . '<hr>'
    . '<span class = "time">'
    . date_format(new DateTime($value['C_DATE_TIME']), 'H:i:s d/m/Y')
    . ' ' . translate('bởi')
    . ' '
    . $value['C_NAME']
    . '</span>'
    . '</div>'
    . '</li>';
}

?>