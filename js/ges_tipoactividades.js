$(document).ready(function(){

	$('#tactiv_nombre').focus();
	
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
			ajax: "consultas/ges_crud_tipoactividades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'tactiv_id'},
				{ data:'tactiv_nombre'}
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
			$('#tactiv_id').val(obj_row.tactiv_id);
			$('#tactiv_nombre').val(obj_row.tactiv_nombre);

			$('#btn_reg_tactiv').hide();
			$('#btn_upd_tactiv').show();
			$('#btn_del_tactiv').show();
			$('#btn_can_tactiv').show();		
			
		});
	}
	
	$('#btn_can_tactiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_tactiv')[0].reset();
		$('#btn_reg_tactiv').show();
		$('#btn_upd_tactiv').hide();
		$('#btn_del_tactiv').hide();
		$('#btn_can_tactiv').hide();
		table.$('tr.selected').removeClass('selected');

		$('#tactiv_nombre').focus();		
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
	
	mayuscula('tactiv_nombre');	
	
	function validar_tactiv(){
		var tactiv_nombre = $.trim($('#tactiv_nombre').val());
		
		if(tactiv_nombre == ''){
			sweet_alert('Error: Ingresar tipo actividad');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_tactiv').click(function(){

		if (validar_tactiv()){	

			$('#loading').show();
			
			var tactiv_nombre = $.trim($('#tactiv_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							tactiv_nombre:tactiv_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_tipoactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_tipoactividades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_tactiv').click(function(){
		if (validar_tactiv()){	

			$('#loading').show();
			var tactiv_id = $.trim($('#tactiv_id').val());
			var tactiv_nombre = $.trim($('#tactiv_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							tactiv_id:tactiv_id,
							tactiv_nombre:tactiv_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_tipoactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_tipoactividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_tactiv').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este Tipo de actividad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var tactiv_id = $.trim($('#tactiv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								tactiv_id:tactiv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_tipoactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_tipoactividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_tipoactividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Tipo actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Tipo actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Tipo actividad eliminada", "success");
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