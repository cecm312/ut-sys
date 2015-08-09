<?php

include_once(SYSTEM_MODULE_DIR."/".$moduleName."_view.php");

$objView=new View_WebSite(MODULE_HTML_DIR);
$page=isset($_REQUEST["page"])?$_REQUEST["page"]:"index";

switch ($action){
    case "default":
        $html=$objView->print_template($page);
        break;
}