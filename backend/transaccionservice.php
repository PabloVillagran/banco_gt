<?php
include_once "baseservice.php";
include_once "model/transaccion.php";
include_once "model/detalleCuenta.php";

class TransaccionService extends BaseService{

    public function postCaja($payload){
        $detalleCuentaModel = new DetalleCuentaModel();
        $transaccionModel = new TransaccionModel();
        
        $monto  = $payload->monto;
        $fecha  = date('Y-m-d H:i:s', strtotime($payload->fecha));

        $detalleResult = $detalleCuentaModel->insertDetalle($payload->cuenta, $monto, $fecha);
        $det_id = $detalleResult["id"];
        $cajero = $payload->idCajero;

        $this->sendOutput(json_encode($transaccionModel->insertTransaccion($cajero, $det_id, $fecha, $monto)));
    }

}
?>