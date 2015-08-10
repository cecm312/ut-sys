<?php
include SYSTEM_MODULE_DIR.'/product_model.php';
include SYSTEM_MODULE_DIR.'/product_view.php';

$objProduct=new Product();
$objViewProduct=new ProductView(SYSTEM_MODULE_DIR.'/views/html/');

switch($action){
    case("default"):
        $layout=isset($_REQUEST["layout"])?$_REQUEST["layout"]:"list";
        $html=$objViewProduct->printLayout($layout,$_REQUEST);
        break;
}
?>


