<?php

class Product extends DBModel {

    function __construct() {
        
    }


    protected function delete() {
        
    }
    
    public function getAll($where=""){
        $this->query="SELECT * FROM products $where";
        $result=$this->get_all_results_query();
        if($result){
            return $this->rows;
        }else{
            return array();
        }
    }
    
    public function constructWhere($array=""){
        $arrayFilter=array();
        if(isset($array["palabraclave"]) and $array["palabraclave"]!=""){
            array_push($arrayFilter, "nombre like '%".$array["palabraclave"]."%'" );
            array_push($arrayFilter, "descripcion like '%".$array["palabraclave"]."%'" );
        }
        if(isset($array["categoria"]) and $array["categoria"]!=""){
            array_push($arrayFilter, "categoria like '".$array["categoria"]."'" );
        }
        $where="";
        if(count($arrayFilter)>0){
            $where=" WHERE ".implode(" and ", $arrayFilter);
        }
        return $where;
    }


    protected function edit($array="") {
        if(is_array($array)){
            $keys=array(
                "nombre"=>$array["nombre"],
                "descripcion"=>$array["descripcion"],
                "cantidad"=>$array["cantidad"],
                "precio"=>$array["precio"],
                "imagen"=>$array["categoria"],
                "categoria"=>$array["categoria"],
            );
            $this->insert_update($keys, "products","idproducto='".$array["idproducto"]."'");
        }
    }


    protected function get($idproduct="") {
        $this->query="SELECT * FROM products WHERE idproducto";
        $result=$this->get_all_results_query();
        if($result){
            return $this->rows;
        }else{
            return array();
        }
    }
    
    protected function set($array="") {
        if(is_array($array)){
            $keys=array(
                "nombre"=>$array["nombre"],
                "descripcion"=>$array["descripcion"],
                "cantidad"=>$array["cantidad"],
                "precio"=>$array["precio"],
                "imagen"=>$array["categoria"],
                "categoria"=>$array["categoria"],
            );
            $this->insert_update($keys, "products");
        }
    }

}

