$(document).ready(function(){

	function jq( myid ) {
		return myid.replace(/[^a-z0-9\s]/gi, '')
	}
/*	
a = "someñ-87.id&^'-=+-*$#";	
b = a.replace(/[^a-z0-9\s]/gi, '')
c=jq(a)
console.log(c)
*/
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sprod_comentario');
	mayuscula('asprod_comentario');

	$('#prod_cod').select2({	});	
	$("#sprod_hentrega").select2({ 	});	
	//$("#sprod_hentrega").val('08:00')
	$("#asprod_hentrega").select2({ 	});	
	$("#asprod_hrentrega").select2({ 	});	
	$("#ssprod_hentrega").select2({ 	});	
	//$("#esprod_hrentrega").select2({ 	});		

	$('#sprod_dentrega').daterangepicker({
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
	
	$('#asprod_dentrega').daterangepicker({
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
	
	$('#asprod_drentrega').daterangepicker({
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

	$('#ssprod_drentrega').daterangepicker({
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
	
	
	
	$('#asprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#rsprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});			
	
	$('#esprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#ssprodd_cant').keypress(function(e){
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

			cancelar();
			var obj_row = tabla_solicitudes.row(this).data();	
			$('#sprod_id').val(obj_row.SPROD_ID);	
			$('#usr_solic').val(obj_row.SOLICITANTE);	
			$('#UNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#sprod_id_dest').val(obj_row.DESTINATARIO_ID).trigger('change');	
			//console.log('hola1')
			carga_productos(obj_row.SPROD_ID);
			//console.log('hola2')
		});
	}
	

	function carga_productos(sprod_id){
		//console.log('hola3')
		//console.log(sprod_id)
		//console.log(sprod_id)
		$('#productos_solicitados').empty();
		parametros = {			
			sprod_id:sprod_id
		}		
		console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				crear_tabla_productos(resp)
			},"json"
		)		
	}
	
	function crear_tabla_productos(resp){
		console.log(resp)
		$('#productos_solicitados').empty();
		resolucion = 'ACEPTADA'
		
		i = 0;
		while(i < resp.length){
			cod_real_prod = resp[i].PROD_COD;
			resp[i].PROD_COD = jq(resp[i].PROD_COD)

			cate = 'cate_'+resp[i].PROD_COD;
			prod = 'prod_'+resp[i].PROD_COD;
			stock = 'stock_'+resp[i].PROD_COD;
			cants = 'cants_'+resp[i].PROD_COD;
			cant = 'cant_'+resp[i].PROD_COD;
			cod_prod = 'codprod_'+resp[i].PROD_COD;
			
			$('#productos_solicitados').append(
				'<tr>'+
					'<td style="text-align:center"><input type="checkbox" class="check_resolucion" id='+resp[i].PROD_COD+' checked/></td>' +
					'<td id='+cate+'>'+resp[i].CATPROD_NOMBRE+'</td>' +
					'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
					'<td id='+stock+' style="text-align:center">'+resp[i].PROD_STOCK+'</td>' +
					'<td id='+cants+' style="text-align:center"><span id='+cod_prod+' style="display:none">'+cod_real_prod+'</span>'+resp[i].SPRODD_CANT+'</td>' +
					'<td style="text-align:center; width:70px"><input style="text-align:center" type="text" maxlength="6" size="4" id='+cant+' value='+resp[i].SPRODD_CANT+' /></td>' +
			'</tr>');	
			
			$('#'+resp[i].PROD_COD).bind('click',function(e){ clic_resolucion(this); });

			$('#'+cant).bind('keypress',function(e){ 
				if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
			})			
			
			i++;
			
		}
		
	}
	
	function clic_resolucion(e){

		prod_cod = e.id;
		cants = 'cants_'+prod_cod;
		cate = 'cate_'+prod_cod;
		prod = 'prod_'+prod_cod;
		stock = 'stock_'+prod_cod;
		cant = 'cant_'+prod_cod;
		valor_cants = $('#'+cants).html();
		
		if($('#'+prod_cod).is(":checked")){
			$('#'+cate).css({'text-decoration-line':'none'})	
			$('#'+prod).css({'text-decoration-line':'none'})
			$('#'+stock).css({'text-decoration-line':'none'})
			$('#'+cants).css({'text-decoration-line':'none'})
			$('#'+cant).val(valor_cants);
			$('#'+cant).prop( "disabled", false );
		}else{
			$('#'+cate).css({'text-decoration-line':'line-through'})	
			$('#'+prod).css({'text-decoration-line':'line-through'})
			$('#'+stock).css({'text-decoration-line':'line-through'})
			$('#'+cants).css({'text-decoration-line':'line-through'})
			$('#'+cant).val('');
			$('#'+cant).prop( "disabled", true );
		}
	}	
	
	$('#sprod_estado').change(function() {
	
		resolucion = $('#sprod_estado').val();
		
		if(resolucion == 'ACEPTADA'){		
			$('#fecha_entrega').show();
			$('#hora_entrega').show();
		}else{
			$('#fecha_entrega').hide();
			$('#hora_entrega').hide();		
		}
		
		$('.check_resolucion').each( function() {
			
			prod_cod = this.id;
			cants = 'cants_'+prod_cod;
			cate = 'cate_'+prod_cod;
			prod = 'prod_'+prod_cod;
			stock = 'stock_'+prod_cod;
			cant = 'cant_'+prod_cod;
			valor_cants = $('#'+cants).html();
			
			valor_cant = $('#'+cant).val();
			
			if(resolucion == 'ACEPTADA'){
			
				$('#'+cate).css({'text-decoration-line':'none'})	
				$('#'+prod).css({'text-decoration-line':'none'})
				$('#'+stock).css({'text-decoration-line':'none'})
				$('#'+cants).css({'text-decoration-line':'none'})
				if(valor_cant == '') $('#'+cant).val(valor_cants);
				$('#'+cant).prop( "disabled", false );				
				$('#'+prod_cod).prop( "checked", true );
			}
			
			if(resolucion == 'RECHAZADA'){
				$('#'+cate).css({'text-decoration-line':'line-through'})	
				$('#'+prod).css({'text-decoration-line':'line-through'})
				$('#'+stock).css({'text-decoration-line':'line-through'})
				$('#'+cants).css({'text-decoration-line':'line-through'})
				$('#'+cant).val('');
				$('#'+cant).prop( "disabled", true );				
				$('#'+prod_cod).prop( "checked", false );
			}				
							
		})			
				
	});	
	

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
		
		$('#eper_agno').select2({			
			data:combobox
		});	
		
		$('#sper_agno').select2({			
			data:combobox
		});			
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		$('#aper_agno').val(corresponding_agno).trigger('change');
		$('#rper_agno').val(corresponding_agno).trigger('change');
		$('#eper_agno').val(corresponding_agno).trigger('change');
		$('#sper_agno').val(corresponding_agno).trigger('change');
	}
	
	$('#per_agno').change(function() { 	change_agno()	});
	$('#aper_agno').change(function() { achange_agno()	});
	$('#rper_agno').change(function() { rchange_agno()	});
	$('#eper_agno').change(function() { echange_agno()	});
	$('#sper_agno').change(function() { schange_agno()	});
	
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
	
	function schange_agno(){
		var per_agno = $('#sper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('ssem_num',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				scarga_semanas(resp)
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
		
		//cancelar();
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
	
	function scarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#ssem_num').select2({			
			data:combobox
		})
		schange_sem_num();
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
		
		$('#esem_num').select2({			
			data:combobox
		});	
		
		$('#ssem_num').select2({			
			data:combobox
		});			

		$('#sem_num').val(corresponding_week).trigger('change');
		$('#asem_num').val(corresponding_week).trigger('change');
		$('#rsem_num').val(corresponding_week).trigger('change');
		$('#esem_num').val(corresponding_week).trigger('change');
		$('#ssem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
		achange_sem_num();
		rchange_sem_num();
		echange_sem_num();
		schange_sem_num();
	}
	
	
	$('#sem_num').change(function() {
		//cancelar();
		change_sem_num();
	});
	
	$('#asem_num').change(function() {
		achange_sem_num();
	});	
	
	$('#rsem_num').change(function() {
		rchange_sem_num();
	});	
	
	$('#esem_num').change(function() {
		echange_sem_num();
	});		
	
	$('#ssem_num').change(function() {
		schange_sem_num();
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
	

	function schange_sem_num(){
		var per_agno = $('#sper_agno').val();
		var sem_num = $('#ssem_num').val();
		if(sem_num == ""){
			clear_combobox('ssprod_dia',0);
		}
		else{
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('ssprod_dia',0);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					scarga_dias(resp)
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
	
	function ecarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#esprod_dia').select2({			
			data:combobox
		});	
	}	
	
	function scarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#ssprod_dia').select2({			
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
		
		$('#eUNDVIV_ID').select2({			
			data:combobox
		});		
		
		$('#sUNDVIV_ID').select2({			
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
		
		$('#asprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});		

		$('#asprod_id_retira').select2({			
			allowClear: true,	
			data:combobox
		});				
		
		$('#rsprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});			
		
		$('#esprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});			

		$('#ssprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});	
		
		$('#ssprod_id_retira').select2({			
			allowClear: true,	
			data:combobox
		});		
		
		$('#ssprod_ids_dest').select2({			
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
		
		$('#eusr_solic').select2({			
			data:combobox
		});	
		
		$('#susr_solic').select2({			
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
		
		$('#scatprod_id').select2({			
			allowClear: true,	
			data:combobox
		});			
		
		$('#catprod_id').select2({			
			allowClear: true,	
			data:combobox
		});				
		
	}	
	
	//CHANGE CATEGORIA
	$('#scatprod_id').change(function() {
		
		var catprod_id = $('#scatprod_id').val();
		
		if(catprod_id == ""){
			clear_combobox('sprod_cod',1);
		}
		else{
			parametros = {			
				id_cat_stock:catprod_id
			}		
			clear_combobox('sprod_cod',1);
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					scarga_productos(resp)
				},"json"
				)	
		}

	});
	
	function scarga_productos(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].PROD_COD, text:resp[i].PROD_NOMBRE});
		}	
		
		$('#sprod_cod').select2({			
			data:combobox
		})
		//flag = $('#h_flag_rowprod').val();
		//if(flag == 'x'){
			prod_selected = $('#sh_prod_cod').val();
			$('#sprod_cod').val(prod_selected).trigger('change');	
		//}
		//$('#h_flag_rowprod').val('');
	}	
	
	
	//CHANGE CATEGORIA
	$('#catprod_id').change(function() {

		var catprod_id = $('#catprod_id').val();
		
		if(catprod_id == ""){
			clear_combobox('prod_cod',1);
		}
		else{
			parametros = {			
				catprod_id:catprod_id
			}		
			clear_combobox('prod_cod',1);
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					xcarga_productos(resp)
				},"json"
				)	
		}

	});
	
	function xcarga_productos(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].PROD_COD, text:resp[i].PROD_NOMBRE});
		}	
		
		$('#prod_cod').select2({			
			data:combobox
		})

	}		
	
	
	
////////////EVENTO CLICK/////////////////		


	
	function cancelar(){
		
		$('#sprod_id').val('');
		$('#usr_solic').val('');
		
		$('#UNDVIV_ID').val('').trigger('change');
		$('#sprod_id_dest').val('').trigger('change');
		
		$('#sprod_estado').val('').trigger('change');
		//$('#sprod_hentrega').val('').trigger('change');
		$('#sprod_comentario').val('');
		
		$('#productos_solicitados').empty();
		
		
	}
	

	function validar_resolucion(){

		var sprod_id = $.trim($('#sprod_id').val());
		var sprod_estado = $.trim($('#sprod_estado').val());
		var sprod_dentrega = $.trim($('#sprod_dentrega').val());
		var sprod_hentrega = $.trim($('#sprod_hentrega').val());		
		var sprod_comentario = $.trim($('#sprod_comentario').val());
		
		var aceptado = 'N';		
		var cant_cero = 0;
		var mayor_stock = 0;
		$('.check_resolucion').each( function() {
			if(this.checked) {
				aceptado = 'S';				
				prod_cod = this.id;
				cant = $('#cant_'+prod_cod).val();
				stock = $('#stock_'+prod_cod).text();
				stock = parseInt(stock,10)
				if(cant > stock) mayor_stock = 1;
				if(cant == 0) cant_cero = 1;
			}	
			
		})	
		

		if(sprod_id == ''){
			sweet_alert('Error: Nro Solicitud inexistente, favor refrescar página');	
			return false;
		}	
		
		if(sprod_estado == ''){
			sweet_alert('Error: Seleccionar resolución');	
			return false;
		}		
		
		if(sprod_estado == 'ACEPTADA' && sprod_dentrega == ''){
			sweet_alert('Error: Seleccionar fecha entrega');	
			return false;
		}	
		
		if(sprod_estado == 'ACEPTADA' && sprod_hentrega == ''){
			sweet_alert('Error: Seleccionar hora entrega');	
			return false;
		}	
		
		if(sprod_estado == 'ACEPTADA' && cant_cero){
			sweet_alert('Error: Todas las cantidades aceptadas deben ser mayor a cero');	
			return false;
		}			
		
		if(sprod_estado == 'ACEPTADA' && aceptado == 'N'){
			sweet_alert('Error: Si la resolución es Aceptada debe seleccionar al menos un producto');	
			return false;
		}	
		
		if(sprod_estado == 'ACEPTADA' && mayor_stock){
			sweet_alert('Error: No se puede aceptar una cantidad mayor al Stock existente');	
			return false;
		}			

		if(sprod_estado == 'RECHAZADA' && sprod_comentario == ''){
			sweet_alert('Error: Ingresar motivo de rechazo');	
			return false;
		}			
		
		return true;
	}


	
	
 	$('#btn_reg_resolucion').click(function(){

		if (validar_resolucion()){	

			var sprod_estado = $.trim($('#sprod_estado').val());
		
			if(sprod_estado == 'RECHAZADA'){

				swal({   
					title: "¿Seguro que deseas Rechazar esta Solicitud?",   
					text: "No podrás deshacer este paso...",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						$('#btn_reg_resolucion').prop( "disabled", true );
						$('#loading').show();
						var sprod_id = $.trim($('#sprod_id').val());
						var sprod_comentario = $.trim($('#sprod_comentario').val());
						var operacion = 'RECHAZAR SOLIC';
						parametros = {	
										sprod_id:sprod_id,
										sprod_comentario:sprod_comentario,
										sprod_estado: sprod_estado,
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
			}
			
			
			if(sprod_estado == 'ACEPTADA'){
				$('#btn_reg_resolucion').prop( "disabled", true );
				$('#loading').show();
				var sprod_id = $.trim($('#sprod_id').val());
				var sprod_dentrega = $.trim($('#sprod_dentrega').val());
				var sprod_hentrega = $.trim($('#sprod_hentrega').val());				
				var sprod_comentario = $.trim($('#sprod_comentario').val());
				
				var prod_cod = {};
				var sprodr_cant = {};
				var sprodr_estado = {};
				
				//x = $('#cant_LIBETI100*80').val();
				//console.log('x:'+x)
				var i = 0;
				$('.check_resolucion').each( function() {
					prod_cod[i] = this.id;
					
					sprodr_cant[i] = $('#cant_'+prod_cod[i]).val();
					prod_cod[i] = $('#codprod_'+prod_cod[i]).text();
					if(this.checked) {
						sprodr_estado[i] = 'ACEPTADA';
					}else{
						sprodr_estado[i] = 'RECHAZADA';
					}

					i++;
				})
				
				var operacion = 'ACEPTAR SOLIC';
				parametros = {	
								sprod_id:sprod_id,
								sprod_dentrega:sprod_dentrega,
								sprod_hentrega:sprod_hentrega,
								sprod_comentario:sprod_comentario,
								sprod_estado: sprod_estado,
								prod_cod: prod_cod,
								sprodr_cant: sprodr_cant,
								sprodr_estado: sprodr_estado,
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
			
			
		}
	})	
	
	
	function bod_crud_solprod(resp){
		$('#btn_reg_resolucion').prop( "disabled", false );
		$('#loading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			if(operacion == 'ACEPTAR SOLIC'){
				swal("Sisconvi-Production", "Resolución Aceptada", "success");
			}
			else if(operacion == 'RECHAZAR SOLIC'){
				swal("Sisconvi-Production", "Resolución Rechazada", "success");
			}			
			$('#tabla_solicitudes tbody').unbind( "click" );
			tabla_solicitudes.destroy();				
			crear_tabla();
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	

	
	
	
	
	
	
	
	
	
	
	
	
//TAB SOLICITUDES ACEPTADAS Y RECHAZADAS










	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		
		if(target == "#tab1primary"){ 
			//fix_select_prod();
			$('#tabla_solicitudes tbody').unbind( "click" );
			tabla_solicitudes.destroy();				
			crear_tabla();			
		}
		if(target == "#tab2primary"){ 
			fix_select_aceptadas();
			busqueda_solic_aceptadas();
		}
		if(target == "#tab3primary"){ 
			fix_select_rechazadas();
			busqueda_solic_rechazadas();
		}
		if(target == "#tab4primary"){ 
			fix_select_entregadas();
			busqueda_solic_entregadas();
		}	
		if(target == "#tab5primary"){ 
			fix_select_salidas();
			cancelacion_salida_bodega()			
			if(typeof stabla_solicitudes != 'undefined') stabla_solicitudes.destroy();
			screar_tabla();
			
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
		$('#asprod_id_retira').select2({});
		$('#asprod_hentrega').select2({});
		$('#asprod_hrentrega').select2({});
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
	
	fix_select_entregadas();
	function fix_select_entregadas(){
	
		$('#eusr_solic').select2({});
		$('#eper_agno').select2({});
		$('#esem_num').select2({});
		$('#esprod_dia').select2({});
		$('#eUNDVIV_ID').select2({});
		$('#esprod_id_dest').select2({});
		$('#prod_cod').select2({	});	
		$('#catprod_id').select2({	});	
		
		
		//$('#esprod_id_retira').select2({});
		//$('#esprod_hentrega').select2({});
		//$('#esprod_hrentrega').select2({});
	}
	
	fix_select_salidas();
	function fix_select_salidas(){
	
		$('#susr_solic').select2({});
		$('#sper_agno').select2({});
		$('#ssem_num').select2({});
		$('#ssprod_dia').select2({});
		$('#sUNDVIV_ID').select2({});
		$('#ssprod_id_dest').select2({});
		$('#ssprod_id_retira').select2({});
		$('#ssprod_id_retira').select2({});
		$('#ssprod_hrentrega').select2({});
		$('#scatprod_id').select2({});
		$('#sprod_cod').select2({});
		
	}	
	
	
	$('#btn_cons_aceptadas').click(function(){
		busqueda_solic_aceptadas();
	})
	

	$('#btn_cons_rechazadas').click(function(){
		busqueda_solic_rechazadas();
	})	
	
	$('#btn_cons_entregadas').click(function(){
		busqueda_solic_entregadas();
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
		//acrear_tabla_productos(0)
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
		$('#tabla_solicitudes_rechazadas tbody').unbind( "click" );
		crear_tabla_rechazadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario)			
	}
	
	
	function busqueda_solic_entregadas(){
		$('#eloading').show();
		elimpieza_resolucion();
		$('#ebtn_acta_entrega').hide();
		var sprod_id = $.trim($('#esprod_id').val());
		var solicitante = $.trim($('#eusr_solic').val());
		var per_agno = $.trim($('#eper_agno').val());
		var sem_num = $.trim($('#esem_num').val());		
		var sprod_dia = $.trim($('#esprod_dia').val());		
		var UNDVIV_ID = $.trim($('#eUNDVIV_ID').val());
		var destinatario = $.trim($('#esprod_id_dest').val());
		
		var prod_cod = $.trim($('#prod_cod').val());
		var catprod_id = $.trim($('#catprod_id').val());		
		
		//acrear_tabla_productos(0)
		//if(typeof xproductos_solicitados_entregados != 'undefined') xproductos_solicitados_entregados.destroy();
		ecrear_tabla_productos(0)
		if(typeof tabla_solicitudes_entregadas != 'undefined') tabla_solicitudes_entregadas.destroy();
		$('#tabla_solicitudes_entregadas tbody').unbind( "click" );
		crear_tabla_entregadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario, prod_cod, catprod_id)			
	}	
	
	
	var tabla_solicitudes_aceptadas;	
	//crear_tabla_aceptadas( '', '', year_current,week_current,'','', '')
	function crear_tabla_aceptadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario){
		console.log(per_agno)
		tabla_solicitudes_aceptadas = $("#tabla_solicitudes_aceptadas").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?aceptadas=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&destinatario="+destinatario,
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
				{ targets: [8,9,10], visible: false },
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
			
			$('#h_asprod_id').val(obj_row.SPROD_ID);
			
			
			var fechahora_entrega = obj_row.FECHA_ENTREGA;
			fechahora_entrega = fechahora_entrega.split(' ')
	
			$('#asprod_dentrega').val(fechahora_entrega[0]);
			$('#asprod_hentrega').val(fechahora_entrega[1]).trigger('change');
			$('#asprod_comentario').val(obj_row.COMENTARIO);	
			
			//acrear_tabla_productos(obj_row.SPROD_ID)
			acarga_productos(obj_row.SPROD_ID)
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
			
			$('#h_rsprod_id').val(obj_row.SPROD_ID);
			
			$('#rsprod_comentario').val(obj_row.COMENTARIO);	
			
			rcrear_tabla_productos(obj_row.SPROD_ID)
			
		});
	}		
	
	
	var tabla_solicitudes_entregadas;	
	//crear_tabla_aceptadas( '', '', year_current,week_current,'','', '')
	function crear_tabla_entregadas( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario, prod_cod, catprod_id){
		console.log(per_agno)
		tabla_solicitudes_entregadas = $("#tabla_solicitudes_entregadas").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?entregadas=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&destinatario="+destinatario+"&prod_cod="+prod_cod+"&catprod_id="+catprod_id,
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
			  $('#eloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_entregadas tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_entregadas.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			elimpieza_resolucion();
			$('#eloading').show();
			var obj_row = tabla_solicitudes_entregadas.row(this).data();
			
			$('#ebtn_acta_entrega').show();
						
			$('#h_esprod_id').val(obj_row.SPROD_ID);
			$('#esprod_comentario').val(obj_row.COMENTARIO);
/*						
			var rfechahora_entrega = obj_row.FECHA_RENTREGA;
			rfechahora_entrega = rfechahora_entrega.split(' ')
	
			$('#esprod_drentrega').val(rfechahora_entrega[0]);
			$('#esprod_hrentrega').val(rfechahora_entrega[1]).trigger('change');			
*/			
			
			ecrear_tabla_productos(obj_row.SPROD_ID);

		});
	}		
	
	
	
	
	
	
/////


	function acarga_productos(sprod_id){
		console.log(sprod_id)
		$('#productos_aceptados').empty();
		parametros = {			
			asprod_id:sprod_id
		}		

		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				acrear_tabla_productos(resp)
			},"json"
			)		
	}
	
	
	function acrear_tabla_productos(resp){
		console.log(resp)
		$('#productos_aceptados').empty();
		$('#aloading').hide();
		
		i = 0;
		while(i < resp.length){
			cod_real_prod = resp[i].PROD_COD;
			resp[i].PROD_COD = jq(resp[i].PROD_COD)

			prodcod = 'a___'+resp[i].PROD_COD;
			cate = 'acate_'+resp[i].PROD_COD;
			prod = 'aprod_'+resp[i].PROD_COD;
			stock = 'astock_'+resp[i].PROD_COD;
			cants = 'acants_'+resp[i].PROD_COD;
			cant = 'acant_'+resp[i].PROD_COD;
			cod_prod = 'acodprod_'+resp[i].PROD_COD;
			
			cant_aceptada = (resp[i].SPRODR_ESTADO == 'ACEPTADA') ? resp[i].SPRODR_CANT:'';
			resolucion = (resp[i].SPRODR_ESTADO == 'ACEPTADA')?'checked':'';
			sol_aceptada = (resp[i].SPRODR_ESTADO == 'ACEPTADA') ? 'none':'line-through';
			cant_estado = (resp[i].SPRODR_ESTADO == 'ACEPTADA')?'':'disabled';
			
			$('#productos_aceptados').append(
				'<tr>'+
					'<td style="text-align:center"><input type="checkbox" class="acheck_resolucion" id='+prodcod+' '+resolucion+'/></td>' +
					'<td id='+cate+' style="text-decoration-line:'+sol_aceptada+'">'+resp[i].CATPROD_NOMBRE+'</td>' +
					'<td id='+prod+' style="text-decoration-line:'+sol_aceptada+'">'+resp[i].PROD_NOMBRE+'</td>' +
					'<td id='+stock+' style="text-align:center; text-decoration-line:'+sol_aceptada+'">'+resp[i].PROD_STOCK+'</td>' +
					'<td id='+cants+' style="text-align:center; text-decoration-line:'+sol_aceptada+'"><span id='+cod_prod+' style="display:none">'+cod_real_prod+'</span>'+resp[i].SPRODD_CANT+'</td>' +
					'<td style="text-align:center; width:70px"><input style="text-align:center" type="text" maxlength="6" size="4" id='+cant+' value="'+cant_aceptada+'" '+cant_estado+' /></td>' +
			'</tr>');	
			
			$('#'+prodcod).bind('click',function(e){ aclic_resolucion(this); });

			$('#'+cant).bind('keypress',function(e){ 
				if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
			})			
			
			i++;
			
		}
		
	}
	
	function aclic_resolucion(e){

		prod_codx = e.id;
		console.log(prod_codx)
		prodcod_split = prod_codx.split('___')
		prod_cod = prodcod_split[1]
		console.log(prod_cod)
		cants = 'acants_'+prod_cod;
		cate = 'acate_'+prod_cod;
		prod = 'aprod_'+prod_cod;
		stock = 'astock_'+prod_cod;
		cant = 'acant_'+prod_cod;
		valor_cants = $('#'+cants).html();
		
		if($('#'+prod_codx).is(":checked")){
			$('#'+cate).css({'text-decoration-line':'none'})	
			$('#'+prod).css({'text-decoration-line':'none'})
			$('#'+stock).css({'text-decoration-line':'none'})
			$('#'+cants).css({'text-decoration-line':'none'})
			$('#'+cant).val(valor_cants);
			$('#'+cant).prop( "disabled", false );
		}else{
			$('#'+cate).css({'text-decoration-line':'line-through'})	
			$('#'+prod).css({'text-decoration-line':'line-through'})
			$('#'+stock).css({'text-decoration-line':'line-through'})
			$('#'+cants).css({'text-decoration-line':'line-through'})
			$('#'+cant).val('');
			$('#'+cant).prop( "disabled", true );
		}
	}


	function avalidar_resolucion(){

		var sprod_id = $.trim($('#h_asprod_id').val());
		var sprod_dentrega = $.trim($('#asprod_dentrega').val());
		var sprod_hentrega = $.trim($('#asprod_hentrega').val());		
		var sprod_comentario = $.trim($('#asprod_comentario').val());
		
		if(sprod_id == ''){
			sweet_alert('Error: Selecione una solicitud');	
			return false;
		}			
		
		var aceptado = 'N';		
		var cant_cero = 0;
		var mayor_stock = 0;
		$('.acheck_resolucion').each( function() {
			if(this.checked) {
				aceptado = 'S';				
				prod_codx = this.id;
				prodcod_split = prod_codx.split('___')
				prod_cod = prodcod_split[1]				
				cant = $('#acant_'+prod_cod).val();	
				stock = $('#astock_'+prod_cod).text();
				stock = parseInt(stock,10)
				if(cant > stock) mayor_stock = 1;	
				console.log(cant +'-'+stock)
				
				if(cant == 0) cant_cero = 1;
			}				
		})	
		
		
				
		if(sprod_dentrega == ''){
			sweet_alert('Error: Seleccionar fecha entrega');	
			return false;
		}	
		
		if(sprod_hentrega == ''){
			sweet_alert('Error: Seleccionar hora entrega');	
			return false;
		}	
		
		if(cant_cero){
			sweet_alert('Error: Todas las cantidades aceptadas deben ser mayor a cero');	
			return false;
		}			
		
		if(aceptado == 'N'){
			sweet_alert('Error: Debe seleccionar al menos un producto o en su defecto Rechazar la Solicitud');	
			return false;
		}				
		
		if(mayor_stock){
			sweet_alert('Error: No se puede aceptar una cantidad mayor al Stock existente');	
			return false;
		}			
		
		return true;
	}	
	

	$('#btn_mod_solicitud').click(function(){
	
		if (avalidar_resolucion()){
			$('#btn_mod_solicitud').prop( "disabled", true );
			$('#aloading').show();
			var sprod_id = $.trim($('#h_asprod_id').val());
			var sprod_dentrega = $.trim($('#asprod_dentrega').val());
			var sprod_hentrega = $.trim($('#asprod_hentrega').val());				
			var sprod_comentario = $.trim($('#asprod_comentario').val());
			
			var prod_cod = {};
			var sprodr_cant = {};
			var sprodr_estado = {};
			
			var i = 0;
			$('.acheck_resolucion').each( function() {
				prod_codx = this.id;
				prodcod_split = prod_codx.split('___')
				prod_cod[i] = prodcod_split[1]		
				sprodr_cant[i] = $('#acant_'+prod_cod[i]).val();
				prod_cod[i] = $('#acodprod_'+prod_cod[i]).text();
				if(this.checked) {
					sprodr_estado[i] = 'ACEPTADA';
				}else{
					sprodr_estado[i] = 'RECHAZADA';
				}
				i++;
			})
			
			var operacion = 'UPDATE SOLIC ACEPTADA';
			parametros = {	
							sprod_id:sprod_id,
							sprod_dentrega:sprod_dentrega,
							sprod_hentrega:sprod_hentrega,
							sprod_comentario:sprod_comentario,
							prod_cod: prod_cod,
							sprodr_cant: sprodr_cant,
							sprodr_estado: sprodr_estado,
							operacion:operacion
						 }		
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						abod_crud_solprod(resp)
				   },"json"
			)			
		}
		
	})	
	
	
	function avalidar_resolucion2(){

		var sprod_id = $.trim($('#h_asprod_id').val());
		var sprod_comentario = $.trim($('#asprod_comentario').val());
		
		if(sprod_id == ''){
			sweet_alert('Error: Selecione una solicitud');	
			return false;
		}
		
		if(sprod_comentario == ''){
			sweet_alert('Error: Ingresar motivo de rechazo');	
			return false;
		}
		
		return true;
	}
	
	
	$('#btn_rech_solicitud').click(function(){

		if (avalidar_resolucion2()){			
			
			swal({   
				title: "¿Seguro que deseas Rechazar esta Solicitud Aceptada previamente? ¿Indicó motivo de Rechazo?",   
				text: "No podrás deshacer este paso...",   
				type: "warning",   
				showCancelButton: true,
				cancelButtonText: "Mmm... mejor no",   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "¡Adelante!",   
				closeOnConfirm: false }, 

				function(){   
					$('#btn_rech_solicitud').prop( "disabled", true );
					$('#aaloading').show();
					var sprod_id = $.trim($('#h_asprod_id').val());
					var sprod_comentario = $.trim($('#asprod_comentario').val());
					var operacion = 'RECHAZAR SOLIC ACEPTADA';
					parametros = {	
									sprod_id:sprod_id,
									sprod_comentario:sprod_comentario,
									operacion:operacion
								 }		
					console.log(parametros)
					$.post(
						   "consultas/bod_crud_solprod.php",
						   parametros,			   
						   function(resp){
								abod_crud_solprod(resp)
						   },"json"
					)
			});										

		}	
	})	
	
	function avalidar_entrega(){

		var sprod_id = $.trim($('#h_asprod_id').val());
		var asprod_id_retira = $.trim($('#asprod_id_retira').val());
		var asprod_drentrega = $.trim($('#asprod_drentrega').val());
		var asprod_hrentrega = $.trim($('#asprod_hrentrega').val());
		
		if(sprod_id == ''){
			sweet_alert('Error: Selecione una solicitud');	
			return false;
		}
		
		if(asprod_id_retira == ''){
			sweet_alert('Error: Seleccione la persona quien retira');	
			return false;
		}
		
		if(asprod_drentrega == ''){
			sweet_alert('Error: Seleccione la fecha real de entrega');	
			return false;
		}		
		
		if(asprod_hrentrega == ''){
			sweet_alert('Error: Seleccione la hora real de entrega');	
			return false;
		}
		
		return true;
	}
	
	$('#btn_entrega_prod').click(function(){

		if (avalidar_entrega()){			
			$('#btn_entrega_prod').prop( "disabled", true );
			$('#aaloading').show();
			var sprod_id = $.trim($('#h_asprod_id').val());
			var sprod_id_retira = $.trim($('#asprod_id_retira').val());
			var sprod_drentrega = $.trim($('#asprod_drentrega').val());
			var sprod_hrentrega = $.trim($('#asprod_hrentrega').val());
			var operacion = 'ENTREGAR PRODUCTOS';
			parametros = {	
							sprod_id:sprod_id,
							sprod_id_retira:sprod_id_retira,
							sprod_drentrega:sprod_drentrega,
							sprod_hrentrega:sprod_hrentrega,
							operacion:operacion
						 }		
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						abod_crud_solprod(resp)
				   },"json"
			)
/*
			parametros = {	
							operacion:'EMAIL_FALTA_STOCK'
						 }				
			
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						console.log(resp)
				   },"json"
			)			
*/			
		}	
	})		
	


	function abod_crud_solprod(resp){
		$('#btn_mod_solicitud').prop( "disabled", false );
		$('#btn_rech_solicitud').prop( "disabled", false );
		$('#btn_entrega_prod').prop( "disabled", false );
		$('#aaloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];

			if(operacion == 'UPDATE SOLIC ACEPTADA'){
				swal("Sisconvi-Production", "Solicitud Modificada", "success");
			}
			else if(operacion == 'RECHAZAR SOLIC ACEPTADA'){
				swal("Sisconvi-Production", "Solicitud Rechazada", "success");
			}
			else if(operacion == 'ENTREGAR PRODUCTOS'){
				var sprod_id = resp['sprod_id'];
				//var url = '/proyecto/sisconvi-production/fpdf17/acta_entrega.php?sprod_id='+sprod_id;
				//window.location.href = url;
				//acta_entrega(sprod_id);
				
				acta_entrega(sprod_id, 'ACTA ENTREGA');
				swal("Sisconvi-Production", "Solicitud Entregada", "success");
			}				
			$('#tabla_solicitudes_aceptadas tbody').unbind( "click" );
			busqueda_solic_aceptadas();
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
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
	

	var xproductos_solicitados_entregados;	

	function ecrear_tabla_productos(sprod_id){

		xproductos_solicitados_entregados = $("#productos_solicitados_entregados").DataTable({
			
			responsive: true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solprod.php?prod_entregados=ok&sprod_id="+sprod_id,
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
			  $('#eloading').hide();
			}
		});
	
	}			
	
	
	
	function limpieza_resolucion(){
	
		$('#h_asprod_id').val('');
	
		$('#asprod_dentrega').val('');
		//$('#asprod_hentrega').val('').trigger('change');
		$('#asprod_comentario').val('');
		$('#productos_aceptados').empty();
		
		$('#asprod_drentrega').val('');
		$('#asprod_hrentrega').val('').trigger('change');		
		$('#asprod_id_retira').val('').trigger('change');
		//if(typeof productos_solicitados_aceptados != 'undefined') productos_solicitados_aceptados.destroy();		
	}
	
	function rlimpieza_resolucion(){
		$('#h_rsprod_id').val('');
		$('#rsprod_comentario').val('');	
		if(typeof productos_solicitados_rechazados != 'undefined') productos_solicitados_rechazados.destroy();		
	}		

	function elimpieza_resolucion(){
		$('#h_esprod_id').val('');
		$('#esprod_comentario').val('');	
		if(typeof xproductos_solicitados_entregados != 'undefined') xproductos_solicitados_entregados.destroy();		
	}		
	
	
	function rvalidar_cambio_resol(){
		
		var sprod_id = $.trim($('#h_rsprod_id').val());
		
		if(sprod_id == ''){
			sweet_alert('Error: Selecione una solicitud');	
			return false;
		}
		
		return true;
	}	
	
	
	$('#btn_cambiar_resol').click(function(){

		if (rvalidar_cambio_resol()){			
			
			swal({   
				title: "¿Seguro que deseas dejar Pendiente esta Solicitud Rechazada anteriormente?",   
				text: "No podrás deshacer este paso...",   
				type: "warning",   
				showCancelButton: true,
				cancelButtonText: "Mmm... mejor no",   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "¡Adelante!",   
				closeOnConfirm: false }, 

				function(){   
					$('#btn_cambiar_resol').prop( "disabled", true );
					$('#rrloading').show();
					var sprod_id = $.trim($('#h_rsprod_id').val());

					var operacion = 'CAMBIAR SOLIC RECHAZADA A PENDIENTE';
					parametros = {	
									sprod_id:sprod_id,
									operacion:operacion
								 }		
					console.log(parametros)
					$.post(
						   "consultas/bod_crud_solprod.php",
						   parametros,			   
						   function(resp){
								rbod_crud_solprod(resp)
						   },"json"
					)
			});										

		}	
	})	
	
	
	
	function rbod_crud_solprod(resp){
		$('#btn_cambiar_resol').prop( "disabled", false );
		$('#rrloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];

			if(operacion == 'CAMBIAR SOLIC RECHAZADA A PENDIENTE'){
				swal("Sisconvi-Production", "Solicitud Modificada", "success");
			}
			
			$('#tabla_solicitudes_rechazadas tbody').unbind( "click" );
			busqueda_solic_rechazadas();
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}		
	
	
	
	
	
	
	
	
//TAB SALIDAS DE BODEGA



	var stabla_solicitudes;
	//screar_tabla();
	function screar_tabla(){

		stabla_solicitudes = $("#stabla_solicitudes").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_solprod.php?salidabod=ok",
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'DESTINATARIO'},
				{ data:'QUIEN_RETIRA'},
				{ data:'FECHA_RENTREGA'},
				{ data:'UNDVIV_ID'},
				{ data:'SOLICITANTE_ID'},
				{ data:'DESTINATARIO_ID'},
				{ data:'QUIENRETIRA_ID'}
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
	
  
		$('#stabla_solicitudes tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				stabla_solicitudes.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			scancelar2();
			var obj_row = stabla_solicitudes.row(this).data();	

			$('#ssprod_id').val(obj_row.SPROD_ID);		
			$('#susr_solic').val(obj_row.SOLICITANTE_ID).trigger('change');
			$('#sUNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#ssprod_id_dest').val(obj_row.DESTINATARIO_ID).trigger('change');
			
			$('#sh_susr_solic').val(obj_row.SOLICITANTE_ID);
			$('#sh_UNDVIV_ID').val(obj_row.UNDVIV_ID);	
			$('#sh_sprod_id_dest').val(obj_row.DESTINATARIO_ID);
			
			$('#sh_ssprod_id_retira').val(obj_row.QUIENRETIRA_ID);
			
			$('#ssprod_id_retira').val(obj_row.QUIENRETIRA_ID).trigger('change');
			
			var fechahora_entrega = obj_row.FECHA_RENTREGA;
			fechahora_entrega = fechahora_entrega.split(' ');
	
			$('#ssprod_drentrega').val(fechahora_entrega[0]);
			$('#ssprod_hrentrega').val(fechahora_entrega[1]).trigger('change');	
			
			$('#sh_ssprod_drentrega').val(fechahora_entrega[0]);
			$('#sh_ssprod_hrentrega').val(fechahora_entrega[1]);			
			
			deshabilitar_encabezado(obj_row.SPROD_ID)

			if(typeof stabla_productos != 'undefined')
			$('#stabla_productos tbody').unbind( "click" );
			stabla_productos.destroy();			
			screar_tabla_prod(obj_row.SPROD_ID)			
	
		});
	}




////////////TABLA PRODUCTOS/////////////////	
	
	var stabla_productos;
	//SE DESCONFIGURA TABLA PRODUCTOS CUANDO CAMBIA DE PESTAñA
	screar_tabla_prod(0);
	
	function screar_tabla_prod(nro_solicitud){

		stabla_productos = $("#stabla_productos").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_solprod.php?nro_solicitud="+nro_solicitud,			
			bProcessing: true,

			columns: [
				{ data:'CATPROD_ID'},
				{ data:'PROD_COD'},
				{ data:'CATPROD_NOMBRE'},				
				{ data:'PROD_NOMBRE'},	
				{ data:'SPRODD_CANT'}
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			}
		});
	
		$('#stabla_productos tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				stabla_productos.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}

			var obj_row = stabla_productos.row(this).data();	
			
			
			$('#sh_flag_rowprod').val('x');
			$('#sh_prod_cod').val(obj_row.PROD_COD);
			$('#scatprod_id').val(obj_row.CATPROD_ID).trigger('change');
			$('#ssprodd_cant').val(obj_row.SPRODD_CANT);
			
			$('#sbtn_reg_prod').hide();
			$('#sbtn_upd_prod').show();
			$('#sbtn_del_prod').show();
			$('#sbtn_can_prod').show();					

		});
		
	}
	
	
	
	

	
	
	
	function scancelar(){
		$('#sform_sprod')[0].reset();

		$('#sbtn_reg_prod').show();
		$('#sbtn_upd_prod').hide();
		$('#sbtn_del_prod').hide();
		$('#sbtn_can_prod').hide();
		stabla_productos.$('tr.selected').removeClass('selected');
		$('#scatprod_id').val('').trigger('change');
		clear_combobox('sprod_cod',1);	
	}
	
	function scancelar2(){
		$('#sform_sprod')[0].reset();

		$('#sbtn_reg_prod').show();
		$('#sbtn_upd_prod').hide();
		$('#sbtn_del_prod').hide();
		$('#sbtn_can_prod').hide();
		$('#scatprod_id').val('').trigger('change');
		clear_combobox('sprod_cod',1);	
	}		
	
	function hide_btnshead(){
		$('#sbtn_regrep_sprod').hide();
		$('#sbtn_canrep_sprod').hide();
		$('#sbtn_updhead_sprod').hide();
		$('#sbtn_canupdhead_sprod').hide();	
		$('#destinatario_multiple').hide();
		$('#ssprod_ids_dest').val('').trigger('change');
		}
	
	
	function deshabilitar_encabezado(sprod_id){
		//$('#per_agno').prop( "disabled", true );
		//$('#sem_num').prop( "disabled", true );
		//$('#sprod_dia').prop( "disabled", true );
		$('#sUNDVIV_ID').prop( "disabled", true );	
		$('#ssprod_id_dest').prop( "disabled", true );
		
		$('#ssprod_id_retira').prop( "disabled", true );
		$('#ssprod_drentrega').prop( "disabled", true );
		$('#ssprod_hrentrega').prop( "disabled", true );
		$('#susr_solic').prop( "disabled", true );
		
		$('#ssprod_id').val(sprod_id);
		
		$('#sbtn_can_sprod').show();
		$('#sbtn_rep_sprod').show();	
		$('#sbtn_del_sprod').show();
		$('#sbtn_upd_sprod').show();
		$('#sbtn_acta_entrega').show();
		$('#sbtn_acta_entregadoc').show();
		
		hide_btnshead();
	}	
	
	function habilitar_encabezado(){
		//$('#per_agno').prop( "disabled", true );
		//$('#sem_num').prop( "disabled", true );
		//$('#sprod_dia').prop( "disabled", true );
		$('#sUNDVIV_ID').prop( "disabled", false );	
		$('#ssprod_id_dest').prop( "disabled", false );	
		
		$('#ssprod_id_retira').prop( "disabled", false );
		$('#ssprod_drentrega').prop( "disabled", false );
		$('#ssprod_hrentrega').prop( "disabled", false );
		$('#susr_solic').prop( "disabled", false );		
		
		$('#sUNDVIV_ID').val('').trigger('change');
		$('#ssprod_id_dest').val('').trigger('change');
		
		$('#ssprod_id_retira').val('').trigger('change');
		$('#ssprod_drentrega').val('');
		$('#ssprod_hrentrega').val('').trigger('change');
		$('#susr_solic').val('').trigger('change');
		
		$('#ssprod_id').val('');
		
		hide_btnshead();
		
		$('#scatprod_id').prop( "disabled", false );
		$('#sprod_cod').prop( "disabled", false );
		$('#ssprodd_cant').prop( "disabled", false );			
		
	}		
	
////////////EVENTO CLICK/////////////////		
	
	$('#sbtn_rep_sprod').click(function(){

		$('#destinatario_multiple').show();

		$('#ssprod_ids_dest').select2({			
			allowClear: true
		});		
		
		$('#sUNDVIV_ID').prop( "disabled", true );	

		$('#sbtn_updhead_sprod').hide();
		$('#sbtn_canupdhead_sprod').hide();		
		$('#sbtn_regrep_sprod').show();
		$('#sbtn_canrep_sprod').show();
		
		scancelar();
		$('#scatprod_id').prop( "disabled", true );
		$('#sprod_cod').prop( "disabled", true );
		$('#ssprodd_cant').prop( "disabled", true );			
	})		
	
	
	
	$('#sbtn_canupdhead_sprod').click(function(){
		$('#sUNDVIV_ID').prop( "disabled", true );	
		$('#ssprod_id_dest').prop( "disabled", true );
		
		$('#ssprod_id_retira').prop( "disabled", true );
		$('#ssprod_drentrega').prop( "disabled", true );
		$('#ssprod_hrentrega').prop( "disabled", true );
		$('#susr_solic').prop( "disabled", true );		
		
		hide_btnshead();
		scancelar();
		
		UNDVIV_ID = $('#sh_UNDVIV_ID').val();	 
		sprod_id_dest = $('#sh_sprod_id_dest').val();
		
		susr_solic = $('#sh_susr_solic').val();
		ssprod_id_retira = $('#sh_ssprod_id_retira').val();
		ssprod_drentrega = $('#sh_ssprod_drentrega').val();
		ssprod_hrentrega = $('#sh_ssprod_hrentrega').val();	
		
		
		$('#sUNDVIV_ID').val(UNDVIV_ID).trigger('change');
		$('#ssprod_id_dest').val(sprod_id_dest).trigger('change');
		
		$('#susr_solic').val(susr_solic).trigger('change');
		$('#ssprod_id_retira').val(ssprod_id_retira).trigger('change');
		$('#ssprod_drentrega').val(ssprod_drentrega);
		$('#ssprod_hrentrega').val(ssprod_hrentrega).trigger('change');
		
		
		$('#scatprod_id').prop( "disabled", false );
		$('#sprod_cod').prop( "disabled", false );
		$('#ssprodd_cant').prop( "disabled", false );

	})		
	
	$('#sbtn_canrep_sprod').click(function(){
		$('#sUNDVIV_ID').prop( "disabled", true );	
		$('#ssprod_id_dest').prop( "disabled", true );
		
		$('#ssprod_id_retira').prop( "disabled", true );
		$('#ssprod_drentrega').prop( "disabled", true );
		$('#ssprod_hrentrega').prop( "disabled", true );
		$('#susr_solic').prop( "disabled", true );		
		
		hide_btnshead();
		scancelar();
		
		UNDVIV_ID = $('#sh_UNDVIV_ID').val();	 
		sprod_id_dest = $('#sh_sprod_id_dest').val();
		
		susr_solic = $('#sh_susr_solic').val();
		ssprod_id_retira = $('#sh_ssprod_id_retira').val();
		ssprod_drentrega = $('#sh_ssprod_drentrega').val();
		ssprod_hrentrega = $('#sh_ssprod_hrentrega').val();	
		
		
		$('#sUNDVIV_ID').val(UNDVIV_ID).trigger('change');
		$('#ssprod_id_dest').val(sprod_id_dest).trigger('change');
		
		$('#susr_solic').val(susr_solic).trigger('change');
		$('#ssprod_id_retira').val(ssprod_id_retira).trigger('change');
		$('#ssprod_drentrega').val(ssprod_drentrega);
		$('#ssprod_hrentrega').val(ssprod_hrentrega).trigger('change');		
		
		$('#scatprod_id').prop( "disabled", false );
		$('#sprod_cod').prop( "disabled", false );
		$('#ssprodd_cant').prop( "disabled", false );

	})		
	
	
	
	$('#sbtn_upd_sprod').click(function(){
		$('#sUNDVIV_ID').prop( "disabled", false );	
		$('#ssprod_id_dest').prop( "disabled", false );
		
		$('#ssprod_id_retira').prop( "disabled", false );
		$('#ssprod_drentrega').prop( "disabled", false );
		$('#ssprod_hrentrega').prop( "disabled", false );
		$('#susr_solic').prop( "disabled", false );				
		
		$('#sbtn_regrep_sprod').hide();
		$('#sbtn_canrep_sprod').hide();
		$('#sbtn_updhead_sprod').show();
		$('#sbtn_canupdhead_sprod').show();
		scancelar();
		$('#scatprod_id').prop( "disabled", true );
		$('#sprod_cod').prop( "disabled", true );
		$('#ssprodd_cant').prop( "disabled", true );

	})	
	
	$('#sbtn_can_prod').click(function(){
		scancelar();
	})
	
	
	$('#sbtn_can_sprod').click(function(){
		cancelacion_salida_bodega()
	})
	
	
	function cancelacion_salida_bodega(){
		scancelar();
		$('#stabla_productos tbody').unbind( "click" );
		stabla_productos.destroy();
		screar_tabla_prod(0);		
		habilitar_encabezado();	
		
		$('#sbtn_can_sprod').hide();
		$('#sbtn_rep_sprod').hide();
		$('#sbtn_del_sprod').hide();	
		$('#sbtn_upd_sprod').hide();	
		$('#sbtn_acta_entrega').hide();	
		$('#sbtn_acta_entregadoc').hide();
	}
	
	
	

	function validar_head_solic(){
		
		var sprod_id = $.trim($('#ssprod_id').val());
		var usr_solic = $.trim($('#susr_solic').val());
		var per_agno = $.trim($('#sper_agno').val());
		var sem_num = $.trim($('#ssem_num').val());		
		var sprod_dia = $.trim($('#ssprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
		var destinatario = $.trim($('#ssprod_id_dest').val());
		
		var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
		var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
		var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());			

		if(sprod_id == ''){
			sweet_alert('Error: Nro Solicitud inexistente, favor refrescar página');	
			return false;
		}	
		
		if(usr_solic == ''){
			sweet_alert('Error: Seleccionar solicitante');	
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
		
		if(sprod_id_retira == ''){
			sweet_alert('Error: Seleccionar quien retira');	
			return false;
		}	
		
		if(sprod_drentrega == ''){
			sweet_alert('Error: Seleccionar día de entrega');	
			return false;
		}	
		
		if(sprod_hrentrega == ''){
			sweet_alert('Error: Seleccionar hora de entrega');	
			return false;
		}			
		
		return true;
	}
	
	
	function validar_head_solic_rep(){
		
		var sprod_id = $.trim($('#ssprod_id').val());
		var usr_solic = $.trim($('#susr_solic').val());
		var per_agno = $.trim($('#sper_agno').val());
		var sem_num = $.trim($('#ssem_num').val());		
		var sprod_dia = $.trim($('#ssprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
		var destinatarios = $.trim($('#ssprod_ids_dest').val());
		
		var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
		var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
		var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());			

		if(sprod_id == ''){
			sweet_alert('Error: Nro Solicitud inexistente, favor refrescar página');	
			return false;
		}	
		
		if(usr_solic == ''){
			sweet_alert('Error: Seleccionar solicitante');	
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
		
		if(sprod_id_retira == ''){
			sweet_alert('Error: Seleccionar quien retira');	
			return false;
		}	
		
		if(sprod_drentrega == ''){
			sweet_alert('Error: Seleccionar día de entrega');	
			return false;
		}	
		
		if(sprod_hrentrega == ''){
			sweet_alert('Error: Seleccionar hora de entrega');	
			return false;
		}			
		
		return true;
	}	
	
	
	
	function validar_prod(){

		var catprod_id = $.trim($('#scatprod_id').val());
		var prod_cod = $.trim($('#sprod_cod').val());
		var sprodd_cant = $.trim($('#ssprodd_cant').val());
		
		var usr_solic = $.trim($('#susr_solic').val());
		var per_agno = $.trim($('#sper_agno').val());
		var sem_num = $.trim($('#ssem_num').val());		
		var sprod_dia = $.trim($('#ssprod_dia').val());
		
		var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
		var destinatario = $.trim($('#ssprod_id_dest').val());
		
		var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
		var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
		var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());	
		
		var nombre_material = $("#sprod_cod option:selected").text();
		var stock_1 = nombre_material.split('(STOCK: ')
		var stock = parseInt(stock_1[1], 10);		

		if(usr_solic == ''){
			sweet_alert('Error: Seleccionar solicitante');	
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
		
		if(sprod_id_retira == ''){
			sweet_alert('Error: Seleccionar quien retira');	
			return false;
		}	
		
		if(sprod_drentrega == ''){
			sweet_alert('Error: Seleccionar día de entrega');	
			return false;
		}	
		
		if(sprod_hrentrega == ''){
			sweet_alert('Error: Seleccionar hora de entrega');	
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

	
	
	
	$('#sbtn_updhead_sprod').click(function(){

		if (validar_head_solic()){	
			$('#sbtn_updhead_sprod').prop( "disabled", true );
			$('#sloading').show();
			
			var sprod_id = $.trim($('#ssprod_id').val());
			var usr_solic = $.trim($('#susr_solic').val());
			var per_agno = $.trim($('#sper_agno').val());
			var sem_num = $.trim($('#ssem_num').val());		
			var sprod_dia = $.trim($('#ssprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
			var destinatario = $.trim($('#ssprod_id_dest').val());
			
			var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
			var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
			var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());					
						
			var operacion = 'UPDATE_HEAD SB';
			parametros = {			
							sprod_id:sprod_id,
							usr_solic:usr_solic,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							destinatario:destinatario,
							sprod_id_retira:sprod_id_retira,
							sprod_drentrega:sprod_drentrega,
							sprod_hrentrega:sprod_hrentrega,							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						sbod_crud_solprod(resp)
				   },"json"
			)
		}	
	})			
	
	
	
	
	$('#sbtn_regrep_sprod').click(function(){

		if (validar_head_solic_rep()){	
			$('#sbtn_regrep_sprod').prop( "disabled", true );
			$('#sloading').show();
			
			var sprod_id = $.trim($('#ssprod_id').val());
			var usr_solic = $.trim($('#susr_solic').val());
			var per_agno = $.trim($('#sper_agno').val());
			var sem_num = $.trim($('#ssem_num').val());		
			var sprod_dia = $.trim($('#ssprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
			var destinatarios = $.trim($('#ssprod_ids_dest').val());	
			
			var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
			var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
			var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());				
					
			var operacion = 'REPLICAR_SOLICITUD SB';
			parametros = {			
							sprod_id:sprod_id,
							usr_solic:usr_solic,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							destinatarios:destinatarios,
							sprod_id_retira:sprod_id_retira,
							sprod_drentrega:sprod_drentrega,
							sprod_hrentrega:sprod_hrentrega,							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						sbod_crud_solprod(resp)
				   },"json"
			)
		}
	})		
	
	
	
		  
	$('#sbtn_reg_prod').click(function(){

		if (validar_prod()){	
			$('#sbtn_reg_prod').prop( "disabled", true );
			$('#sloading').show();
			
			var sprod_id = $.trim($('#ssprod_id').val());
			var usr_solic = $.trim($('#susr_solic').val());
			
			var per_agno = $.trim($('#sper_agno').val());
			var sem_num = $.trim($('#ssem_num').val());		
			var sprod_dia = $.trim($('#ssprod_dia').val());
			
			var UNDVIV_ID = $.trim($('#sUNDVIV_ID').val());
			var destinatario = $.trim($('#ssprod_id_dest').val());
			
			var sprod_id_retira = $.trim($('#ssprod_id_retira').val());
			var sprod_drentrega = $.trim($('#ssprod_drentrega').val());
			var sprod_hrentrega = $.trim($('#ssprod_hrentrega').val());			
			
			var prod_cod = $.trim($('#sprod_cod').val());
			var sprodd_cant = $.trim($('#ssprodd_cant').val());
			
			var operacion = 'INSERT SB';
			parametros = {			
							sprod_id:sprod_id,
							usr_solic:usr_solic,
							per_agno:per_agno,
							sem_num:sem_num,
							sprod_dia:sprod_dia,
							UNDVIV_ID:UNDVIV_ID,
							destinatario:destinatario,
							sprod_id_retira:sprod_id_retira,
							sprod_drentrega:sprod_drentrega,
							sprod_hrentrega:sprod_hrentrega,
							prod_cod:prod_cod,
							sprodd_cant:sprodd_cant,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						sbod_crud_solprod(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#sbtn_upd_prod').click(function(){
		if (validar_prod()){	
			$('#sbtn_upd_prod').prop( "disabled", true );
			$('#sloading').show();
			
			var sprod_id = $.trim($('#ssprod_id').val());
			var h_prod_cod = $.trim($('#sh_prod_cod').val());
			var prod_cod = $.trim($('#sprod_cod').val());
			var sprodd_cant = $.trim($('#ssprodd_cant').val());
			
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
						sbod_crud_solprod(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#sbtn_del_prod').click(function(){

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
				$('#sbtn_del_prod').prop( "disabled", true );
				$('#sloading').show();
				var sprod_id = $.trim($('#ssprod_id').val());
				var h_prod_cod = $.trim($('#sh_prod_cod').val());
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
							sbod_crud_solprod(resp)
					   },"json"
				)
		});	
		
	})
	
	
 	$('#sbtn_del_sprod').click(function(){

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
				$('#sbtn_del_prod').prop( "disabled", true );
				$('#sloading').show();
				var sprod_id = $.trim($('#ssprod_id').val());
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
							sbod_crud_solprod(resp)
					   },"json"
				)
		});	
		
	})	
	
	
	function sbod_crud_solprod(resp){
		$('#sbtn_updhead_sprod').prop( "disabled", false );
		$('#sbtn_regrep_sprod').prop( "disabled", false );
		$('#sbtn_reg_prod').prop( "disabled", false );
		$('#sbtn_upd_prod').prop( "disabled", false );
		$('#sbtn_del_prod').prop( "disabled", false );
		$('#sloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			scancelar();
			var sprod_id = resp['sprod_id'];
			if(operacion == 'INSERT SB'){
				swal("Sisconvi-Production", "Producto registrado, Nro Solicitud: "+sprod_id, "success");				
				deshabilitar_encabezado(sprod_id);	
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Producto modificado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'UPDATE_HEAD SB'){
				swal("Sisconvi-Production", "Solicitud modificada", "success");
				actualizar_tabla_solicitud();
				deshabilitar_encabezado(sprod_id);	
				$('#scatprod_id').prop( "disabled", false );
				$('#sprod_cod').prop( "disabled", false );
				$('#ssprodd_cant').prop( "disabled", false );				
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Producto eliminado", "success");
				actualizar_tabla_producto(sprod_id);
			}else if(operacion == 'DELETE ALL'){
				swal("Sisconvi-Production", "Solicitud eliminada", "success");
				habilitar_encabezado();
				actualizar_tabla_solicitud();
				actualizar_tabla_producto(sprod_id);
				$('#sbtn_can_sprod').hide();
				$('#sbtn_rep_sprod').hide();
				$('#sbtn_del_sprod').hide();	
				$('#sbtn_upd_sprod').hide();
				$('#sbtn_acta_entrega').hide();
				$('#sbtn_acta_entregadoc').hide();
			}else if(operacion == 'REPLICAR_SOLICITUD SB'){
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
		$('#stabla_solicitudes tbody').unbind( "click" );
		stabla_solicitudes.destroy();		
		screar_tabla();
	}
	
	
	function actualizar_tabla_producto(sprod_id){
		$('#stabla_productos tbody').unbind( "click" );
		stabla_productos.destroy();
		screar_tabla_prod(sprod_id);					
	}	
	
	
	
 	$('#ebtn_acta_entrega').click(function(){

		var sprod_id = $.trim($('#h_esprod_id').val());
		//console.log(sprod_id)
		acta_entrega(sprod_id, 'ACTA ENTREGA');
	})	
	
 	$('#sbtn_acta_entrega').click(function(){
		
		var sprod_id = $.trim($('#ssprod_id').val());
		acta_entrega(sprod_id, 'ACTA ENTREGA Y REBAJA STOCK');
	})		
	
 	$('#sbtn_acta_entregadoc').click(function(){
		
		var sprod_id = $.trim($('#ssprod_id').val());
		acta_entrega(sprod_id, 'ACTA ENTREGA');
	})		
	
	function acta_entrega(sprod_id, operacion){
		
		if(operacion == 'ACTA ENTREGA Y REBAJA STOCK'){
			parametros = {
							sprod_id:sprod_id,
							operacion:operacion
						 }		
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solprod.php",
				   parametros,			   
				   function(resp){
						var cod_resp = resp['cod'];
						if(cod_resp == 'ok'){
							var url = '/proyecto/sisconvi-production/Informes/acta_entrega.php?sprod_id='+sprod_id;
							//var url = '/proyecto/sisconvi-production/Informes/acta_entrega.php?sprod_id='+sprod_id;
							window.location.href = url;								
						}else{
							var desc_error = resp['desc'];
							swal("Sisconvi-Production", desc_error, "error");							
						}
				   },"json"
			)			
		}		
		else{
			var url = '/proyecto/sisconvi-production/Informes/acta_entrega.php?sprod_id='+sprod_id;
			//var url = '/proyecto/sisconvi-production/Informes/acta_entrega.php?sprod_id='+sprod_id;
			window.location.href = url;							
		}


	
	}
	
	
	
	
	
});