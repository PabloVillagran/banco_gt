<?php
require_once "database.php";

class CuentaModel extends Database{

    public function getCuenta($id){
        return $this->select("SELECT * FROM cuenta where idCuenta = ?", "i" , [$id]);
    }

    public function insertCuenta($nombre, $DPI){
        return $this->insert("INSERT INTO cuenta 
        (Nombre, DPIAsociado)
        VALUES(?,?)", "ss", [$nombre,$DPI]);
    }

}

?>