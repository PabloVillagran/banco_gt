import {baseURL} from './config.js';

$().ready(function(){
    const loginNav = document.querySelector('#login-nav');
    let path = window.location.pathname;
    if (path.endsWith("/login.html")) path="./login";
    else path=".";
    console.log(path);
    loginNav.innerHTML=`
    <div class="container-fluid nav-container">
        <div class="logo navbar-brand">
            <img>
            <span class="name">Banco Guatemalteco</span>
        </div>
        <button id="navtoggler" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-item-container" aria-controls="navbar-item-container" aria-expanded="false" aria-label="Toggle navigation">
            <span class="bi bi-list"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-item-container">
            <ul class="navbar-nav nav-items">
                <li class="nav-item">
                    <a class="nav-link" href="`+path+`/usuario.html">Usuario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="`+path+`/admin.html">Administrador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="`+path+`/caja.html">Cajero</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="`+path+`/registro.html">Registrate</a>
                </li>
            </ul>
        </div>
    </div>
    `;

    $("#adminSession").on('click', function(){
        loginAdmin();
    });
    $("#cajaSession").on('click', function(){
        loginCaja();
    });
    $("#userSession").on('click', function(){
        loginUsuario();
    });
    $("#register").on('click', function(){
        register();
    })
});

function loginAdmin(){
    var req = {user: $("#txtUsuario").val(), pass:$("#passUsuario").val()};
    $.ajax({
        url:baseURL+'/admin/login',
        type:"POST",
        data:JSON.stringify(req),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            if(response[0]){
                sessionStorage.setItem("userId", response[0].log_in);
                sessionStorage.setItem("userName", response[0].name);
                document.location = "../admin/index.html";
            }else{
                $("#warn").html("Datos Incorrectos");
            }
        }
    });
}

function loginCaja(){
    var req = {user: $("#txtUsuario").val(), pass:$("#passUsuario").val()};
    $.ajax({
        url:baseURL+'/cajero/login',
        type:"POST",
        data:JSON.stringify(req),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            if(response[0]){
                sessionStorage.setItem("userId", response[0].log_in);
                sessionStorage.setItem("userName", response[0].name);
                window.location.href ="../caja/index.html";
            }else{
                $("#warn").html("Datos Incorrectos");
            }
        }
    });
}

function loginUsuario(){
    var req = {user: $("#txtUsuario").val(), pass:$("#passUsuario").val()};
    $.ajax({
        url:baseURL+'/user/login',
        type:"POST",
        data:JSON.stringify(req),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            if(response[0]){
                sessionStorage.setItem("userId", response[0].log_in);
                sessionStorage.setItem("userName", response[0].name);
                sessionStorage.setItem("cuentaId", response[0].cuenta);
                window.location.href ="../user/index.html";
            }else{
                $("#warn").html("Datos Incorrectos");
            }
        }
    });
}

function register(){
    /*"cuenta":"1", 
    "correo":"usuario@correo.com", 
    "telefono":"22222222", 
    "pass":"usuario1234"
   */
    var cuentav = $("#txtCuenta").val();
    var correov = $("#txtUsuario").val();
    var telv = $("#txtTelefono").val();
    var passv = $("#passUsuario").val();
    var passcv= $("#cpassUsuario").val();

    if(passv!= passcv){
        $("#warn").html("La contraseña no coincide");
        return;
    }
    if(cuentav&&correov&&telv&&passv&&passcv){
        var req = {cuenta: cuentav, 
        correo:correov,
        telefono:telv,
        pass:passv};
        $.ajax({
            url:baseURL+'/user/create',
            type:"POST",
            data:JSON.stringify(req),
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(response){
                if(response.id){
                    sessionStorage.setItem("userId", response.log_in);
                    sessionStorage.setItem("userName", correov);
                    sessionStorage.setItem("cuentaId", cuentav);
                    window.location.href ="../user/index.html";
                }else{
                    $("#warn").html("Datos Incorrectos");
                }
            }
        });
    }else{
        $("#warn").html("Datos faltantes");
    }

}
