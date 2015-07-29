<?php

class View {

    public function create_options($arrayOptions, $selected = "") {
        $html = "";
        foreach ($arrayOptions as $option => $value) {
            $sel = ($selceted == $option) ? "selected" : "";
            $html.="<option $sel>$option</option>";
        }
        return $html;
    }

    function print_template($template, $keys) {
        $file = MODULE_DIRECTORY . '/' . MODULE . '/views' . $template . '.html';
        $html = file_get_contents($file);
        foreach ($keys as $clave => $valor) {
            # code...
            $html = str_replace('{' . $clave . '}', $valor, $html);
        }
        return $html;
    }

    function print_rows_table($template, $arrayData) {
        $html = "";
        foreach ($arrayData as $array) {
            $html.= print_template($template, $array);
        
}        return $html;
    }

}
