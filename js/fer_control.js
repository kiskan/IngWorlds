$(document).ready(function(){

	$('#fer_ph').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		fer_ph = $('#fer_ph').val();
		if(e.which==44 && fer_ph.search( ',' ) != -1)return false;			
	});	
	
	$('#fer_ce').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#fer_caudal').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	

	$('#pis_pm').select2({	});
	$('#pis_id').select2({ });
	$('#ctrlagua_hora').select2({	}); 

	var table;	
/*	
	function crear_tabla(num_sem, per_agno, dia, hora){
	console.log(num_sem +'-'+ per_agno +'-'+ dia +'-'+ hora)
		ajax: "consultas/ges_crud_fercontrol.php?num_sem="+num_sem+"&per_agno="+per_agno+"&dia="+dia+"&hora="+hora,
*/		
	function crear_tabla(ctrlagua_id){	
		console.log(ctrlagua_id)
		table = $("#datatable-responsive").DataTable({
			
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_fercontrol.php?ctrlagua_id="+ctrlagua_id,
			bProcessing: true,
			columns: [
				{ data:'CTRLAGUA_ID'},
				{ data:'PER_AGNO'},					
				{ data:'SEM_NUM'},			
				{ data:'CTRLAGUA_DIA'},
				{ data:'CTRLAGUA_HORA'},
				{ data:'PIS_PM'},
				{ data:'PIS_ID'},		
				{ data:'FER_PH'},
				{ data:'FER_CE'},				
				{ data:'FER_CAUDAL'},			
				{ data:'FER_COMENTARIO'}
			],			
			
			columnDefs: [
			{ targets: [1,2,3,4,5,6,7,8,9], visible: true},
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
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}

			var obj_row = table.row(this).data();	

			console.log(obj_row)

			$('#h_ctrlagua_id_orig').val(obj_row.CTRLAGUA_ID);
			
			//$('#ctrlagua_hora').val(obj_row.CTRLAGUA_HORA).trigger('change');
			
			$('#h_pis_pm').val(obj_row.PIS_PM);
			$('#h_pis_id').val(obj_row.PIS_ID);
			
			$('#pis_pm').val(obj_row.PIS_PM).trigger('change');
			$('#pis_id').val(obj_row.PIS_ID).trigger('change');
			
			$('#fer_ph').val(obj_row.FER_PH);
			$('#fer_ce').val(obj_row.FER_CE);
			$('#fer_caudal').val(obj_row.FER_CAUDAL);
			$('#fer_comentario').val(obj_row.FER_COMENTARIO);
		
			$('#btn_reg_fer').hide();
			$('#btn_upd_fer').show();
			$('#btn_del_fer').show();
			$('#btn_can_fer').show();		
			
		});
	}


	$('#btn_can_fer').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_fer')[0].reset();
		
		$('#h_ctrlagua_id').val('');
		$('#h_ctrlagua_id_orig').val('');
		
		$('#btn_reg_fer').show();
		$('#btn_upd_fer').hide();
		$('#btn_del_fer').hide();
		$('#btn_can_fer').hide();
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
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
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
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		
	}
	
	$('#per_agno').change(function() {
	
		change_agno()
		
	});
	
	function change_agno(){
		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		//console.log(parametros)
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
		
		//cancelar();
		//$('#datatable-responsive tbody').unbind( "click" );
		//table.destroy();		
		change_sem_num();
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
		$('#datatable-responsive tbody').unbind( "click" );
		//table.destroy();
		change_sem_num();

	});
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('ctrlagua_dia',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}

	function carga_dias(resp){
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#ctrlagua_dia').select2({			
			data:combobox
		});	
		//console.log(date_current)
		//$('#ctrlagua_dia').val(date_current).trigger('change');
		
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		//var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
		
		if(sem_num == corresponding_week && year_current == per_agno){
			$('#ctrlagua_dia').val(date_current).trigger('change');
		}		

		
		//var ctrlagua_dia = $("#ctrlagua_dia option")[0].value;
		//table.destroy();
		//crear_tabla(sem_num,per_agno,ctrlagua_dia);
	}
		

/*		
	$('#ctrlagua_dia').change(function() {	
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		var ctrlagua_dia = $('#ctrlagua_dia').val();
		//var ctrlagua_dia = $("#ctrlagua_dia option")[0].value;
		//table.destroy();
		if(typeof table != 'undefined') table.destroy()
		crear_tabla(sem_num,per_agno,ctrlagua_dia);
	})
*/
	$('#ctrlagua_dia').change(function() {

		//cancelar();
		//$('#datatable-responsive tbody').unbind( "click" );
		//table.destroy();
		change_dia();

	});	

	function change_dia(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();
		var ctrlagua_dia = $('#ctrlagua_dia').val();
		
		parametros = {			
			per_agno:per_agno,
			sem_num:sem_num,
			ctrlagua_dia:ctrlagua_dia
		}		
		clear_combobox('ctrlagua_hora',0);
		console.log(parametros)
		$.post(
			"consultas/ges_crud_fercontrol.php",
			parametros,			   
			function(resp){
				carga_horas(resp)
			},"json"
		)		
	}	
	
	
	function carga_horas(resp){
		console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].CTRLAGUA_ID, text:resp[i].CTRLAGUA_HORA});
		}	

		//if(resp.length > 0){
			$('#ctrlagua_hora').select2({			
				data:combobox
			});	
			
			//var ctrlagua_hora = $("#ctrlagua_hora option")[0].value;
			//$('#h_ctrlagua_id').val(ctrlagua_hora);
			
			change_grilla();
		//}
	}	
	
	$('#ctrlagua_hora').change(function() {	
	
		//cancelar();
		//$('#datatable-responsive tbody').unbind( "click" );	
		
		
		change_grilla();
	})
	
	function change_grilla(){
/*		
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		var ctrlagua_dia = $('#ctrlagua_dia').val();
*/		
		var ctrlagua_hora = $('#ctrlagua_hora').val();
		
		$('#h_ctrlagua_id').val(ctrlagua_hora);

		if(typeof table != 'undefined') table.destroy()
		//crear_tabla(sem_num,per_agno,ctrlagua_dia,ctrlagua_hora);	
		crear_tabla(ctrlagua_hora);
	}
	
	
//BOTONES ABM	
	
	
	
	
	
	function validar_fer(){
		
		var h_ctrlagua_id = $.trim($('#h_ctrlagua_id').val());
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
		var ctrlagua_hora = $('#ctrlagua_hora').val();

		var pis_pm = $('#pis_pm').val();
		var pis_id = $('#pis_id').val();
		
		var fer_ph = $('#fer_ph').val();
		var fer_ce = $('#fer_ce').val();

		if(h_ctrlagua_id == ''){
			sweet_alert('Error: Falta ingresar Período Control de Agua');	
			return false;
		}		
		
		if(per_agno == ''){
			sweet_alert('Error: Ingresar Año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Ingresar Semana');	
			return false;
		}		
		
		if(ctrlagua_dia == ''){
			sweet_alert('Error: Ingresar Día');	
			return false;
		}	
		
		if(ctrlagua_hora == ''){
			sweet_alert('Error: Ingresar Hora de Registro');	
			return false;
		}		
		
		if(pis_pm == ''){
			sweet_alert('Error: Seleccionar Planta Madre');	
			return false;
		}		
		
		if(pis_id == ''){
			sweet_alert('Error: Seleccionar Piscina');	
			return false;
		}
				
		if(fer_ph == ''){
			sweet_alert('Error: Ingresar PH');	
			return false;
		}		
		
		if(fer_ce == ''){
			sweet_alert('Error: Ingresar Conductividad Eléctrica');	
			return false;
		}			
		
		return true;
	}
		  
	$('#btn_reg_fer').click(function(){

		if (validar_fer()){	

			$('#loading').show();
			
			var h_ctrlagua_id = $.trim($('#h_ctrlagua_id').val());
/*			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
			var ctrlagua_hora = $('#ctrlagua_hora').val();
*/
			var pis_pm = $('#pis_pm').val();
			var pis_id = $('#pis_id').val();
			
			var fer_ph = $('#fer_ph').val();
			var fer_ce = $('#fer_ce').val();
			var fer_caudal = $('#fer_caudal').val();
			
			var fer_comentario = $.trim($('#fer_comentario').val());

			var operacion = 'INSERT';			
			parametros = {		
							h_ctrlagua_id:h_ctrlagua_id,
							pis_pm:pis_pm,
							pis_id:pis_id,
							fer_ph:fer_ph,
							fer_ce:fer_ce,
							fer_caudal:fer_caudal,
							fer_comentario:fer_comentario,
							operacion:operacion
						 }	
			console.log(parametros)

			$.post(
				   "consultas/ges_crud_fercontrol.php",
				   parametros,			   
				   function(resp){
						ges_crud_fer(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_fer').click(function(){
		if (validar_fer()){	

			$('#loading').show();

			var h_ctrlagua_id_orig = $.trim($('#h_ctrlagua_id_orig').val());
			var h_ctrlagua_id = $.trim($('#h_ctrlagua_id').val());			
/*			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
*/
			var h_pis_pm = $('#h_pis_pm').val();
			var h_pis_id = $('#h_pis_id').val();

			var pis_pm = $('#pis_pm').val();
			var pis_id = $('#pis_id').val();
			
			var fer_ph = $('#fer_ph').val();
			var fer_ce = $('#fer_ce').val();
			var fer_caudal = $('#fer_caudal').val();
			
			var fer_comentario = $.trim($('#fer_comentario').val());	
			
			var operacion = 'UPDATE';
			parametros = {	
							h_ctrlagua_id_orig:h_ctrlagua_id_orig,
							h_ctrlagua_id:h_ctrlagua_id,
							h_pis_pm:h_pis_pm,
							h_pis_id:h_pis_id,							
							pis_pm:pis_pm,
							pis_id:pis_id,
							fer_ph:fer_ph,
							fer_ce:fer_ce,
							fer_caudal:fer_caudal,
							fer_comentario:fer_comentario,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_fercontrol.php",
				   parametros,			   
				   function(resp){
						ges_crud_fer(resp)
				   },"json"
			)			
			return false;		
		}
	})		

 	$('#btn_del_fer').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Fertilización?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_ctrlagua_id_orig = $.trim($('#h_ctrlagua_id_orig').val());
				var h_pis_pm = $('#h_pis_pm').val();
				var h_pis_id = $('#h_pis_id').val();				
				var operacion = 'DELETE';
				parametros = {	
								h_ctrlagua_id_orig:h_ctrlagua_id_orig,
								h_pis_pm:h_pis_pm,
								h_pis_id:h_pis_id,									
								operacion:operacion
							 }	
				console.log(parametros)			 
				
				$.post(
					   "consultas/ges_crud_fercontrol.php",
					   parametros,			   
					   function(resp){
							ges_crud_fer(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_fer(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			cancelar();
			
			var operacion = resp['operacion'];	
			
			if(operacion == 'INSERT'){
				//cancelar();
				swal("Sisconvi-Production", "Fertilización registrada", "success");
			}else if(operacion == 'UPDATE'){
				//cancelar();
				swal("Sisconvi-Production", "Fertilización modificada", "success");
			}else if(operacion == 'DELETE'){
				//cancelar();
				swal("Sisconvi-Production", "Fertilización eliminada", "success");
			}			

			$('#datatable-responsive tbody').unbind( "click" );
			//table.destroy();
			
			change_grilla();
			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});