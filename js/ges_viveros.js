$(document).ready(function(){

	$('#undviv_nombre').focus();
	
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
			ajax: "consultas/ges_crud_viveros.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'undviv_id'},
				{ data:'undviv_nombre'}
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
			$('#undviv_id').val(obj_row.undviv_id);
			$('#undviv_nombre').val(obj_row.undviv_nombre);

			$('#btn_reg_vivero').hide();
			$('#btn_upd_vivero').show();
			$('#btn_del_vivero').show();
			$('#btn_can_vivero').show();		
			
		});
	}
	
	$('#btn_can_vivero').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_vivero')[0].reset();
		$('#btn_reg_vivero').show();
		$('#btn_upd_vivero').hide();
		$('#btn_del_vivero').hide();
		$('#btn_can_vivero').hide();
		table.$('tr.selected').removeClass('selected');

		$('#undviv_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('undviv_nombre');	
	
	function validar_vivero(){
		var undviv_nombre = $.trim($('#undviv_nombre').val());
		if(undviv_nombre == ''){
			swal({ 
				title: "Error: Ingresar Vivero",
				text: "Se cerrará en 3 segundos.",
				type: "error", 
				timer: 3000,
				showConfirmButton: false 
			});			
			
			return false;
		}
		return true;
	}
	  
	$('#btn_reg_vivero').click(function(){

		if (validar_vivero()){	

			$('#loading').show();
			
			var undviv_nombre = $.trim($('#undviv_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							undviv_nombre:undviv_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_viveros.php",
				   parametros,			   
				   function(resp){
						ges_crud_viveros(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_vivero').click(function(){
		if (validar_vivero()){	

			$('#loading').show();
			var undviv_id = $.trim($('#undviv_id').val());
			var undviv_nombre = $.trim($('#undviv_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							undviv_id:undviv_id,
							undviv_nombre:undviv_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_viveros.php",
				   parametros,			   
				   function(resp){
						ges_crud_viveros(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_vivero').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Unid. Vivero?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var undviv_id = $.trim($('#undviv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								undviv_id:undviv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_viveros.php",
					   parametros,			   
					   function(resp){
							ges_crud_viveros(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_viveros(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Unid. Vivero registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Unid. Vivero modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Unid. Vivero eliminado", "success");
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