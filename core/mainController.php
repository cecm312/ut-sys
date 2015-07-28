<?php


session_start();
$uri = $_SERVER['REQUEST_URI'];

$_CONFIG['ROOT_BASE'] = getcwd();
echo $_SERVER['DOCUMENT_ROOT'];
echo "</br>";
echo $_SERVER['HTTP_HOST'];
echo "</br>";
echo $_SERVER['SERVER_ADDR'];
echo "</br>";
echo $_SERVER['REQUEST_URI'];
        
        
echo getcwd();
   function config($dominio, $ip) {

        if (isset($dominio['host']))
            $dominio = $dominio['host'];
        else
            $dominio = $dominio['path'];

        $pos = strpos($dominio, "www.");

        if ($pos !== true) {
            $dominio = $this->saca_dominio($dominio);
        }

        $where_url = "url LIKE '%" . $dominio . "%'";

        return $this->fetch_array("SELECT * FROM config c,config_register cr WHERE c.idconfig=cr.syte AND $where_url");
    }

    function saca_dominio($url) {
        $url = explode('/', str_replace('www.', '', str_replace('http://', '', $url)));
        return $url[0];
    }
    
echo $uri;