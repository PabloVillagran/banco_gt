<?php
include_once "baseservice.php";
include_once "model/detalleCuenta.php";
include_once "model/terceros.php";

class TercerosService extends BaseService{

    public function transferenciaTercero($payload){
        $detalleCuentaModel = new DetalleCuentaModel();
        
        $monto  = $payload->monto;
        $_monto = $monto * -1;
        $fecha  = date('Y-m-d H:i:s', strtotime($payload->fecha));

        $detalleOrigen = $detalleCuentaModel->insertDetalle($payload->origen, $_monto, $fecha);
        $detalleDestino = $detalleCuentaModel->insertDetalle($payload->destino, $monto, $fecha);

        $this->sendOutput(json_encode(array("idDetOrigen"=>$detalleOrigen["id"], "idDetDestino"=>$detalleDestino["id"])));
    }

    public function addTercero($payload){
        $model = new TercerosModel();
        return $this->sendOutput(json_encode($model->insertRel($payload->idOrigen,$payload->idDestino)));
    }

    public function getTerceros($payload){
        $model = new TercerosModel();
        return $this->sendOutput(json_encode($model->getTerceros($payload["id"])));
    }

}
?>