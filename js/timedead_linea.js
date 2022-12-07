$(document).ready(function(){

	$('#lin_nombre').focus();
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
			
			
			buttons: [
			{
			  extend: "excel",
			  className: "btn-sm"
			},			
			{
			  extend: "copy",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			}
			],			
			
			
			columnDefs: [
				{ targets: [1], visible: true},
				{ targets: '_all', visible: false }			
			],	 
			ajax: "consultas/time_crud_linea.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'lin_id'},
				{ data:'lin_nombre'}
			],

			searching:true,
			dom: "Bfrtip",
			responsive: true,

			oLanguage: {
			  "sProcessing":     "Procesando...",
			  "sLengthMenu":     "Mostrar _MENU_ registros",
			  "sZeroRecords":    "No se encontraron resultados",
			  "sEmptyTable":     "Ningún dato disponible en esta tabla",
			  "sInfo":           "<br />_TOTAL_ resultado(s)",
			  "sInfoEmpty":      "No existen registros",
			  "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			  "sInfoPostFix":    "",
			  "sSearch":         "Buscar:",
			  "sUrl":            "",
			  "sInfoThousands":  ",",
			  "sLoadingRecords": "Cargando...",
			  "oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "&Uacute;ltimo",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			  },
			  "oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
	  
		$('#datatable-responsive tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			var obj_row = table.row(this).data();		
			$('#lin_id').val(obj_row.lin_id);
			$('#lin_nombre').val(obj_row.lin_nombre);

			$('#btn_reg_lin').hide();
			$('#btn_upd_lin').show();
			$('#btn_del_lin').show();
			$('#btn_can_lin').show();		
			
		});
	}
	
	$('#btn_can_lin').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_lin')[0].reset();
		$('#btn_reg_lin').show();
		$('#btn_upd_lin').hide();
		$('#btn_del_lin').hide();
		$('#btn_can_lin').hide();
		table.$('tr.selected').removeClass('selected');

		$('#lin_nombre').focus();		
	}

	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 3 segundos.",
			type: "error", 
			timer: 3000,
			showConfirmButton: false 
		});			
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('lin_nombre');	
	
	function validar_lin(){
		var lin_nombre = $.trim($('#lin_nombre').val());
		
		if(lin_nombre == ''){
			sweet_alert('Error: Ingresar línea productiva');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_lin').click(function(){

		if (validar_lin()){	

			$('#loading').show();
			
			var lin_nombre = $.trim($('#lin_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							lin_nombre:lin_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_linea.php",
				   parametros,			   
				   function(resp){
						time_crud_linea(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_lin').click(function(){
		if (validar_lin()){	

			$('#loading').show();
			var lin_id = $.trim($('#lin_id').val());
			var lin_nombre = $.trim($('#lin_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							lin_id:lin_id,
							lin_nombre:lin_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/time_crud_linea.php",
				   parametros,			   
				   function(resp){
						time_crud_linea(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_lin').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Línea Productiva?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var lin_id = $.trim($('#lin_id').val());
				var operacion = 'DELETE';
				parametros = {	
								lin_id:lin_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_linea.php",
					   parametros,			   
					   function(resp){
							time_crud_linea(resp)
					   },"json"
				)
				console.log(parametros)
		});	
		
	})		
	
	function time_crud_linea(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Línea Productiva registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Línea Productiva modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Línea Productiva eliminada", "success");
			}
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
});