<?php
include SYSTEM_MODULE_DIR.'/product_model.php';
include SYSTEM_MODULE_DIR.'/product_view.php';

$objProduct=new Product();
$objViewProduct=new ProductView(SYSTEM_MODULE_DIR.'/views/html/');

switch($action){
    case "default":
        $layout=isset($_REQUEST["layout"])?$_REQUEST["layout"]:"list";
        $html=$objViewProduct->printLayout($layout,$_REQUEST);
        break;
    case "saveProduct":
        echo json_encode($objProduct->set($_REQUEST));
        break;
    case "saveCategory":
        echo json_encode($objProduct->saveCategory($_REQUEST));
        break;
    case "searchProduct":
        $where=$objProduct->constructWhere($_REQUEST);
        $productos=$objProduct->getAll($where);
        echo json_encode(array("html"=>$objViewProduct->print_table("table_products", $productos)));
        break;
    case "deleteProduct":
        if(isset($_REQUEST["idproduct"]) and $_REQUEST["idproduct"]!=""){
            if($objProduct->delete($_REQUEST["idproduct"])){
               echo json_encode(array("resultado"=>true)); 
            }else{
                echo json_encode(array("resultado"=>false)); 
            };
        }else{
            echo json_encode(array("resultado"=>false));
        }
       
        break;
}
?>


