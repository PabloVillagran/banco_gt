<?php
include_once "baseservice.php";
include_once "model/cajero.php";

class CajeroService extends BaseService{

    public function validateUser($payload){
        $model = new CajeroModel();
        $this->sendOutput(json_encode($model->getUser($payload->user, $payload->pass)));
    }

    public function getCajeros($payload){
        $model = new CajeroModel();
        if(isset($payload["id"]))$id=$payload["id"];
        else $id =null;
        $this->sendOutput(json_encode($model->getCajeros($id)));
    }

    public function postCajero($payload){
        $model = new CajeroModel();
        $this->sendOutput(json_encode($model->insertCajero($payload->nombre, $payload->usuario, $payload->pass, $payload->id_admin)));
    }

    public function putCajero($payload){
        $model = new CajeroModel();
        $this->sendOutput(json_encode($model->updateCajero($payload->id, $payload->status)));
    }

}
?>