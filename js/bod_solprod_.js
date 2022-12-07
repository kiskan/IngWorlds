$(document).ready(function(){

	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sprod_motivo');

	$("#prod_cod").select2({
		allowClear: true
	});	
	
	$('#sprodd_cant').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});
	
	$('#asprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#rsprod_id').keypress(function(e){
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
			//ajax: "consultas/bod_crud_solprod.php?data="+num_sem+"&per_agno="+per_agno+"&dia="+dia,
			ajax: "consultas/bod_crud_solprod.php?data=pendientes",
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'DESTINATARIO'},
				{ data:'COMENTARIO'},
				{ data:'UNDVIV_ID'},
				{ data:'DESTINATARIO_ID'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6], visible: true},
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
			//console.log(obj_row.DESTINATARIO_ID)
			//$('#sprod_id').val(obj_row.SPROD_ID);			
			$('#UNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#sprod_id_dest').val(obj_row.DESTINATARIO_ID).trigger('change');
			
			$('#h_unidad_id').val(obj_row.UNDVIV_ID);	
			$('#h_sprod_id_dest').val(obj_row.DESTINATARIO_ID);
			$('#h_sprod_motivo').val(obj_row.COMENTARIO);
			$('#sprod_motivo').val(obj_row.COMENTARIO);
			
			deshabilitar_encabezado(obj_row.SPROD_ID)

			$('#tabla_productos tbody').unbind( "click" );
			tabla_productos.destroy();			
			crear_tabla_prod(obj_row.SPROD_ID)			
	
		});
	}
	

////////////TABLA PRODUCTOS/////////////////	
	
	var tabla_productos;
	
	crear_tabla_prod(0);
	
	function crear_tabla_prod(nro_solicitud){

		tabla_productos = $("#tabla_productos").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_solprod.php?nro_solicitud="+nro_solicitud,			
			bProcessing: true,

			columns: [
			
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'DESTINATARIO'},
				{ data:'COMENTARIO'},
				{ data:'CATPROD_ID'},
				{ data:'PROD_COD'},
				{ data:'CATPROD_NOMBRE'},				
				{ data:'PROD_NOMBRE'},	
				{ data:'SPRODD_CANT'},
				{ data:'PROD_VALOR'},
				{ data:'PROT_TOTAL'}
			],		
			
			columnDefs: [
			{ targets: [10,11,12,13,14], visible: true},
			{ targets: '_all', visible: false }						
			],
		//{ targets: [2,3,4], visible: true},
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
			$('#catprod_id').val(obj_row.CATPROD_ID).trigger('change');
			//$('#prod_cod').val(obj_row.PROD_COD).trigger('change');
			$('#sprodd_cant').val(obj_row.SPRODD_CANT);
			
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
		
		$('#aper_agno').select2({			
			data:combobox
		});		
		
		$('#rper_agno').select2({			
			data:combobox
		});			
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		$('#aper_agno').val(corresponding_agno).trigger('change');
		$('#rper_agno').val(corresponding_agno).trigger('change');
	}
	
	$('#per_agno').change(function() { 	change_agno()	});
	$('#aper_agno').change(function() { achange_agno()	});
	$('#rper_agno').change(function() { rchange_agno()	});
	
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
	
	function achange_agno(){
		var per_agno = $('#aper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('asem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				acarga_semanas(resp)
			},"json"
		)		
	}	
	
	function rchange_agno(){
		var per_agno = $('#rper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('rsem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				rcarga_semanas(resp)
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
	
	function acarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#asem_num').select2({			
			data:combobox
		})
		
		//cancelar();
		achange_sem_num();
	}	
	
	function rcarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#rsem_num').select2({			
			data:combobox
		})
		
		//cancelar();
		rchange_sem_num();
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
		
		$('#asem_num').select2({			
			data:combobox
		});
		
		$('#rsem_num').select2({			
			data:combobox
		});			

		$('#sem_num').val(corresponding_week).trigger('change');
		$('#asem_num').val(corresponding_week).trigger('change');
		$('#rsem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
		achange_sem_num();
		rchange_sem_num();
	}
	
	
	$('#sem_num').change(function() {
		cancelar();
		change_sem_num();
	});
	
	$('#asem_num').change(function() {
		achange_sem_num();
	});	
	
	$('#rsem_num').change(function() {
		rchange_sem_num();
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
	
	function achange_sem_num(){
		var per_agno = $('#aper_agno').val();
		var sem_num = $('#asem_num').val();

		if(sem_num == ""){
			clear_combobox('asprod_dia',1);
		}
		else{			
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('asprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					acarga_dias(resp)
				},"json"
			)
		}
	}	
	
	function rchange_sem_num(){
		var per_agno = $('#rper_agno').val();
		var sem_num = $('#rsem_num').val();
		if(sem_num == ""){
			clear_combobox('rsprod_dia',1);
		}
		else{
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('rsprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					rcarga_dias(resp)
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
		
	function acarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#asprod_dia').select2({			
			data:combobox
		});	

	}	
	
	function rcarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#rsprod_dia').select2({			
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
		
		$('#aUNDVIV_ID').select2({			
			data:combobox
		});			

		$('#rUNDVIV_ID').select2({			
			data:combobox
		});			
	}	
	
	
	
	
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
	
	//LOAD DESTINATARIOS
	carga_destinatarios();
	function carga_destinatarios(){
		var combobox = [];
		for(var i  = 0 ; i < data_destinatarios.length; i++) {
			combobox.push({id:data_destinatarios[i].ID_DEST, text:data_destinatarios[i].DESTINATARIO});
		}	
		
		$('#sprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});
		
		$('#sprod_ids_dest').select2({			
			allowClear: true,	
			data:combobox
		});
		
		$('#asprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});		

		$('#rsprod_id_dest').select2({			
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
		
		$('#ausr_solic').select2({			
			data:combobox
		});			

		$('#rusr_solic').select2({			
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
		$('#btn_regrep_sprod').hide();
		$('#btn_canrep_sprod').hide();
		$('#btn_updhead_sprod').hide();
		$('#btn_canupdhead_sprod').hide();	
		$('#destinatario_multiple').hide();
		$('#sprod_ids_dest').val('').trigger('change');
	}
	
	
	function deshabilitar_encabezado(sprod_id){
		//$('#per_agno').prop( "disabled", true );
		//$('#sem_num').prop( "disabled", true );
		//$('#sprod_dia').prop( "disabled", true );
		$('#UNDVIV_ID').prop( "disabled", true );	
		$('#sprod_id_dest').prop( "disabled", true );	
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
		//$('#per_agno').prop( "disabled", true );
		//$('#sem_num').prop( "disabled", true );
		//$('#sprod_dia').prop( "disabled", true );
		$('#UNDVIV_ID').prop( "disabled", false );	
		$('#sprod_id_dest').prop( "disabled", false );	
		$('#sprod_motivo').prop( "disabled", false );
		$('#UNDVIV_ID').val('').trigger('change');
		$('#sprod_id_dest').val('').trigger('change');
		$('#sprod_motivo').val('');
		
		$('#sprod_id').val('');
		$('#nro_solicitud').hide();
		
		hide_btnshead();
		
		$('#catprod_id').prop( "disabled", false );
		$('#prod_cod').prop( "disabled", false );
		$('#sprodd_cant').prop( "disabled", false );			
		
	}		
	
////////////EVENTO CLICK/////////////////		
	
	$('#btn_rep_sprod').click(function(){

		$('#destinatario_multiple').show();

		$('#sprod_ids_dest').select2({			
			allowClear: true
		});		
		
		$('#UNDVIV_ID').prop( "disabled", true );
		//$('#sprod_motivo').prop( "disabled", true );
		$('#sprod_motivo').prop( "disabled", true );	
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
	
	
	
	$('#btn_canupdhead_sprod').click(function(){
		$('#UNDVIV_ID').prop( "disabled", true );	
		$('#sprod_motivo').prop( "disabled", true );
		$('#sprod_id_dest').prop( "disabled", true );
		hide_btnshead();
		cancelar();
		
		UNDVIV_ID = $('#h_unidad_id').val();	 
		sprod_id_dest = $('#h_sprod_id_dest').val();	
		motivo = $('#h_sprod_motivo').val();
		
		$('#UNDVIV_ID').val(UNDVIV_ID).trigger('change');
		$('#sprod_id_dest').val(sprod_id_dest).trigger('change');
		$('#sprod_motivo').val(motivo)
		
		$('#catprod_id').prop( "disabled", false );
		$('#prod_cod').prop( "disabled", false );
		$('#sprodd_cant').prop( "disabled", false );

	})		
	
	$('#btn_canrep_sprod').click(function(){
		$('#UNDVIV_ID').prop( "disabled", true );
		$('#sprod_motivo').prop( "disabled", true );
		$('#sprod_id_dest').prop( "disabled", true );
		hide_btnshead();
		cancelar();

		UNDVIV_ID = $('#h_unidad_id').val();	 
		sprod_id_dest = $('#h_sprod_id_dest').val();	
		motivo = $('#h_sprod_motivo').val();
		
		$('#UNDVIV_ID').val(UNDVIV_ID).trigger('change');
		$('#sprod_id_dest').val(sprod_id_dest).trigger('change');	
		$('#sprod_motivo').val(motivo)
		
		$('#catprod_id').prop( "disabled", false );
		$('#prod_cod').prop( "disabled", false );
		$('#sprodd_cant').prop( "disabled", false );

	})		
	
	
	
	$('#btn_upd_sprod').click(function(){
		$('#UNDVIV_ID').prop( "disabled", false );
		$('#sprod_motivo').prop( "disabled", false );
		$('#sprod_id_dest').prop( "disabled", false );
		$('#btn_regrep_sprod').hide();
		$('#btn_canrep_sprod').hide();
		$('#btn_updhead_sprod').show();
		$('#btn_canupdhead_sprod').show();
		cancelar();
		$('#catprod_id').prop( "disabled", true );
		$('#prod_cod').prop( "disabled", true );
		$('#sprodd_cant').prop( "disabled", true );

	})	
	
	$('#btn_can_prod').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_sprod')[0].reset();

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
		var destinatario = $.trim($('#sprod_id_dest').val());

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
		
		if(destinatario == ''){
			sweet_alert('Error: Seleccionar destinatario');	
			return false;
		}			
		
		return true;
	}
	
	
	function validar_head_solic_rep(){
		
		var sprod_id = $.trim($('#sprod_id').val());
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());
		
		
		var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
		var destinatarios = $.trim($('#sprod_ids_dest').val());

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
		
		if(destinatarios == ''){
			sweet_alert('Error: Seleccionar destinatario(s)');	
			return false;
		}			
		
		return true;
	}	
	
	
	
	function validar_prod(){

		var catprod_id = $.trim($('#catprod_id').val());
		var prod_cod = $.trim($('#prod_cod').val());
		var sprodd_cant = $.trim($('#sprodd_cant').val());
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
		var destinatario = $.trim($('#sprod_id_dest').val());
		
		var nombre_material = $("#prod_cod option:selected").text();
		var stock_1 = nombre_material.split('(STOCK: ')
		var stock = parseInt(stock_1[1], 10);
		console.log(stock)

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
		
		if(destinatario == ''){
			sweet_alert('Error: Seleccionar destinatario');	
			return false;
		}			
		
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
		
		if(sprodd_cant > stock){
			sweet_alert('Error: Cantidad solicitada mayor a Stock existente');	
			return false;
		}		
		
		return true;
	}

	
	
	
	$('#btn_updhead_sprod').click(function(){

		if (validar_head_solic()){	
			
			$('#loading').show();
			
			var sprod_id = $.trim($('#sprod_id').val());
			var sprod_motivo = $.trim($('#sprod_motivo').val());
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var sprod_dia = $.trim($('#sprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
			var destinatario = $.trim($('#sprod_id_dest').val());
						
			var operacion = 'UPDATE_HEAD';
			parametros = {			
							sprod_id:sprod_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							sprod_motivo:sprod_motivo,
							destinatario:destinatario,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						bod_crud_solprod(resp)
				   },"json"
			)
		}	
	})			
	
	
	
	
	$('#btn_regrep_sprod').click(function(){

		if (validar_head_solic_rep()){	
			$('#loading').show();
			
			var sprod_id = $.trim($('#sprod_id').val());
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var sprod_dia = $.trim($('#sprod_dia').val());
			var sprod_motivo = $.trim($('#sprod_motivo').val());
			var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
			var destinatarios = $.trim($('#sprod_ids_dest').val());			
					
			var operacion = 'REPLICAR_SOLICITUD';
			parametros = {			
							sprod_id:sprod_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							sprod_motivo:sprod_motivo,
							UNDVIV_ID:UNDVIV_ID,
							destinatarios:destinatarios,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						bod_crud_solprod(resp)
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
			var destinatario = $.trim($('#sprod_id_dest').val());
			var sprod_motivo = $.trim($('#sprod_motivo').val());
			var prod_cod = $.trim($('#prod_cod').val());
			var sprodd_cant = $.trim($('#sprodd_cant').val());
			
			var operacion = 'INSERT';
			parametros = {			
							sprod_id:sprod_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							sprod_motivo:sprod_motivo,
							destinatario:destinatario,
							prod_cod:prod_cod,
							sprodd_cant:sprodd_cant,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						bod_crud_solprod(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_prod').click(function(){
		if (validar_prod()){	

			$('#loading').show();
			
			var sprod_id = $.trim($('#sprod_id').val());
			var h_prod_cod = $.trim($('#h_prod_cod').val());
			var prod_cod = $.trim($('#prod_cod').val());
			var sprodd_cant = $.trim($('#sprodd_cant').val());
			
			var operacion = 'UPDATE';
			parametros = {
							sprod_id:sprod_id,
							h_prod_cod:h_prod_cod,
							prod_cod:prod_cod,
							sprodd_cant:sprodd_cant,
							operacion:operacion
						 }		
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						bod_crud_solprod(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_prod').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este Producto?",   
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
				var h_prod_cod = $.trim($('#h_prod_cod').val());
				var operacion = 'DELETE';
				parametros = {	
								sprod_id:sprod_id,
								h_prod_cod:h_prod_cod,
								operacion:operacion
							 }		
				console.log(parametros)
				$.post(
					   "consultas/bod_crud_solprod.php",
					   parametros,			   
					   function(resp){
							bod_crud_solprod(resp)
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
					   "consultas/bod_crud_solprod.php",
					   parametros,			   
					   function(resp){
							bod_crud_solprod(resp)
					   },"json"
				)
		});	
		
	})	
	
	
	function bod_crud_solprod(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			var sprod_id = resp['sprod_id'];
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Producto registrado, Nro Solicitud: "+sprod_id, "success");				
				deshabilitar_encabezado(sprod_id);	
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Producto modificado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'UPDATE_HEAD'){
				swal("Sisconvi-Production", "Solicitud modificada", "success");
				var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
				var sprod_id_dest = $.trim($('#sprod_id_dest').val());
				var sprod_motivo = $.trim($('#sprod_motivo').val());
			
				$('#h_unidad_id').val(UNDVIV_ID);	 
				$('#h_sprod_id_dest').val(sprod_id_dest);	
				$('#h_sprod_motivo').val(sprod_motivo);					
				actualizar_tabla_solicitud();
				deshabilitar_encabezado(sprod_id);	
				$('#catprod_id').prop( "disabled", false );
				$('#prod_cod').prop( "disabled", false );
				$('#sprodd_cant').prop( "disabled", false );
	
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Producto eliminado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'DELETE ALL'){
				swal("Sisconvi-Production", "Solicitud eliminada", "success");
				habilitar_encabezado();
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
				$('#btn_can_sprod').hide();
				$('#btn_rep_sprod').hide();
				$('#btn_del_sprod').hide();	
				$('#btn_upd_sprod').hide();					
			}else if(operacion == 'REPLICAR_SOLICITUD'){
				swal("Sisconvi-Production", "Solicitud replicada", "success");
				actualizar_tabla_solicitud();		
				hide_btnshead();				
			}

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	

	function actualizar_tabla_solicitud(){
		$('#tabla_solicitudes tbody').unbind( "click" );
		tabla_solicitudes.destroy();
		/*
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();	
		var sprod_dia = $('#sprod_dia').val();
		crear_tabla(sem_num,per_agno,sprod_dia);	*/			
		crear_tabla();
	}
	
	
	function actualizar_tabla_producto(sprod_id){
		$('#tabla_productos tbody').unbind( "click" );
		tabla_productos.destroy();
		crear_tabla_prod(sprod_id);					
	}	

	
	
//TAB SOLICITUDES ACEPTADAS Y RECHAZADAS


	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		
		if(target == "#tab1primary"){ 
			//fix_select_prod();		  
		}
		if(target == "#tab2primary"){ 
			fix_select_aceptadas();
			busqueda_solic_aceptadas();
		}
		if(target == "#tab3primary"){ 
			fix_select_rechazadas();
			busqueda_solic_rechazadas();
		}
	});	
	
	
	fix_select_aceptadas();
	function fix_select_aceptadas(){
	
		$('#ausr_solic').select2({});
		$('#aper_agno').select2({});
		$('#asem_num').select2({});
		$('#asprod_dia').select2({});
		$('#aUNDVIV_ID').select2({});
		$('#asprod_id_dest').select2({});
		$('#asprod_hentrega').select2({});
	}
	
	fix_select_rechazadas();
	function fix_select_rechazadas(){
	
		$('#rusr_solic').select2({});
		$('#rper_agno').select2({});
		$('#rsem_num').select2({});
		$('#rsprod_dia').select2({});
		$('#rUNDVIV_ID').select2({});
		$('#rsprod_id_dest').select2({});
	}		
	
	
	$('#btn_cons_aceptadas').click(function(){
		busqueda_solic_aceptadas();
	})	
	
	$('#btn_cons_rechazadas').click(function(){
		busqueda_solic_rechazadas();
	})	
	
	
	function busqueda_solic_aceptadas(){
		$('#aloading').show();
		limpieza_resolucion();
		var sprod_id = $.trim($('#asprod_id').val());
		var solicitante = $.trim($('#ausr_solic').val());
		var per_agno = $.trim($('#aper_agno').val());
		var sem_num = $.trim($('#asem_num').val());		
		var sprod_dia = $.trim($('#asprod_dia').val());		
		var UNDVIV_ID = $.trim($('#aUNDVIV_ID').val());
		var destinatario = $.trim($('#asprod_id_dest').val());
		crear_tabla_productos(0)
		if(typeof tabla_solicitudes_aceptadas != 'undefined') tabla_solicitudes_aceptadas.destroy();
		//$('#tabla_solicitudes_aceptadas tbody').unbind( "click" );
		crear_tabla_aceptadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario)			
	}
	
	function busqueda_solic_rechazadas(){
		$('#rloading').show();
		rlimpieza_resolucion();
		var sprod_id = $.trim($('#rsprod_id').val());
		var solicitante = $.trim($('#rusr_solic').val());
		var per_agno = $.trim($('#rper_agno').val());
		var sem_num = $.trim($('#rsem_num').val());		
		var sprod_dia = $.trim($('#rsprod_dia').val());		
		var UNDVIV_ID = $.trim($('#rUNDVIV_ID').val());
		var destinatario = $.trim($('#rsprod_id_dest').val());
		rcrear_tabla_productos(0)
		if(typeof tabla_solicitudes_rechazadas != 'undefined') tabla_solicitudes_rechazadas.destroy();
		//$('#tabla_solicitudes_aceptadas tbody').unbind( "click" );
		crear_tabla_rechazadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario)			
	}
	
	var tabla_solicitudes_aceptadas;	
	//crear_tabla_aceptadas( '', '', year_current,week_current,'','', '')
	function crear_tabla_aceptadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario){
		console.log(destinatario)
		tabla_solicitudes_aceptadas = $("#tabla_solicitudes_aceptadas").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?solaceptadas=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&destinatario="+destinatario,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'DESTINATARIO'},
				{ data:'FECHA_ENTREGA'},
				{ data:'FECHA_RENTREGA'},
				{ data:'QUIEN_RETIRA'},
				{ data:'COMENTARIO'}
			],	
		
			columnDefs: [
				{ targets: [10], visible: false },
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			},

			fnInitComplete: function(oSettings, json) {
			  $('#aloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_aceptadas tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_aceptadas.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			limpieza_resolucion();
			$('#aloading').show();
			var obj_row = tabla_solicitudes_aceptadas.row(this).data();	
			
			var fechahora_entrega = obj_row.FECHA_ENTREGA;
			fechahora_entrega = fechahora_entrega.split(' ')
	
			$('#asprod_dentrega').val(fechahora_entrega[0]);
			$('#asprod_hentrega').val(fechahora_entrega[1]).trigger('change');
			$('#asprod_comentario').val(obj_row.COMENTARIO);	
			
			crear_tabla_productos(obj_row.SPROD_ID)
			
		});
	}	
	
//////


	
	var tabla_solicitudes_rechazadas;	
	//crear_tabla_rechazadas( '', '', year_current,week_current,'','', '')
	function crear_tabla_rechazadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario){
		console.log(solicitante)
		tabla_solicitudes_rechazadas = $("#tabla_solicitudes_rechazadas").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?rechazadas=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&destinatario="+destinatario,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'DESTINATARIO'},
				{ data:'COMENTARIO'}
			],	
		
			columnDefs: [
				{ targets: [7], visible: false },
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			},

			fnInitComplete: function(oSettings, json) {
			  $('#rloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_rechazadas tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_rechazadas.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			rlimpieza_resolucion();
			$('#rloading').show();
			var obj_row = tabla_solicitudes_rechazadas.row(this).data();	
			
			$('#rsprod_comentario').val(obj_row.COMENTARIO);	
			
			rcrear_tabla_productos(obj_row.SPROD_ID)
			
		});
	}		
	
	
	
	
	
	
	
	
	
/////
	
	var productos_solicitados_aceptados;	

	function crear_tabla_productos(sprod_id){

		productos_solicitados_aceptados = $("#productos_solicitados_aceptados").DataTable({
			
			responsive: true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?prod_aceptados=ok&sprod_id="+sprod_id,
			bProcessing: true,
			columns: [
				{ data:'RESOLUCION'},
				{ data:'CATEGORIA'},
				{ data:'PRODUCTO'},								
				{ data:'CANT_SOLICITADA'},
				{ data:'CANT_ACEPTADA'}
			],	
		
			columnDefs: [
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			},

			fnInitComplete: function(oSettings, json) {
			  $('#aloading').hide();
			}
		});
	
	}	
	
	
/////
	
	var productos_solicitados_rechazados;	

	function rcrear_tabla_productos(sprod_id){

		productos_solicitados_rechazados = $("#productos_solicitados_rechazados").DataTable({
			
			responsive: true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?prod_rechazados=ok&sprod_id="+sprod_id,
			bProcessing: true,
			columns: [
				{ data:'CATEGORIA'},
				{ data:'PRODUCTO'},								
				{ data:'CANT_SOLICITADA'}
			],	
		
			columnDefs: [
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			},

			fnInitComplete: function(oSettings, json) {
			  $('#rloading').hide();
			}
		});
	
	}		
	
	
	
	function limpieza_resolucion(){
		$('#asprod_dentrega').val('');
		$('#asprod_hentrega').val('').trigger('change');
		$('#asprod_comentario').val('');	
		if(typeof productos_solicitados_aceptados != 'undefined') productos_solicitados_aceptados.destroy();		
	}
	
	function rlimpieza_resolucion(){
		$('#rsprod_comentario').val('');	
		if(typeof productos_solicitados_rechazados != 'undefined') productos_solicitados_rechazados.destroy();		
	}	
	
	
/*
	function crear_tabla_productos(resp){
		console.log(resp)
		$('#productos_solicitados_aceptados').empty();
		
		i = 0;
		while(i < resp.length){

			resolucion = (resp[i].SPROD_ESTADO == 'ACEPTADA')?'checked':'';
			
			$('#productos_solicitados').append(
				'<tr>'+
					'<td style="text-align:center"><input type="checkbox" '+resolucion+'/></td>' +
					'<td>'+resp[i].CATPROD_NOMBRE+'</td>' +
					'<td>'+resp[i].PROD_NOMBRE+'</td>' +
					'<td style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
					'<td style="text-align:center">'+resp[i].SPRODR_CANT+'</td>' +
			'</tr>');			
			
			i++;
			
		}
		
	}	
*/	
	
});