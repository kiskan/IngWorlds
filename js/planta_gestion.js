$(document).ready(function(){
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}
	
	fix_select_actual();
	function fix_select_actual(){
		
		$('#pm_plantas').select2({});		
		$('#pm_piscinas').select2({});
		$('#clon_id').select2({});
		$('#pm_estado').select2({});		
	}

	fix_select_historico();
	function fix_select_historico(){
	
		$('#per_agno').select2({	});
		$('#per_mes').select2({	});
		$('#sem_num').select2({	});
		$('#pm_filtro').select2({ });	
	}	
	
	moment.locale('es');
	var fecha_hoy = moment().format('DD-MM-YYYY');
	
	$('#pm_finstal').daterangepicker({
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
	
	$('#xpm_fcambio').daterangepicker({
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
	
	$('#xpm_finstal').daterangepicker({
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
	

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") 
		if(target == "#tab1primary"){ 
			fix_select_actual();		  
		}
		if(target == "#tab2primary"){ 
			fix_select_historico();		  
		}
		cancelar();
	});		

	
	
	var table;
	crear_tabla();
	function crear_tabla(){
		var pm_plantas = $.trim($('#pm_plantas').val());
		table = $("#datatable-responsive").DataTable({
			columnDefs: [
				{ targets: [0,1,2,3,4,5,6], visible: true},
				{ targets: '_all', visible: false }			
			],	  
			ajax: "consultas/ges_crud_plantamadre.php?planta_madre="+pm_plantas,
			bPaginate:false,
			bProcessing: true,
			columns: [
				{ data:'pis_pm'},
				{ data:'pis_id'},
				{ data:'clon_id'},
				{ data:'clon_especie'},
				{ data:'pis_estado'},
				{ data:'pis_numseto'},
				{ data:'pis_finstal'}				
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
			
			$('#hpm_plantas').val(obj_row.pis_pm);
			$('#hpm_piscinas').val(obj_row.pis_id);
			
			//$('#pm_plantas').val(obj_row.pis_pm).trigger('change');
			$('#pm_piscinas').val(obj_row.pis_id).trigger('change');
			$('#clon_id').val(obj_row.clon_id).trigger('change');
			$('#pm_estado').val(obj_row.pis_estado).trigger('change');			
			$('#pm_setos').val(obj_row.pis_numseto);
			$('#pm_finstal').val(obj_row.pis_finstal);
			
			$('#hclon_id').val(obj_row.clon_id);
			$('#hpm_estado').val(obj_row.pis_estado);			
			$('#hpm_setos').val(obj_row.pis_numseto);
			$('#hpm_finstal').val(obj_row.pis_finstal);
			
			ocultar_cambio();			
			
			$('#btn_reg_pm').hide();
			$('#btn_upd_pm').show();
			//$('#btn_del_pm').show();
			$('#btn_can_pm').show();	
			$('#btn_cam_pm').show();
		});
	}
	
	
	
//INFO HISTORICA
	
	var table_historia;
	
	crear_tabla_historia(year_current,'','','');
	
	function crear_tabla_historia(per_agno, per_mes, sem_num, pm_filtro){
		//console.log(dia);console.log(id_area);
		table_historia = $("#tabla_historia").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_plantamadre.php?per_agno="+per_agno+"&per_mes="+per_mes+"&sem_num="+sem_num+"&pm_filtro="+pm_filtro,			
			bProcessing: true,
			
			columns: [
				{ data:'agno'},
				{ data:'mes'},
				{ data:'semana'},
				{ data:'pis_pm'},
				{ data:'pis_id'},
				{ data:'clon_id'},
				{ data:'clon_especie'},
				{ data:'pis_estado'},
				{ data:'pis_numseto'},
				{ data:'pis_finstal'},
				{ data:'pis_fcambio'}
			],
			
			columnDefs: [
			{ targets: '_all', visible: true}/*,
			{ targets: '_all', visible: false }	*/					
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
		
	}		
	
	
	
	
	//AÑOS
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}			
		$('#per_agno').select2({				
			data:combobox
		});		
		$('#per_agno').val(year_current).trigger('change');			
	}	

	$('#per_agno').change(function() {
		$('#per_mes').val('').trigger('change');	
		clear_combobox('sem_num',1);
	})	
	
	//MESES
	$('#per_mes').change(function() {
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();
		clear_combobox('sem_num',1);
		if(per_mes != ''){		
			var cons_periodo = 'carga_inicial'		
			
			parametros = {			
				cons_periodo:cons_periodo,
				agno:per_agno,
				mes:per_mes				
			}	
			console.log(parametros)
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					carga_semanas(resp)
				},"json"
			)
		}
	})		
	
	
	function carga_semanas(resp){
		console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
				
	}	
	
	$('#btn_monitoreo').click(function(){
		table_historia.destroy();
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();	
		var sem_num = $('#sem_num').val();
		var pm_filtro = $('#pm_filtro').val();
		
		crear_tabla_historia( per_agno, per_mes, sem_num, pm_filtro);
	})	
	
	
	
	
	
	$('#pm_plantas').change(function() {	
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		crear_tabla();
		cancelar();
		ocultar_cambio();

	})
	
	function ocultar_cambio(){
		$('#pm_piscinas').prop('disabled',false);
		$('#clon_id').prop('disabled',false);
		$('#pm_estado').prop('disabled',false);
		$('#pm_setos').prop('disabled',false);
		$('#pm_finstal').prop('disabled',false);		
		
		$('#cambio_piscina').hide();		
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
	
	
	$('#pm_setos').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;			
	});	

	
	carga_clones();
	function carga_clones(){
		var combobox = [];
		for(var i  = 0 ; i < data_clones.length; i++) {
			combobox.push({id:data_clones[i].clon_id, text:data_clones[i].clon});
		}
		
		$('#clon_id').select2({			
			allowClear: true,
			data:combobox
		});		
		
		$('#xclon_id').select2({			
			allowClear: true,
			data:combobox
		});		
	}		
	
	$('#btn_can_pm').click(function(){
		cancelar();
	})
	
	function cancelar(){
		//$('#form_plantamadre')[0].reset();

		$('#btn_reg_pm').show();
		$('#btn_upd_pm').hide();
		//$('#btn_del_pm').hide();
		$('#btn_can_pm').hide();
		$('#btn_cam_pm').hide();
		table.$('tr.selected').removeClass('selected');
		$('#pm_piscinas').val('1').trigger('change');
		$('#clon_id').val('').trigger('change');
		$('#pm_estado').val('PRODUCCION').trigger('change');
		$('#pm_setos').val('');
		$('#pm_finstal').val(fecha_hoy);
		
		//ocultar_cambio();
	}	
	
	
	function validar_pm(){

		var pm_plantas = $.trim($('#pm_plantas').val());
		var pm_piscinas = $.trim($('#pm_piscinas').val());
		var clon_id = $.trim($('#clon_id').val());
		var pm_estado = $.trim($('#pm_estado').val());
		var pm_setos = $.trim($('#pm_setos').val());
		var pm_finstal = $.trim($('#pm_finstal').val());
		
		if(pm_plantas == ''){
			sweet_alert('Error: Seleccionar planta madre');	
			return false;
		}
		
		if(pm_piscinas == ''){
			sweet_alert('Error: Seleccionar piscina');	
			return false;
		}		

		if(clon_id == ''){
			sweet_alert('Error: Seleccionar clon');
			return false;
		}
		
		if(pm_estado == ''){
			sweet_alert('Error: Seleccionar estado');	
			return false;
		}		

		if(pm_setos == ''){
			sweet_alert('Error: Ingresar número de setos');	
			return false;
		}		
		
		if(pm_finstal == ''){
			sweet_alert('Error: Ingresar fecha de instalación');	
			return false;
		}			
			
		if (!moment(pm_finstal,'DD-MM-YYYY').isValid()) {
			sweet_alert('Error: Fecha de instalación inválida');
			return false;
		} 

		return true;
	}	
	
	
	$('#btn_reg_pm').click(function(){

		if (validar_pm()){	

			$('#loading').show();
			
			var pm_plantas = $.trim($('#pm_plantas').val());
			var pm_piscinas = $.trim($('#pm_piscinas').val());
			var clon_id = $.trim($('#clon_id').val());
			var pm_estado = $.trim($('#pm_estado').val());
			var pm_setos = $.trim($('#pm_setos').val());
			var pm_finstal = $.trim($('#pm_finstal').val());
			
			var operacion = 'INSERT';
			parametros = {			
							pm_plantas:pm_plantas,
							pm_piscinas:pm_piscinas,
							clon_id:clon_id,
							pm_estado:pm_estado,
							pm_finstal:pm_finstal,
							pm_setos:pm_setos,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_plantamadre.php",
				   parametros,			   
				   function(resp){
						ges_crud_plantamadre(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_pm').click(function(){
		if (validar_pm()){	

			$('#loading').show();
			
			var hpm_plantas = $.trim($('#hpm_plantas').val());
			var hpm_piscinas = $.trim($('#hpm_piscinas').val());
			var pm_plantas = $.trim($('#pm_plantas').val());
			var pm_piscinas = $.trim($('#pm_piscinas').val());			
			var clon_id = $.trim($('#clon_id').val());
			var pm_estado = $.trim($('#pm_estado').val());
			var pm_setos = $.trim($('#pm_setos').val());
			var pm_finstal = $.trim($('#pm_finstal').val());
			
			var operacion = 'UPDATE';
			parametros = {
							hpm_plantas:hpm_plantas,
							hpm_piscinas:hpm_piscinas,			
							pm_plantas:pm_plantas,
							pm_piscinas:pm_piscinas,
							clon_id:clon_id,
							pm_estado:pm_estado,
							pm_finstal:pm_finstal,
							pm_setos:pm_setos,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_plantamadre.php",
				   parametros,			   
				   function(resp){
						ges_crud_plantamadre(resp)
				   },"json"
			)
			
			return false;		
		}
	})		
/*
 	$('#btn_del_pm').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta piscina?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var hpm_plantas = $.trim($('#hpm_plantas').val());
				var hpm_piscinas = $.trim($('#hpm_piscinas').val());
				var operacion = 'DELETE';
				parametros = {	
								hpm_plantas:hpm_plantas,
								hpm_piscinas:hpm_piscinas,	
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_plantamadre.php",
					   parametros,			   
					   function(resp){
							ges_crud_plantamadre(resp)
					   },"json"
				)
		});	
		
	})		
*/	
	function ges_crud_plantamadre(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Piscina registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Piscina modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Piscina eliminada", "success");
			}else if(operacion == 'INSERT_CAMBIO'){
				swal("Sisconvi-Production", "Cambio registrado", "success");
				ocultar_cambio();
			}		
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}		
	

	
/**CAMBIO DE PISCINA**/	
	
	$('#btn_cam_pm').click(function(){

		$('#btn_upd_pm').hide();
		$('#btn_can_pm').hide();
		$('#btn_cam_pm').hide();
			
		var hpm_piscinas = $.trim($('#hpm_piscinas').val());			
		var hclon_id = $.trim($('#hclon_id').val());
		var hpm_estado = $.trim($('#hpm_estado').val());
		var hpm_setos = $.trim($('#hpm_setos').val());
		var hpm_finstal = $.trim($('#hpm_finstal').val());		
		
		$('#pm_piscinas').val(hpm_piscinas).trigger('change');
		$('#clon_id').val(hclon_id).trigger('change');
		$('#pm_estado').val(hpm_estado).trigger('change');
		$('#pm_setos').val(hpm_setos);
		$('#pm_finstal').val(hpm_finstal);	
		
		$('#pm_piscinas').prop('disabled',true);
		$('#clon_id').prop('disabled',true);
		$('#pm_estado').prop('disabled',true);
		$('#pm_setos').prop('disabled',true);
		$('#pm_finstal').prop('disabled',true);			

		$('#xpm_piscinas').val(hpm_piscinas).trigger('change');
		$('#xclon_id').val('').trigger('change');
		$('#xpm_estado').val('PRODUCCION').trigger('change');
		$('#xpm_setos').val('');
		$('#xpm_finstal').val(fecha_hoy);
		$('#xpm_fcambio').val(fecha_hoy);
		
		$('#cambio_piscina').show();
		
		$('#xpm_piscinas').select2({});
		$('#xclon_id').select2({});
		$('#xpm_estado').select2({});		
				
	})	
	
	$('#xbtn_can_pm').click(function(){

		$('#btn_upd_pm').show();
		$('#btn_can_pm').show();
		$('#btn_cam_pm').show();
		
		$('#pm_piscinas').prop('disabled',false);
		$('#clon_id').prop('disabled',false);
		$('#pm_estado').prop('disabled',false);
		$('#pm_setos').prop('disabled',false);
		$('#pm_finstal').prop('disabled',false);			
		
		$('#cambio_piscina').hide();				
	})		
	
	
	
	
	function validar_pmx(){

		var pm_plantas = $.trim($('#pm_plantas').val());
		var xpm_fcambio = $.trim($('#xpm_fcambio').val());
		var xpm_piscinas = $.trim($('#xpm_piscinas').val());
		var xclon_id = $.trim($('#xclon_id').val());
		var xpm_estado = $.trim($('#xpm_estado').val());
		var xpm_setos = $.trim($('#xpm_setos').val());
		var xpm_finstal = $.trim($('#xpm_finstal').val());
		var pm_finstal = $.trim($('#pm_finstal').val());

		var fechacambio = xpm_fcambio.split('-');
		pm_fechacambio = fechacambio[2]+'-'+fechacambio[1]+'-'+fechacambio[0];		
		
		var inivig = pm_finstal.split('-');
		pm_inivig = inivig[2]+'-'+inivig[1]+'-'+inivig[0];
		
		var finvig = xpm_finstal.split('-');		
		pm_finvig = finvig[2]+'-'+finvig[1]+'-'+finvig[0];		
		
		
		if(pm_plantas == ''){
			sweet_alert('Error: Seleccionar planta madre');	
			return false;
		}
		
		if(xpm_piscinas == ''){
			sweet_alert('Error: Seleccionar piscina');	
			return false;
		}		

		if(xclon_id == ''){
			sweet_alert('Error: Seleccionar clon');
			return false;
		}
		
		if(xpm_estado == ''){
			sweet_alert('Error: Seleccionar estado');	
			return false;
		}		

		if(xpm_setos == ''){
			sweet_alert('Error: Ingresar número de setos');	
			return false;
		}		
		
		if(xpm_finstal == ''){
			sweet_alert('Error: Ingresar fecha de instalación');	
			return false;
		}			
			
		if (!moment(xpm_finstal,'DD-MM-YYYY').isValid()) {
			sweet_alert('Error: Fecha de instalación inválida');
			return false;
		} 
		
		if(xpm_fcambio == ''){
			sweet_alert('Error: Ingresar fecha de instalación');	
			return false;
		}			
			
		if (!moment(xpm_fcambio,'DD-MM-YYYY').isValid()) {
			sweet_alert('Error: Fecha de instalación inválida');
			return false;
		} 
/*		
		if (moment(pm_finvig).isSameOrBefore(pm_inivig)) {
			sweet_alert('Error: Nueva fecha instalación no puede ser menor o igual a fecha instalación a cambiar');
			return false;
		}		
		
		if (moment(pm_fechacambio).isSameOrBefore(pm_inivig)) {
			sweet_alert('Error: Fecha de cambio no puede ser menor o igual a fecha instalación a cambiar');
			return false;
		}	
*/		
		if (moment(pm_fechacambio).isBefore(pm_inivig)) {
			sweet_alert('Error: Fecha de cambio no puede ser menor a fecha instalación a cambiar');
			return false;
		}			
		
/*		
		if (moment(pm_finvig).isSameOrBefore(pm_fechacambio)) {
			sweet_alert('Error: Fecha de cambio no puede ser mayor o igual a nueva fecha instalación');
			return false;
		}		
*/
		return true;
	}		
	
	
	
	$('#xbtn_reg_pm').click(function(){

		if (validar_pmx()){	

			$('#loading').show();
			
			var pm_plantas = $.trim($('#pm_plantas').val());
			var hpm_piscinas = $.trim($('#hpm_piscinas').val());
			var xpm_fcambio = $.trim($('#xpm_fcambio').val());
			//var xpm_piscinas = $.trim($('#xpm_piscinas').val());
			var xclon_id = $.trim($('#xclon_id').val());
			var xpm_estado = $.trim($('#xpm_estado').val());
			var xpm_setos = $.trim($('#xpm_setos').val());
			var xpm_finstal = $.trim($('#xpm_finstal').val());
						
			var clon_id = $.trim($('#clon_id').val());
			var pm_estado = $.trim($('#pm_estado').val());
			var pm_setos = $.trim($('#pm_setos').val());
			var pm_finstal = $.trim($('#pm_finstal').val());			
			
			var operacion = 'INSERT_CAMBIO';
			parametros = {			
							pm_plantas:pm_plantas,
							hpm_piscinas:hpm_piscinas,
							xpm_fcambio:xpm_fcambio,
							//xpm_piscinas:xpm_piscinas,
							xclon_id:xclon_id,
							xpm_estado:xpm_estado,
							xpm_finstal:xpm_finstal,
							xpm_setos:xpm_setos,
							clon_id:clon_id,
							pm_estado:pm_estado,
							pm_finstal:pm_finstal,
							pm_setos:pm_setos,							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_plantamadre.php",
				   parametros,			   
				   function(resp){
						ges_crud_plantamadre(resp)
				   },"json"
			)
		}	
	})		
});