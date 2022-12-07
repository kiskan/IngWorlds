$(document).ready(function(){

	$('#area_nombre').focus();
	
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
			ajax: "consultas/ges_crud_areas.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'area_id'},
				{ data:'area_nombre'}
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
			$('#area_id').val(obj_row.area_id);
			$('#area_nombre').val(obj_row.area_nombre);

			$('#btn_reg_area').hide();
			$('#btn_upd_area').show();
			$('#btn_del_area').show();
			$('#btn_can_area').show();		
			
		});
	}
	
	$('#btn_can_area').click(function(){
		cancelar();
	})
	
	function cancelar(){/*
		$('#area_id').val('');
		$('#area_nombre').val('');*/
		$('#form_area')[0].reset();
		$('#btn_reg_area').show();
		$('#btn_upd_area').hide();
		$('#btn_del_area').hide();
		$('#btn_can_area').hide();
		table.$('tr.selected').removeClass('selected');

		$('#area_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('area_nombre');	
	
	function validar_area(){
		var area_nombre = $.trim($('#area_nombre').val());
		if(area_nombre == ''){
			swal({ 
				title: "Error: Ingresar Area",
				text: "Se cerrará en 3 segundos.",
				type: "error", 
				timer: 3000,
				showConfirmButton: false 
			});			
			
			return false;
		}
		return true;
	}
	  
	$('#btn_reg_area').click(function(){

		if (validar_area()){	

			$('#loading').show();
			
			var area_nombre = $.trim($('#area_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							area_nombre:area_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_areas.php",
				   parametros,			   
				   function(resp){
						ges_crud_areas(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_area').click(function(){
		if (validar_area()){	

			$('#loading').show();
			var area_id = $.trim($('#area_id').val());
			var area_nombre = $.trim($('#area_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							area_id:area_id,
							area_nombre:area_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_areas.php",
				   parametros,			   
				   function(resp){
						ges_crud_areas(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_area').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta area?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var area_id = $.trim($('#area_id').val());
				var operacion = 'DELETE';
				parametros = {	
								area_id:area_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_areas.php",
					   parametros,			   
					   function(resp){
							ges_crud_areas(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_areas(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Area registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Area modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Area eliminada", "success");
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