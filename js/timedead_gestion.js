$(document).ready(function(){

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}
	
	$("#ctrltd_hrini").select2({	});
	$("#ctrltd_minini").select2({	});	
	
	$("#ctrltd_hrfin").select2({	});
	$("#ctrltd_minfin").select2({	});		
		
	
	$("#dctrltd_hrini").select2({	});
	$("#dctrltd_minini").select2({	});
	
	$("#dctrltd_hrfin").select2({	});
	$("#dctrltd_minfin").select2({	});
	
	$("#ctiempo_cod").select2({	});
	$("#time_dead").select2({ placeholder: "SELECCIONE TIEMPO(S) MUERTO(S)"	});
	
	

//MANTENCIONES SANITIZADO
	
	$('#ctrltd_frcamboq').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_frcamboq").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_cantcamboq').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_cantcamboq").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_frlavboq').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_frlavboq").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_cantlavboq').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_cantlavboq").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	
//BANDEJA 88 CAV
	
	$('#ctrltd_88buencorteza').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88buencorteza").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	

	$('#ctrltd_88defcorteza').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88defcorteza").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});		
	
	$('#ctrltd_88buenturba').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88buenturba").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	

	$('#ctrltd_88defturba').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88defturba").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	

	$('#ctrltd_88buensanitizado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88buensanitizado").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	

	$('#ctrltd_88defsanitizado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_88defsanitizado").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});		
	
	
//BANDEJA 45 CAV
	
	$('#ctrltd_45buencorteza').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45buencorteza").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_45defcorteza').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45defcorteza").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});		
	
	$('#ctrltd_45buenturba').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45buenturba").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_45defturba').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45defturba").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});

	$('#ctrltd_45buensanitizado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45buensanitizado").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_45defsanitizado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_45defsanitizado").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	
//CONSUMOS
	
	$('#ctrltd_sacoturba').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_sacoturba").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});		
	
	$('#ctrltd_sacoperlita').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_sacoperlita").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_basacote').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_basacote").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrltd_osmocote').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_osmocote").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});

	$('#ctrltd_vermiculita').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrltd_vermiculita").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	
	
	/*
	$('a[data-toggle="tab"]').on('click', function(){
	  if ($(this).parent('li').hasClass('disabled')) {
		return false;
	  };
	});	
	*/
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		
		if(target == "#tab1primary"){ 

			$('#tabla_regtimedead tbody').unbind( "click" );
			table_detalle.destroy();
			
			ctrltd_id = $('#ctrltd_id').val();
//console.log(ctrltd_id)			
			crear_tabla_detalle(ctrltd_id);	  
		}
	})
	
	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 5 segundos.",
			type: "error", 
			timer: 5000,
			showConfirmButton: true 
		});			
	}	
	
	function sweet_success(title){
		swal({ 
			title: title,
			type: "success" 

			},function() {
				$('#tabla_regtimedead tbody').unbind( "click" );
				table_detalle.destroy();				
				ctrltd_id = $('#ctrltd_id').val();
				crear_tabla_detalle(ctrltd_id);
			}
		);			
	}

	
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	 
			ajax: "consultas/time_crud_gestion.php?data=a",
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			//scroller:       true,
			//bProcessing: 	true,
			paging: false,			
			//order:[],
			
			columnDefs: [
				{ targets: [0,4,6,8], visible: false},
				{ targets: '_all', visible: true }			
			],			
			
			columns: [
				 { data:'CTRLTD_ID'}            			              
				,{ data:'PER_AGNO'}
				,{ data:'SEM_NUM'}
				,{ data:'CTRLTD_DIA'}
				,{ data:'SUP_RUT'}
				,{ data:'SUPERVISOR'}			
				,{ data:'OPER_RUT'}             
				,{ data:'OPERARIO'}			              
				,{ data:'LIN_ID'}               
				,{ data:'LIN_NOMBRE'}
				,{ data:'CTRLTD_HRINI'}         
				,{ data:'CTRLTD_HRFIN'}         
				,{ data:'CTRLTD_SACOTURBA'}     
				,{ data:'CTRLTD_SACOPERLITA'}   
				,{ data:'CTRLTD_BASACOTE'}      
				,{ data:'CTRLTD_OSMOCOTE'}      
				,{ data:'CTRLTD_VERMICULITA'}
				,{ data:'CTRLTD_FRCAMBOQ'}      
				,{ data:'CTRLTD_CANTCAMBOQ'}    
				,{ data:'CTRLTD_FRLAVBOQ'}      
				,{ data:'CTRLTD_CANTLAVBOQ'}    
				,{ data:'CTRLTD_88BUENCORTEZA'} 
				,{ data:'CTRLTD_88DEFCORTEZA'}
				,{ data:'CTRLTD_88TOTALCORTEZA'}			
				,{ data:'CTRLTD_45BUENCORTEZA'} 
				,{ data:'CTRLTD_45DEFCORTEZA'}
				,{ data:'CTRLTD_45TOTALCORTEZA'}
				,{ data:'CTRLTD_88_45TOTALCORTEZA'}
				,{ data:'CTRLTD_88BUENTURBA'}   
				,{ data:'CTRLTD_88DEFTURBA'}
				,{ data:'CTRLTD_88TOTALTURBA'}
				,{ data:'CTRLTD_45BUENTURBA'}   
				,{ data:'CTRLTD_45DEFTURBA'}
				,{ data:'CTRLTD_45TOTALTURBA'}			
				,{ data:'CTRLTD_88_45TOTALTURBA'}
				,{ data:'CTRLTD_88BUENSANITIZADO'} 
				,{ data:'CTRLTD_88DEFSANITIZADO'}
				,{ data:'CTRLTD_88TOTALSANITIZADO'}
				,{ data:'CTRLTD_45BUENSANITIZADO'} 
				,{ data:'CTRLTD_45DEFSANITIZADO'}
				,{ data:'CTRLTD_45TOTALSANITIZADO'}
				,{ data:'CTRLTD_88_45TOTALSANITIZADO'}
			],

			//searching:true,
			dom: "Bfrtip",
			
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

			//responsive: true,

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
			$('#ctrltd_id').val(obj_row.CTRLTD_ID);
			$('#sup_rut').val(obj_row.SUP_RUT).trigger('change');
			$('#oper_rut').val(obj_row.OPER_RUT).trigger('change');
			$('#lin_id').val(obj_row.LIN_ID).trigger('change');

/*Año/Semana/Día*/

			$('#h_sem_num').val(obj_row.SEM_NUM);
			
			var dia_1 = obj_row.CTRLTD_DIA
			var dia_2 = dia_1.replace('-', '').replace('-', '');
			$('#h_ctrltd_dia').val(dia_2);
			
			$('#per_agno').val(obj_row.PER_AGNO).trigger('change');
			
/*----------------------*/
			
			var hr_ini_1 = obj_row.CTRLTD_HRINI
			var hr_ini_2 = hr_ini_1.split(':');
			var hr_ini_3 = hr_ini_2[0];
			var hr_ini_4 = hr_ini_2[1];
			
			$('#ctrltd_hrini').val(hr_ini_3).trigger('change');
			$('#ctrltd_minini').val(hr_ini_4).trigger('change');
			
			var hr_fin_1 = obj_row.CTRLTD_HRFIN
			var hr_fin_2 = hr_fin_1.split(':');
			var hr_fin_3 = hr_fin_2[0];
			var hr_fin_4 = hr_fin_2[1];
			
			$('#ctrltd_hrfin').val(hr_fin_3).trigger('change');
			$('#ctrltd_minfin').val(hr_fin_4).trigger('change');
			
			$('#ctrltd_frcamboq').val(obj_row.CTRLTD_FRCAMBOQ);
			$('#ctrltd_cantcamboq').val(obj_row.CTRLTD_CANTCAMBOQ);
			$('#ctrltd_frlavboq').val(obj_row.CTRLTD_FRLAVBOQ);
			$('#ctrltd_cantlavboq').val(obj_row.CTRLTD_CANTLAVBOQ);
			
			$('#ctrltd_sacoturba').val(obj_row.CTRLTD_SACOTURBA);
			$('#ctrltd_sacoperlita').val(obj_row.CTRLTD_SACOPERLITA);
			$('#ctrltd_basacote').val(obj_row.CTRLTD_BASACOTE);
			$('#ctrltd_osmocote').val(obj_row.CTRLTD_OSMOCOTE);
			$('#ctrltd_vermiculita').val(obj_row.CTRLTD_VERMICULITA);
			
			$('#ctrltd_88buencorteza').val(obj_row.CTRLTD_88BUENCORTEZA);
			$('#ctrltd_88defcorteza').val(obj_row.CTRLTD_88DEFCORTEZA);
			$('#ctrltd_88totalcorteza').val(obj_row.CTRLTD_88TOTALCORTEZA);
			$('#ctrltd_45buencorteza').val(obj_row.CTRLTD_45BUENCORTEZA);
			$('#ctrltd_45defcorteza').val(obj_row.CTRLTD_45DEFCORTEZA);
			$('#ctrltd_45totalcorteza').val(obj_row.CTRLTD_45TOTALCORTEZA);

			$('#ctrltd_88buenturba').val(obj_row.CTRLTD_88BUENTURBA);
			$('#ctrltd_88defturba').val(obj_row.CTRLTD_88DEFTURBA);
			$('#ctrltd_88totalturba').val(obj_row.CTRLTD_88TOTALTURBA);
			$('#ctrltd_45buenturba').val(obj_row.CTRLTD_45BUENTURBA);
			$('#ctrltd_45defturba').val(obj_row.CTRLTD_45DEFTURBA);
			$('#ctrltd_45totalturba').val(obj_row.CTRLTD_45TOTALTURBA);

			$('#ctrltd_88buensanitizado').val(obj_row.CTRLTD_88BUENSANITIZADO);
			$('#ctrltd_88defsanitizado').val(obj_row.CTRLTD_88DEFSANITIZADO);
			$('#ctrltd_88totalsanitizado').val(obj_row.CTRLTD_88TOTALSANITIZADO);
			$('#ctrltd_45buensanitizado').val(obj_row.CTRLTD_45BUENSANITIZADO);
			$('#ctrltd_45defsanitizado').val(obj_row.CTRLTD_45DEFSANITIZADO);
			$('#ctrltd_45totalsanitizado').val(obj_row.CTRLTD_45TOTALSANITIZADO);			

			$('#btn_reg_ctrltd').hide();
			$('#btn_upd_ctrltd').show();
			$('#btn_del_ctrltd').show();
			$('#btn_can_ctrltd').show();

			$('#btn_reg_dctrltd').show();
			$('#btn_upd_dctrltd').hide();
			$('#btn_del_dctrltd').hide();
			$('#btn_can_dctrltd').hide();

			$('#btn_reg_dctrltd').prop('disabled',false);
			$('#btn_mant_sanitizado').prop('disabled',false);
			$('#btn_ban88cav').prop('disabled',false);
			$('#btn_ban45cav').prop('disabled',false);
			$('#btn_consumos').prop('disabled',false);

			$('#tabla_regtimedead tbody').unbind( "click" );
			table_detalle.destroy();
			//console.log(obj_row.CTRLTD_ID)			
			crear_tabla_detalle(obj_row.CTRLTD_ID);	
			time_acum(obj_row.CTRLTD_ID);
			
			table.columns.adjust().draw();
		});
	}
	
	
	
//DETALLE

	var table_detalle;
	crear_tabla_detalle(0);
	
	function crear_tabla_detalle(ctrltd_id){
	
		table_detalle = $("#tabla_regtimedead").DataTable({
 
 
			columnDefs: [
				{ targets: [43,44,45,47,49,50], visible: true},
				{ targets: '_all', visible: false }			
			], 
			ajax: "consultas/time_crud_gestion.php?ctrltd_id="+ctrltd_id,
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'lin_id'},
				{ data:'lin_nombre'}
			],

			searching:true,
			dom: "Bfrtip",
			responsive: true,
 
 /*
			ajax: "consultas/time_crud_gestion.php?ctrltd_id="+ctrltd_id,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			paging: false,			
			order:[1, 'dsc'],
			
			columnDefs: [
				{ targets: [43,44,45,47,49,50], visible: true},
				{ targets: '_all', visible: false }			
			],				
*/			
			columns: [
				 { data:'CTRLTD_ID'}            			              
				,{ data:'PER_AGNO'}
				,{ data:'SEM_NUM'}
				,{ data:'CTRLTD_DIA'}
				,{ data:'SUP_RUT'}
				,{ data:'SUPERVISOR'}			
				,{ data:'OPER_RUT'}             
				,{ data:'OPERARIO'}			              
				,{ data:'LIN_ID'}               
				,{ data:'LIN_NOMBRE'}
				,{ data:'CTRLTD_HRINI'}         
				,{ data:'CTRLTD_HRFIN'}         
				,{ data:'CTRLTD_SACOTURBA'}     
				,{ data:'CTRLTD_SACOPERLITA'}   
				,{ data:'CTRLTD_BASACOTE'}      
				,{ data:'CTRLTD_OSMOCOTE'}      
				,{ data:'CTRLTD_VERMICULITA'}
				,{ data:'CTRLTD_FRCAMBOQ'}      
				,{ data:'CTRLTD_CANTCAMBOQ'}    
				,{ data:'CTRLTD_FRLAVBOQ'}      
				,{ data:'CTRLTD_CANTLAVBOQ'}    
				,{ data:'CTRLTD_88BUENCORTEZA'} 
				,{ data:'CTRLTD_88DEFCORTEZA'}
				,{ data:'CTRLTD_88TOTALCORTEZA'}			
				,{ data:'CTRLTD_45BUENCORTEZA'} 
				,{ data:'CTRLTD_45DEFCORTEZA'}
				,{ data:'CTRLTD_45TOTALCORTEZA'}
				,{ data:'CTRLTD_88_45TOTALCORTEZA'}
				,{ data:'CTRLTD_88BUENTURBA'}   
				,{ data:'CTRLTD_88DEFTURBA'}
				,{ data:'CTRLTD_88TOTALTURBA'}
				,{ data:'CTRLTD_45BUENTURBA'}   
				,{ data:'CTRLTD_45DEFTURBA'}
				,{ data:'CTRLTD_45TOTALTURBA'}			
				,{ data:'CTRLTD_88_45TOTALTURBA'}
				,{ data:'CTRLTD_88BUENSANITIZADO'} 
				,{ data:'CTRLTD_88DEFSANITIZADO'}
				,{ data:'CTRLTD_88TOTALSANITIZADO'}
				,{ data:'CTRLTD_45BUENSANITIZADO'} 
				,{ data:'CTRLTD_45DEFSANITIZADO'}
				,{ data:'CTRLTD_45TOTALSANITIZADO'}
				,{ data:'CTRLTD_88_45TOTALSANITIZADO'}				
				,{ data:'DCTRLTD_ID'}
				,{ data:'DCTRLTD_HRINI'}
				,{ data:'DCTRLTD_HRFIN'}
				,{ data:'DURACION'}
				,{ data:'UNDVIV_ID'}
				,{ data:'UNDVIV_NOMBRE'}
				,{ data:'CTIEMPO_COD'}
				,{ data:'CTIEMPO_CAUSA'}
				,{ data:'DCTRLTD_OBS'}				
			],

			//searching:true,
			//dom: "Bfrtip",
			
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

			//responsive: true,

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
	  
		$('#tabla_regtimedead tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table_detalle.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}			
			
			var obj_row = table_detalle.row(this).data();		
			$('#dctrltd_id').val(obj_row.DCTRLTD_ID);
			
			$('#h_ctiempo_cod').val(obj_row.CTIEMPO_COD);
			$('#undviv_id').val(obj_row.UNDVIV_ID).trigger('change');
			
			//$('#ctiempo_cod').val(obj_row.CTIEMPO_COD).trigger('change');
			
			
			$('#dctrltd_obs').val(obj_row.DCTRLTD_OBS);
			
			var hr_ini_1 = obj_row.DCTRLTD_HRINI
			var hr_ini_2 = hr_ini_1.split(':');
			var hr_ini_3 = hr_ini_2[0];
			var hr_ini_4 = hr_ini_2[1];
			
			$('#dctrltd_hrini').val(hr_ini_3).trigger('change');
			$('#dctrltd_minini').val(hr_ini_4).trigger('change');
			
			var hr_fin_1 = obj_row.DCTRLTD_HRFIN
			var hr_fin_2 = hr_fin_1.split(':');
			var hr_fin_3 = hr_fin_2[0];
			var hr_fin_4 = hr_fin_2[1];
			
			$('#dctrltd_hrfin').val(hr_fin_3).trigger('change');
			$('#dctrltd_minfin').val(hr_fin_4).trigger('change');


			$('#btn_reg_dctrltd').hide();
			$('#btn_upd_dctrltd').show();
			$('#btn_del_dctrltd').show();
			$('#btn_can_dctrltd').show();

		});
	}

	

	function time_acum(ctrltd_id){

		parametros = {
			tiempo_acumulado: '',
			ctrltd_id:ctrltd_id
		}	
		
		$('#ctrltd_acum').val('');
		$.post(
			"consultas/time_crud_gestion.php",
			parametros,			   
			function(resp){
				var time_acum = resp['tiempo_acumulado'];
				$('#ctrltd_acum').val(time_acum);
				
			},"json"
		)		
	}
	
	
	$('#btn_can_ctrltd').click(function(){
		cancelar();
	})
	
	function cancelar(){

		$('#form_ctrltd')[0].reset();
		$('#ctrltd_id').val('')
		$('#dctrltd_id').val('')
		
		$('#h_sem_num').val('');
		$('#h_ctrltd_dia').val('');
		$('#h_ctiempo_cod').val('');		
		
		$('#btn_reg_ctrltd').show();
		$('#btn_upd_ctrltd').hide();
		$('#btn_del_ctrltd').hide();
		$('#btn_can_ctrltd').hide();

		$('#btn_reg_dctrltd').show();
		$('#btn_upd_dctrltd').hide();
		$('#btn_del_dctrltd').hide();
		$('#btn_can_dctrltd').hide();

		$('#btn_reg_dctrltd').prop('disabled',true)		
		$('#btn_mant_sanitizado').prop('disabled',true)
		$('#btn_ban88cav').prop('disabled',true)
		$('#btn_ban45cav').prop('disabled',true)
		$('#btn_consumos').prop('disabled',true)

		$('#ctrltd_hrini').val('').trigger('change');
		$('#ctrltd_minini').val('').trigger('change');
		$('#ctrltd_hrfin').val('').trigger('change');
		$('#ctrltd_minfin').val('').trigger('change');
		$('#lin_id').val('').trigger('change');
		$('#sup_rut').val('').trigger('change');
		$('#oper_rut').val('').trigger('change');

		$('#undviv_id').val('').trigger('change');		
		clear_combobox('ctiempo_cod',1);
		
		clear_combobox('time_dead',1);
		//$('#ctiempo_cod').val('').trigger('change');
		$('#dctrltd_hrini').val('').trigger('change');
		$('#dctrltd_minini').val('').trigger('change');
		$('#dctrltd_hrfin').val('').trigger('change');
		$('#dctrltd_minfin').val('').trigger('change');

		$('#table_detalle tbody').unbind( "click" );
		table_detalle.destroy();
		crear_tabla_detalle(0);
	
		$('#per_agno').val(corresponding_agno).trigger('change');
		carga_semanas_ini();
	}
	

//CARGA INICIAL


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
	
	$('#per_agno').change(function() { 	change_agno()	});
	
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

	function carga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		
		h_sem_num = $('#h_sem_num').val();
		if(h_sem_num != '')	{
			$('#sem_num').val(h_sem_num).trigger('change');
		}else{
			change_sem_num();
		}
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

		$('#sem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
	}
		
	$('#sem_num').change(function() {
		//cancelar();
		change_sem_num();
	});

	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('ctrltd_dia',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}


	function carga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#ctrltd_dia').select2({			
			data:combobox
		});	

		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		
		h_ctrltd_dia = $('#h_ctrltd_dia').val();

		if(h_ctrltd_dia != '')	
		{
			$('#ctrltd_dia').val(h_ctrltd_dia).trigger('change');		
		}
		else{
			if(sem_num == corresponding_week && year_current == per_agno){
				$('#ctrltd_dia').val(date_current).trigger('change');
			}		
		}
	}


	//SUPERVISORES	
	load_supervisores();
	function load_supervisores(){
	
		var load = 'carga_inicial'

		parametros = {			
			load:load
		}	
		clear_combobox('sup_rut',1);
		$.post(
			"consultas/ges_crud_supervisores.php",
			parametros,			   
			function(resp){
				carga_supervisores(resp)
			},"json"
		)			
	}	

	function carga_supervisores(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
		}	
		
		$('#sup_rut').select2({			
			data:combobox
		})
	}


	//OPERADORES	
	carga_operadores()
	function carga_operadores(){
		
		var combobox = [];
		for(var i  = 0 ; i < data_operadores.length; i++) {
			combobox.push({id:data_operadores[i].OPER_RUT, text:data_operadores[i].OPERARIO});
		}	
		
		$('#oper_rut').select2({			
			data:combobox
		})
	}

	//LINEAS	
	carga_lineas()
	function carga_lineas(){
		
		var combobox = [];
		for(var i  = 0 ; i < data_lineas.length; i++) {
			combobox.push({id:data_lineas[i].lin_id, text:data_lineas[i].lin_nombre});
		}	
		
		$('#lin_id').select2({			
			data:combobox
		})
	}
/*
	//AREAS	
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
*/

	//UNID VIVEROS
	carga_unidviv();
	function carga_unidviv(){
		var combobox = [];
		for(var i  = 0 ; i < data_unidviv.length; i++) {
			combobox.push({id:data_unidviv[i].undviv_id, text:data_unidviv[i].undviv_nombre});
		}	
		
		$('#undviv_id').select2({			
			data:combobox
		});		
		
	}
/*
	//CAUSAS	
	carga_causas();
	function carga_causas(){
		var combobox = [];
		for(var i  = 0 ; i < data_causas.length; i++) {
			combobox.push({id:data_causas[i].ctiempo_cod, text:data_causas[i].causa});
		}	
		
		$('#ctiempo_cod').select2({			
			data:combobox
		});		
		
	}
*/

	$('#undviv_id').change(function() {

		var undviv_id = $('#undviv_id').val();

		if(undviv_id == ""){
			clear_combobox('ctiempo_cod',1);
		}
		else{
			parametros = {			
				causas:'carga',
				undviv_id:undviv_id
			}		
			clear_combobox('ctiempo_cod',1);
			$.post(
				"consultas/time_crud_causas.php",
				parametros,			   
				function(resp){
					carga_causas(resp)
				},"json"
				)	
		}

	});
	
	//CAUSAS
	function carga_causas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].ctiempo_cod, text:resp[i].causa});
		}	
		
		$('#ctiempo_cod').select2({			
			data:combobox
		})
		ctiempo_cod_selected = $('#h_ctiempo_cod').val();
		$('#ctiempo_cod').val(ctiempo_cod_selected).trigger('change');
	}

	
	function validar_ctrltd(){
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());
		var ctrltd_dia = $.trim($('#ctrltd_dia').val());
		var ctrltd_hrini = $.trim($('#ctrltd_hrini').val());
		var ctrltd_minini = $.trim($('#ctrltd_minini').val());
		var ctrltd_hrfin = $.trim($('#ctrltd_hrfin').val());
		var ctrltd_minfin = $.trim($('#ctrltd_minfin').val());
		var lin_id = $.trim($('#lin_id').val());
		var sup_rut = $.trim($('#sup_rut').val());
		var oper_rut = $.trim($('#oper_rut').val());
		
		if(per_agno == ''){
			sweet_alert('Error: Seleccionar año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Seleccionar semana');	
			return false;
		}		
		
		if(ctrltd_dia == ''){
			sweet_alert('Error: Seleccionar día');	
			return false;
		}
		
		if(ctrltd_hrini == '' || ctrltd_minini == ''){
			sweet_alert('Error: Seleccionar hora/min de inicio');	
			return false;
		}
	
		if(ctrltd_hrfin == '' || ctrltd_minfin == ''){
			sweet_alert('Error: Seleccionar hora/min de término');	
			return false;
		}		
	
/*		
		if(ctrltd_hrfin != '' && ctrltd_minfin == ''){
			sweet_alert('Error: Si selecciona hora de término debe indicar los minutos');	
			return false;
		}	

		if(ctrltd_hrfin == '' && ctrltd_minfin != ''){
			sweet_alert('Error: Si selecciona min de término debe indicar la hora');	
			return false;
		}		
*/		
		if(lin_id == ''){
			sweet_alert('Error: Seleccionar línea de producción');	
			return false;
		}

		if(sup_rut == ''){
			sweet_alert('Error: Seleccionar supervisor');	
			return false;
		}
		
		if(oper_rut == ''){
			sweet_alert('Error: Seleccionar operador');	
			return false;
		}
		
		//if(ctrltd_hrfin != '' && ctrltd_minfin != ''){
			hrini = parseInt(ctrltd_hrini);
			minini = parseInt(ctrltd_minini);
			hrfin = parseInt(ctrltd_hrfin);
			minfin = parseInt(ctrltd_minfin);
				
			if(hrini > hrfin){
				sweet_alert('Error: Hora de inicio no puede ser mayor a la hora de término');	
				return false;			
			}
			
			if(hrini == hrfin && minini > minfin){
				sweet_alert('Error: Hora de inicio no puede ser mayor a la hora de término');	
				return false;			
			}		
		//}
		
		return true;
	}
	  
	$('#btn_reg_ctrltd').click(function(){

		if (validar_ctrltd()){	

			$('#loading').show();
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());
			var ctrltd_dia = $.trim($('#ctrltd_dia').val());
			var ctrltd_hrini = $.trim($('#ctrltd_hrini').val());
			var ctrltd_minini = $.trim($('#ctrltd_minini').val());
			var ctrltd_hrfin = $.trim($('#ctrltd_hrfin').val());
			var ctrltd_minfin = $.trim($('#ctrltd_minfin').val());
			var lin_id = $.trim($('#lin_id').val());
			var sup_rut = $.trim($('#sup_rut').val());
			var oper_rut = $.trim($('#oper_rut').val());
			
			var operacion = 'INSERT';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							ctrltd_dia:ctrltd_dia,
							ctrltd_hrini:ctrltd_hrini,
							ctrltd_minini:ctrltd_minini,
							ctrltd_hrfin:ctrltd_hrfin,
							ctrltd_minfin:ctrltd_minfin,
							lin_id:lin_id,
							sup_rut:sup_rut,
							oper_rut:oper_rut,
							operacion:operacion
						 }

			console.log(parametros)
						 
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
						time_crud_gestion(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_ctrltd').click(function(){
		if (validar_ctrltd()){	

			$('#loading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());
			var ctrltd_dia = $.trim($('#ctrltd_dia').val());
			var ctrltd_hrini = $.trim($('#ctrltd_hrini').val());
			var ctrltd_minini = $.trim($('#ctrltd_minini').val());
			var ctrltd_hrfin = $.trim($('#ctrltd_hrfin').val());
			var ctrltd_minfin = $.trim($('#ctrltd_minfin').val());
			var lin_id = $.trim($('#lin_id').val());
			var sup_rut = $.trim($('#sup_rut').val());
			var oper_rut = $.trim($('#oper_rut').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							ctrltd_id:ctrltd_id,
							per_agno:per_agno,
							sem_num:sem_num,
							ctrltd_dia:ctrltd_dia,
							ctrltd_hrini:ctrltd_hrini,
							ctrltd_minini:ctrltd_minini,
							ctrltd_hrfin:ctrltd_hrfin,
							ctrltd_minfin:ctrltd_minfin,
							lin_id:lin_id,
							sup_rut:sup_rut,
							oper_rut:oper_rut,
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
						time_crud_gestion(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_ctrltd').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta gestión de tiempos muertos?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var ctrltd_id = $.trim($('#ctrltd_id').val());
				var operacion = 'DELETE';
				parametros = {	
								ctrltd_id:ctrltd_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_gestion.php",
					   parametros,			   
					   function(resp){
							time_crud_gestion(resp)
					   },"json"
				)
		});	
		
	})		
	
	function time_crud_gestion(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Gestión tiempos muertos registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Gestión tiempos muertos modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Gestión tiempos muertos eliminada", "success");
			}
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			
		}else{
			var desc_error = resp['desc'];
			sweet_alert(desc_error);
			//swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
	
//DETALLE TIEMPOS MUERTOS

	$('#btn_can_dctrltd').click(function(){
		cancelar_detalle();
	})
	
	function cancelar_detalle(){

		$('#btn_reg_dctrltd').show();
		$('#btn_upd_dctrltd').hide();
		$('#btn_del_dctrltd').hide();
		$('#btn_can_dctrltd').hide();

		$('#undviv_id').val('').trigger('change');
		$('#ctiempo_cod').val('').trigger('change');
		$('#dctrltd_hrini').val('').trigger('change');
		$('#dctrltd_minini').val('').trigger('change');
		$('#dctrltd_hrfin').val('').trigger('change');
		$('#dctrltd_minfin').val('').trigger('change');

		$('#dctrltd_obs').val('');

	}	

	function validar_dctrltd(){
		
		var ctrltd_id = $.trim($('#ctrltd_id').val());
		var undviv_id = $.trim($('#undviv_id').val());
		var ctiempo_cod = $.trim($('#ctiempo_cod').val());
		var dctrltd_hrini = $.trim($('#dctrltd_hrini').val());
		var dctrltd_minini = $.trim($('#dctrltd_minini').val());
		var dctrltd_hrfin = $.trim($('#dctrltd_hrfin').val());
		var dctrltd_minfin = $.trim($('#dctrltd_minfin').val());		
		var dctrltd_obs = $.trim($('#dctrltd_obs').val());

		if(ctrltd_id == ''){
			sweet_alert('Error: Seleccionar un caso del Listado Gestión Tiempos Muertos');	
			return false;
		}
	
		if(undviv_id == ''){
			sweet_alert('Error: Seleccionar unidad vivero');	
			return false;
		}
		
		if(ctiempo_cod == ''){
			sweet_alert('Error: Seleccionar causa');	
			return false;
		}		
				
		if(dctrltd_hrini == '' || dctrltd_minini == ''){
			sweet_alert('Error: Seleccionar hora/min de inicio');	
			return false;
		}
		
		if(dctrltd_hrfin == '' || dctrltd_minfin == ''){
			sweet_alert('Error: Seleccionar hora/min de término');	
			return false;
		}		
		/*
		if(dctrltd_obs == ''){
			sweet_alert('Error: ingresar observación');	
			return false;
		}
*/
		hrini = parseInt(dctrltd_hrini);
		minini = parseInt(dctrltd_minini);
		hrfin = parseInt(dctrltd_hrfin);
		minfin = parseInt(dctrltd_minfin);
			
		if(hrini > hrfin){
			sweet_alert('Error: Hora de inicio no puede ser mayor a la hora de término');	
			return false;			
		}
		
		if(hrini == hrfin && minini > minfin){
			sweet_alert('Error: Hora de inicio no puede ser mayor a la hora de término');	
			return false;			
		}		
			
		return true;
	}
	
	
	
	$('#btn_reg_dctrltd').click(function(){

		if (validar_dctrltd()){	

			$('#dloading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var undviv_id = $.trim($('#undviv_id').val());
			var ctiempo_cod = $.trim($('#ctiempo_cod').val());
			var dctrltd_hrini = $.trim($('#dctrltd_hrini').val());
			var dctrltd_minini = $.trim($('#dctrltd_minini').val());
			var dctrltd_hrfin = $.trim($('#dctrltd_hrfin').val());
			var dctrltd_minfin = $.trim($('#dctrltd_minfin').val());		
			var dctrltd_obs = $.trim($('#dctrltd_obs').val());
			
			var operacion = 'INSERT_DET';
			parametros = {
							ctrltd_id:ctrltd_id,
							undviv_id:undviv_id,
							ctiempo_cod:ctiempo_cod,
							dctrltd_hrini:dctrltd_hrini,
							dctrltd_minini:dctrltd_minini,
							dctrltd_hrfin:dctrltd_hrfin,
							dctrltd_minfin:dctrltd_minfin,
							dctrltd_obs:dctrltd_obs,
							operacion:operacion
						 }

			console.log(parametros)
						 
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
						time_crud_detalle(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_dctrltd').click(function(){
		
		if (validar_dctrltd()){	

			$('#dloading').show();
			var dctrltd_id = $.trim($('#dctrltd_id').val());
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var undviv_id = $.trim($('#undviv_id').val());
			var ctiempo_cod = $.trim($('#ctiempo_cod').val());
			var dctrltd_hrini = $.trim($('#dctrltd_hrini').val());
			var dctrltd_minini = $.trim($('#dctrltd_minini').val());
			var dctrltd_hrfin = $.trim($('#dctrltd_hrfin').val());
			var dctrltd_minfin = $.trim($('#dctrltd_minfin').val());		
			var dctrltd_obs = $.trim($('#dctrltd_obs').val());
			
			var operacion = 'UPDATE_DET';
			parametros = {	
							dctrltd_id:dctrltd_id,
							ctrltd_id:ctrltd_id,
							undviv_id:undviv_id,
							ctiempo_cod:ctiempo_cod,
							dctrltd_hrini:dctrltd_hrini,
							dctrltd_minini:dctrltd_minini,
							dctrltd_hrfin:dctrltd_hrfin,
							dctrltd_minfin:dctrltd_minfin,
							dctrltd_obs:dctrltd_obs,
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
						time_crud_detalle(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_dctrltd').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este tiempo muerto?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#dloading').show();
				var dctrltd_id = $.trim($('#dctrltd_id').val());
				var operacion = 'DELETE_DET';
				parametros = {	
								dctrltd_id:dctrltd_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_gestion.php",
					   parametros,			   
					   function(resp){
							time_crud_detalle(resp)
					   },"json"
				)
		});	
		
	})		
	
	function time_crud_detalle(resp){
		$('#dloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar_detalle();
			
			if(operacion == 'INSERT_DET'){
				swal("Sisconvi-Production", "Tiempo muerto registrado", "success");
			}else if(operacion == 'UPDATE_DET'){
				swal("Sisconvi-Production", "Tiempo muerto modificado", "success");
			}else if(operacion == 'DELETE_DET'){
				swal("Sisconvi-Production", "Tiempo muerto eliminado", "success");
			}
			
			$('#tabla_regtimedead tbody').unbind( "click" );
			table_detalle.destroy();				
			ctrltd_id = $('#ctrltd_id').val();
			crear_tabla_detalle(ctrltd_id);			
			time_acum(ctrltd_id);
/*
			if(operacion == 'INSERT_DET'){
				sweet_success("Tiempo muerto registrado")	
			}else if(operacion == 'UPDATE_DET'){				
				sweet_success("Tiempo muerto modificado")				
			}else if(operacion == 'DELETE_DET'){
				sweet_success("Tiempo muerto eliminado")	
			}			
*/			
		}else{
			var desc_error = resp['desc'];
			sweet_alert(desc_error);
			//swal("Sisconvi-Production", desc_error, "error");
		}
	}	


//MANTENCIONES SANITIZADO


	function validar_manctrltd(){
		
		var ctrltd_id = $.trim($('#ctrltd_id').val());
		var ctrltd_frcamboq = $.trim($('#ctrltd_frcamboq').val());
		var ctrltd_cantcamboq = $.trim($('#ctrltd_cantcamboq').val());
		var ctrltd_frlavboq = $.trim($('#ctrltd_frlavboq').val());
		var ctrltd_cantlavboq = $.trim($('#ctrltd_cantlavboq').val());

		if(ctrltd_id == ''){
			sweet_alert('Error: Seleccionar un caso del Listado Gestión Tiempos Muertos');	
			return false;
		}
	
		if(ctrltd_frcamboq == ''){
			sweet_alert('Error: Frecuencia de cambio de boquillas en blanco');	
			return false;
		}
		
		if(ctrltd_cantcamboq == ''){
			sweet_alert('Error: Cantidad de cambio de boquillas en blanco');	
			return false;
		}		
				
		if(ctrltd_frlavboq == ''){
			sweet_alert('Error: Frecuencia de lavado de boquillas en blanco');	
			return false;
		}
		
		if(ctrltd_cantlavboq == ''){
			sweet_alert('Error: Cantidad de lavado de boquillas en blanco');	
			return false;
		}	

		if(ctrltd_frcamboq > 0 && ctrltd_cantcamboq == 0){
			sweet_alert('Error: Si registras Frecuencia de cambio de boquillas debes indicar Cantidad mayor a 0');	
			return false;
		}	

		if(ctrltd_frcamboq == 0 && ctrltd_cantcamboq > 0){
			sweet_alert('Error: Si registras Cantidad de cambio de boquillas debes indicar Frecuencia mayor a 0');	
			return false;
		}	

		if(ctrltd_frlavboq > 0 && ctrltd_cantlavboq == 0){
			sweet_alert('Error: Si registras Frecuencia de lavado debes indicar Cantidad mayor a 0');	
			return false;
		}	

		if(ctrltd_frlavboq == 0 && ctrltd_cantlavboq > 0){
			sweet_alert('Error: Si registras Cantidad de lavado debes indicar Frecuencia mayor a 0');	
			return false;
		}	

		if(ctrltd_frcamboq > ctrltd_cantcamboq){
			sweet_alert('Error: Frecuencia de cambio de boquillas no puede ser mayor a la Cantidad');	
			return false;
		}		
			
		if(ctrltd_frlavboq > ctrltd_cantlavboq){
			sweet_alert('Error: Frecuencia de lavado de boquillas no puede ser mayor a la Cantidad');	
			return false;
		}			
			
		return true;
	}


 	$('#btn_mant_sanitizado').click(function(){
		
		if (validar_manctrltd()){	

			$('#manloading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var ctrltd_frcamboq = $.trim($('#ctrltd_frcamboq').val());
			var ctrltd_cantcamboq = $.trim($('#ctrltd_cantcamboq').val());
			var ctrltd_frlavboq = $.trim($('#ctrltd_frlavboq').val());
			var ctrltd_cantlavboq = $.trim($('#ctrltd_cantlavboq').val());
			
			var operacion = 'UPDATE_MAN';
			parametros = {	
							ctrltd_id:ctrltd_id,
							ctrltd_frcamboq:ctrltd_frcamboq,
							ctrltd_cantcamboq:ctrltd_cantcamboq,
							ctrltd_frlavboq:ctrltd_frlavboq,
							ctrltd_cantlavboq:ctrltd_cantlavboq,
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
					   $('#manloading').hide();
						time_crud_mantencion(resp)
				   },"json"
			)
			
			return false;		
		}
	})
	
	
//BANDEJA 88 CAV


	function validar_ban88cav(){
		
		var ctrltd_id = $.trim($('#ctrltd_id').val());
		var ctrltd_88buencorteza = $.trim($('#ctrltd_88buencorteza').val());
		var ctrltd_88defcorteza = $.trim($('#ctrltd_88defcorteza').val());
		var ctrltd_88buenturba = $.trim($('#ctrltd_88buenturba').val());
		var ctrltd_88defturba = $.trim($('#ctrltd_88defturba').val());
		var ctrltd_88buensanitizado = $.trim($('#ctrltd_88buensanitizado').val());
		var ctrltd_88defsanitizado = $.trim($('#ctrltd_88defsanitizado').val());
		
		if(ctrltd_id == ''){
			sweet_alert('Error: Seleccionar un caso del Listado Gestión Tiempos Muertos');	
			return false;
		}
	
		if(ctrltd_88buencorteza == ''){
			sweet_alert('Error: c/corteza buenas en blanco');	
			return false;
		}
		
		if(ctrltd_88defcorteza == ''){
			sweet_alert('Error: c/corteza deficientes en blanco');	
			return false;
		}		
				
		if(ctrltd_88buenturba == ''){
			sweet_alert('Error: c/turba buenas en blanco');	
			return false;
		}
		
		if(ctrltd_88defturba == ''){
			sweet_alert('Error: c/turba deficientes en blanco');	
			return false;
		}		

		if(ctrltd_88buensanitizado == ''){
			sweet_alert('Error: sanitizado buenas en blanco');	
			return false;
		}
		
		if(ctrltd_88defsanitizado == ''){
			sweet_alert('Error: sanitizado deficientes en blanco');	
			return false;
		}
			
		return true;
	}


 	$('#btn_ban88cav').click(function(){
		
		if (validar_ban88cav()){	

			$('#ban88loading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var ctrltd_88buencorteza = $.trim($('#ctrltd_88buencorteza').val());
			var ctrltd_88defcorteza = $.trim($('#ctrltd_88defcorteza').val());
			var ctrltd_88buenturba = $.trim($('#ctrltd_88buenturba').val());
			var ctrltd_88defturba = $.trim($('#ctrltd_88defturba').val());
			var ctrltd_88buensanitizado = $.trim($('#ctrltd_88buensanitizado').val());
			var ctrltd_88defsanitizado = $.trim($('#ctrltd_88defsanitizado').val());
			
			var operacion = 'UPDATE_BAN88';
			parametros = {	
							ctrltd_id:ctrltd_id,
							ctrltd_88buencorteza:ctrltd_88buencorteza,
							ctrltd_88defcorteza:ctrltd_88defcorteza,
							ctrltd_88buenturba:ctrltd_88buenturba,
							ctrltd_88defturba:ctrltd_88defturba,
							ctrltd_88buensanitizado:ctrltd_88buensanitizado,
							ctrltd_88defsanitizado:ctrltd_88defsanitizado,							
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
					   $('#ban88loading').hide();
						time_crud_mantencion(resp)
				   },"json"
			)
			
			return false;		
		}
	})	
	
//BANDEJA 45 CAV


	function validar_ban45cav(){
		
		var ctrltd_id = $.trim($('#ctrltd_id').val());
		var ctrltd_45buencorteza = $.trim($('#ctrltd_45buencorteza').val());
		var ctrltd_45defcorteza = $.trim($('#ctrltd_45defcorteza').val());
		var ctrltd_45buenturba = $.trim($('#ctrltd_45buenturba').val());
		var ctrltd_45defturba = $.trim($('#ctrltd_45defturba').val());
		var ctrltd_45buensanitizado = $.trim($('#ctrltd_45buensanitizado').val());
		var ctrltd_45defsanitizado = $.trim($('#ctrltd_45defsanitizado').val());
		
		if(ctrltd_id == ''){
			sweet_alert('Error: Seleccionar un caso del Listado Gestión Tiempos Muertos');	
			return false;
		}
	
		if(ctrltd_45buencorteza == ''){
			sweet_alert('Error: c/corteza buenas en blanco');	
			return false;
		}
		
		if(ctrltd_45defcorteza == ''){
			sweet_alert('Error: c/corteza deficientes en blanco');	
			return false;
		}		
				
		if(ctrltd_45buenturba == ''){
			sweet_alert('Error: c/turba buenas en blanco');	
			return false;
		}
		
		if(ctrltd_45defturba == ''){
			sweet_alert('Error: c/turba deficientes en blanco');	
			return false;
		}		

		if(ctrltd_45buensanitizado == ''){
			sweet_alert('Error: sanitizado buenas en blanco');	
			return false;
		}
		
		if(ctrltd_45defsanitizado == ''){
			sweet_alert('Error: sanitizado deficientes en blanco');	
			return false;
		}
			
		return true;
	}


 	$('#btn_ban45cav').click(function(){
		
		if (validar_ban45cav()){	

			$('#ban45loading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var ctrltd_45buencorteza = $.trim($('#ctrltd_45buencorteza').val());
			var ctrltd_45defcorteza = $.trim($('#ctrltd_45defcorteza').val());
			var ctrltd_45buenturba = $.trim($('#ctrltd_45buenturba').val());
			var ctrltd_45defturba = $.trim($('#ctrltd_45defturba').val());
			var ctrltd_45buensanitizado = $.trim($('#ctrltd_45buensanitizado').val());
			var ctrltd_45defsanitizado = $.trim($('#ctrltd_45defsanitizado').val());
			
			var operacion = 'UPDATE_BAN45';
			parametros = {	
							ctrltd_id:ctrltd_id,
							ctrltd_45buencorteza:ctrltd_45buencorteza,
							ctrltd_45defcorteza:ctrltd_45defcorteza,
							ctrltd_45buenturba:ctrltd_45buenturba,
							ctrltd_45defturba:ctrltd_45defturba,
							ctrltd_45buensanitizado:ctrltd_45buensanitizado,
							ctrltd_45defsanitizado:ctrltd_45defsanitizado,							
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
					   $('#ban45loading').hide();
						time_crud_mantencion(resp)
				   },"json"
			)
			
			return false;		
		}
	})
	
	
	
//CONSUMOS


	function validar_consumos(){
		
		var ctrltd_id = $.trim($('#ctrltd_id').val());
		var ctrltd_sacoturba = $.trim($('#ctrltd_sacoturba').val());
		var ctrltd_sacoperlita = $.trim($('#ctrltd_sacoperlita').val());
		var ctrltd_basacote = $.trim($('#ctrltd_basacote').val());
		var ctrltd_osmocote = $.trim($('#ctrltd_osmocote').val());
		var ctrltd_vermiculita = $.trim($('#ctrltd_vermiculita').val());
		
		if(ctrltd_id == ''){
			sweet_alert('Error: Seleccionar un caso del Listado Gestión Tiempos Muertos');	
			return false;
		}
	
		if(ctrltd_sacoturba == ''){
			sweet_alert('Error: sacos turba en blanco');	
			return false;
		}
		
		if(ctrltd_sacoperlita == ''){
			sweet_alert('Error: sacos perlita en blanco');	
			return false;
		}		
				
		if(ctrltd_basacote == ''){
			sweet_alert('Error: Kg basacote en blanco');	
			return false;
		}
		
		if(ctrltd_osmocote == ''){
			sweet_alert('Error: Kg osmocote en blanco');	
			return false;
		}		

		if(ctrltd_vermiculita == ''){
			sweet_alert('Error: Kg vermiculita en blanco');	
			return false;
		}
		
			
		return true;
	}


 	$('#btn_consumos').click(function(){
		
		if (validar_consumos()){	

			$('#sacoloading').show();
			var ctrltd_id = $.trim($('#ctrltd_id').val());
			var ctrltd_sacoturba = $.trim($('#ctrltd_sacoturba').val());
			var ctrltd_sacoperlita = $.trim($('#ctrltd_sacoperlita').val());
			var ctrltd_basacote = $.trim($('#ctrltd_basacote').val());
			var ctrltd_osmocote = $.trim($('#ctrltd_osmocote').val());
			var ctrltd_vermiculita = $.trim($('#ctrltd_vermiculita').val());
			
			var operacion = 'UPDATE_CONSUMO';
			parametros = {	
							ctrltd_id:ctrltd_id,
							ctrltd_sacoturba:ctrltd_sacoturba,
							ctrltd_sacoperlita:ctrltd_sacoperlita,
							ctrltd_basacote:ctrltd_basacote,
							ctrltd_osmocote:ctrltd_osmocote,
							ctrltd_vermiculita:ctrltd_vermiculita,						
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_gestion.php",
				   parametros,			   
				   function(resp){
					   $('#sacoloading').hide();
						time_crud_mantencion(resp)
				   },"json"
			)
			
			return false;		
		}
	})			
	
	
	
	function time_crud_mantencion(resp){

		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			//cancelar();
			
			if(operacion == 'UPDATE_MAN'){
				swal("Sisconvi-Production", "Se han registrado los datos de mantención de sanitizado", "success");
			}else if(operacion == 'UPDATE_BAN88'){
				swal("Sisconvi-Production", "Se han registrado los datos de bandeja 88 cav", "success");
			}else if(operacion == 'UPDATE_BAN45'){
				swal("Sisconvi-Production", "Se han registrado los datos de bandeja 45 cav", "success");
			}else if(operacion == 'UPDATE_CONSUMO'){
				swal("Sisconvi-Production", "Se han registrado los datos de consumos", "success");
			}
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			
		}else{
			var desc_error = resp['desc'];
			sweet_alert(desc_error);
		}
	}

	
});