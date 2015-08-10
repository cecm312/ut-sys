<?php

class Product extends DBModel {
    
    public $defaultImage="default.jpg";
    public $dirUploadsProductImage="products/";

    function __construct() {
        
    }


    public function delete($idproducto="") {
        $result=false;
        if($idproducto!=""){
            $keys=array("estado"=>2);
            $result=$this->insert_update($keys, "products","idproducto='$idproducto'");
        }
        return $result;
        
    }
    
    public function getAll($where=""){
        $this->query="SELECT p.idproducto,p.nombre,p.imagen,p.cantidad,p.precio,p.descripcion,IFNULL(c.name,'Sin categoria') as categoria FROM products as p LEFT JOIN category as c ON(p.categoria=c.idcategory) $where ORDER BY p.fecha_creacion DESC";
        
        $result=$this->get_all_results_query();
        if($result){
            foreach ($this->rows as $row=>$value){
                $imagenProduct=$this->rows[$row]["imagen"];
                if(is_null($imagenProduct) or $imagenProduct==""){
                   $this->rows[$row]["imagen"]=UPLOADS_DIR.$this->dirUploadsProductImage.$this->defaultImage; 
                }else{
                    if(file_exists(SYSTEM_UPLOADS_DIR.$this->dirUploadsProductImage.$imagenProduct)){
                        $this->rows[$row]["imagen"]=UPLOADS_DIR.$this->dirUploadsProductImage.$this->rows[$row]["imagen"];
                    }else{
                        $this->rows[$row]["imagen"]=UPLOADS_DIR.$this->dirUploadsProductImage.$this->defaultImage;
                    }
                    
                }
            }
            return $this->rows;
        }else{
            return array();
        }
    }
    
    public function constructWhere($array=""){
        $arrayFilter=array();
        if(isset($array["palabraclave"]) and $array["palabraclave"]!=""){
            array_push($arrayFilter, "(p.nombre like '%".$array["palabraclave"]."%' or p.descripcion like '%".$array["palabraclave"]."%')" );
        }
        if(isset($array["categoria"]) and $array["categoria"]!=""){
            array_push($arrayFilter, "p.categoria like '".$array["categoria"]."'" );
        }
        if(isset($array["estado"]) and $array["estado"]!=""){
            array_push($arrayFilter, "p.categoria like '".$array["estado"]."'" );
        }else{
             array_push($arrayFilter, "p.estado like 1");
        }
        if(isset($array["products"]) and is_array($array["products"])){
            $arrayproductos=array();
            foreach ($array["products"] as $produc){
                array_push($arrayproductos,"idproducto='$produc'");
            }
            array_push($arrayFilter, "(".implode(" or ",$arrayproductos).")");
        }
        $where="";
        if(count($arrayFilter)>0){
            $where=" WHERE ".implode(" and ", $arrayFilter);
        }
        return $where;
    }
    
    public function getCategoryAll(){
        $this->query="SELECT * FROM category";
        $this->get_all_results_query();
        return $this->rows;
    }
    
    public function getCategoryOptions(){
        $options=$this->getCategoryAll();
        $arrayTemp=array();
        foreach($options as $row){
            $arrayTemp=$arrayTemp+array($row["idcategory"]=>$row["name"]);
        }
        return $arrayTemp;
    }
    
    public function saveCategory($params){
        $result=array("resultado"=>false);
        if(isset($params["categoryName"])){
            $keys=array(
                "name"=>$params["categoryName"]
            );
            $result=array("id"=>$this->insert_update($keys, "category"),"resultado"=>true);
        }
        return $result;
        
        
    }


    public function edit($array="") {
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


    public function get($idproduct="") {
        $this->query="SELECT * FROM products WHERE idproducto";
        $result=$this->get_all_results_query();
        if($result){
            return $this->rows;
        }else{
            return array();
        }
    }
    
    public function set($array="") {
        $result=0;
        $imagen=$this->defaultImage;
        if(isset($_FILES["imagenProducto"])){
            
            $imagenCopiada=$this->saveFile($_FILES["imagenProducto"],$this->dirUploadsProductImage);
            if($imagenCopiada["result"]==1){
                $imagen=$imagenCopiada["file"];
            }
        }
        if(is_array($array)){
            $keys=array(
                "nombre"=>$array["nombre"],
                "descripcion"=>$array["descripcion"],
                "cantidad"=>$array["cantidad"],
                "precio"=>$array["precio"],
                "imagen"=>$imagen,
                "categoria"=>$array["categoria"],
            );
            $result=$this->insert_update($keys, "products");
        }
        return array("resultado"=>$result);
        
    }

}

