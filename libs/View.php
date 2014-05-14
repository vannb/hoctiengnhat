<?php

class View {

    protected $name = '';
    public $template;
    public $popup_msg = '';

    function __construct($name) {
        $this->name = $name;
        $this->template->default_navbar = array(
            "Trang chủ" => URL.'home',
            "Bài giảng" => array('Phồn thể' => 'bloh'),
            "Chữ Hán" => array('')
        );
    }

    public function get_controller_url($name = null) {
        if (empty($name)) {
            $name = $this->name;
        }

        return URL . $name . '/';
    }

    public function render_error($msg = ''){
        require 'views/error.php';
        die();
    }
    
    public function render($file, $popup_msg = null, $render_header = 1) {
        if (!file_exists('views/' . $file . '.php')) {
            if (DEBUG_MODE == false) {
                $this->render_error('Không tìm thấy file view');
            } elseif (DEBUG_MODE == true) {
                echo "Không tìm thấy <b>$file</b>";
            }
            die();
        }
        $this->popup_msg = $popup_msg;
        if ($render_header) {
            require 'views/header' . $render_header . '.php';
            require 'views/' . $file . '.php';
            require 'views/footer' . $render_header . '.php';
        } else {
            require 'views/' . $file . '.php';
        }
    }

    public static function hidden($name, $value = '') {
        if (strpos($value, '"') !== FALSE) {
            return '<input type="hidden" name="' . $name . '" id="' . $name . '" value=\'' . $value . '\' />';
        } else {
            return '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />';
        }
    }

    public static function generate_select_option($arrData, $selected = NULL, $public_xml_file_name = '') {
        $html = '';
        if ($public_xml_file_name !== '') {
            $f = SERVER_ROOT . 'public/xml/' . $public_xml_file_name;
            if (file_exists($f)) {
                $xml = simplexml_load_file($f);
                $items = $xml->xpath("//item");
                foreach ($items as $item) {
                    $str_selected = ($item->attributes()->name == strval($selected)) ? ' selected' : '';
                    $html .= '<option value="' . $item->attributes()->name . '"' . $str_selected . '>' . $item->attributes()->value . '</option>';
                }
            }
        } else {
            foreach ($arrData as $key => $val) {
                $str_selected = ($key == strval($selected)) ? ' selected' : '';
                $html .= '<option value="' . $key . '"' . $str_selected . '>' . $val . '</option>';
            }
        }
        return $html;
    }

    public static function paging($page, $rows_per_page, $total_record) {
        $html = '';

        if ($total_record % $rows_per_page == 0) {
            $v_total_page = $total_record / $rows_per_page;
        } else {
            $v_total_page = intval($total_record / $rows_per_page) + 1;
        }

        $arr_page = array();
        for ($i = 1; $i <= $v_total_page; $i++) {
            $arr_page[$i] = __('page') . '&nbsp;' . $i;
        }

        $html .= '<div class="pager" id="pager">';
        $html .= __('total') . ' ' . $v_total_page . ' ' . __('page');

        $html .= '. ' . __('go to') . '<select name="sel_goto_page" onchange="this.form.submit();">';
        $html .= self::generate_select_option($arr_page, $page);
        $html .= '</select>';

        $html .= __('display') . '<select name="sel_rows_per_page" onchange="this.form.sel_goto_page.value=1;this.form.submit();">';
        $html .= self::generate_select_option(null, $rows_per_page, 'xml_rows_per_page.xml');
        $html .= '</select> ' . __('record') . '/1 ' . __('page');

        $html .= '</div>';

        return $html;
    }

    public static function paging2($arr_all_record) {
        $html = '';

        $rows_per_page = isset($_POST['sel_rows_per_page']) ? replace_bad_char($_POST['sel_rows_per_page']) : _CONST_DEFAULT_ROWS_PER_PAGE;
        if (isset($arr_all_record[0]['TOTAL_RECORD'])) {
            $page = isset($_POST['sel_goto_page']) ? replace_bad_char($_POST['sel_goto_page']) : 1;
            $total_record = $arr_all_record[0]['TOTAL_RECORD'];
        } else {
            $page = 1;
            $total_record = $rows_per_page;
        }

        if ($total_record % $rows_per_page == 0) {
            $v_total_page = $total_record / $rows_per_page;
        } else {
            $v_total_page = intval($total_record / $rows_per_page) + 1;
        }

        $arr_page = array();
        for ($i = 1; $i <= $v_total_page; $i++) {
            $arr_page[$i] = __('page') . '&nbsp;' . $i;
        }

        $html .= '<div class="pager" id="pager">';
        $html .= __('total') . ' ' . $v_total_page . ' ' . __('page');

        $html .= '. ' . __('go to') . '<select name="sel_goto_page" onchange="this.form.submit();">';
        $html .= self::generate_select_option($arr_page, $page);
        $html .= '</select>';

        $html .= __('display') . '<select name="sel_rows_per_page" onchange="this.form.sel_goto_page.value=1;this.form.submit();">';
        $html .= self::generate_select_option(null, $rows_per_page, 'xml_rows_per_page.xml');
        $html .= '</select> ' . __('record') . '/1 ' . __('page');

        $html .= '</div>';

        return $html;
    }

    public static function required($n = 1) {
        $html = '<font color="#FF0000">';
        for ($i = 1; $i <= $n; $i++) {
            $html .= '*';
        }
        $html .= '</font>';

        return $html;
    }

}
