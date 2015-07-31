<?php

class User extends DBModel{
    public $type;//tipo de usuario=1-invitado,2-cliente,3-administrador
    public $image;
    public $name;
    

    function __construct($idUser) {
        $this->get();
    }
    
    protected function delete() {
        
    }

    protected function edit() {
        
    }

    protected function get() {
        $this->type=1;
        $this->image="image";
        $this->name="Usuario Invitado";
    }

    protected function set() {
        
    }
}