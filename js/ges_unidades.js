$(document).ready(function(){

	$('#und_nombre').focus();
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
			columnDefs: [
				{ targets: [1], visible: true},
				{ targets: '_all', visible: false }			
			],		
			ajax: "consultas/ges_crud_unidades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'und_id'},
				{ data:'und_nombre'}
			],

			searching:true,
			dom: "Bfrtip",

			buttons: [
			{
			  extend: "copy",
			  className: "btn-sm"
			},
			{
			  extend: "excel",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			},
			],
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
			$('#und_id').val(obj_row.und_id);
			$('#und_nombre').val(obj_row.und_nombre);

			$('#btn_reg_unidad').hide();
			$('#btn_upd_unidad').show();
			$('#btn_del_unidad').show();
			$('#btn_can_unidad').show();		
			
		});
	}
	
	$('#btn_can_unidad').click(function(){
		cancelar();
	})
	
	function cancelar(){
		//$('#und_id').val('');
		//$('#und_nombre').val('');
		$('#form_unidad')[0].reset();
		$('#btn_reg_unidad').show();
		$('#btn_upd_unidad').hide();
		$('#btn_del_unidad').hide();
		$('#btn_can_unidad').hide();
		table.$('tr.selected').removeClass('selected');

		$('#und_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('und_nombre');	
	
	function validar_unidad(){
		var und_nombre = $.trim($('#und_nombre').val());
		if(und_nombre == ''){
			swal({ 
				title: "Error: Ingresar unidad",
				text: "Se cerrará en 3 segundos.",
				type: "error", 
				timer: 3000,
				showConfirmButton: false 
			});			
			
			return false;
		}
		return true;
	}
	  
	$('#btn_reg_unidad').click(function(){

		if (validar_unidad()){	

			$('#loading').show();
			
			var und_nombre = $.trim($('#und_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							und_nombre:und_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_unidades.php",
				   parametros,			   
				   function(resp){
						ges_crud_unidades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_unidad').click(function(){
		if (validar_unidad()){	

			$('#loading').show();
			var und_id = $.trim($('#und_id').val());
			var und_nombre = $.trim($('#und_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							und_id:und_id,
							und_nombre:und_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_unidades.php",
				   parametros,			   
				   function(resp){
						ges_crud_unidades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_unidad').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta unidad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var und_id = $.trim($('#und_id').val());
				var operacion = 'DELETE';
				parametros = {	
								und_id:und_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_unidades.php",
					   parametros,			   
					   function(resp){
							ges_crud_unidades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_unidades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			//$('#form_unidad')[0].reset();
			cancelar();
			//table.ajax.reload(null, false);
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Unidad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Unidad modificada", "success");
				//cancelar();
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Unidad eliminada", "success");
				//cancelar();
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