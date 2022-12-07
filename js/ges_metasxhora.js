$(document).ready(function(){
		
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_metasxhora.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_NOMBRE'},			
				{ data:'MET_UNDXHR', sType: "numeric-comma"},	
				{ data:'UND_NOMBRE'},
				{ data:'MET_INIVIG', sType: "date-br"},
				{ data:'MET_FINVIG', sType: "date-br"},
				{ data:'AREA_ID'},
				{ data:'ACTIV_ID'},			
				{ data:'MET_ID'}
			],	
			
			columnDefs: [
				{ targets: [0,1,2,3,4,5], visible: true},
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

			$('#met_id').val(obj_row.MET_ID);
			$('#h_activ_id').val(obj_row.ACTIV_ID);
			$('#met_area').val(obj_row.AREA_ID).trigger('change');
			$('#met_undxhr').val(obj_row.MET_UNDXHR);
			$('#met_inivig').val(obj_row.MET_INIVIG);
			//$('#met_inivig').data('daterangepicker').setStartDate(obj_row.MET_INIVIG);
			//$('#met_finvig').data('daterangepicker').autoUpdateInput= true;
			//$('#met_finvig').data('daterangepicker').setStartDate(obj_row.MET_FINVIG);
			//$('#met_finvig').data('daterangepicker').autoUpdateInput= false;
			if(obj_row.MET_FINVIG!=null){
				$('#met_finvig').val(obj_row.MET_FINVIG);
				$('#met_finvig').data('daterangepicker').setStartDate(obj_row.MET_FINVIG);
			}else{
				$('#met_finvig').val('');
			}
				
			$('#btn_reg_metasxhora').hide();
			$('#btn_upd_metasxhora').show();
			$('#btn_del_metasxhora').show();
			$('#btn_can_metasxhora').show();		
			
		});
	}
	
	$('#btn_can_metasxhora').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_metasxhora')[0].reset();

		$('#btn_reg_metasxhora').show();
		$('#btn_upd_metasxhora').hide();
		$('#btn_del_metasxhora').hide();
		$('#btn_can_metasxhora').hide();
		table.$('tr.selected').removeClass('selected');
		$('#met_area').val('').trigger('change');
		clear_combobox('met_activ',1);	
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


	$('#met_undxhr').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#met_undxhr").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	

	$('#met_inivig').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		showWeekNumbers: true,
		
		locale: {
			separator:'-',
			format: 'DD-MM-YYYY',
			daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			firstDay: 1
		}		
	});
		
	$('#met_finvig').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		showWeekNumbers: true,
		autoUpdateInput: false,		
		locale: {
			separator:'-',
			format: 'DD-MM-YYYY',
			daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			firstDay: 1
		}}, function(fecha) {
			$('#met_finvig').val(fecha.format('DD-MM-YYYY'));
	});	

	$('#met_activ').select2({			
		allowClear: true
	});	

	carga_areas();
	function carga_areas(){
		var combobox = [];
		for(var i  = 0 ; i < data_areas.length; i++) {
			combobox.push({id:data_areas[i].area_id, text:data_areas[i].area_nombre});
		}	
		
		$('#met_area').select2({			
			allowClear: true,
			data:combobox
		});			
	}	

	
	$('#met_area').change(function() {

		var met_area = $('#met_area').val();

		if(met_area == ""){
			clear_combobox('met_activ',1);
		}
		else{
			parametros = {			
				met_area:met_area
			}		
			clear_combobox('met_activ',1);
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
		
		$('#met_activ').select2({			
			data:combobox
		})
		activ_selected = $('#h_activ_id').val();
		$('#met_activ').val(activ_selected).trigger('change');
	}

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}



	
	
	function validar_metasxhora(){

		var met_area = $.trim($('#met_area').val());
		var met_activ = $.trim($('#met_activ').val());
		var met_undxhr = $.trim($('#met_undxhr').val());
		var met_inivig = $.trim($('#met_inivig').val());
		var met_finvig = $.trim($('#met_finvig').val());
		
		
		if(met_area == ''){
			sweet_alert('Error: Seleccionar área');	
			return false;
		}
		
		if(met_activ == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}		

		if(met_undxhr == ''){
			sweet_alert('Error: Ingresar meta');	
			return false;
		}
		
		if(met_inivig == ''){
			sweet_alert('Error: Ingresar inicio de vigencia');	
			return false;
		}		
		
			
		if(moment(met_inivig,'DD-MM-YYYY').isoWeekday() != 1){
			sweet_alert('Error: Debe iniciar un día LUNES');	
			return false;				
		}

		
		if(met_finvig != ''){
			var inivig = met_inivig.split('-');
			met_inivig = inivig[2]+'-'+inivig[1]+'-'+inivig[0];
			
			var finvig = met_finvig.split('-');		
			met_finvig = finvig[2]+'-'+finvig[1]+'-'+finvig[0];
			
			//validar fechas
			if(!moment(met_inivig).isSame(met_finvig) && !moment(met_inivig).isBefore(met_finvig)){
				sweet_alert('Error: Inicio vigencia mayor a Fin vigencia');	
				return false;			
			}
		}
		return true;
	}
		  
	$('#btn_reg_metasxhora').click(function(){

		if (validar_metasxhora()){	

			$('#loading').show();
			
			var met_activ = $.trim($('#met_activ').val());
			var met_undxhr = $.trim($('#met_undxhr').val());
			var met_inivig = $.trim($('#met_inivig').val());
			var met_finvig = $.trim($('#met_finvig').val());
			
			var operacion = 'INSERT';
			parametros = {			
							met_activ:met_activ,
							met_undxhr:met_undxhr,
							met_inivig:met_inivig,
							met_finvig:met_finvig,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_metasxhora.php",
				   parametros,			   
				   function(resp){
						ges_crud_metasxhora(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_metasxhora').click(function(){
		if (validar_metasxhora()){	

			$('#loading').show();
			
			var met_id = $.trim($('#met_id').val());
			var met_area = $.trim($('#met_area').val());
			var met_activ = $.trim($('#met_activ').val());
			var met_undxhr = $.trim($('#met_undxhr').val());
			var met_inivig = $.trim($('#met_inivig').val());
			var met_finvig = $.trim($('#met_finvig').val());
			
			var operacion = 'UPDATE';
			parametros = {
							met_id:met_id,
							met_activ:met_activ,
							met_undxhr:met_undxhr,
							met_inivig:met_inivig,
							met_finvig:met_finvig,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_metasxhora.php",
				   parametros,			   
				   function(resp){
						ges_crud_metasxhora(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_metasxhora').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta meta?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var met_id = $.trim($('#met_id').val());
				var operacion = 'DELETE';
				parametros = {	
								met_id:met_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_metasxhora.php",
					   parametros,			   
					   function(resp){
							ges_crud_metasxhora(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_metasxhora(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Meta registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Meta modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Meta eliminada", "success");
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