<?php
include SYSTEM_MODULE_DIR.'/store_model.php';
include SYSTEM_MODULE_DIR.'/store_view.php';
include SYSTEM_MODULES_DIR.'product/product_model.php';

$objStore=new Store();
$objProduct=new Product();
$objViewStore=new StoreView(SYSTEM_MODULE_DIR.'/views/html/');

if(isset($_REQUEST["buy"])){
    $action="printLayoutBuy";
}
if(isset($_REQUEST["myaccount"])){
    $action="printLayoutAccount";
}
switch($action){
    case "default":
        $layout=isset($_REQUEST["layout"])?$_REQUEST["layout"]:"list";
        $html=$objViewStore->printLayout($layout,$_REQUEST);
        break;
    case "printLayoutCar":
        echo json_encode($objViewStore->print_layout_car($_REQUEST));
        break;
    case "printLayoutBuy":
        $html=$objViewStore->printLayout("buy");
        break;
    case "printLayoutAccount":
        $html=$objViewStore->printLayout("account");
        break;
}
?>


