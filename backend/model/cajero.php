<?php
require_once "database.php";

class CajeroModel extends Database{

    public function getCajeros($adminid=null){
        if(isset($adminid)){
            return $this->select("SELECT idCajero, Nombre, 
            usuario, Administrador_idAdministrador, activo 
            FROM cajero
            where Administrador_idAdministrador = ?","i",[$adminid]);
        }
        return $this->select("SELECT idCajero, Nombre, 
        usuario, Administrador_idAdministrador, activo 
        FROM cajero","",[]);
    }

    public function getUser($user, $pass){
        return $this->select("SELECT `idCajero` as `log_in`,
        `Nombre` as `name`
        FROM `cajero` 
        where `usuario` = ?
        and `password` = ?
        and `activo` = 1", "ss" , [$user, $pass]);
    }

    public function insertCajero($nombre, $usuario, $pass, $id_admin){
        return $this->insert("INSERT INTO cajero
        (Nombre,
        usuario,
        password,
        Administrador_idAdministrador)
        VALUES(?,?,?,?)", "sssi", [$nombre,$usuario,$pass,$id_admin]);
    }

    public function updateCajero($id, $status){
        return $this->update("UPDATE cajero
        SET activo = ?
        WHERE idCajero = ?", "ii", [$status, $id]);
    }

}

?>