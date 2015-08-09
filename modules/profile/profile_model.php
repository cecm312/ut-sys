<?php

class Profile extends DBModel{
    public $tipo;//tipo de usuario=1-invitado,2-cliente,3-administrador
    public $imagen;
    public $nombre;
    

    function __construct($idprofile) {
        $this->get($idprofile);
    }
    
    protected function delete() {
        
    }

    protected function edit() {
        
    }

    protected function get($idprofile="") {
        if($idprofile!=""){
            $query="SELECT * FROM perfil WHERE idprofile='$idprofile'";
            $this->query=$query;
            $this->get_result_query();
            foreach($this->rows as $row=>$value){
                $this->$row=$value;
            }
        }
    }

    protected function set() {
        
    }
}