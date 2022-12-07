$(document).ready(function(){

////////////FUNCIONES COMUNES/////////////////

	function removeItemArray(arr) {

		var what, a = arguments, L = a.length, ax;
		while (L > 1 && arr.length) {
			what = a[--L];
			while ((ax= arr.indexOf(what)) !== -1) {
				arr.splice(ax, 1);
			}
		}
		return arr;
	}

	fix_select_prod();
	function fix_select_prod(){
		
		$('#activ_prod_id').select2({});
	
		$('#sup_rut_prod').select2({			
			allowClear: true,
			placeholder: "SELECCIONE SUPERVISOR(ES)"
		})	
		
		$('#activ_interes').select2({});		
	}

	fix_select_apoyo();
	function fix_select_apoyo(){
	
		$('#activ_apoyo_id').select2({});	
	
		$('#sup_rut_apoyo').select2({			
			allowClear: true,
			placeholder: "SELECCIONE SUPERVISOR(ES)"
		})		
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
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}
	
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href") 
		if(target == "#tab1primary"){ 
			fix_select_prod();		  
		}
		if(target == "#tab2primary"){ 
			fix_select_apoyo();
		  
		}
		cancelar();
	});	
	
	function cancelar(){
		$('#form_planxmaestro')[0].reset();		
		$('#h_activ_id').val('');
		
		$('#activ_prod_id').val('');
		$('#activ_prod_id').trigger('change');
		$('#sup_rut_prod').val('');
		$('#sup_rut_prod').trigger('change');

		$('#activ_apoyo_id').val('');
		$('#activ_apoyo_id').trigger('change');
		$('#sup_rut_apoyo').val('');
		$('#sup_rut_apoyo').trigger('change');	
		
		$('#plan_dia_rep').val('');
		$('#plan_dia_rep').trigger('change');
		$('#plan_dia_elim').val('');
		$('#plan_dia_elim').trigger('change');		
		
		
		$('#btn_reg_activ_prod').show();
		$('#btn_upd_activ_prod').hide();
		$('#btn_del_activ_prod').hide();
		$('#btn_can_activ_prod').hide();	
		
		$('#btn_reg_activ_apoyo').show();
		$('#btn_upd_activ_apoyo').hide();
		$('#btn_del_activ_apoyo').hide();
		$('#btn_can_activ_apoyo').hide();			

		table_prod.$('tr.selected').removeClass('selected');
		table_apoyo.$('tr.selected').removeClass('selected');

	}
	
	function deshabilitar_filtros(){
		$('#per_agno').prop( "disabled", true );
		$('#sem_num').prop( "disabled", true );
		$('#plan_dia').prop( "disabled", true );
		$('#area_id').prop( "disabled", true );		
		$('#btn_del_planxmaestro').show();
		$('#btn_can_planxmaestro').show();	
		
		$('#btn_comun_planxmaestro').hide();
		$('#pos_activ_comun').show();
		
		actualizar_filtros();	
	}

	function habilitar_filtros(){
		$('#per_agno').prop( "disabled", false );
		$('#sem_num').prop( "disabled", false );
		$('#plan_dia').prop( "disabled", false );
		$('#area_id').prop( "disabled", false );	
		$('#btn_del_planxmaestro').hide();
		$('#btn_can_planxmaestro').hide();	
		
		$('#plan_dia').val('');
		$('#plan_dia').trigger('change');		
		$('#area_id').val('');
		$('#area_id').trigger('change');	
		
		$('#btn_comun_planxmaestro').show();
		$('#pos_activ_comun').hide();		
	}
	
	
	function actualizar_filtros(){
		var plan_dia = $.trim($('#plan_dia').val());
		
		$('#plan_dia_rep').select2('destroy');
		
		$("#plan_dia_rep > option").each(function() {
			$("#plan_dia_rep").find("option[value='"+this.value+"']").removeAttr("disabled")
		});	
		
		$.each(plan_dia.split(","), function(i,e){
			$("#plan_dia_rep").find("option[value='"+e+"']").attr('disabled', 'disabled');
		});		
		
		$('#plan_dia_rep').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			multiple: true
		});	

		
		$('#plan_dia_elim').select2('destroy');
		
		$("#plan_dia_elim > option").each(function() {
			$("#plan_dia_elim").find("option[value='"+this.value+"']").attr('disabled', 'disabled');
		});
	
		$.each(plan_dia.split(","), function(i,e){
			$("#plan_dia_elim").find("option[value='"+e+"']").removeAttr("disabled")
		});		
		
		$('#plan_dia_elim').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			multiple: true
		});	
	
	}
	
	function actualizar_tablas_activ(dia, area_id,tipo){
	
		if(tipo == 'PRODUCTIVA'){
			$('#tabla_activ_prod tbody').unbind( "click" );
			table_prod.destroy();
			crear_tabla_prod(dia, area_id);
		}
		
		if(tipo == 'APOYO'){
			$('#tabla_activ_apoyo tbody').unbind( "click" );
			table_apoyo.destroy();
			crear_tabla_apoyo(dia, area_id);
		}		
	}
	
	
	function actualizar_planm(sem_num,per_agno){
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		crear_tabla(sem_num,per_agno);	
	}
	
////////////KEYPRESS/////////////////

	$('#activ_prod_jornada').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		prod_esperada = $('#activ_prod_jornada').val();
		if(e.which==44 && prod_esperada.search( ',' ) != -1)return false;			
	});		
	
	$('#activ_prod_esperada').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		//prod_esperada = $('#activ_prod_esperada').val();
		//if(e.which==44 && prod_esperada.search( ',' ) != -1)return false;			
	});	
	
	$('#activ_apoyo_jornada').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		prod_esperada = $('#activ_apoyo_jornada').val();
		if(e.which==44 && prod_esperada.search( ',' ) != -1)return false;			
	});	

////////////CARGAS INICIALES/////////////////

	//LOAD DATATABLE
	var table;
	function crear_tabla(num_sem, per_agno){
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_planxmaestro.php?data="+num_sem+"&per_agno="+per_agno,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'PLAN_DIA'},
				{ data:'AREA_NOMBRE'},			
				{ data:'AREA_ID'}
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
	
		$('#datatable-responsive tbody')
			.on( 'click', 'tr', function () {
			/*
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}*/

			var obj_row = table.row(this).data();	

			//console.log(obj_row)
			fecha = obj_row.PLAN_DIA;
			fecha = fecha.split('-');
			fecha = fecha[2]+fecha[1]+fecha[0];
			
			$('#plan_dia').val(fecha).trigger('change');
			$('#area_id').val(obj_row.AREA_ID).trigger('change');

			$('#tabla_activ_prod tbody').unbind( "click" );
			table_prod.destroy();
			crear_tabla_prod(fecha, obj_row.AREA_ID)

			$('#tabla_activ_apoyo tbody').unbind( "click" );
			table_apoyo.destroy();
			crear_tabla_apoyo(fecha, obj_row.AREA_ID)
			
			cancelar();
			deshabilitar_filtros();

					
		});
	}


/////// PRODUCTIVA /////////////

	var table_prod;
	
	crear_tabla_prod(0, 0);
	
	function crear_tabla_prod(dia, id_area){
		//console.log(dia);console.log(id_area);
		table_prod = $("#tabla_activ_prod").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_planxmaestro.php?dia_activ_prod="+dia+"&id_area="+id_area,			
			bProcessing: true,

			columns: [
				{ data:'ACTIV_NOMBRE'},
				{ data:'SUPERVISOR'},
				{ data:'DE_INTERES'},
				{ data:'JORNADA'},			
				{ data:'META'},
				{ data:'PROD_ESPERADA'},
				{ data:'UNIDAD'},
				{ data:'ACTIV_ID'},
				{ data:'SUP_RUT'}
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
	
		$('#tabla_activ_prod tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table_prod.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}

			var obj_row = table_prod.row(this).data();	
			
			$('#activ_prod_id').val(obj_row.ACTIV_ID).trigger('change');
			
			activ_split = obj_row.ACTIV_ID.split('---');			
			activ_id = activ_split[0];
			$('#h_activ_id').val(activ_id);
			
			supervisores = [];
			$.each(obj_row.SUP_RUT.split(","), function(i,e){
				supervisores.push(e);
			});	

			$('#sup_rut_prod').val(supervisores).trigger('change');
			$('#activ_prod_interes').val(obj_row.DE_INTERES);
			
			$('#activ_prod_jornada').val(obj_row.JORNADA);
			$('#activ_prod_meta').val(obj_row.META);
			$('#activ_prod_esperada').val(obj_row.PROD_ESPERADA);
			$('#activ_prod_unidad').val(obj_row.UNIDAD);

			$('#btn_reg_activ_prod').hide();
			$('#btn_upd_activ_prod').show();
			$('#btn_del_activ_prod').show();
			$('#btn_can_activ_prod').show();				


		});
		
	}
	
	
////////// APOYO ///////////////////	
	
	
	
	var table_apoyo;
	
	crear_tabla_apoyo(0, 0);
	
	function crear_tabla_apoyo(dia, id_area){
		//console.log(dia);console.log(id_area);
		table_apoyo = $("#tabla_activ_apoyo").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_planxmaestro.php?dia_activ_apoyo="+dia+"&id_area="+id_area,			
			bProcessing: true,
			
			columns: [
				{ data:'ACTIV_NOMBRE'},
				{ data:'SUPERVISOR'},
				{ data:'JORNADA'},			
				{ data:'ACTIV_ID'},
				{ data:'SUP_RUT'}
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
	
		$('#tabla_activ_apoyo tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table_apoyo.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}

			var obj_row = table_apoyo.row(this).data();	
			console.log(obj_row)
			$('#activ_apoyo_id').val(obj_row.ACTIV_ID).trigger('change');
	
			$('#h_activ_id').val(obj_row.ACTIV_ID);
			
			supervisores = [];
			$.each(obj_row.SUP_RUT.split(","), function(i,e){
				supervisores.push(e);
			});	

			$('#sup_rut_apoyo').val(supervisores).trigger('change');
			$('#activ_apoyo_jornada').val(obj_row.JORNADA);

			$('#btn_reg_activ_apoyo').hide();
			$('#btn_upd_activ_apoyo').show();
			$('#btn_del_activ_apoyo').show();
			$('#btn_can_activ_apoyo').show();				

		});
		
	}	
	
	
	
	
	
	
	
	
	
	
	
////////////////////////////
	
	
	//LOAD AÑOS
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		
	}
	
	//LOAD SEMANAS
	carga_semanas_ini();
	function carga_semanas_ini(){
		var combobox = [];
		for(var i  = 0 ; i < data_semanas.length; i++) {
			combobox.push({id:data_semanas[i].SEM_NUM, text:data_semanas[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		});	
		$('#sem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
	}	
	
	//LOAD AREAS
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
	

////////////CHANGE/////////////////
	
		
	//CHANGE AÑO
	$('#per_agno').change(function() {	
		change_agno()		
	});
	
	function change_agno(){
		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		clear_combobox('sem_num',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_semanas(resp)
			},"json"
		)		
	}
	
	//LOAD SEMANA X CHANGE AÑO
	function carga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		
		cancelar();
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();		
		change_sem_num();
	}

	
	//CHANGE SEMANA
	$('#sem_num').change(function() {

		cancelar();
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		change_sem_num();

	});
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num:sem_num
		}		
		clear_combobox('plan_dia',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}

	//LOAD DIAS X CHANGE SEMANA
	function carga_dias(resp){
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#plan_dia').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			data:combobox
		});			
	
		$('#plan_dia_rep').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			data:combobox
		});		

		$('#plan_dia_elim').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			data:combobox
		});			
	
		
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		
		//console.log(sem_num)
		//console.log(per_agno)
		
		crear_tabla(sem_num,per_agno);
		sem_txt = $('#sem_num option:selected').text();
		$('#sem_txt').html(sem_txt);
	}	
		
	
	//CHANGE AREA
	$('#area_id').change(function() {

		var area_id = $('#area_id').val();
		var fecha_dia = $("#plan_dia option")[0].value;
		//var activ_id = $('#h_activ_id').val();
		//var sem_num = $('#sem_num').val();
		//var plan_dia = $.trim($('#plan_dia').val());

		$('#activ_prod_meta').val('');
		$('#activ_prod_unidad').val('');
		
		if(area_id == ""){
			clear_combobox('sup_rut_prod',0);
			clear_combobox('sup_rut_apoyo',0);
			clear_combobox('activ_prod_id',1);
			clear_combobox('activ_apoyo_id',1);
		}
		else{		

			parametros = {			
				plan_area:area_id
			}		
			clear_combobox('sup_rut_prod',0);
			clear_combobox('sup_rut_apoyo',0);
			$.post(
				"consultas/ges_crud_supervisores.php",
				parametros,			   
				function(resp){
					carga_supervisores(resp)
				},"json"
				)	
			
			parametros = {			
				plan_maestro:area_id,fecha_dia:fecha_dia
			}			
			
			clear_combobox('activ_prod_id',1);
			clear_combobox('activ_apoyo_id',1);
			$.post(
				"consultas/ges_crud_actividades.php",
				parametros,			   
				function(resp){
					carga_actividades(resp)
				},"json"
			)
		}
					
	});
	
	//CHANGE ACTIVIDAD PRODUCTIVA
	$('#activ_prod_id').change(function() {
		
		activ_id = $.trim($('#activ_prod_id').val());
		//console.log(activ_id)
		if(activ_id == ""){
			$('#activ_prod_jornada').val('');
			$('#activ_prod_meta').val('');
			$('#activ_prod_esperada').val('');
			$('#activ_prod_unidad').val('');			
		}else{
		
			split_actividad = activ_id.split("---");
			unidad = split_actividad[1];
			meta = split_actividad[2];
			
			$('#activ_prod_meta').val(meta);
			$('#activ_prod_unidad').val(unidad);

			jornada = $.trim($('#activ_prod_jornada').val());
			prod_esperada = $.trim($('#activ_prod_esperada').val());
			
			if(jornada != '' && meta != ''){
				
				jornada = jornada.replace(',','.');
				jornada = Math.round(jornada * 10)/10;
				meta = meta.replace(',','.');
				//val_prod_esperada = jornada * meta;
				//val_prod_esperada = Math.round(val_prod_esperada * 10)/10;
				//val_prod_esperada = String(val_prod_esperada).replace('.',',');
				val_prod_esperada = Math.round(jornada * meta * 8.25);
				$('#activ_prod_esperada').val(val_prod_esperada);			
				
			}
			else if(prod_esperada != '' && meta != '' && meta != '0'){
			
				prod_esperada = prod_esperada.replace(',','.');
				meta = meta.replace(',','.');
				//val_jornada = prod_esperada / meta;
				val_jornada = prod_esperada / (meta * 8.25);
				val_jornada = Math.round(val_jornada * 10)/10;
				val_jornada = String(val_jornada).replace('.',',');
				$('#activ_prod_jornada').val(val_jornada);			
			}	
		}
	})	
	

	
	//LOAD SUPERVISORES X CHANGE AREA
	function carga_supervisores(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
		}	

		$('#sup_rut_prod').select2({			
			allowClear: true,
			placeholder: "SELECCIONE SUPERVISOR(ES)",
			data:combobox
		})		

		$('#sup_rut_apoyo').select2({			
			allowClear: true,
			placeholder: "SELECCIONE SUPERVISOR(ES)",
			data:combobox
		})		
		
	}	
	
	//LOAD ACTIVIDADES X CHANGE AREA
	function carga_actividades(resp){
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
		
			tipo_actividad = resp[i].ACTIV_ID.split("---");
			
			if(tipo_actividad[3] == "APOYO") break;
		
			combobox.push({id:resp[i].ACTIV_ID, text:resp[i].ACTIV_NOMBRE});
		}	

		var combobox2 = [];
		for( ; i < resp.length; i++) {
			actividad = resp[i].ACTIV_ID.split("---");
			combobox2.push({id:actividad[0], text:resp[i].ACTIV_NOMBRE});
		}		
		
		$('#activ_prod_id').select2({			
			data:combobox
		})
	
		$('#activ_apoyo_id').select2({			
			data:combobox2
		})	

	}	

	
////////////EVENTO FOCUSOUT/////////////////

	//FOCUSOUT JORNADA PRODUCTIVA
	$('#activ_prod_jornada').focusout(function() {
	
		activ_id = $.trim($('#activ_prod_id').val());
		jornada = $.trim($('#activ_prod_jornada').val());
		prod_esperada = $.trim($('#activ_prod_esperada').val());
		
		if(jornada == ","){
			$('#activ_prod_jornada').val('');
			$('#activ_prod_esperada').val('');
		}
		else{
			if(activ_id != "" && jornada != ""){
				split_actividad = activ_id.split("---");
				meta = split_actividad[2];
				
				if(meta != ''){
					jornada = jornada.replace(',','.');
					jornada = Math.round(jornada * 10)/10;
					meta = meta.replace(',','.');
					//val_prod_esperada = jornada * meta * 8.25;
					//val_prod_esperada = Math.round(val_prod_esperada * 10)/10;
					//val_prod_esperada = String(val_prod_esperada).replace('.',',');
					val_prod_esperada = Math.round(jornada * meta * 8.25);
					$('#activ_prod_esperada').val(val_prod_esperada);
					jornada = String(jornada).replace('.',',');
					$('#activ_prod_jornada').val(jornada);
				}					
			}else if(activ_id != "" && jornada == "" && prod_esperada != "" && prod_esperada != ","){		

				split_actividad = activ_id.split("---");
				meta = split_actividad[2];
				
				if(meta != '' && meta != '0'){
					prod_esperada = prod_esperada.replace(',','.');
					meta = meta.replace(',','.');
					val_jornada = prod_esperada / (meta * 8.25);
					val_jornada = Math.round(val_jornada * 10)/10;
					val_jornada = String(val_jornada).replace('.',',');
					$('#activ_prod_jornada').val(val_jornada);
				}			
			
			}else if(activ_id != ""){
				$('#activ_prod_jornada').val('');
				$('#activ_prod_esperada').val('');		
			}
		}	
	})	

	//FOCUSOUT PRODUCCION ESPERADA
	$('#activ_prod_esperada').focusout(function() {
		
		activ_id = $.trim($('#activ_prod_id').val());
		prod_esperada = $.trim($('#activ_prod_esperada').val());
		jornada = $.trim($('#activ_prod_jornada').val());

		if(prod_esperada == "," || prod_esperada == "0"){
			$('#activ_prod_jornada').val('');
			$('#activ_prod_esperada').val('');
		}		
		else{
			if(activ_id != "" && prod_esperada != ""){

				split_actividad = activ_id.split("---");
				meta = split_actividad[2];

				if(meta != '' && meta != '0'){
					//prod_esperada = prod_esperada.replace(',','.');
					//prod_esperada = Math.round(prod_esperada * 10)/10;
					meta = meta.replace(',','.');
					
					val_jornada = prod_esperada / (meta * 8.25);
					val_jornada = Math.round(val_jornada * 10)/10;
					val_jornada = String(val_jornada).replace('.',',');
					$('#activ_prod_jornada').val(val_jornada);
					
					//prod_esperada = String(prod_esperada).replace('.',',');
					//$('#activ_prod_esperada').val(prod_esperada);
				}			
			
			}else if(activ_id != "" && prod_esperada == "" && jornada != "" && jornada != ","){		

				split_actividad = activ_id.split("---");
				meta = split_actividad[2];
				
				if(meta != '' && meta != '0'){
				
					jornada = jornada.replace(',','.');
					meta = meta.replace(',','.');
					//val_prod_esperada = jornada * meta * 8.25;
					//val_prod_esperada = Math.round(val_prod_esperada * 10)/10;
					//val_prod_esperada = String(val_prod_esperada).replace('.',',');
					val_prod_esperada = Math.round(jornada * meta * 8.25);
					$('#activ_prod_esperada').val(val_prod_esperada);
				}			
			
			}else if(activ_id != ""){
				$('#activ_prod_jornada').val('');
				$('#activ_prod_esperada').val('');		
			}
		}
	})		
	
	
	//FOCUSOUT JORNADA
	$('#activ_apoyo_jornada').focusout(function() {
		
		jornada = $.trim($('#activ_apoyo_jornada').val());
		
		if(jornada == ","){
			$('#activ_apoyo_jornada').val('');
		}
		else{
			if(jornada != ""){

					jornada = jornada.replace(',','.');
					jornada = Math.round(jornada * 10)/10;
					jornada = String(jornada).replace('.',',');
					$('#activ_apoyo_jornada').val(jornada);
				}					

		}	
	})		
	
	
	
////////////EVENTO CLICK/////////////////	

	//ACTIVIDADES EN COMUN 
	$('#btn_comun_planxmaestro').click(function(){
			
			var dia = $.trim($('#plan_dia').val());
			var area_id = $.trim($('#area_id').val());
			
			if(dia == '' || area_id == ''){
				sweet_alert('Para esta búsqueda se requiere que ingrese día(s) y área');	
			}			
			else{

				parametros = {			
					activ_comunes:'',
					dia: dia,
					area_id: area_id
				}	

				$.post(
					"consultas/ges_crud_planxmaestro.php",
					parametros,			   
					function(resp){
						carga_tablas_activ(resp)
					},"json"
				)			

			}
			
	})
	
	function carga_tablas_activ(resp){
	
		var rowcount = resp['rowcount'];
		
		if(rowcount == 0){
			sweet_alert('No se han encontrado registros, según criterio de búsqueda');
		}else{
		
			var dia = $.trim($('#plan_dia').val());
			var area_id = $.trim($('#area_id').val());		
		
			$('#tabla_activ_prod tbody').unbind( "click" );
			table_prod.destroy();
			crear_tabla_prod(dia, area_id);

			$('#tabla_activ_apoyo tbody').unbind( "click" );
			table_apoyo.destroy();
			crear_tabla_apoyo(dia, area_id);
			
			cancelar();
			deshabilitar_filtros();			
		}
		
	}

	
//BOTONES ABM ACTIVIDAD 	
	
	
	//VALIDAR 
	function validar_actividad(tipo){
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var plan_dia = $.trim($('#plan_dia').val());
		
		if(tipo == "PRODUCTIVA"){
			var activ_id = $.trim($('#activ_prod_id').val());		
			var sup_rut = $.trim($('#sup_rut_prod').val());		
			var jornada = $.trim($('#activ_prod_jornada').val());	
		}else {			
			var activ_id = $.trim($('#activ_apoyo_id').val());		
			var sup_rut = $.trim($('#sup_rut_apoyo').val());		
			var jornada = $.trim($('#activ_apoyo_jornada').val());
		}
	
		if(per_agno == ''){
			sweet_alert('Error: Ingresar Año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Ingresar Semana');	
			return false;
		}		
		
		if(plan_dia == ''){
			sweet_alert('Error: Ingresar día(s) a planificar');	
			return false;
		}
		
		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}	
		
		if(sup_rut == ''){
			sweet_alert('Error: Seleccionar supervisor');	
			return false;
		}		
		
		return true;
	}
	
	//REGISTRAR 
	
	$('#btn_reg_activ_prod').click(function(){
		registrar_actividad('PRODUCTIVA')	
	})
	
	$('#btn_reg_activ_apoyo').click(function(){
		registrar_actividad('APOYO')	
	})	
	
	function registrar_actividad(tipo){
	
		if (validar_actividad(tipo)){	

			$('#loading').show();
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var plan_dia = $.trim($('#plan_dia').val());
			
			if(tipo == "PRODUCTIVA"){
				var activ_id = $.trim($('#activ_prod_id').val());		
				var sup_rut = $.trim($('#sup_rut_prod').val());		
				var jornada = $.trim($('#activ_prod_jornada').val());
				var prod_esperada = $.trim($('#activ_prod_esperada').val());
				var de_interes = $.trim($('#activ_prod_interes').val());	
			}else {			
				var activ_id = $.trim($('#activ_apoyo_id').val());		
				var sup_rut = $.trim($('#sup_rut_apoyo').val());		
				var jornada = $.trim($('#activ_apoyo_jornada').val());
				var prod_esperada = 0;
				var de_interes = 'N';
			}
			
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];			
			
			var operacion = 'INSERT';			
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							activ_id:activ_id,
							sup_rut:sup_rut,							
							jornada:jornada,
							prod_esperada:prod_esperada,
							de_interes:de_interes,
							tipo: tipo,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/ges_crud_planxmaestro.php",
				   parametros,			   
				   function(resp){
						ges_crud_planxmaestro(resp)
				   },"json"
			)
		}			
	}
		
	
	
	//ACTUALIZAR 
	
	$('#btn_upd_activ_prod').click(function(){
		actualizar_actividad('PRODUCTIVA')	
		})
	
	$('#btn_upd_activ_apoyo').click(function(){
		actualizar_actividad('APOYO')	
	})	
	
	function actualizar_actividad(tipo){
	
		if (validar_actividad(tipo)){	

			$('#loading').show();
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var plan_dia = $.trim($('#plan_dia').val());
			
			if(tipo == "PRODUCTIVA"){
				var activ_id = $.trim($('#activ_prod_id').val());		
				var sup_rut = $.trim($('#sup_rut_prod').val());		
				var jornada = $.trim($('#activ_prod_jornada').val());
				var prod_esperada = $.trim($('#activ_prod_esperada').val());
				var de_interes = $.trim($('#activ_prod_interes').val());	
			}else {			
				var activ_id = $.trim($('#activ_apoyo_id').val());		
				var sup_rut = $.trim($('#sup_rut_apoyo').val());		
				var jornada = $.trim($('#activ_apoyo_jornada').val());
				var prod_esperada = 0;
				var de_interes = 'N';
			}
			
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];
			
			var h_activ_id = $.trim($('#h_activ_id').val());
			
			var operacion = 'UPDATE';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							activ_id:activ_id,
							sup_rut:sup_rut,							
							jornada:jornada,
							de_interes:de_interes,
							prod_esperada:prod_esperada,
							tipo: tipo,
							h_activ_id:h_activ_id,
							operacion:operacion
						 }
			//console.log(parametros)
			$.post(
				   "consultas/ges_crud_planxmaestro.php",
				   parametros,			   
				   function(resp){
						ges_crud_planxmaestro(resp)
				   },"json"
			)			
			return false;		
		}
	}		

	//ELIMINAR 
	
	$('#btn_del_activ_prod').click(function(){
		eliminar_actividad('PRODUCTIVA')	
		})
	
	$('#btn_del_activ_apoyo').click(function(){
		eliminar_actividad('APOYO')	
	})		
	
 	function eliminar_actividad(tipo){

		swal({   
			title: "¿Seguro que deseas eliminar esta actividad de la planificación?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_activ_id = $.trim($('#h_activ_id').val());		
				var plan_dia = $.trim($('#plan_dia').val());
				var operacion = 'DELETE';
				parametros = {	
								h_activ_id:h_activ_id,
								plan_dia:plan_dia,
								tipo: tipo,
								operacion:operacion
							 }		
				//console.log(parametros)
				$.post(
					   "consultas/ges_crud_planxmaestro.php",
					   parametros,			   
					   function(resp){
							ges_crud_planxmaestro(resp)
					   },"json"
				)
		});	
		
	}	
	
	
	//ELIMINAR PLANIFICACIÓN DEL DIA X DE LAS ACTIVIDADES DEL AREA X
	
	
 	$('#btn_del_planxmaestro').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar la planificación del o los días seleccionados?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var dia = $.trim($('#plan_dia').val());
				var area_id = $.trim($('#area_id').val());
				var operacion = 'DELETE ALL';
				parametros = {	
								dia:dia,
								area_id:area_id,
								operacion:operacion
							 }	
				console.log(parametros)
				$.post(
					   "consultas/ges_crud_planxmaestro.php",
					   parametros,			   
					   function(resp){
							ges_crud_planxmaestro(resp)
					   },"json"
				)
		});	
		
	});
	
	
	
	
	//DIAS A REPLICAR
	
	$('#btn_rep_dia').click(function(){

		var plan_dia_rep = $.trim($('#plan_dia_rep').val());		
		var plan_dia = $.trim($('#plan_dia').val());
		var area_id = $.trim($('#area_id').val());		
		
		var operacion = 'INSERT-REPLICA';			
		parametros = {			
						plan_dia_rep:plan_dia_rep,
						plan_dia:plan_dia,
						area_id:area_id,
						operacion:operacion
					 }	
		console.log(parametros)
		
		$.post(
			   "consultas/ges_crud_planxmaestro.php",
			   parametros,			   
			   function(resp){
					ges_crud_planxmaestro(resp)
			   },"json"
		)	
	
	});	
	
	
	
	
	//DIAS A ELIMINAR
	
	$('#btn_elim_dia').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta actividades en común en día(s) seleccionados?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var plan_dia_elim = $.trim($('#plan_dia_elim').val());		
				var plan_dia = $.trim($('#plan_dia').val());
				var area_id = $.trim($('#area_id').val());	
				var operacion = 'DELETE-DIACOMUN';
				
				parametros = {			
								plan_dia_elim:plan_dia_elim,
								plan_dia:plan_dia,
								area_id:area_id,
								operacion:operacion
							 }	
			
				$.post(
					   "consultas/ges_crud_planxmaestro.php",
					   parametros,			   
					   function(resp){
							ges_crud_planxmaestro(resp)
					   },"json"
				)		
			
		});		

	});	
	
	
	
	
	
	//CANCELAR
	
	$('#btn_can_planxmaestro').click(function(){
		cancelar_plan();
	});
	
	$('#btn_can_activ_prod').click(function(){
		cancelar();
	});	

	$('#btn_can_activ_apoyo').click(function(){
		cancelar();
	});	
	
	function cancelar_plan(){
		cancelar();
		$('#tabla_activ_prod tbody').unbind( "click" );
		table_prod.destroy();
		crear_tabla_prod(0, 0);

		$('#tabla_activ_apoyo tbody').unbind( "click" );
		table_apoyo.destroy();
		crear_tabla_apoyo(0, 0);		
		habilitar_filtros();	
	}
	
	
	function ges_crud_planxmaestro(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){

			var tipo = resp['tipo'];
			var dia = $.trim($('#plan_dia').val());
			var area_id = $.trim($('#area_id').val());
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();			
			var operacion = resp['operacion'];		
			
			if(operacion == 'INSERT'){			
				actualizar_tablas_activ(dia, area_id,tipo)								
				deshabilitar_filtros();
				actualizar_planm(sem_num,per_agno)
				swal("Sisconvi-Production", "Actividad registrada", "success");
				
			}else if(operacion == 'UPDATE'){
				actualizar_tablas_activ(dia, area_id,tipo)
				swal("Sisconvi-Production", "Actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				actualizar_tablas_activ(dia, area_id,tipo)		
				actualizar_planm(sem_num,per_agno)
				
				parametros = {			
					activ_comunes:'',
					dia: dia,
					area_id: area_id
				}	

				$.post(
					"consultas/ges_crud_planxmaestro.php",
					parametros,			   
					function(resp){
						var rowcount = resp['rowcount'];
						if(rowcount == 0) habilitar_filtros();
					},"json"
				)				
				
				swal("Sisconvi-Production", "Actividad eliminada", "success");
			}else if(operacion == 'DELETE ALL'){

				$('#tabla_activ_prod tbody').unbind( "click" );
				table_prod.destroy();
				crear_tabla_prod(0, 0);

				$('#tabla_activ_apoyo tbody').unbind( "click" );
				table_apoyo.destroy();
				crear_tabla_apoyo(0, 0);
				
				actualizar_planm(sem_num,per_agno)
		
				habilitar_filtros();
				swal("Sisconvi-Production", "Planificación eliminada", "success");						
			}else if(operacion == 'INSERT-REPLICA'){
				var plan_dia_rep = $.trim($('#plan_dia_rep').val());

				dias = [];
				$.each(dia.split(","), function(i,e){
					dias.push(e);
				});					
				$.each(plan_dia_rep.split(","), function(i,e){
					dias.push(e);
				});	

				$('#plan_dia').val(dias).trigger('change');			
				
				actualizar_filtros();
				actualizar_planm(sem_num,per_agno);
				swal("Sisconvi-Production", "Actividades en común replicadas en día(s) seleccionados", "success");								
			}else if(operacion == 'DELETE-DIACOMUN'){
				var plan_dia_elim = $.trim($('#plan_dia_elim').val());

				dias = [];
				$.each(dia.split(","), function(i,e){
					dias.push(e);
				});					
				$.each(plan_dia_elim.split(","), function(i,e){
					removeItemArray(dias, e)
				});	
				
				if(dias.length == 0){
					$('#tabla_activ_prod tbody').unbind( "click" );
					table_prod.destroy();
					crear_tabla_prod(0, 0);

					$('#tabla_activ_apoyo tbody').unbind( "click" );
					table_apoyo.destroy();
					crear_tabla_apoyo(0, 0);

					habilitar_filtros();
				}else{
					$('#plan_dia').val(dias).trigger('change');							
					actualizar_filtros();				
				}

				actualizar_planm(sem_num,per_agno);
				swal("Sisconvi-Production", "Actividades en común eliminadas en día(s) seleccionados", "success");								
			}else if(operacion == 'INSERT_ERROR'){
				var desc_error = resp['desc'];
				swal("Sisconvi-Production", desc_error, "error");
			}
			
			cancelar();
			
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
	
	
});