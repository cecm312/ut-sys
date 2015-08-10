<?php

class BuyOrder extends DBModel {

    function __construct() {
        
    }
    
    public function delete($idproducto="") {        
    }
    
    public function getAll($where=""){
        
    }
    
    public function constructWhere($array=""){
        $arrayFilter=array();
        if(isset($array["requisitor"]) and $array["requisitor"]!=""){
            array_push($arrayFilter, "(p.nombre like '%".$array["palabraclave"]."%' or p.descripcion like '%".$array["palabraclave"]."%')" );
        }
        return $where;
    }
    

    public function edit($array="") {
        
    }


    public function get($idproduct="") {
        
    }
    
    public function set($array="") {
        global $objProfile;
        $result=0;
        if(is_array($array)){
            foreach($array as $clave=>$valor){
                $$clave=$valor;
            }
            $keys=array(
                "requisitor"=>$objProfile->idprofile,
                "paymethod"=>$paymethod,
                "delivermethod"=>$delivermethod
            );
            $idbuyorder=$this->insert_update($keys,"buy_order");
            if($idbuyorder){
                $result=true;
                foreach($products as $product){
                    $keys=array(
                        "idbuy_order"=>$idbuyorder,
                        "idproduct"=>$product["idproduct"],
                        "price"=>0,
                        "qty"=>$product["qty"]
                    );
                    $resultRelacion=$this->insert_update($keys, "buy_order_details");
                }
            }
        }
        return array("resultado"=>$result,"idorder"=>$idbuyorder);
        
    }

}

