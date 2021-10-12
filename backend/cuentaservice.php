<?php
include_once "baseservice.php";
include_once "model/cuenta.php";

class CuentaService extends BaseService{

    public function get($payload){
        $model = new CuentaModel();
        $this->sendOutput(json_encode($model->getCuenta($payload["id"])));
    }

    public function post($payload){
        $model = new CuentaModel();
        $this->sendOutput(json_encode($model->insertCuenta($payload->nombre, $payload->DPI)));
    }

}
?>