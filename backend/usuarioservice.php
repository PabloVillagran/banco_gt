<?php
include_once "baseservice.php";
include_once "model/usuario.php";

class UsuarioService extends BaseService{

    public function validateUser($payload){
        $model = new UsuarioModel();
        $this->sendOutput(json_encode($model->getUser($payload->user, $payload->pass)));
    }

    public function addUser($payload){
        $model = new UsuarioModel();
        $this->sendOutput(json_encode($model->insertUsuario($payload->cuenta, $payload->correo, $payload->telefono, $payload->pass)));
    }

}
?>