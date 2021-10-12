<?php
include_once "baseservice.php";
include_once "model/detalleCuenta.php";

class DetalleService extends BaseService{

    public function getDetalle($payload){
        $model = new DetalleCuentaModel();
        $id = $payload["id"];
        $detalle = $model->selectDetalle($id);
        $sum = $model->sumDetalle($id);

        $this->sendOutput(json_encode(array("detalle"=>$detalle,"total"=>$sum)));
    }

}
?>