$(document).ready(function(){

	$('#sfactiv_nombre').focus();
	
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
				{ targets: [2,3], visible: true},
				{ targets: '_all', visible: false }			
			],	 
			ajax: "consultas/ges_crud_sfamactividades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'factiv_id'},
				{ data:'sfactiv_id'},
				{ data:'factiv_nombre'},
				{ data:'sfactiv_nombre'}
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
			$('#sfactiv_id').val(obj_row.sfactiv_id);
			$('#factiv_id').val(obj_row.factiv_id).trigger('change');
			$('#sfactiv_nombre').val(obj_row.sfactiv_nombre);

			$('#btn_reg_sfactiv').hide();
			$('#btn_upd_sfactiv').show();
			$('#btn_del_sfactiv').show();
			$('#btn_can_sfactiv').show();		
			
		});
	}
	
	$('#btn_can_sfactiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_sfactiv')[0].reset();
		$('#btn_reg_sfactiv').show();
		$('#btn_upd_sfactiv').hide();
		$('#btn_del_sfactiv').hide();
		$('#btn_can_sfactiv').hide();
		table.$('tr.selected').removeClass('selected');
		$('#factiv_id').val('').trigger('change');
		$('#sfactiv_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sfactiv_nombre');	

	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 3 segundos.",
			type: "error", 
			timer: 3000,
			showConfirmButton: false
		});			
	}	
	
	carga_factividades();
	function carga_factividades(){
		var combobox = [];
		for(var i  = 0 ; i < data_famactividades.length; i++) {
			combobox.push({id:data_famactividades[i].factiv_id, text:data_famactividades[i].factiv_nombre});
		}	
		
		$('#factiv_id').select2({
			data:combobox
		});			
	}	
	
	
	function validar_sfactiv(){
		var factiv_id = $.trim($('#factiv_id').val());
		var sfactiv_nombre = $.trim($('#sfactiv_nombre').val());

		if(factiv_id == ''){
			sweet_alert('Error: Seleccionar familia actividad');	
			return false;
		}
		
		if(sfactiv_nombre == ''){
			sweet_alert('Error: Ingresar subfamilia actividad');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_sfactiv').click(function(){

		if (validar_sfactiv()){	

			$('#loading').show();
			
			var factiv_id = $.trim($('#factiv_id').val());
			var sfactiv_nombre = $.trim($('#sfactiv_nombre').val());
			
			var operacion = 'INSERT';
			parametros = {
							factiv_id:factiv_id,
							sfactiv_nombre:sfactiv_nombre,
							operacion:operacion
						 }	
			console.log(parametros)				
			$.post(
				   "consultas/ges_crud_sfamactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_sfamactividades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_sfactiv').click(function(){
		if (validar_sfactiv()){	

			$('#loading').show();
			var factiv_id = $.trim($('#factiv_id').val());
			var sfactiv_id = $.trim($('#sfactiv_id').val());
			var sfactiv_nombre = $.trim($('#sfactiv_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							factiv_id:factiv_id,
							sfactiv_id:sfactiv_id,
							sfactiv_nombre:sfactiv_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_sfamactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_sfamactividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_sfactiv').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta SubFamilia de actividad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var sfactiv_id = $.trim($('#sfactiv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								sfactiv_id:sfactiv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_sfamactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_sfamactividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_sfamactividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "SubFamilia Actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "SubFamilia Actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "SubFamilia Actividad eliminada", "success");
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