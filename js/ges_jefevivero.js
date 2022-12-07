$(document).ready(function(){
	/*
	$("#jefund_estado").select2({
		allowClear: true
	});	
	*/
	$('#area_id').select2({			
		allowClear: true,
		placeholder: "SELECCIONA AREA(S)"
	});		
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
			table = $("#datatable-responsive").DataTable({
		
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_jefevivero.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'UNDVIV_ID'},
				{ data:'USR_ID'},
				{ data:'UNDVIV_NOMBRE'},	
				{ data:'USR_NOMBRE'},
				/*{ data:'JEFUND_ESTADO'},*/
				{ data:'AREAS'},
				{ data:'AREAS_ID'}
			],	

			columnDefs: [
				{ targets: [2,3,4], visible: true},
				{ targets: '_all', visible: false }			
			],
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
				"sSortAscending":  ": operar para ordenar la columna de manera ascendente",
				"sSortDescending": ": operar para ordenar la columna de manera descendente"
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
			//console.log(obj_row)
			
			$('#h_undviv_id').val(obj_row.UNDVIV_ID);
			$('#h_usr_id').val(obj_row.USR_ID);
			//$('#h_jefund_estado').val(obj_row.JEFUND_ESTADO);
			//$('#h_areas_id').val(obj_row.AREAS_ID);
			$('#undviv_id').val(obj_row.UNDVIV_ID).trigger('change');
			$('#usr_id').val(obj_row.USR_ID).trigger('change');
			//$('#jefund_estado').val(obj_row.JEFUND_ESTADO).trigger('change');
			
			var array_areas = obj_row.AREAS_ID.split(',');
			$('#area_id').val(array_areas).trigger('change');

			
			$('#btn_reg_jefund').hide();
			$('#btn_upd_jefund').show();
			$('#btn_del_jefund').show();
			$('#btn_can_jefund').show();		
			
		});
	}
	
	$('#btn_can_jefund').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_jefund')[0].reset();

		$('#btn_reg_jefund').show();
		$('#btn_upd_jefund').hide();
		$('#btn_del_jefund').hide();
		$('#btn_can_jefund').hide();
		table.$('tr.selected').removeClass('selected');
		
		$('#undviv_id').val('').trigger('change');	
		$('#usr_id').val('').trigger('change');	
		//$('#jefund_estado').val('VIGENTE').trigger('change');	
		$('#area_id').val('').trigger('change');
	
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

	
	
	carga_viveros();
	function carga_viveros(){
		var combobox = [];
		for(var i  = 0 ; i < data_viveros.length; i++) {
			combobox.push({id:data_viveros[i].undviv_id, text:data_viveros[i].undviv_nombre});
		}	
		
		$('#undviv_id').select2({			
			allowClear: true,	
			data:combobox
		});			
	}	
	
	carga_jefeviveros();
	function carga_jefeviveros(){
		var combobox = [];
		for(var i  = 0 ; i < data_jefeunidad.length; i++) {
			combobox.push({id:data_jefeunidad[i].USR_ID, text:data_jefeunidad[i].USR_NOMBRE});
		}	
		
		$('#usr_id').select2({			
			allowClear: true,	
			data:combobox
		});			
	}	
	
	carga_areas();
	function carga_areas(){
		var combobox = [];
		for(var i  = 0 ; i < data_areas.length; i++) {
			combobox.push({id:data_areas[i].area_id, text:data_areas[i].area_nombre});
		}	
		
		$('#area_id').select2({	
			allowClear: true,
			placeholder: "SELECCIONA AREA(S)",		
			data:combobox
		})			
	}		
	
	function validar_jefund(){
	
		var undviv_id = $.trim($('#undviv_id').val());
		var usr_id = $.trim($('#usr_id').val());		
		//var jefund_estado = $.trim($('#jefund_estado').val());
		var area_id = $.trim($('#area_id').val());
	
		if(undviv_id == ''){
			sweet_alert('Error: Ingresar Unid. Viveros');	
			return false;
		}
		
		if(usr_id == ''){
			sweet_alert('Error: Ingresar jefe Unid. Viveros');	
			return false;
		}		
/*
		if(jefund_estado == ''){
			sweet_alert('Error: Ingresar estado jefe Unid. Viveros');	
			return false;
		}
*/		
		if(area_id == ''){
			sweet_alert('Error: Ingresar Área(s) a cargo');	
			return false;
		}

		return true;
	}
			  
	$('#btn_reg_jefund').click(function(){

		if (validar_jefund()){	

			$('#loading').show();
			
			var undviv_id = $.trim($('#undviv_id').val());
			var usr_id = $.trim($('#usr_id').val());		
			//var jefund_estado = $.trim($('#jefund_estado').val());
			var area_id = $.trim($('#area_id').val());

			var operacion = 'INSERT';
			parametros = {			
							undviv_id:undviv_id,
							usr_id:usr_id,
							//jefund_estado:jefund_estado,
							area_id:area_id,
							operacion:operacion
						 }	
			console.log(parametros)	
			$.post(
				   "consultas/ges_crud_jefevivero.php",
				   parametros,			   
				   function(resp){
						ges_crud_jefevivero(resp)
				   },"json"
			)
		}	
	})	

 	$('#btn_upd_jefund').click(function(){
		if (validar_jefund()){	

			$('#loading').show();
			
			var h_undviv_id = $.trim($('#h_undviv_id').val());
			var h_usr_id = $.trim($('#h_usr_id').val());
			//var h_jefund_estado = $.trim($('#h_jefund_estado').val());
			var undviv_id = $.trim($('#undviv_id').val());
			var usr_id = $.trim($('#usr_id').val());		
			//var jefund_estado = $.trim($('#jefund_estado').val());
			var area_id = $.trim($('#area_id').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							h_undviv_id:h_undviv_id,
							h_usr_id:h_usr_id,
							//h_jefund_estado:h_jefund_estado,
							undviv_id:undviv_id,
							usr_id:usr_id,
							//jefund_estado:jefund_estado,
							area_id:area_id,
							operacion:operacion
						 }		
			console.log(parametros)			 
			$.post(
				   "consultas/ges_crud_jefevivero.php",
				   parametros,			   
				   function(resp){
						ges_crud_jefevivero(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_jefund').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta asignación Jefe Unid. Viveros?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_undviv_id = $.trim($('#h_undviv_id').val());
				//var h_usr_id = $.trim($('#h_usr_id').val());
				var operacion = 'DELETE';
				parametros = {	
								h_undviv_id:h_undviv_id,
								//h_usr_id:h_usr_id,
								operacion:operacion
							 }	
				//console.log(parametros)
				$.post(
					   "consultas/ges_crud_jefevivero.php",
					   parametros,			   
					   function(resp){
							ges_crud_jefevivero(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_jefevivero(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Asignación Jefe Unid. Viveros registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Asignación Jefe Unid. Viveros modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Asignación Jefe Unid. Viveros eliminado", "success");
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