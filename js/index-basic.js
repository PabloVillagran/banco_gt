import {baseURL} from './config.js';

function exit(){
    window.history.back();
}

function addExitListener(){
    var exitElements = document.querySelectorAll(".exit-btn");
    console.log(exitElements);
    exitElements.forEach(element=>{
        element.addEventListener("click", function(){
            exit();
        });
    });
}

$(document).ready(function(){
    const navbar = document.querySelector("#full-nav");
    addExitListener();
    addTabListener();
    addModalListener();
    addNewUserListener();
    addDepositoListener();
    addRetiroListener();
    addTerceroListener();
    //navbar.innerHTML=``;
    if(sessionStorage.getItem("ultimaCuentaMod")){
        $("#warnCrear").html("Ultima cuenta modificada " + sessionStorage.getItem("ultimaCuentaMod"));
    }
});

function addTabListener(){
    var tabAdminCajeros = document.querySelectorAll('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]');
    if(tabAdminCajeros){
        tabAdminCajeros.forEach(
            element=> {
                element.addEventListener('shown.bs.tab', function(event){
                    let tabTarget = event.target.getAttribute("data-bs-target");
                    if(tabTarget=='#tab-cajeros'){
                        getAllCajeros();
                    }
                    if(tabTarget=='#tab-transferencia'){
                        getAllTerceros();
                    }
                })
            }
        );
    }
}

function getAllCajeros(){
    $.ajax({
        url:baseURL+'/cajero?id='+sessionStorage.getItem("userId"),
        type:"GET",
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            var table = $("#allcajeros>tbody");
            table.html('');

            var appender="";
            response.forEach(
                item=>{
                    appender+='<tr> ' 
                    + '<td><i class="bi bi-person-fill"></i></td> '
                    + '<td>'+item.Nombre+'</td> '
                    + '<td> '
                    + '    <div class="form-check form-switch"> '
                    + '        <input class="form-check-input" type="checkbox" id="sw_'+item.idCajero+'" aria-value="'+item.idCajero+'" '
                    + ((item.activo==1)?'checked':'')
                    +'> '
                    + '    </div> '
                    + '</td> '
                    + '</tr>';
                }
            );
            table.html(appender);
            var newElements = document.querySelectorAll(".form-check-input");
            newElements.forEach(newElement=>{
                newElement.addEventListener("change", function(event){
                    var id = event.target.getAttribute('aria-value');
                    var stat = (event.target.checked)?1:0;
                    updateElement(id, stat);
                })
            });
        }
    });
}

function updateElement(idval, stat){
    $.ajax({
        url:baseURL+'/cajero',
        type:"PUT",
        data: JSON.stringify({id: idval, status: stat}),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(){
            location.reload();
        }
    })
}

function addModalListener(){
    var saveButton = document.querySelector("#modSave");
    var warndiv = $("#warn_add");
    if(saveButton){
        saveButton.addEventListener("click", function(){
            var contra = $('#contra').val();
            var usuario = $('#usuario').val();
            var nombre = $('#nombre').val();
            console.log(contra, usuario, nombre);
            if($('#ccontra').val()!=$('#contra').val()) warndiv.html("Las contraseñas no coinciden");
            else{
                if(contra && usuario && nombre){
                    addCajero(contra, usuario, nombre);
                }else{
                    warndiv.html("Faltan datos!");
                }
            }
        });
    }
}

function addCajero(contrav, usuariov, nombrev){
    var sessionId = sessionStorage.getItem("userId");
    $.ajax({
        url:baseURL+'/cajero/add',
        type:"POST",
        data: JSON.stringify({nombre:nombrev, usuario:usuariov, pass: contrav, id_admin:sessionId}),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(){
            location.reload();
        }
    })
}

function addNewUserListener(){
    var btnGuardar = document.querySelector("#crearCuenta");
    var warnDiv = $("#warnCrear");
    if(btnGuardar){
        btnGuardar.addEventListener("click", function(){
            var nombreCuenta = $("#nombre-cuenta").val();
            var dpi = $("#dpi").val();
            var montoinit = $("#montoInit").val();
            if(!$.isNumeric(montoinit) || montoinit<=0){
                warnDiv.html("Monto no válido!");
            }else{
                if(nombreCuenta && dpi && montoinit){
                    addCuenta(nombreCuenta, dpi, montoinit);
                }else{
                    warnDiv.html("Faltan datos!");
                }
            }
        })
    }
}

function addCuenta(nombreCuentav, dpiv, montoinitv){
    $.ajax({
        url:baseURL+'/cuenta',
        type:"POST",
        data: JSON.stringify({nombre:nombreCuentav, DPI:dpiv}),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            sendTransac(response.id, montoinitv);
        }
    });
}

function addDepositoListener(){
    var buttonDeposito = document.querySelector("#guardarDeposito");
    var warnDiv = $("#warnCrear");
    if(buttonDeposito){
        buttonDeposito.addEventListener("click", function(){
            var depoNoCuenta = $("#depo-no-cuenta").val();
            var cantidadDepo = $("#cantidad-depo").val();
            if(!$.isNumeric(cantidadDepo)||cantidadDepo<=0){
                warnDiv.html("Monto inválido!");
            }else{
                depositar(depoNoCuenta, cantidadDepo);
            }
        })
    }
}

function addRetiroListener(){
    var buttonRetiro = document.querySelector("#guardarRetiro");
    var warnDiv = $("#warnCrear");
    if(buttonRetiro){
        buttonRetiro.addEventListener("click", function(){
            var depoNoCuenta = $("#ret-no-cuenta").val();
            var cantidadDepo = $("#cantidad-ret").val();
            if(!$.isNumeric(cantidadDepo)||cantidadDepo<=0){
                warnDiv.html("Monto inválido!");
            }else{
                retirar(depoNoCuenta, cantidadDepo);
            }
        })
    }
}

function depositar(nocuenta, cantidad){
    console.log(nocuenta, cantidad);
    sendTransac(nocuenta, cantidad);
}

function retirar(nocuenta, cantidad){
    sendTransac(nocuenta, -1*cantidad);
}

function sendTransac(idCuentav, montov){
    var warnDiv = $("#warnCrear");
    var now = new Date().getTime();
    var sessionId = sessionStorage.getItem("userId");
    $.ajax({
        url:baseURL+'/transac/caja',
        type:"POST",
        data: JSON.stringify({monto:montov, cuenta:idCuentav, fecha: now, idCajero: sessionId}),
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(){
            sessionStorage.setItem("ultimaCuentaMod", idCuentav);
            location.reload();
        },
        error: function(){
            warnDiv.html("Error en transacción a cuenta: "+idCuentav);
        },
        always: function(){
            warnDiv.html("Realizada transaccion a cuenta: "+idCuentav);
        }
    });
}

function addTerceroListener(){
    var addTercero = document.querySelector("#guardarTercero");
    if(addTercero){
        addTercero.addEventListener("click", function(){
            var valCuenta = $("#no-cuenta").val();
            var origenv = sessionStorage.getItem("cuentaId");
            $.ajax({
                url:baseURL+'/tercero/add',
                type:"POST",
                data: JSON.stringify({idOrigen:origenv, idDestino:valCuenta}),
                contentType:"application/json; charset=utf-8",
                dataType:"json",
                success: function(){
                    location.reload();
                }
            })
        });
    }
}

function getAllTerceros(){
    var selectCuentas = document.getElementById("cuentas");
    $.ajax({
        url:baseURL+'/tercero?id='+sessionStorage.getItem("cuentaId"),
        type:"GET",
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        success: function(response){
            var optdef = document.createElement("option");
            optdef.setAttribute("value", "-1");
            optdef.text = "Seleccionar cuenta";
            selectCuentas.appendChild(optdef);
            response.forEach(element=>{
                var option = document.createElement("option");
                option.setAttribute("value", element.idCuenta);
                option.text = element.Nombre;
                selectCuentas.appendChild(option);
            });
        }
    })
}

