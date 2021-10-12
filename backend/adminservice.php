<?php
include_once "baseservice.php";
include_once "model/administrador.php";

class AdminService extends BaseService{

    public function validateUser($payload){
        $adminCon = new AdministradorModel();
        $this->sendOutput(json_encode($adminCon->getUser($payload->user, $payload->pass)));
    }

}
?>