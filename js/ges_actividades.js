$(document).ready(function(){
	
	$('#activ_nombre').focus();
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_actividades.php?data=a",
			//bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'ACTIV_ID'},
				{ data:'AREA_ID'},
				{ data:'UND_ID'},			
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_NOMBRE'},
				{ data:'UND_NOMBRE'},
				{ data:'ACTIV_STANDAR'},
				{ data:'ACTIV_TIPO'}
			],
			columnDefs: [
				{ targets: [3,4,5,6,7], visible: true},
				{ targets: '_all', visible: false }			
			],
			//autoWidth: false,
			//searching:true,
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
			//

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
			//console.log(obj_row)
			$('#activ_id').val(obj_row.ACTIV_ID);
			$('#activ_nombre').val(obj_row.ACTIV_NOMBRE);
			$('#activ_area').val(obj_row.AREA_ID).trigger('change');
			$('#activ_unidad').val(obj_row.UND_ID).trigger('change');
			$('#activ_standar').val(obj_row.ACTIV_STANDAR).trigger('change');
			$('#activ_tipo').val(obj_row.ACTIV_TIPO).trigger('change');

			$('#btn_reg_actividad').hide();
			$('#btn_upd_actividad').show();
			$('#btn_del_actividad').show();
			$('#btn_can_actividad').show();		
			
		});
	}
	
	$('#btn_can_actividad').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_actividad')[0].reset();

		$('#btn_reg_actividad').show();
		$('#btn_upd_actividad').hide();
		$('#btn_del_actividad').hide();
		$('#btn_can_actividad').hide();
		table.$('tr.selected').removeClass('selected');
		$('#activ_area').val('').trigger('change');
		$('#activ_unidad').val('').trigger('change');
		$('#activ_standar').val('S').trigger('change');	
		$('#activ_standar').val('APOYO').trigger('change');
		$('#activ_nombre').focus();		
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
	
	mayuscula('activ_nombre');

	$('#activ_standar').select2({			
	});
	
	$('#activ_tipo').select2({			
	});	
	
	carga_areas();
	function carga_areas(){
		var combobox = [];
		for(var i  = 0 ; i < data_areas.length; i++) {
			combobox.push({id:data_areas[i].area_id, text:data_areas[i].area_nombre});
		}	
		
		$('#activ_area').select2({			
			allowClear: true,
			data:combobox
		});			
	}	
	
	carga_unidades();
	function carga_unidades(){
		var combobox = [];
		for(var i  = 0 ; i < data_unidades.length; i++) {
			combobox.push({id:data_unidades[i].und_id, text:data_unidades[i].und_nombre});
		}	
		
		$('#activ_unidad').select2({			
			allowClear: true,	
			data:combobox
		});			
	}		
	
	function validar_actividad(){
		var activ_area = $.trim($('#activ_area').val());
		var activ_nombre = $.trim($('#activ_nombre').val());		
		var activ_unidad = $.trim($('#activ_unidad').val());
	
		if(activ_area == ''){
			sweet_alert('Error: Ingresar área');	
			return false;
		}
		
		if(activ_nombre == ''){
			sweet_alert('Error: Ingresar actividad');	
			return false;
		}		
		
		if(activ_nombre.length > 250){
			sweet_alert('Error: máximo 250 caracteres en Actividad');	
			return false;
		}
			
		return true;
	}
		  
	$('#btn_reg_actividad').click(function(){

	if (validar_actividad()){	

			$('#loading').show();
			
			var activ_area = $.trim($('#activ_area').val());
			var activ_nombre = $.trim($('#activ_nombre').val());		
			var activ_unidad = $.trim($('#activ_unidad').val());
			var activ_standar = $.trim($('#activ_standar').val());
			var activ_tipo = $.trim($('#activ_tipo').val());
			
			var operacion = 'INSERT';
			parametros = {			
							activ_area:activ_area,
							activ_nombre:activ_nombre,
							activ_unidad:activ_unidad,
							activ_standar:activ_standar,
							activ_tipo:activ_tipo,
							operacion:operacion
						 }
			//console.log(parametros)
			$.post(
				   "consultas/ges_crud_actividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_actividades(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_actividad').click(function(){
		if (validar_actividad()){	

			$('#loading').show();
			
			var activ_id = $.trim($('#activ_id').val());
			var activ_area = $.trim($('#activ_area').val());
			var activ_nombre = $.trim($('#activ_nombre').val());		
			var activ_unidad = $.trim($('#activ_unidad').val());
			var activ_standar = $.trim($('#activ_standar').val());
			var activ_tipo = $.trim($('#activ_tipo').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							activ_id:activ_id,
							activ_area:activ_area,
							activ_nombre:activ_nombre,
							activ_unidad:activ_unidad,
							activ_standar:activ_standar,
							activ_tipo:activ_tipo,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_actividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_actividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_actividad').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este actividad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var activ_id = $.trim($('#activ_id').val());
				var operacion = 'DELETE';
				parametros = {	
								activ_id:activ_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_actividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_actividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_actividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Actividad eliminada", "success");
			}			
			
			//table.ajax.reload(null, false);
			//table.fnAdjustColumnSizing();
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});