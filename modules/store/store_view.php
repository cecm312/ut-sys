<?php

class StoreView extends View{
    
    public function __construct($views_dir) {
        parent::__construct($views_dir);
    }
    
    public function printLayout($layout="list",$req=array()){
        global $objProfile;
        $html="";
        switch($layout){
            case "list":
                $html=$this->print_list($req);
                break;
            case "car":
                $html=$this->print_layout_car();
                break;
            case "account":
                $html=$this->print_layout_account();
                break;
            case "buy":
                $html=$this->print_layout_buy();
                break;
        }
        $keys=array("LAYOUT"=>$html,"ACCOUNT_OPTIONS"=>$this->print_template($objProfile->tipo>1?"registerUser":"unRegisterUser"));
        return $this->print_template("container",$keys);
    }
    
    public function print_layout_buy(){
        global $objProfile;
        $html="";
        if($objProfile->tipo>1){
            $html=$this->print_template("finishOrder_layout");
        }else{
            $html=$this->print_template("login_layout");
        }
        return $html;
        
    }
    public function print_layout_account(){
        global $objProfile;
        $html="";
        if($objProfile->tipo>1){
            $html=$this->print_template("account");
        }else{
            $html=$this->print_template("login_layout");
        }
        return $html;
        
    }
    
    public function print_list($filters){
        global $objStore,$objProduct;
        $keys=array(
            "OPTIONS_CATEGORY"=>$this->create_options($objProduct->getCategoryOptions()),
            "PRODUCTS"=>$this->print_products($filters)
        );
        return $this->print_template("listProducts",$keys);
    }
    
    
    public function print_layout_car($_R){
        global $objProduct;
        $products=array();
        if(isset($_R["products"]) and is_array($_R["products"])){
            if(count($_R["products"])>0){
                $where=$objProduct->constructWhere($_R);
                $products=$objProduct->getAll($where);
            }
        }
        $keys=array(
            "TABLE"=>$this->print_table("car_products", $products)
        );
        return array("html"=>$this->print_template("car_layout",$keys));
    }
    
    public function print_products($filters=array()){
        global $objProduct;
        $where=$objProduct->constructWhere($filters);
        $products=$objProduct->getAll($where);
        $html="";
        foreach ($products as $product){
            $html.=$this->print_template("productMin",$product);
        }
        return $html;
    }
    
    
    
    
}

