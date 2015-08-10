<?php

class ProductView extends View{
    
    public function __construct($views_dir) {
        parent::__construct($views_dir);
    }
    
    public function printLayout($layout="list",$req=array()){
        $html="";
        switch($layout){
            case "list":
                $html=$this->print_list($req);
                break;
            case "addproduct":
                $html=$this->print_add_product();
                break;
        }
        $keys=array("LAYOUT"=>$html);
        return $this->print_template("container", $keys);
    }
    
   
    public function print_list($params){
        global $objProduct;
        $where=$objProduct->constructWhere($params);
        $productos=$objProduct->getAll($where);
        $keys=array(
            "TABLE"=>$this->print_table("table_products", $productos),
            "OPTIONS_CATEGORY"=>$this->create_options($objProduct->getCategoryOptions())
        );
        return $this->print_template("listaProductos",$keys);
    }
    public function print_add_product(){
        global $objProduct;
        $html="";
        $keys=array(
            "OPTIONS_CATEGORY"=>$this->create_options($objProduct->getCategoryOptions())
        );
        return $this->print_template("addProduct",$keys);
    }
    
    
    
    
}

