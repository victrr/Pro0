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
    // this will contain a reference to the checkbox   
    if (this.checked) {
        alert(newnum);
    	newnum = newnum + 1
        $( "#labelhide1" ).show( "slow" );
   		$('#telcel').append('<input type=text class="form-control" id="telcelu" placeholder="" name="telcelu" />');
   		if (newnum == 1)
	    {
	     null;
	    }
    } else {
        $( "#labelhide1" ).hide();
        // the checkbox is now no longer checked
        if (newnum != 0) { $('#telcelu' + newnum).remove(); newnum = newnum - 1; }
 
		if (newnum == 0) { $('#telcel').empty();

		$('#telcel').remove();

		}
    }
});

$('#telC').change(function() {
    // this will contain a reference to the checkbox   
    if (this.checked) {
    	newnum = newnum + 1
        $( "#labelhide2" ).show( "slow" );
   		$('#telcasa').append('<input type=text class="form-control" id="telcas" placeholder="" name="telcas" />');
   		if (newnum == 1)
	    {
	     null;
	    }
    } else {
        $( "#labelhide2" ).hide();
        // the checkbox is now no longer checked
        if (newnum != 0) { $('#telcas' + newnum).remove(); newnum = newnum - 1; }
 
		if (newnum == 0) { $('#telcasa').empty();

		$('#telcasa').remove();
 
		}
    }
});

$('#telTr').change(function() {
    // this will contain a reference to the checkbox   
    if (this.checked) {
    	newnum = newnum + 1
        $( "#labelhide3" ).show( "slow" );
   		$('#teltrabajo').append('<input type=text class="form-control" id="teltrab" placeholder="" name="teltrab" />');
   		if (newnum == 1)
	    {
	     null;
	    }
    } else {
        $( "#labelhide3" ).hide();
        // the checkbox is now no longer checked
        if (newnum != 0) { $('#teltrab' + newnum).remove(); newnum = newnum - 1; }
 
		if (newnum == 0) { $('#teltrabajo').empty();

		$('#teltrabajo').remove();
 
		}
    }
});
});

/*
*@description Funcion de envio del formulario al controlador [ModuloController] funcion [addAction] agregar persona
*
*/
$('#formper').submit(function(){
	var formURL = $('#formper').attr('action');

    var datos = $(this).serialize();
    console.log(datos+' '+formUR);
    alert(datos);
    $.ajax({
        url: formURL,
        type: "POST",
        dataType: "json",
        data: datos,
        async: true,
        success: function (data)
        {
            console.log(arrData)
            alert(arrData);

        }
    });
    return false;

});



