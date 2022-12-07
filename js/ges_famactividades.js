$(document).ready(function(){

	$('#factiv_nombre').focus();
	
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
			ajax: "consultas/ges_crud_famactividades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'factiv_id'},
				{ data:'factiv_nombre'}
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
			$('#factiv_id').val(obj_row.factiv_id);
			$('#factiv_nombre').val(obj_row.factiv_nombre);

			$('#btn_reg_factiv').hide();
			$('#btn_upd_factiv').show();
			$('#btn_del_factiv').show();
			$('#btn_can_factiv').show();		
			
		});
	}
	
	$('#btn_can_factiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_factiv')[0].reset();
		$('#btn_reg_factiv').show();
		$('#btn_upd_factiv').hide();
		$('#btn_del_factiv').hide();
		$('#btn_can_factiv').hide();
		table.$('tr.selected').removeClass('selected');

		$('#factiv_nombre').focus();		
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
	
	mayuscula('factiv_nombre');	
	
	function validar_factiv(){
		var factiv_nombre = $.trim($('#factiv_nombre').val());
		
		if(factiv_nombre == ''){
			sweet_alert('Error: Ingresar familia actividad');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_factiv').click(function(){

		if (validar_factiv()){	

			$('#loading').show();
			
			var factiv_nombre = $.trim($('#factiv_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							factiv_nombre:factiv_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_famactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_famactividades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_factiv').click(function(){
		if (validar_factiv()){	

			$('#loading').show();
			var factiv_id = $.trim($('#factiv_id').val());
			var factiv_nombre = $.trim($('#factiv_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							factiv_id:factiv_id,
							factiv_nombre:factiv_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_famactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_famactividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_factiv').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Familia de actividad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var factiv_id = $.trim($('#factiv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								factiv_id:factiv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_famactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_famactividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_famactividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Familia Actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Familia Actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Familia Actividad eliminada", "success");
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