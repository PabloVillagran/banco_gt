<?php
require_once "database.php";

class TercerosModel extends Database{

    public function insertRel($idOrigen, $idDestino){
        return $this->insert("INSERT INTO `terceros`
        (`principal`,
        `vinculada`)
        VALUES
        (?,?)", "ii", [$idOrigen, $idDestino]);
    }

    public function getTerceros($idOrigen){
        return $this->select("SELECT `idCuenta`, `Nombre`
        FROM cuenta 
        WHERE idCuenta IN (
            SELECT vinculada 
            FROM terceros 
            WHERE principal = ?
        )", "i", [$idOrigen]);
    }

}

?>