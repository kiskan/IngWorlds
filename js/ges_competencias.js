$(document).ready(function(){

	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
		
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_competencias.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'OPER_NOMBRE'},
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_COMPETENTES'},	
				{ data:'ID_ACTIV_COMPETENTES'},
				{ data:'OPER_RUT'},
				{ data:'AREA_ID'}			
			],	
			
			columnDefs: [
				{ targets: [0,1,2], visible: true},
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
				"sSortAscending":  ": supar para ordenar la columna de manera ascendente",
				"sSortDescending": ": supar para ordenar la columna de manera descendente"
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

			$('#h_oper_rut').val(obj_row.OPER_RUT);
			//$('#h_activ_id').val(obj_row.ACTIV_ID);
			
			$('#oper_rut').val(obj_row.OPER_RUT).trigger('change');
			$('#area_id').val(obj_row.AREA_ID).trigger('change');

			//var array_competencias = obj_row.ID_ACTIV_COMPETENTES.split(',');
			//$('#h_activ_id').val(array_competencias);
			$('#h_activ_id').val(obj_row.ID_ACTIV_COMPETENTES);
			//$('#activ_id').val(array_competencias).trigger('change');			
			
			$('#btn_reg_competencias').hide();
			$('#btn_upd_competencias').show();
			$('#btn_del_competencias').show();
			$('#btn_can_competencias').show();		
			
		});
	
	}
	
	$('#btn_can_competencias').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_competencias')[0].reset();
		$('#h_activ_id').val('');
		$('#h_oper_rut').val('');
		$('#btn_reg_competencias').show();
		$('#btn_upd_competencias').hide();
		$('#btn_del_competencias').hide();
		$('#btn_can_competencias').hide();
		table.$('tr.selected').removeClass('selected');
		$('#oper_rut').val('').trigger('change');
		$('#area_id').val('').trigger('change');
		clear_combobox('activ_id',1);	
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

	
	carga_operadores();
	function carga_operadores(){
		var combobox = [];
		for(var i  = 0 ; i < data_operadores.length; i++) {
			combobox.push({id:data_operadores[i].OPER_RUT, text:data_operadores[i].OPERARIO});
		}	
		
		$('#oper_rut').select2({			
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
			data:combobox
		});			
	}	

	$('#activ_id').select2({			
		allowClear: true,
		placeholder: "SELECCIONA ACTIVIDAD(ES)"
	});	
	
	$('#area_id').change(function() {

		var area_id = $('#area_id').val();
		clear_combobox('activ_id',1);
		if(area_id != ""){

			parametros = {			
				area_id:area_id,
				activ_comp:''
			}		
			
			$.post(
				"consultas/ges_crud_actividades.php",
				parametros,			   
				function(resp){
					carga_actividades(resp)
				},"json"
				)	
		}

	});

	function carga_actividades(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].ACTIV_ID, text:resp[i].ACTIV_NOMBRE});
		}	
		
		$('#activ_id').select2({	
			allowClear: true,
			placeholder: "SELECCIONA ACTIVIDADE(S)",		
			data:combobox
		})
		activ_selected = $('#h_activ_id').val();
		var array_competencias = activ_selected.split(',');
		$('#activ_id').val(array_competencias).trigger('change');				
	}

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}


	function validar_competencias(){

		var oper_rut = $.trim($('#oper_rut').val());
		var area_id = $.trim($('#area_id').val());
		var activ_id = $.trim($('#activ_id').val());

		if(oper_rut == ''){
			sweet_alert('Error: Seleccionar operador');	
			return false;
		}
		
		if(area_id == ''){
			sweet_alert('Error: Seleccionar área');	
			return false;
		}
		
		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}		

		return true;
	}
		  
	$('#btn_reg_competencias').click(function(){

		if (validar_competencias()){	

			$('#loading').show();
			
			var oper_rut = $.trim($('#oper_rut').val());
			var activ_id = $.trim($('#activ_id').val());
			
			var operacion = 'INSERT';
			parametros = {			
							oper_rut:oper_rut,
							activ_id:activ_id,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_competencias.php",
				   parametros,			   
				   function(resp){
						ges_crud_competencias(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_competencias').click(function(){
		if (validar_competencias()){	

			$('#loading').show();
			
			var oper_rut = $.trim($('#oper_rut').val());
			var activ_id = $.trim($('#activ_id').val());
			
			var h_oper_rut = $.trim($('#h_oper_rut').val());
			var h_activ_id = $.trim($('#h_activ_id').val());			
			var operacion = 'UPDATE';
			parametros = {
							oper_rut:oper_rut,
							activ_id:activ_id,
							h_oper_rut:h_oper_rut,
							h_activ_id:h_activ_id,
							operacion:operacion
						 }
			console.log(parametros)				
			$.post(
				   "consultas/ges_crud_competencias.php",
				   parametros,			   
				   function(resp){
						ges_crud_competencias(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_competencias').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Competencia?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_oper_rut = $.trim($('#h_oper_rut').val());
				var h_activ_id = $.trim($('#h_activ_id').val());
				var operacion = 'DELETE';
				parametros = {	
								h_oper_rut:h_oper_rut,
								h_activ_id:h_activ_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_competencias.php",
					   parametros,			   
					   function(resp){
							ges_crud_competencias(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_competencias(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Competencia registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Competencia modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Competencia eliminada", "success");
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