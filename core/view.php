<?php

class View {

    private $views_dir;

    function __construct($views_dir) {
        $this->views_dir = $views_dir;
    }

    public function create_options($arrayOptions, $selected = "") {
        $html = "";
        foreach ($arrayOptions as $option => $value) {
            $sel = ($selected == $option) ? "selected" : "";
            $html.="<option $sel>$option</option>";
        }
        return $html;
    }

    public function print_template($template, $keys) {
        $file = $this->views_dir . $template . '.html';
        $html = file_get_contents($file);
        foreach ($keys as $clave => $valor) {
            # code...
            $html = str_replace('{' . $clave . '}', $valor, $html);
        }
        return $html;
    }

    public function print_rows_table($template, $arrayData) {
        $html = "";
        foreach ($arrayData as $array) {
            $html.= print_template($template, $array);
        } return $html;
    }

}
