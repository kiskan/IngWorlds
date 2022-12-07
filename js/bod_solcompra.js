$(document).ready(function(){

	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sprodd_servicio');
	mayuscula('sprod_motivo');

	$("#prod_cod").select2({
		allowClear: true
	});
	
	$("#sprod_tipocompra").select2({
		allowClear: true
	});	
	
	$("#sprod_prioridad").select2({
		allowClear: true
	});
	
	$("#sprod_tipomant").select2({
		allowClear: true
	});	
	
	
	$('#sprodd_cant').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});
	
	$('#esprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#tsprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#sprodd_plazo').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});			
	
	
	
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

	
////////////TABLA SOLICITUDES/////////////////	
	
	var tabla_solicitudes;
	crear_tabla();
	function crear_tabla(){
		//function crear_tabla(num_sem, per_agno, dia){
		//console.log(num_sem +'-'+ per_agno +'-'+ dia)
		tabla_solicitudes = $("#tabla_solicitudes").DataTable({
	
			responsive: true,
			order:[],
			//ajax: "consultas/bod_crud_solcompra.php?data="+num_sem+"&per_agno="+per_agno+"&dia="+dia,
			ajax: "consultas/bod_crud_solcompra.php?data=pendientes",
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'UNDVIV_ID'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true},
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
	
  
		$('#tabla_solicitudes tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			cancelar2();
			var obj_row = tabla_solicitudes.row(this).data();	
		
			$('#UNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#sprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#sprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#sprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#sprod_motivo').val(obj_row.SPROD_MOTIVO);
			
			
			$('#h_UNDVIV_ID').val(obj_row.UNDVIV_ID);	
			$('#h_sprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA);
			$('#h_sprod_prioridad').val(obj_row.SPROD_PRIORIDAD);
			$('#h_sprod_tipomant').val(obj_row.SPROD_TIPOMANT);
			$('#h_sprod_motivo').val(obj_row.SPROD_MOTIVO);
			
			a = $('#h_sprod_tipocompra').val()
			console.log(a)
			
			deshabilitar_encabezado(obj_row.SPROD_ID)

			$('#tabla_productos tbody').unbind( "click" );
			tabla_productos.destroy();			
			crear_tabla_prod(obj_row.SPROD_ID)	
			
			$('#btn_pdf_solcompra').show();
	
		});
	}
	

////////////TABLA PRODUCTOS/////////////////	
	
	var tabla_productos;
	
	crear_tabla_prod(0);
	
	function crear_tabla_prod(nro_solicitud){

		tabla_productos = $("#tabla_productos").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_solcompra.php?nro_solicitud="+nro_solicitud,			
			bProcessing: true,

			columns: [
				{ data:'SPRODD_ID'},
				{ data:'CATPROD_ID'},
				{ data:'PROD_COD'},
				{ data:'CATPROD_NOMBRE'},				
				{ data:'PROD_NOMBRE'},
				{ data:'PROD_NOMBRE_ACORTADO'},
				{ data:'SPRODD_CANT'},
				{ data:'PROD_VALOR'},
				{ data:'PROT_TOTAL'}				
			],
			
			columnDefs: [
			{ targets: [3,5,6,7,8], visible: true},
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
	
		$('#tabla_productos tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_productos.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}

			var obj_row = tabla_productos.row(this).data();	
			
			
			$('#h_flag_rowprod').val('x');
			$('#h_prod_cod').val(obj_row.PROD_COD);
			$('#h_sprodd_servicio').val(obj_row.PROD_NOMBRE)
			$('#h_sprodd_id').val(obj_row.SPRODD_ID);
						
			tipo_compra = $('#sprod_tipocompra').val();
			console.log(tipo_compra)
						
			//compra materiales

			if(tipo_compra == 'COMPRA MATERIAL'){
				$('#catprod_id').val(obj_row.CATPROD_ID).trigger('change');
				$('#sprodd_cant').val(obj_row.SPRODD_CANT);
			}
			
			if(tipo_compra == 'PRESTACIÓN SERVICIO'){
				$('#sprodd_servicio').val(obj_row.PROD_NOMBRE);
				$('#sprodd_plazo').val(obj_row.SPRODD_CANT);				
			}
			
			
			$('#btn_reg_prod').hide();
			$('#btn_upd_prod').show();
			$('#btn_del_prod').show();
			$('#btn_can_prod').show();					

		});
		
	}
	
	
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});
		
		$('#eper_agno').select2({			
			data:combobox
		});		
		
		$('#tper_agno').select2({			
			data:combobox
		});			
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		$('#eper_agno').val(corresponding_agno).trigger('change');
		$('#tper_agno').val(corresponding_agno).trigger('change');
	}
	
	$('#per_agno').change(function() { 	change_agno()	});
	$('#eper_agno').change(function() { echange_agno()	});
	$('#tper_agno').change(function() { tchange_agno()	});
	
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
	
	function echange_agno(){
		var per_agno = $('#eper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('esem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				ecarga_semanas(resp)
			},"json"
		)		
	}	
	
	function tchange_agno(){
		var per_agno = $('#tper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('tsem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				tcarga_semanas(resp)
			},"json"
		)		
	}		
	

	function carga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		
		cancelar();
		change_sem_num();
	}
	
	function ecarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#esem_num').select2({			
			data:combobox
		})
		
		//cancelar();
		echange_sem_num();
	}	
	
	function tcarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#tsem_num').select2({			
			data:combobox
		})
		
		//cancelar();
		tchange_sem_num();
	}		
	
		
	carga_semanas_ini();
	function carga_semanas_ini(){
		var combobox = [];
		for(var i  = 0 ; i < data_semanas.length; i++) {
			combobox.push({id:data_semanas[i].SEM_NUM, text:data_semanas[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		});	
		
		$('#esem_num').select2({			
			data:combobox
		});
		
		$('#tsem_num').select2({			
			data:combobox
		});			

		$('#sem_num').val(corresponding_week).trigger('change');
		$('#esem_num').val(corresponding_week).trigger('change');
		$('#tsem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
		echange_sem_num();
		tchange_sem_num();
	}
	
	
	$('#sem_num').change(function() {
		cancelar();
		change_sem_num();
	});
	
	$('#esem_num').change(function() {
		echange_sem_num();
	});	
	
	$('#tsem_num').change(function() {
		tchange_sem_num();
	});		
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('sprod_dia',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}
	
	function echange_sem_num(){
		var per_agno = $('#eper_agno').val();
		var sem_num = $('#esem_num').val();

		if(sem_num == ""){
			clear_combobox('esprod_dia',1);
		}
		else{			
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('esprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					ecarga_dias(resp)
				},"json"
			)
		}
	}	
	
	function tchange_sem_num(){
		var per_agno = $('#tper_agno').val();
		var sem_num = $('#tsem_num').val();
		if(sem_num == ""){
			clear_combobox('tsprod_dia',1);
		}
		else{
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('tsprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					tcarga_dias(resp)
				},"json"
			)
		}
	}		

	function carga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#sprod_dia').select2({			
			data:combobox
		});	

		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();

		if(sem_num == corresponding_week && year_current == per_agno){
			$('#sprod_dia').val(date_current).trigger('change');
		}		
		sem_txt = $('#sem_num option:selected').text();
		$('#sem_txt').html(sem_txt);
	}	
		
	function ecarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#esprod_dia').select2({			
			data:combobox
		});	

	}	
	
	function tcarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#tsprod_dia').select2({			
			data:combobox
		});	

	}		
	
	//LOAD UNIDADES
	carga_unidades();
	function carga_unidades(){
	//console.log(data_viveros)
		var combobox = [];
		for(var i  = 0 ; i < data_viveros.length; i++) {
			combobox.push({id:data_viveros[i].undviv_id, text:data_viveros[i].undviv_nombre});
		}	
		
		$('#UNDVIV_ID').select2({			
			data:combobox
		});
		
		$('#eUNDVIV_ID').select2({			
			data:combobox
		});			

		$('#tUNDVIV_ID').select2({			
			data:combobox
		});			
	}

	//CHANGE TIPO DE COMPRA
	$('#sprod_tipocompra').change(function() {
		var sprod_tipocompra = $('#sprod_tipocompra').val();
		
		if(sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
			$('#div_materiales').hide();
			$('#div_servicios').show();
		}
		if(sprod_tipocompra == 'COMPRA MATERIAL'){
			$('#div_materiales').show();
			$('#div_servicios').hide();			
		}
		
	});	
	
	
	//LOAD CATEGORIAS
	carga_categorias();
	function carga_categorias(){
		var combobox = [];
		for(var i  = 0 ; i < data_categorias.length; i++) {
			combobox.push({id:data_categorias[i].catprod_id, text:data_categorias[i].catprod_nombre});
		}	
		
		$('#catprod_id').select2({			
			allowClear: true,	
			data:combobox
		});			
	}	
	

	//LOAD SOLICITANTES
	carga_solicitantes();
	function carga_solicitantes(){
		var combobox = [];
		for(var i  = 0 ; i < data_solicitantes.length; i++) {
			combobox.push({id:data_solicitantes[i].USR_ID, text:data_solicitantes[i].USR_NOMBRE});
		}	
		
		$('#eusr_solic').select2({			
			data:combobox
		});			

		$('#tusr_solic').select2({			
			data:combobox
		});		
	}	
	
	
	//CHANGE CATEGORIA
	$('#catprod_id').change(function() {

		var catprod_id = $('#catprod_id').val();
		
		if(catprod_id == ""){
			clear_combobox('prod_cod',1);
		}
		else{
			parametros = {			
				id_cat_stock:catprod_id
			}		
			clear_combobox('prod_cod',1);
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					carga_productos(resp)
				},"json"
				)	
		}

	});

	function carga_productos(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].PROD_COD, text:resp[i].PROD_NOMBRE});
		}	
		
		$('#prod_cod').select2({			
			data:combobox
		})
	
		flag = $('#h_flag_rowprod').val();
		if(flag == 'x'){
			prod_selected = $('#h_prod_cod').val();
			$('#prod_cod').val(prod_selected).trigger('change');	
		}
		$('#h_flag_rowprod').val('');
	}	
	
	function hide_btnshead(){
		//$('#btn_regrep_sprod').hide();
		//$('#btn_canrep_sprod').hide();
		$('#btn_updhead_sprod').hide();
		$('#btn_canupdhead_sprod').hide();	
		//$('#btn_pdf_solcompra').hide();
		//$('#destinatario_multiple').hide();
		//$('#sprod_ids_dest').val('').trigger('change');
	}
	
	
	function deshabilitar_encabezado(sprod_id){

		$('#UNDVIV_ID').prop( "disabled", true );	
		$('#sprod_tipocompra').prop( "disabled", true );
		$('#sprod_prioridad').prop( "disabled", true );
		$('#sprod_tipomant').prop( "disabled", true );
		$('#sprod_motivo').prop( "disabled", true );
		
		$('#sprod_id').val(sprod_id);
		$('#nro_solicitud').show();
		
		$('#btn_can_sprod').show();
		$('#btn_rep_sprod').show();	
		$('#btn_del_sprod').show();
		$('#btn_upd_sprod').show();
		
		hide_btnshead();
	}	
	
	function habilitar_encabezado(){

		$('#UNDVIV_ID').prop( "disabled", false );	
		$('#sprod_tipocompra').prop( "disabled", false );
		$('#sprod_prioridad').prop( "disabled", false );
		$('#sprod_tipomant').prop( "disabled", false );
		$('#sprod_motivo').prop( "disabled", false );	
		
		$('#UNDVIV_ID').val('').trigger('change');
		$('#sprod_tipocompra').val('').trigger('change');
		$('#sprod_prioridad').val('').trigger('change');
		$('#sprod_tipomant').val('').trigger('change');
		$('#sprod_motivo').val('').trigger('change');
		
		$('#sprod_id').val('');
		$('#nro_solicitud').hide();
		
		hide_btnshead();
		
		$('#catprod_id').prop( "disabled", false );
		$('#prod_cod').prop( "disabled", false );
		$('#sprodd_cant').prop( "disabled", false );		
		
		$('#sprodd_servicio').prop( "disabled", false );
		$('#sprodd_plazo').prop( "disabled", false );		
		
	}		
	
////////////EVENTO CLICK/////////////////		
/*	
	$('#btn_rep_sprod').click(function(){

		$('#destinatario_multiple').show();

		$('#sprod_ids_dest').select2({			
			allowClear: true
		});		
		
		$('#UNDVIV_ID').prop( "disabled", true );	
		//$('#sprod_id_dest').prop( "disabled", false );
		$('#btn_updhead_sprod').hide();
		$('#btn_canupdhead_sprod').hide();		
		$('#btn_regrep_sprod').show();
		$('#btn_canrep_sprod').show();
		
		cancelar();
		$('#catprod_id').prop( "disabled", true );
		$('#prod_cod').prop( "disabled", true );
		$('#sprodd_cant').prop( "disabled", true );			
	})		
*/	
	
	
	$('#btn_canupdhead_sprod').click(function(){
		$('#UNDVIV_ID').prop( "disabled", true );	
		$('#sprod_tipocompra').prop( "disabled", true );
		$('#sprod_prioridad').prop( "disabled", true );
		$('#sprod_tipomant').prop( "disabled", true );
		$('#sprod_motivo').prop( "disabled", true );
		hide_btnshead();
		cancelar();
		
		UNDVIV_ID = $('#h_UNDVIV_ID').val();	 
		sprod_tipocompra = $('#h_sprod_tipocompra').val();
		sprod_prioridad = $('#h_sprod_prioridad').val();	
		sprod_tipomant = $('#h_sprod_tipomant').val();	
		sprod_motivo = $('#h_sprod_motivo').val();	
		
		$('#UNDVIV_ID').val(UNDVIV_ID).trigger('change');
		$('#sprod_tipocompra').val(sprod_tipocompra).trigger('change');
		$('#sprod_prioridad').val(sprod_prioridad).trigger('change');
		$('#sprod_tipomant').val(sprod_tipomant).trigger('change');
		$('#sprod_motivo').val(sprod_motivo);	
		
		$('#catprod_id').prop( "disabled", false );
		$('#prod_cod').prop( "disabled", false );
		$('#sprodd_cant').prop( "disabled", false );
		$('#sprodd_servicio').prop( "disabled", false );
		$('#sprodd_plazo').prop( "disabled", false );	
	})		
	
	
	
	
	
	$('#btn_upd_sprod').click(function(){
		$('#UNDVIV_ID').prop( "disabled", false );	
		//$('#sprod_tipocompra').prop( "disabled", false );
		$('#sprod_prioridad').prop( "disabled", false );
		$('#sprod_tipomant').prop( "disabled", false );
		$('#sprod_motivo').prop( "disabled", false );
		$('#btn_updhead_sprod').show();
		$('#btn_canupdhead_sprod').show();
		//$('#btn_pdf_solcompra').show();
		cancelar();
		$('#catprod_id').prop( "disabled", true );
		$('#prod_cod').prop( "disabled", true );
		$('#sprodd_cant').prop( "disabled", true );
		$('#sprodd_servicio').prop( "disabled", true );
		$('#sprodd_plazo').prop( "disabled", true );
	})	
	
	$('#btn_can_prod').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_sprod')[0].reset();
		$('#btn_pdf_solcompra').hide();
		
		$('#btn_reg_prod').show();
		$('#btn_upd_prod').hide();
		$('#btn_del_prod').hide();
		$('#btn_can_prod').hide();
		tabla_productos.$('tr.selected').removeClass('selected');
		$('#catprod_id').val('').trigger('change');
		clear_combobox('prod_cod',1);	
	}
	
	function cancelar2(){
		$('#form_sprod')[0].reset();

		$('#btn_reg_prod').show();
		$('#btn_upd_prod').hide();
		$('#btn_del_prod').hide();
		$('#btn_can_prod').hide();
		//tabla_solicitudes.$('tr.selected').removeClass('selected');
		$('#catprod_id').val('').trigger('change');
		clear_combobox('prod_cod',1);	
	}	
	
	
	$('#btn_can_sprod').click(function(){
		cancelar();
		$('#tabla_productos tbody').unbind( "click" );
		tabla_productos.destroy();
		crear_tabla_prod(0);		
		habilitar_encabezado();	
		
		$('#btn_can_sprod').hide();
		$('#btn_rep_sprod').hide();
		$('#btn_del_sprod').hide();	
		$('#btn_upd_sprod').hide();		
	})
	
	
	

	function validar_head_solic(){
		
		var sprod_id = $.trim($('#sprod_id').val());
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
		var sprod_tipocompra = $.trim($('#sprod_tipocompra').val());
		var sprod_prioridad = $.trim($('#sprod_prioridad').val());	
		var sprod_tipomant = $.trim($('#sprod_tipomant').val());	
		var sprod_motivo = $.trim($('#sprod_motivo').val());	

		if(sprod_id == ''){
			sweet_alert('Error: Nro Solicitud inexistente, favor refrescar página');	
			return false;
		}		
		
		if(per_agno == ''){
			sweet_alert('Error: Seleccionar año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Seleccionar semana');	
			return false;
		}		
		
		if(sprod_dia == ''){
			sweet_alert('Error: Seleccionar día');	
			return false;
		}
		
		if(UNDVIV_ID == ''){
			sweet_alert('Error: Seleccionar área');	
			return false;
		}	
		
		if(sprod_tipocompra == ''){
			sweet_alert('Error: Seleccionar Tipo Compra');	
			return false;
		}			
		
		if(sprod_prioridad == ''){
			sweet_alert('Error: Seleccionar Tipo Prioridad');	
			return false;
		}	
		
		if(sprod_tipomant == ''){
			sweet_alert('Error: Seleccionar Tipo Mantenimiento');	
			return false;
		}		
		
		if(sprod_motivo == ''){
			sweet_alert('Error: Registrar Motivo de Compra');	
			return false;
		}		
		return true;
	}
	

	
	
	function validar_prod(){

		var catprod_id = $.trim($('#catprod_id').val());
		var prod_cod = $.trim($('#prod_cod').val());
		var sprodd_cant = $.trim($('#sprodd_cant').val());
		
		var sprodd_servicio = $.trim($('#sprodd_servicio').val());
		var sprodd_plazo = $.trim($('#sprodd_plazo').val());
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
		var sprod_tipocompra = $.trim($('#sprod_tipocompra').val());
		var sprod_prioridad = $.trim($('#sprod_prioridad').val());	
		var sprod_tipomant = $.trim($('#sprod_tipomant').val());	
		var sprod_motivo = $.trim($('#sprod_motivo').val());	

		if(per_agno == ''){
			sweet_alert('Error: Seleccionar año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Seleccionar semana');	
			return false;
		}		
		
		if(sprod_dia == ''){
			sweet_alert('Error: Seleccionar día');	
			return false;
		}
		
		if(UNDVIV_ID == ''){
			sweet_alert('Error: Seleccionar área');	
			return false;
		}	
		
		if(sprod_tipocompra == ''){
			sweet_alert('Error: Seleccionar Tipo Compra');	
			return false;
		}			
		
		if(sprod_prioridad == ''){
			sweet_alert('Error: Seleccionar Tipo Prioridad');	
			return false;
		}	
		
		if(sprod_tipomant == ''){
			sweet_alert('Error: Seleccionar Tipo Mantenimiento');	
			return false;
		}		
		
		if(sprod_motivo == ''){
			sweet_alert('Error: Registrar Motivo de Compra');	
			return false;
		}
		
		if(sprod_tipocompra == 'COMPRA MATERIAL'){
		
			if(catprod_id == ''){
				sweet_alert('Error: Seleccionar categoría');	
				return false;
			}
			
			if(prod_cod == ''){
				sweet_alert('Error: Seleccionar producto');	
				return false;
			}		

			if(sprodd_cant == ''){
				sweet_alert('Error: Ingresar cantidad');	
				return false;
			}
		}
		
		if(sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
		
			if(sprodd_servicio == ''){
				sweet_alert('Error: registrar Servicio');	
				return false;
			}
			
			if(sprodd_plazo == ''){
				sweet_alert('Error: indicar Plazo');	
				return false;
			}				
		}
		
		return true;
	}

	
	
	
	$('#btn_updhead_sprod').click(function(){

		if (validar_head_solic()){	
			
			$('#loading').show();
			
			var sprod_id = $.trim($('#sprod_id').val());
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var sprod_dia = $.trim($('#sprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
			var sprod_tipocompra = $.trim($('#sprod_tipocompra').val());
			var sprod_prioridad = $.trim($('#sprod_prioridad').val());	
			var sprod_tipomant = $.trim($('#sprod_tipomant').val());	
			var sprod_motivo = $.trim($('#sprod_motivo').val());	
						
			var operacion = 'UPDATE_HEAD';
			parametros = {			
							sprod_id:sprod_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							sprod_tipocompra:sprod_tipocompra,
							sprod_prioridad:sprod_prioridad,
							sprod_tipomant:sprod_tipomant,
							sprod_motivo:sprod_motivo,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						bod_crud_solcompra(resp)
				   },"json"
			)
		}	
	})			
	

		  
	$('#btn_reg_prod').click(function(){

		if (validar_prod()){	

			$('#loading').show();
			
			var sprod_id = $.trim($('#sprod_id').val());
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var sprod_dia = $.trim($('#sprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
			var sprod_tipocompra = $.trim($('#sprod_tipocompra').val());
			var sprod_prioridad = $.trim($('#sprod_prioridad').val());	
			var sprod_tipomant = $.trim($('#sprod_tipomant').val());	
			var sprod_motivo = $.trim($('#sprod_motivo').val());
			
			var prod_cod = $.trim($('#prod_cod').val());
			var sprodd_cant = $.trim($('#sprodd_cant').val());
			
			var sprodd_servicio = $.trim($('#sprodd_servicio').val());
			var sprodd_plazo = $.trim($('#sprodd_plazo').val());			
			
			var operacion = 'INSERT';
			parametros = {			
							sprod_id:sprod_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							sprod_tipocompra:sprod_tipocompra,
							sprod_prioridad:sprod_prioridad,
							sprod_tipomant:sprod_tipomant,
							sprod_motivo:sprod_motivo,
							prod_cod:prod_cod,
							sprodd_cant:sprodd_cant,
							sprodd_servicio:sprodd_servicio,
							sprodd_plazo:sprodd_plazo,							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						bod_crud_solcompra(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_prod').click(function(){
		if (validar_prod()){	

			$('#loading').show();
			var h_sprodd_id = $.trim($('#h_sprodd_id').val());
			var sprod_id = $.trim($('#sprod_id').val());
			var h_prod_cod = $.trim($('#h_prod_cod').val());
			var prod_cod = $.trim($('#prod_cod').val());
			var sprodd_cant = $.trim($('#sprodd_cant').val());
			
			var h_sprodd_servicio = $.trim($('#h_sprodd_servicio').val());
			var sprodd_servicio = $.trim($('#sprodd_servicio').val());
			var sprodd_plazo = $.trim($('#sprodd_plazo').val());
			
			var sprod_tipocompra = $.trim($('#h_sprod_tipocompra').val());
			
			var operacion = 'UPDATE';
			parametros = {
							sprodd_id:h_sprodd_id,
							sprod_id:sprod_id,
							h_prod_cod:h_prod_cod,
							prod_cod:prod_cod,
							sprodd_cant:sprodd_cant,
							h_sprodd_servicio:h_sprodd_servicio,
							sprodd_servicio:sprodd_servicio,
							sprodd_plazo:sprodd_plazo,
							sprod_tipocompra:sprod_tipocompra,
							operacion:operacion
						 }		
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						bod_crud_solcompra(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_prod').click(function(){

		var sprod_tipocompra = $.trim($('#h_sprod_tipocompra').val());
		var tipocompra = '';
		if(sprod_tipocompra == 'COMPRA MATERIAL'){
			tipocompra = 'Producto';
		}
		if(sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
			tipocompra = 'Servicio';
		}
		
		swal({   
			title: "¿Seguro que deseas eliminar este "+tipocompra+"?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var sprod_id = $.trim($('#sprod_id').val());
				//var h_prod_cod = $.trim($('#h_prod_cod').val());
				var h_sprodd_id = $.trim($('#h_sprodd_id').val());
				var operacion = 'DELETE';
				parametros = {	
								sprodd_id:h_sprodd_id,
								sprod_id:sprod_id,
								operacion:operacion
							 }		
				console.log(parametros)
				$.post(
					   "consultas/bod_crud_solcompra.php",
					   parametros,			   
					   function(resp){
							bod_crud_solcompra(resp)
					   },"json"
				)
		});	
		
	})
	
	
 	$('#btn_del_sprod').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Solicitud?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var sprod_id = $.trim($('#sprod_id').val());
				var operacion = 'DELETE ALL';
				parametros = {	
								sprod_id:sprod_id,
								operacion:operacion
							 }		
				console.log(parametros)
				$.post(
					   "consultas/bod_crud_solcompra.php",
					   parametros,			   
					   function(resp){
							bod_crud_solcompra(resp)
					   },"json"
				)
		});	
		
	})	
	
	
	function bod_crud_solcompra(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			var sprod_id = resp['sprod_id'];
			
			var sprod_tipocompra = $.trim($('#h_sprod_tipocompra').val());
			var tipocompra = '';
			if(sprod_tipocompra == 'COMPRA MATERIAL'){
				tipocompra = 'Producto';
			}
			if(sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
				tipocompra = 'Servicio';
			}		
			//console.log(tipocompra)
			//console.log(sprod_tipocompra)
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", tipocompra + " registrado, Nro Solicitud: "+sprod_id, "success");				
				deshabilitar_encabezado(sprod_id);	
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
				$('#btn_pdf_solcompra').show();
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production",tipocompra + " modificado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'UPDATE_HEAD'){
				swal("Sisconvi-Production", "Solicitud modificada", "success");
				actualizar_tabla_solicitud();
				deshabilitar_encabezado(sprod_id);	
				$('#catprod_id').prop( "disabled", false );
				$('#prod_cod').prop( "disabled", false );
				$('#sprodd_cant').prop( "disabled", false );
				$('#sprodd_servicio').prop( "disabled", false );
				$('#sprodd_plazo').prop( "disabled", false );
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production",tipocompra + " eliminado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'DELETE ALL'){
				swal("Sisconvi-Production", "Solicitud eliminada", "success");
				habilitar_encabezado();
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
				$('#btn_can_sprod').hide();
				$('#btn_del_sprod').hide();	
				$('#btn_upd_sprod').hide();					
			}

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	

	function actualizar_tabla_solicitud(){
		$('#tabla_solicitudes tbody').unbind( "click" );
		tabla_solicitudes.destroy();		
		crear_tabla();
	}
	
	
	function actualizar_tabla_producto(sprod_id){
		$('#tabla_productos tbody').unbind( "click" );
		tabla_productos.destroy();
		crear_tabla_prod(sprod_id);					
	}	

	
	
//TAB SOLICITUDES EN PROCESO Y FINALIZADAS
	
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		
		if(target == "#tab1primary"){ 
			$('#tabla_solicitudes tbody').unbind( "click" );
			tabla_solicitudes.destroy();				
			crear_tabla();			
		}
		if(target == "#tab2primary"){ 
			fix_select_enproceso();
			limpieza_enproceso_full();
			busqueda_solic_enproceso();
		}
		if(target == "#tab3primary"){ 
			fix_select_terminados();
			limpieza_terminados_full();
			busqueda_solic_terminados();
		}
		
	});		
	
	
	
	fix_select_enproceso();
	function fix_select_enproceso(){
	
		$('#eusr_solic').select2({});
		$('#eper_agno').select2({});
		$('#esem_num').select2({});
		$('#esprod_dia').select2({});
		$('#eUNDVIV_ID').select2({});
		$('#esprod_tipocompra').select2({});
		$('#esprod_prioridad').select2({});
		$('#esprod_tipomant').select2({});
	}
	
	
	fix_select_terminados();
	function fix_select_terminados(){
	
		$('#tusr_solic').select2({});
		$('#tper_agno').select2({});
		$('#tsem_num').select2({});
		$('#tsprod_dia').select2({});
		$('#tUNDVIV_ID').select2({});
		$('#tsprod_tipocompra').select2({});
		$('#tsprod_prioridad').select2({});
		$('#tsprod_tipomant').select2({});
	}	

	$('#btn_cons_enproceso').click(function(){
		busqueda_solic_enproceso();
	})	

	$('#btn_cons_terminados').click(function(){
		busqueda_solic_terminados();
	})	
		
	function busqueda_solic_enproceso(){
		$('#eloading').show();
		limpieza_enproceso();
		var sprod_id = $.trim($('#esprod_id').val());
		var solicitante = $.trim($('#eusr_solic').val());
		var per_agno = $.trim($('#e').val());
		var sem_num = $.trim($('#esem_num').val());		
		var sprod_dia = $.trim($('#esprod_dia').val());		
		var UNDVIV_ID = $.trim($('#eUNDVIV_ID').val());
		var sprod_tipocompra = $.trim($('#esprod_tipocompra').val());
		var sprod_prioridad = $.trim($('#esprod_prioridad').val());
		var sprod_tipomant = $.trim($('#esprod_tipomant').val());
		//var sprod_codigosap = $.trim($('#esprod_codigosap').val());
		if(typeof tabla_solicitudes_enproceso != 'undefined') tabla_solicitudes_enproceso.destroy();
		crear_tabla_enproceso( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, sprod_tipocompra, sprod_prioridad, sprod_tipomant/*, sprod_codigosap*/)			
	}
	
	function busqueda_solic_terminados(){
		$('#tloading').show();
		limpieza_terminados();
		var sprod_id = $.trim($('#tsprod_id').val());
		var solicitante = $.trim($('#tusr_solic').val());
		var per_agno = $.trim($('#tper_agno').val());
		var sem_num = $.trim($('#tsem_num').val());		
		var sprod_dia = $.trim($('#tsprod_dia').val());		
		var UNDVIV_ID = $.trim($('#tUNDVIV_ID').val());
		var sprod_tipocompra = $.trim($('#tsprod_tipocompra').val());
		var sprod_prioridad = $.trim($('#tsprod_prioridad').val());
		var sprod_tipomant = $.trim($('#tsprod_tipomant').val());
		//var sprod_codigosap = $.trim($('#tsprod_codigosap').val());

		if(typeof tabla_solicitudes_terminados != 'undefined') tabla_solicitudes_terminados.destroy();
		crear_tabla_terminados( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, sprod_tipocompra, sprod_prioridad, sprod_tipomant/*, sprod_codigosap*/)	
	}

	
	var tabla_solicitudes_enproceso;	
	function crear_tabla_enproceso( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, psprod_tipocompra, psprod_prioridad, psprod_tipomant/*, psprod_codigosap*/){
		//console.log('psprod_codigosap:'+psprod_codigosap)
		tabla_solicitudes_enproceso = $("#tabla_solicitudes_enproceso").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solcompra.php?enproceso=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&psprod_tipocompra="+psprod_tipocompra+"&psprod_prioridad="+psprod_prioridad+"&psprod_tipomant="+psprod_tipomant/*+"&psprod_codigosap="+psprod_codigosap*/,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'SPROD_COMENCOTIZ'},
				/*{ data:'SPROD_CODIGOSAP'},*/
				{ data:'SPROD_COMENCOMPRA'},
				{ data:'UNDVIV_ID'},
				{ data:'USR_ID_SOLIC'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true },
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
			},

			fnInitComplete: function(oSettings, json) {
			  $('#eloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_enproceso tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_enproceso.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			limpieza_enproceso();
			var obj_row = tabla_solicitudes_enproceso.row(this).data();	
			
			$('#esprod_id').val(obj_row.SPROD_ID);	
			$('#eusr_solic').val(obj_row.USR_ID_SOLIC).trigger('change');			
			$('#eUNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#esprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#esprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#esprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#esprod_motivo').val(obj_row.SPROD_MOTIVO);
			$('#esprod_comencotiz').val(obj_row.SPROD_COMENCOTIZ);			
			//$('#esprod_codigosap').val(obj_row.SPROD_CODIGOSAP);
			$('#esprod_comencompra').val(obj_row.SPROD_COMENCOMPRA);
			
			$('#h_esprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA)
			$('#h_sprod_id').val(obj_row.SPROD_ID);
			
			carga_productos_enproceso(obj_row.SPROD_ID);
		});
	}	
	
//////	

	var tabla_solicitudes_terminados;	
	function crear_tabla_terminados( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, tsprod_tipocompra, tsprod_prioridad, tsprod_tipomant/*, tsprod_codigosap*/){
		//console.log('tsprod_codigosap:'+tsprod_codigosap)
		tabla_solicitudes_terminados = $("#tabla_solicitudes_terminados").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solcompra.php?terminados=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&tsprod_tipocompra="+tsprod_tipocompra+"&tsprod_prioridad="+tsprod_prioridad+"&tsprod_tipomant="+tsprod_tipomant/*+"&tsprod_codigosap="+tsprod_codigosap*/,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'SPROD_COMENCOTIZ'},
				//{ data:'SPROD_CODIGOSAP'},
				{ data:'SPROD_COMENCOMPRA'},
				{ data:'UNDVIV_ID'},
				{ data:'USR_ID_SOLIC'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true },
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
			},

			fnInitComplete: function(oSettings, json) {
			  $('#tloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_terminados tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_terminados.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			limpieza_terminados();
			//$('#tloading').show();
			var obj_row = tabla_solicitudes_terminados.row(this).data();
			console.log(obj_row.USR_ID_SOLIC)
			$('#tsprod_id').val(obj_row.SPROD_ID);	
			$('#tusr_solic').val(obj_row.USR_ID_SOLIC).trigger('change');			
			$('#tUNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#tsprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#tsprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#tsprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#tsprod_motivo').val(obj_row.SPROD_MOTIVO);
			$('#tsprod_comencotiz').val(obj_row.SPROD_COMENCOTIZ);			
			//$('#tsprod_codigosap').val(obj_row.SPROD_CODIGOSAP);
			$('#tsprod_comencompra').val(obj_row.SPROD_COMENCOMPRA);
			
			$('#h_esprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA)
			$('#h_tsprod_id').val(obj_row.SPROD_ID);
			
			carga_productos_terminados(obj_row.SPROD_ID);			
			
		});
	}		
	
/////


	function carga_productos_enproceso(sprod_id){
		console.log(sprod_id)
		$('#productos_enproceso').empty();
		
		tipo_compra = $('#h_esprod_tipocompra').val();
		
		parametros = {	
			compra:'',
			tipo_compra:tipo_compra,
			sprod_id:sprod_id
		}		
		console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				pcrear_tabla_productos(resp)
			},"json"
			)		
	}
	

	
	function pcrear_tabla_productos(resp){
		console.log(resp)
		$('#productos_enproceso').empty();
		total_cotiz = 0;
		tipo_compra = $('#h_esprod_tipocompra').val();
		console.log(tipo_compra)
		
		if(tipo_compra == 'COMPRA MATERIAL'){
			i = 0;
			
			while(i < resp.length){
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].PROD_NOMBRE;
			
				
				$('#productos_enproceso').append(
					'<tr>'+
						'<td>'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td>'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].PROD_NOMBRE_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-total="'+resp[i].COTCOM_TOTAL+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-avance="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
				i++;
			}
		}
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
			i = 0;
			while(i < resp.length){
			
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].SPRODD_SERVICIO;
				
				$('#productos_enproceso').append(
					'<tr>'+
						'<td>'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].SPRODD_SERVICIO+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td>'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].SPRODD_SERVICIO_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-avance="'+resp[i].COTCOM_AVANCE+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-total="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');

				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
	
				i++;
			}
		}				
		$('#esprod_total').val(total_cotiz)
		
	}	
	

/////
	
	function carga_productos_terminados(sprod_id){
		console.log(sprod_id)
		$('#productos_terminados').empty();
		
		tipo_compra = $('#h_esprod_tipocompra').val();
		
		parametros = {	
			compra:'',
			tipo_compra:tipo_compra,
			sprod_id:sprod_id
		}		
		console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				tcrear_tabla_productos(resp)
			},"json"
			)		
	}
	

	
	function tcrear_tabla_productos(resp){
		console.log(resp)
		$('#productos_terminados').empty();
		total_cotiz = 0;
		tipo_compra = $('#h_esprod_tipocompra').val();
		console.log(tipo_compra)
		
		if(tipo_compra == 'COMPRA MATERIAL'){
		//sd.SPRODD_ID, p.PROD_COD, p.PROD_NOMBRE, sd.SPRODD_CANT, sd.CC_ID, c.COTCOM_PROVEEDOR, c.COTCOM_ACORDADO
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, (c.COTCOM_PRECIO * c.COTCOM_CANTIDAD) COTCOM_TOTAL, c.COTCOM_ACORDADO_PROV
			i = 0;
			
			while(i < resp.length){
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].PROD_NOMBRE;
			
				
				$('#productos_terminados').append(
					'<tr>'+
						'<td>'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td>'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].PROD_NOMBRE_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-total="'+resp[i].COTCOM_TOTAL+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-avance="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });		
				//carga_cc(cc)									
				//$('#'+cc).val(resp[i].CC_ID).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
				//$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				i++;
			}
		}
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
		//SELECT  sd.SPRODD_ID, sd.SPRODD_SERVICIO, sd.SPRODD_CANT, sd.CC_ID
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, c.COTCOM_AVANCE, c.COTCOM_ACORDADO_PROV
			i = 0;
			while(i < resp.length){
			
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].SPRODD_SERVICIO;
				
				$('#productos_terminados').append(
					'<tr>'+
						'<td>'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].SPRODD_SERVICIO+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td>'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].SPRODD_SERVICIO_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-avance="'+resp[i].COTCOM_AVANCE+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-total="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });		
				//carga_cc(cc)									
				//$('#'+cc).val(resp[i].CC_ID).trigger('change');
				//$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
	
				i++;
			}
		}				
		$('#tsprod_total').val(total_cotiz)
		
	}	

	function limpieza_enproceso(){
		
		$('#h_esprod_id').val('');
	
		$('#esprod_motivo').val('');
		$('#esprod_comencotiz').val('');
		//$('#esprod_codigosap').val('');
		$('#esprod_comencompra').val('');
		$('#esprod_total').val('');
		$('#productos_enproceso').empty();
	}
	
	function limpieza_enproceso_full(){
	
		$('#h_esprod_id').val('');
		$('#esprod_id').val('');
		$('#esprod_motivo').val('');
		$('#esprod_comencotiz').val('');
		//$('#esprod_codigosap').val('');
		$('#esprod_comencompra').val('');
		$('#esprod_total').val('');
		$('#productos_enproceso').empty();
			
		$('#eusr_solic').val('').trigger('change');			
		$('#eUNDVIV_ID').val('').trigger('change');
		$('#esprod_tipocompra').val('').trigger('change');
		$('#esprod_prioridad').val('').trigger('change');
		$('#esprod_tipomant').val('').trigger('change');			

	}	
	
	function limpieza_terminados(){
		$('#h_tsprod_id').val('');
	
		$('#tsprod_motivo').val('');
		$('#tsprod_comencotiz').val('');
		//$('#tsprod_codigosap').val('');
		$('#tsprod_comencompra').val('');
		$('#tsprod_total').val('');
		$('#productos_terminados').empty();
	}		
	
	function limpieza_terminados_full(){
		$('#h_tsprod_id').val('');
		
		$('#tsprod_motivo').val('');
		$('#tsprod_comencotiz').val('');
		//$('#tsprod_codigosap').val('');
		$('#tsprod_comencompra').val('');
		$('#tsprod_total').val('');
		$('#productos_terminados').empty();
		$('#tsprod_id').val('');	
		$('#tusr_solic').val('').trigger('change');			
		$('#tUNDVIV_ID').val('').trigger('change');
		$('#tsprod_tipocompra').val('').trigger('change');
		$('#tsprod_prioridad').val('').trigger('change');
		$('#tsprod_tipomant').val('').trigger('change');			
		//$('#tsprod_codigosap').val('');
		
		
	}		
	

//WModal_Cotizacion
	
	$("#WModal_Cotizacion").on('show.bs.modal', function(event){
	
		var identificador = $(event.relatedTarget);		
		var sprodd_id = identificador.data('sprodd_id');
		var tipo_compra = identificador.data('tipocompra');
		var prod = 'Cotización: '+identificador.data('prodserv');
		$('#title_cotizacion').html(prod)
		
		var cant = 'Cantidad Solicitada: '+identificador.data('cant');
		$('#title_cotcant').html(cant)			

		$('#h_sprodd_id').val(sprodd_id);
		$('#h_sprod_tipocompra').val(tipo_compra);
		
		if(typeof tabla_cotizacion != 'undefined') tabla_cotizacion.destroy()
		crear_tabla_cotizacion();
	
    });
	
	
	var tabla_cotizacion;
	
	function crear_tabla_cotizacion(){

		var sprodd_id = $('#h_sprodd_id').val();	
		var tipo_compra = $('#h_sprod_tipocompra').val();
		var cotcom_tipo = 'COTIZACION';
		console.log(sprodd_id)
		tabla_cotizacion = $("#datatable-cotizaciones").DataTable({
			
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
				{ targets: [1,3,4,5,6,7], visible: true},
				{ targets: '_all', visible: false }			
			], 
			ajax: "consultas/bod_crud_solcompra.php?sprodd_id="+sprodd_id+"&cotcom_tipo="+cotcom_tipo+"&tipo_compra="+tipo_compra,	
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'COTCOM_ID'},
				{ data:'COTCOM_PROVSEL'},
				{ data:'COTCOM_PROVEEDOR_ACORTADO'},	
				{ data:'COTCOM_PROVEEDOR'},						
				{ data:'COTCOM_PRECIO'},
				{ data:'COTCOM_CANTIDAD'},
				{ data:'COTCOM_TOTAL'},
				{ data:'COTCOM_ACORDADO'}
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
	  
	}		
	
	
	$("#WModal_Compra").on('show.bs.modal', function(event){
	
		var identificador = $(event.relatedTarget);
		var sprodd_id = identificador.data('sprodd_id');
		var tipo_compra = identificador.data('tipocompra');
		
		var prod = 'Compra: '+identificador.data('prodservfill');
		$('#title_compra').html(prod)
		
		var cant = 'Cantidad Solicitada: '+identificador.data('cant');
		$('#title_cant').html(cant)		
		
		$('#h_sprodd_id').val(sprodd_id);
		$('#h_sprod_tipocompra').val(tipo_compra);
		if(typeof tabla_compra != 'undefined') tabla_compra.destroy()
		crear_tabla_compra();
		
    });
	
	
	var tabla_compra;
	
	function crear_tabla_compra(){

		var sprodd_id = $('#h_sprodd_id').val();	
		var tipo_compra = $('#h_sprod_tipocompra').val();
		var cotcom_tipo = 'COMPRA';
		console.log(sprodd_id)
		tabla_compra = $("#datatable-compra").DataTable({
			
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
				{ targets: [1,2,4,5,6,7,8,9], visible: true},
				{ targets: '_all', visible: false }			
			], 
			ajax: "consultas/bod_crud_solcompra.php?sprodd_id="+sprodd_id+"&cotcom_tipo="+cotcom_tipo+"&tipo_compra="+tipo_compra,	
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'COTCOM_ID'},
				{ data:'COTCOM_HES'},
				{ data:'COTCOM_PROVEEDOR_ACORTADO'},	
				{ data:'COTCOM_PROVEEDOR'},	
				{ data:'FECHA_ENTREGA'},		
				{ data:'COTCOM_PRECIO'},
				{ data:'COTCOM_CANTIDAD'},
				{ data:'COTCOM_TOTAL'},								
				{ data:'COTCOM_ACORDADO'},
				{ data:'COTCOM_AVANCE'}
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
	  

	}
	
	
	
	
	$('#btn_pdf_solcompra').click(function(){
		
		var sprod_id = $('#sprod_id').val();

		var url = '/proyecto/sisconvi-production/Informes/inf_solicitud_compra.php?sprod_id='+sprod_id;	
		window.location.href = url;		
	})
	
});