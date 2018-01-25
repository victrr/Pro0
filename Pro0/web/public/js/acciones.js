/**
* @fileoverview Documento de acciones javascript.
*               Hoja js para el uso de acciones y eventos dentro de las plantillas del proyecto
* @version      1.0
* @author       VHA
*
**/


/**
*@description Agrega un nuevo campo al formulario 
*/
$(document).ready(function() {
	var newnum =0;  
  $('#telCl').change(function() {
    if (this.checked) {
    	newnum = newnum + 1
        $( "#labelhide1" ).show( "slow" );
   		$('#telcel').append('<input type=text class="form-control" id="telcelu" placeholder="" name="telcelu" />');
   		if (newnum == 1)
	    {
	     newnum =0;
	    }
    } else {
        hideId("#labelhide1");
        if (newnum != 0) { $('#telcelu' + newnum).remove(); newnum = newnum - 1; }

		if (newnum == 0) { 
            removeId('#telcel');
		}
    }
});

$('#telC').change(function() {
    if (this.checked) {
    	newnum = newnum + 1
        $( "#labelhide2" ).show( "slow" );
   		$('#telcasa').append('<input type=text class="form-control" id="telcas" placeholder="" name="telcas" />');
   		if (newnum == 1)
	    {
	     newnum = 0;
	    }
    } else {
        hideId("#labelhide2");
        if (newnum != 0) { $('#telcas' + newnum).remove(); newnum = newnum - 1; }
 
		if (newnum == 0) { 
            removeId('#telcasa');
		}
    }
});

$('#telTr').change(function() {
 
    if (this.checked) {
    	newnum = newnum + 1
        $( "#labelhide3" ).show( "slow" );
   		$('#teltrabajo').append('<input type=text class="form-control" id="teltrab" placeholder="" name="teltrab" />');
   		if (newnum == 1)
	    {
	     newnum = 0;
	    }
    } else {
        hideId("#labelhide3");
        if (newnum != 0) { $('#teltrab' + newnum).remove(); newnum = newnum - 1; }
 
		if (newnum == 0) { 
            removeId('#teltrabajo');
		}
    }
});
});
function removeId(id){
 $(id).empty();   
}
function removeTels() {
    $('#telcel,#telcasa,#teltrabajo').empty();
}
function hideLabels(){
    $( "#labelhide1,#labelhide2,#labelhide3" ).hide();
}
function hideId(id){
    $(id).hide();
}

/*
*@description Funcion de envio del formulario al controlador [ModuloController] funcion [addAction] agregar persona
*
*/
function enviarform() {
    //$('#formper').submit(function(){
    	var formURL = $('#formper').attr('action');
        var datos = $('#formper').serialize();
        console.log(datos+' '+formURL);
        $.ajax({
            url: formURL,
            type: "POST",
            dataType: "json",
            data: datos,
            async: true,
            success: function (data)
            {   
                //$('#agregar').empty(); 
                $( "#alert_success").fadeIn(1000);
                //$(".modal").on("hidden.bs.modal", function(){
                  //  $(".modal-body").html("");
               // });           
               setTimeout('document.location.reload()',1000);

            }
        });

        return false;
}

/**
* @description Validaciones de formulario Agregar persona
*/

$('#enviar').click(function() {
    nombre = $('#nombre').val();
    appaterno = $('#appaterno').val();
    apmaterno = $('#apmaterno').val();
    telcelu = $('#telcelu').val();
    telcas = $('#telcas').val();
    teltrab = $('#teltrab').val();
    
    if(($('#telCl').is(":checked")) || ($('#telC').is(":checked")) || ($('#telTr').is(":checked")) ) {
        var si = 1;        
    }

    if (nombre == ''){   
        msnVal ('Nombre');
    }
    else if (appaterno == ''){
        msnVal ('Apellido Paterno');
    }  
    else if (apmaterno == ''){
        msnVal ('Apellido Materno');
    } 
    else if(si != 1) {
        msnVal ('Numero telefonico');
    }
    else if (telcelu == ''){
        msnVal ('Tel-Celular');
    }else if(telcas == ''){
        msnVal ('Tel-Casa');
    }else if (teltrab == '') {
        msnVal ('Tel-Trabajo');
    }
    else if ( $("#telcelu").length > 0 ) {
        if (!validaTel('#telcelu')){
            msnVal ('Tel-Celular no es un numero telefonico valido.');
        }
    }
    else if ( $("#telcas").length > 0 ) {
        if (!validaTel('#telcas')){
            msnVal ('Tel-Casa no es un numero telefonico valido.');
        }
    }
    else if ( $("#teltrab").length > 0 ) {
        if (!validaTel('#teltrab')){
            msnVal ('Tel-Trabajo no es un numero telefonico valido.');
        }
    }
    else{
        //enviarform();
    }   
});

function validaTel(id){
    if ($(id).val().length != 9 || isNaN($(id).val())){
        return false;
    }
    return true;
}

$('#nombre,#appaterno,#apmaterno,#telcelu,#telcas,#teltrab').focus(function() {
    $( "#mensaje_val" ).hide( "slow" );        
});

$( "#telCl,#telC,#telTr" ).on( "click", function() {
    $( "#mensaje_val" ).hide( "slow" );   
});

/**
* @description Funcion muestra mensaje de validacion de campo
* @param msn
*/
function msnVal (msn){
    removeId('#texto')     
    $( "#mensaje_val" ).show( "slow" );
    $('#texto').append('<p>Verifique campo '+ msn + '</p>');
}


$('#agregar').on('hidden.bs.modal', function (e) {
    alert('lol');
    $('.formModal')[0].reset();
    $( "#mensaje_val" ).hide( "slow" );  
    hideLabels();
    removeTels();  
});
