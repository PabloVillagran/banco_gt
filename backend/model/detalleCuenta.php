<?php
require_once "database.php";

class DetalleCuentaModel extends Database{

    public function insertDetalle($cuenta, $monto, $fecha){
        return $this->insert("INSERT INTO `detalle_cuenta`
        (`Cuenta_idCuenta`,
        `monto`,
        `fecha`)
        VALUES
        (?,?,?)
        ", "iss", [$cuenta, $monto, $fecha]);
    }

    public function selectDetalle($cuenta){
        return $this->select("SELECT correlativo, monto, fecha 
        FROM detalle_cuenta 
        WHERE Cuenta_idCuenta = ?","i",[$cuenta]);
    }

    public function sumDetalle($cuenta){
        return $this->select("SELECT sum(monto) as sum
        FROM detalle_cuenta
        WHERE Cuenta_idCuenta = ?
        GROUP BY Cuenta_idCuenta", "i", [$cuenta]);
    }

}
?>