$(document).ready(function(){
		
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/time_crud_metas.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'LIN_NOMBRE'},		
				{ data:'METLI_UNID', sType: "numeric-comma"},	
				{ data:'METLI_INIVIG', sType: "date-br"},
				{ data:'METLI_FINVIG', sType: "date-br"},
				{ data:'LIN_ID'},		
				{ data:'METLI_ID'}
			],	
			
			columnDefs: [
				{ targets: [0,1,2,3], visible: true},
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

			$('#metli_id').val(obj_row.METLI_ID);

			$('#lin_id').val(obj_row.LIN_ID).trigger('change');
			$('#metli_unid').val(obj_row.METLI_UNID);
			$('#metli_inivig').val(obj_row.METLI_INIVIG);

			if(obj_row.METLI_FINVIG!=null){
				$('#metli_finvig').val(obj_row.METLI_FINVIG);
				$('#metli_finvig').data('daterangepicker').setStartDate(obj_row.METLI_FINVIG);
			}else{
				$('#metli_finvig').val('');
			}
				
			$('#btn_reg_metas_linea').hide();
			$('#btn_upd_metas_linea').show();
			$('#btn_del_metas_linea').show();
			$('#btn_can_metas_linea').show();		
			
		});
	}
	
	$('#btn_can_metas_linea').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_metas_linea')[0].reset();

		$('#btn_reg_metas_linea').show();
		$('#btn_upd_metas_linea').hide();
		$('#btn_del_metas_linea').hide();
		$('#btn_can_metas_linea').hide();
		table.$('tr.selected').removeClass('selected');
		$('#lin_id').val('').trigger('change');

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


	$('#metli_unid').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#metli_unid").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	

	$('#metli_inivig').daterangepicker({
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
		
	$('#metli_finvig').daterangepicker({
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
			$('#metli_finvig').val(fecha.format('DD-MM-YYYY'));
	});	


	carga_lineas();
	function carga_lineas(){
		var combobox = [];
		for(var i  = 0 ; i < data_lineas.length; i++) {
			combobox.push({id:data_lineas[i].lin_id, text:data_lineas[i].lin_nombre});
		}	
		
		$('#lin_id').select2({			
			allowClear: true,
			data:combobox
		});			
	}	

	
	function validar_metas_linea(){

		var lin_id = $.trim($('#lin_id').val());
		var metli_unid = $.trim($('#metli_unid').val());
		var metli_inivig = $.trim($('#metli_inivig').val());
		var metli_finvig = $.trim($('#metli_finvig').val());
		
		
		if(lin_id == ''){
			sweet_alert('Error: Seleccionar línea productiva');	
			return false;
		}		

		if(metli_unid == ''){
			sweet_alert('Error: Ingresar meta');	
			return false;
		}
		
		if(metli_inivig == ''){
			sweet_alert('Error: Ingresar inicio de vigencia');	
			return false;
		}		

		if(metli_finvig != ''){
			var inivig = metli_inivig.split('-');
			metli_inivig = inivig[2]+'-'+inivig[1]+'-'+inivig[0];
			
			var finvig = metli_finvig.split('-');		
			metli_finvig = finvig[2]+'-'+finvig[1]+'-'+finvig[0];
			
			//validar fechas
			if(!moment(metli_inivig).isSame(metli_finvig) && !moment(metli_inivig).isBefore(metli_finvig)){
				sweet_alert('Error: Inicio vigencia mayor a Fin vigencia');	
				return false;			
			}
		}
		return true;
	}
		  
	$('#btn_reg_metas_linea').click(function(){

		if (validar_metas_linea()){	

			$('#loading').show();
			
			var lin_id = $.trim($('#lin_id').val());
			var metli_unid = $.trim($('#metli_unid').val());
			var metli_inivig = $.trim($('#metli_inivig').val());
			var metli_finvig = $.trim($('#metli_finvig').val());
			
			var operacion = 'INSERT';
			parametros = {			
							lin_id:lin_id,
							metli_unid:metli_unid,
							metli_inivig:metli_inivig,
							metli_finvig:metli_finvig,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/time_crud_metas.php",
				   parametros,			   
				   function(resp){
						time_crud_metas(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_metas_linea').click(function(){
		if (validar_metas_linea()){	

			$('#loading').show();
			
			var metli_id = $.trim($('#metli_id').val());
			var lin_id = $.trim($('#lin_id').val());
			var metli_unid = $.trim($('#metli_unid').val());
			var metli_inivig = $.trim($('#metli_inivig').val());
			var metli_finvig = $.trim($('#metli_finvig').val());
			
			var operacion = 'UPDATE';
			parametros = {
							metli_id:metli_id,
							lin_id:lin_id,
							metli_unid:metli_unid,
							metli_inivig:metli_inivig,
							metli_finvig:metli_finvig,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/time_crud_metas.php",
				   parametros,			   
				   function(resp){
						time_crud_metas(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_metas_linea').click(function(){

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
				var metli_id = $.trim($('#metli_id').val());
				var operacion = 'DELETE';
				parametros = {	
								metli_id:metli_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_metas.php",
					   parametros,			   
					   function(resp){
							time_crud_metas(resp)
					   },"json"
				)
		});	
		
	})		
	
	function time_crud_metas(resp){
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