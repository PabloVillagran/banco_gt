<?php
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if($_SERVER['REQUEST_METHOD']=='GET'){
    $payload = $_GET;
}else{
    $payload = json_decode(file_get_contents("php://input"));
    if(!isset($payload)){
        $payload = json_encode($_REQUEST);
        echo print_r($_POST);
    }
}

header("HTTP/1.1 404 Not Found");

if(isset($uri[2])){
    if($uri[2]=='admin'){
        require 'backend/adminservice.php';
        $controller = new AdminService();
        if($uri[3]=='login'){
            $controller->validateUser($payload);
        }
    }else if($uri[2]=='cajero'){
        require 'backend/cajeroservice.php';
        $controller = new CajeroService();
        switch($_SERVER['REQUEST_METHOD'])
        {
        case 'GET': $controller->getCajeros($payload);break;
        case 'POST':
            if($uri[3]=='login'){
                $controller->validateUser($payload);
            }else if($uri[3]=='add'){
                $controller->postCajero($payload);
            }
            break;
        case 'PUT': $controller->putCajero($payload);break;
        }
    }else if($uri[2]=='cuenta'){
        require 'backend/cuentaservice.php';
        $controller = new CuentaService();
        switch($_SERVER['REQUEST_METHOD'])
        {
        case 'GET': 
            if(isset($uri[3])&&$uri[3]=='detalle'){
                require 'backend/detalleservice.php';
                $detController = new DetalleService();
                $detController->getDetalle($payload);
            }else{
                $controller->get($payload);
            }
            break;
        case 'POST': $controller->post($payload);break;
        }
    }else if($uri[2]=='transac'){
        require 'backend/transaccionservice.php';
        $controller = new TransaccionService();
        if($uri[3]=='caja'){
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $controller->postCaja($payload);
            }
        }
    }else if($uri[2]=='user'){
        require 'backend/usuarioservice.php';
        $controller = new UsuarioService();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if($uri[3]=='login'){
                $controller->validateUser($payload);
            }else if($uri[3]=='create'){
                $controller->addUser($payload);
            }
        }
    }else if($uri[2]=='tercero'){
        require 'backend/tercerosservice.php';
        $controller = new TercerosService();
        switch($_SERVER['REQUEST_METHOD'])
        {
        case 'GET': $controller->getTerceros($payload);break;
        case 'POST': 
            if($uri[3]=='add'){
                $controller->addTercero($payload);
            }else if($uri[3]=='transac'){
                $controller->transferenciaTercero($payload);
            }
            break;
        }
    }
}else{
    exit();
}
?>