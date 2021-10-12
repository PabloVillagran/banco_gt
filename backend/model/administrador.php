<?php
require_once "database.php";

class AdministradorModel extends Database{

    public function getUser($user, $pass){
        return $this->select("SELECT idAdministrador as log_in, 
        Nombre as `name`
        FROM administrador where usuario = ? and password = ?", "ss" , [$user, $pass]);
    }

}

?>