<?php
include SYSTEM_MODULE_DIR.'/buy_order_model.php';
include SYSTEM_MODULE_DIR.'/buy_order_view.php';

$objBuyOrder=new BuyOrder();
switch($action){
    case "default":
        $layout=isset($_REQUEST["layout"])?$_REQUEST["layout"]:"list";
        $html=$objViewProduct->printLayout($layout,$_REQUEST);
        break;
    case "setOrder":
        echo json_encode($objBuyOrder->set($_POST));
        break;
}
?>


