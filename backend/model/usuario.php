<?php 
require_once "database.php";
class UsuarioModel extends Database{

    public function getUser($user, $pass){
        return $this->select("SELECT idUsuario as log_in,
        correo as `name`,
        Cuenta_idCuenta as `cuenta`
        FROM usuario 
        where correo = ? 
        and `Password` = ?", "ss" , [$user, $pass]);
    }
    
    public function insertUsuario($cuenta, $correo, $telefono, $pass){
        return $this->insert("INSERT INTO `usuario`
        (`Cuenta_idCuenta`,
        `correo`,
        `telefono`,
        `Password`)
        VALUES
        (?,
        ?,
        ?,
        ?)","isss",[$cuenta, $correo, $telefono, $pass]);
    }

}
?>