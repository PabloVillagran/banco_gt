<?php
require_once "database.php";

class TransaccionModel extends Database{

    public function insertTransaccion($cajero, $det_id, $fecha, $monto){
        return $this->insert("INSERT INTO `transaccion`
        (`Cajero_idCajero`,
        `detalle_cuenta_correlativo`,
        `fecha`,
        `monto`)
        VALUES
        (?,?,?,?)", "iiss", [$cajero, $det_id, $fecha, $monto]);
    }

}
?>