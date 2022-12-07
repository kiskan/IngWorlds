$(document).ready(function(){
		
	$('#paramfer_iph').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		paramfer_iph = $('#paramfer_iph').val();
		if(e.which==44 && paramfer_iph.search( ',' ) != -1)return false;			
	});	
	
	$('#paramfer_fph').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		paramfer_fph = $('#paramfer_fph').val();
		if(e.which==44 && paramfer_fph.search( ',' ) != -1)return false;			
	});		
	
	$('#paramfer_ice').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#paramfer_fce').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
		
	$('#paramfer_icaudal').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#paramfer_fcaudal').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_ferparametros.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'PARAMFER_IPH'},
				{ data:'PARAMFER_FPH'},
				{ data:'PARAMFER_ICE'},
				{ data:'PARAMFER_FCE'},
				{ data:'PARAMFER_ICAUDAL'},
				{ data:'PARAMFER_FCAUDAL'},
				{ data:'PARAMFER_INIVIG', sType: "date-br"},
				{ data:'PARAMFER_FINVIG', sType: "date-br"},		
				{ data:'PARAMFER_ID'}
			],	
		
			columnDefs: [
				{ targets: [8], visible: false},
				{ targets: '_all', visible: true }			
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

			$('#h_paramfer_id').val(obj_row.PARAMFER_ID);
			
			$('#paramfer_iph').val(obj_row.PARAMFER_IPH);
			$('#paramfer_fph').val(obj_row.PARAMFER_FPH);
			
			$('#paramfer_ice').val(obj_row.PARAMFER_ICE);
			$('#paramfer_fce').val(obj_row.PARAMFER_FCE);
			
			$('#paramfer_icaudal').val(obj_row.PARAMFER_ICAUDAL);
			$('#paramfer_fcaudal').val(obj_row.PARAMFER_FCAUDAL);	
			
			$('#paramfer_inivig').val(obj_row.PARAMFER_INIVIG);
			
			if(obj_row.PARAMFER_FINVIG!=null){
				$('#paramfer_finvig').val(obj_row.PARAMFER_FINVIG);
				$('#paramfer_finvig').data('daterangepicker').setStartDate(obj_row.PARAMFER_FINVIG);
			}else{
				$('#paramfer_finvig').val('');
			}
				
			$('#btn_reg_paramfer').hide();
			$('#btn_upd_paramfer').show();
			$('#btn_del_paramfer').show();
			$('#btn_can_paramfer').show();		
			
		});
	}
	
	$('#btn_can_paramfer').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_paramfer')[0].reset();

		$('#btn_reg_paramfer').show();
		$('#btn_upd_paramfer').hide();
		$('#btn_del_paramfer').hide();
		$('#btn_can_paramfer').hide();
		table.$('tr.selected').removeClass('selected');
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

	$('#paramfer_inivig').daterangepicker({
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
		
	$('#paramfer_finvig').daterangepicker({
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
			$('#paramfer_finvig').val(fecha.format('DD-MM-YYYY'));
	});	

	
	function validar_paramfer(){

		var paramfer_iph = $.trim($('#paramfer_iph').val()).replace(',','.');
		var paramfer_fph = $.trim($('#paramfer_fph').val()).replace(',','.');
		
		var paramfer_ice = $.trim($('#paramfer_ice').val());
		var paramfer_fce = $.trim($('#paramfer_fce').val());
		var paramfer_icaudal = $.trim($('#paramfer_icaudal').val());
		var paramfer_fcaudal = $.trim($('#paramfer_fcaudal').val());
		var paramfer_inivig = $.trim($('#paramfer_inivig').val());
		var paramfer_finvig = $.trim($('#paramfer_finvig').val());
		
		if(paramfer_iph == ''){
			sweet_alert('Error: Ingresar PH mínimo');	
			return false;
		}
		
		if(paramfer_fph == ''){
			sweet_alert('Error: Ingresar PH máximo');	
			return false;
		}		
		
		if(paramfer_iph > paramfer_fph){
			sweet_alert('Error: PH mínimo no puede ser mayor a PH máximo');	
			return false;
		}		
		
		if(paramfer_ice == ''){
			sweet_alert('Error: Ingresar CE mínimo');	
			return false;
		}
		
		if(paramfer_fce == ''){
			sweet_alert('Error: Ingresar CE máximo');	
			return false;
		}
		
		if(paramfer_ice > paramfer_fce){
			sweet_alert('Error: CE mínimo no puede ser mayor a CE máximo');	
			return false;
		}		
		
		if(paramfer_icaudal == ''){
			sweet_alert('Error: Ingresar Caudal mínimo');	
			return false;
		}		

		if(paramfer_fcaudal == ''){
			sweet_alert('Error: Ingresar Caudal máximo');	
			return false;
		}		
		
		if(paramfer_icaudal > paramfer_fcaudal){
			sweet_alert('Error: Caudal mínimo no puede ser mayor a Caudal máximo');	
			return false;
		}		
		
		if(paramfer_inivig == ''){
			sweet_alert('Error: Ingresar inicio de vigencia');	
			return false;
		}		
		
			
		if(moment(paramfer_inivig,'DD-MM-YYYY').isoWeekday() != 1){
			sweet_alert('Error: Debe iniciar un día LUNES');	
			return false;				
		}

		
		if(paramfer_finvig != ''){
			var inivig = paramfer_inivig.split('-');
			paramfer_inivig = inivig[2]+'-'+inivig[1]+'-'+inivig[0];
			
			var finvig = paramfer_finvig.split('-');		
			paramfer_finvig = finvig[2]+'-'+finvig[1]+'-'+finvig[0];
			
			//validar fechas
			if(!moment(paramfer_inivig).isSame(paramfer_finvig) && !moment(paramfer_inivig).isBefore(paramfer_finvig)){
				sweet_alert('Error: Inicio vigencia mayor a Fin vigencia');	
				return false;			
			}
		}
		return true;
	}
		  
	$('#btn_reg_paramfer').click(function(){

		if (validar_paramfer()){	

			$('#loading').show();
			
			var paramfer_iph = $.trim($('#paramfer_iph').val());
			var paramfer_fph = $.trim($('#paramfer_fph').val());
			var paramfer_ice = $.trim($('#paramfer_ice').val());
			var paramfer_fce = $.trim($('#paramfer_fce').val());
			var paramfer_icaudal = $.trim($('#paramfer_icaudal').val());
			var paramfer_fcaudal = $.trim($('#paramfer_fcaudal').val());
			var paramfer_inivig = $.trim($('#paramfer_inivig').val());
			var paramfer_finvig = $.trim($('#paramfer_finvig').val());
			
			var operacion = 'INSERT';
			parametros = {			
							paramfer_iph:paramfer_iph,
							paramfer_fph:paramfer_fph,
							paramfer_ice:paramfer_ice,
							paramfer_fce:paramfer_fce,							
							paramfer_icaudal:paramfer_icaudal,
							paramfer_fcaudal:paramfer_fcaudal,
							paramfer_inivig:paramfer_inivig,
							paramfer_finvig:paramfer_finvig,							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_ferparametros.php",
				   parametros,			   
				   function(resp){
						ges_crud_ferparametros(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_paramfer').click(function(){
		if (validar_paramfer()){	

			$('#loading').show();
			
			var h_paramfer_id = $.trim($('#h_paramfer_id').val());
			var paramfer_iph = $.trim($('#paramfer_iph').val());
			var paramfer_fph = $.trim($('#paramfer_fph').val());
			var paramfer_ice = $.trim($('#paramfer_ice').val());
			var paramfer_fce = $.trim($('#paramfer_fce').val());
			var paramfer_icaudal = $.trim($('#paramfer_icaudal').val());
			var paramfer_fcaudal = $.trim($('#paramfer_fcaudal').val());
			var paramfer_inivig = $.trim($('#paramfer_inivig').val());
			var paramfer_finvig = $.trim($('#paramfer_finvig').val());
			
			var operacion = 'UPDATE';
			parametros = {
							h_paramfer_id:h_paramfer_id,
							paramfer_iph:paramfer_iph,
							paramfer_fph:paramfer_fph,
							paramfer_ice:paramfer_ice,
							paramfer_fce:paramfer_fce,							
							paramfer_icaudal:paramfer_icaudal,
							paramfer_fcaudal:paramfer_fcaudal,
							paramfer_inivig:paramfer_inivig,
							paramfer_finvig:paramfer_finvig,	
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_ferparametros.php",
				   parametros,			   
				   function(resp){
						ges_crud_ferparametros(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_paramfer').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar estos Parámetros?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_paramfer_id = $.trim($('#h_paramfer_id').val());
				var operacion = 'DELETE';
				parametros = {	
								h_paramfer_id:h_paramfer_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_ferparametros.php",
					   parametros,			   
					   function(resp){
							ges_crud_ferparametros(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_ferparametros(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Parámetros registrados", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Parámetros modificados", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Parámetros eliminados", "success");
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