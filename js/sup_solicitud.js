$(document).ready(function(){

	$('#btn_oper_sactiv').click(function(){
	    sem_txt = $('#sem_num option:selected').text()
		$('#h_sem_txt').val(sem_txt);
		$('#h_sup_rut').val(rut_supervisor);
		$('#form_sactiv').submit();
	})

	var table;
	//crear_tabla();
	function crear_tabla(num_sem, per_agno, sup_rut){
	
		table = $("#datatable-responsive").DataTable({
		
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_supxsolicitud.php?data="+num_sem+"&per_agno="+per_agno+"&sup_rut="+sup_rut,
			bProcessing: true,
			columns: [				
				{ data:'SACTIV_DIA'},					
				{ data:'ACTIV_NOMBRE'},				
				{ data:'AREA_NOMBRE'},				
				{ data:'SACTIV_OPCION'},				
				{ data:'SACTIV_ESTADO'},
				{ data:'SACTIV_MOTIVO'},
				{ data:'SUPERVISOR'},
				{ data:'USR_NOMBRE'},
				{ data:'SACTIV_COMENTARIO'},
				{ data:'SACTIV_ID'},
				{ data:'AREA_ID'},
				{ data:'ACTIV_ID'}
			],									
			
			columnDefs: [
				{ targets: [0,1,2,3,4], visible: true},
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
			//console.log(obj_row)
			
			$('#sactiv_id').val(obj_row.SACTIV_ID);
			fecha = obj_row.SACTIV_DIA;
			fecha = fecha.split('-');
			fecha = fecha[2]+fecha[1]+fecha[0];			
			$('#sactiv_dia').val(fecha).trigger('change');
			$('#sactiv_opcion').val(obj_row.SACTIV_OPCION).trigger('change');
			$('#area_id').val(obj_row.AREA_ID)/*.trigger('change');*/
			$('#area_id').change();
			
			$('#h_activ_id').val(obj_row.ACTIV_ID);
			change_diasolarea(obj_row.ACTIV_ID)
			$('#sactiv_motivo').val(obj_row.SACTIV_MOTIVO);
			$('#usr_resp').val(obj_row.USR_NOMBRE);
			$('#sactiv_comentario').val(obj_row.SACTIV_COMENTARIO);
			
			$('#h_sactiv_dia').val(fecha);
			$('#h_area_id').val(obj_row.AREA_ID);
			
			sem_num = $('#sem_num').val();
			per_agno = $('#per_agno').val();
			
			$('#h_sem_num').val(sem_num);
			$('#h_per_agno').val(per_agno);
			

			
			
					
			$('#btn_reg_sactiv').hide();
			$('#btn_oper_sactiv').hide();
						
			if(tipo_usuario != 'SUPERVISOR'){
				$('#btn_upd_sactiv').hide();
				$('#btn_del_sactiv').hide();
				$('#btn_can_sactiv').hide();
				
				$('#supervisor_solicitante').html(obj_row.SUPERVISOR)
				$('#supervisor_solicitante').show();
				if(obj_row.SACTIV_ESTADO =='PENDIENTE'){	
					$('#autorizador').hide();
					$('#comentario').hide();				
				}else{
					$('#autorizador').show();
					$('#comentario').show();
					/*
					if(obj_row.SACTIV_ESTADO =='AUTORIZADO'){
						$('#btn_oper_sactiv').show();
					}*/
				}				
			}else{
				if(obj_row.SACTIV_ESTADO =='PENDIENTE'){
					$('#btn_upd_sactiv').show();
					$('#btn_del_sactiv').show();
					$('#btn_can_sactiv').show();	
					$('#autorizador').hide();
					$('#comentario').hide();				
				}else{
					$('#btn_upd_sactiv').hide();
					$('#btn_del_sactiv').hide();
					$('#btn_can_sactiv').show();
					$('#autorizador').show();
					$('#comentario').show();

					if(obj_row.SACTIV_ESTADO =='AUTORIZADO'){
						$('#btn_oper_sactiv').show();
					}
				}			
			}
			
		});
	
	}
	
	$('#btn_can_sactiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_sactiv')[0].reset();
		$('#sactiv_id').val('');
		$('#h_activ_id').val('');
		$('#supervisor_solicitante').html('')
		$('#supervisor_solicitante').hide();
		$('#btn_reg_sactiv').show();
		$('#btn_upd_sactiv').hide();
		$('#btn_del_sactiv').hide();
		$('#btn_can_sactiv').hide();
		$('#btn_oper_sactiv').hide();
		$('#autorizador').hide();
		$('#comentario').hide();			
		
		table.$('tr.selected').removeClass('selected');
		
		$('#area_id').val('');
		$('#area_id').change();
		$('#activ_id').val('');
		$('#activ_id').change();		
		
		/*clear_combobox('activ_id',1);	*/
	}


	$('#sactiv_opcion').select2({	

	});
	
	$('#activ_id').select2({	

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

	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	mayuscula('sactiv_motivo');
	
	
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});			
	}
	
	$('#per_agno').change(function() {
	
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
		
	});

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

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
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
		$('#sem_num').val(numeroSemana).trigger('change');
		change_sem_num();	
	}
	
	
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
		clear_combobox('sactiv_dia',0);
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

		$('#sactiv_dia').select2({			
			data:combobox
		});			
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		var sup_rut = rut_supervisor;
		//var sup_rut = $('#sup_rut').val();
		crear_tabla(sem_num, per_agno, sup_rut);
		sem_txt = $('#sem_num option:selected').text();
		$('#sem_txt').html(sem_txt);
	}	
	
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
		
		if(tipo_usuario == 'SUPERVISOR'){
			$('#sup_rut').val(rut_supervisor).trigger('change');
		}
	}	
	

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

	
	$('#sactiv_dia').change(function() {
		change_diasolarea('')
	});

	$('#sactiv_opcion').change(function() {
		change_diasolarea('')
	});	
	
	$('#area_id').change(function() {
		change_diasolarea('')
	});	
	
	function change_diasolarea(h_activ_id){
		var sactiv_dia = $('#sactiv_dia').val();
		var sactiv_opcion = $('#sactiv_opcion').val();
		var area_id = $('#area_id').val();
		if(tipo_usuario != 'SUPERVISOR'){
			var sup_rut = $('#sup_rut').val();
		}else{
			var sup_rut = rut_supervisor;
		}
		$('#h_activ_id').val(h_activ_id);
		clear_combobox('activ_id',1);
		if(area_id != ""){

			parametros = {			
				sactiv_dia:sactiv_dia,
				sup_rut:sup_rut,
				sactiv_opcion:sactiv_opcion,
				area_id:area_id,
				sol_activ:''
			}		
			//console.log(parametros)
			$.post(
				"consultas/ges_crud_actividades.php",
				parametros,			   
				function(resp){
					carga_actividades(resp)
				},"json"
				)	
		}		
	}
	

	function carga_actividades(resp){
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].ACTIV_ID, text:resp[i].ACTIV_NOMBRE});
		}	
		
		$('#activ_id').select2({	
			allowClear: true,
			placeholder: "SELECCIONA ACTIVIDAD",		
			data:combobox
		})
		activ_selected = $('#h_activ_id').val();
		$('#activ_id').val(activ_selected).trigger('change');				
	}
	
	$('#sup_rut').change(function(){
		//console.log('aa')
		if(tipo_usuario != 'SUPERVISOR'){
			cancelar();
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();	
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();
			var sup_rut = $('#sup_rut').val();
			crear_tabla(sem_num, per_agno, sup_rut);
		}
	})
	
	




	function validar_solicitud(){
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());	
		var sactiv_dia = $.trim($('#sactiv_dia').val());
		var sactiv_opcion = $.trim($('#sactiv_opcion').val());
		var activ_id = $.trim($('#activ_id').val());
		var sactiv_motivo = $.trim($('#sactiv_motivo').val());

		if(per_agno == ''){
			sweet_alert('Error: Ingresar Año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Ingresar Semana');	
			return false;
		}		
		
		if(sactiv_dia == ''){
			sweet_alert('Error: Seleccionar día');	
			return false;
		}
		
		if(sactiv_opcion == ''){
			sweet_alert('Error: Seleccionar solicitud');	
			return false;
		}
		
		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}		

		if(sactiv_motivo == ''){
			sweet_alert('Error: Ingresar motivo');	
			return false;
		}		
		
		return true;
	}
		  
	$('#btn_reg_sactiv').click(function(){

		if (validar_solicitud()){	

			$('#loading').show();

			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());	
			var sactiv_dia = $.trim($('#sactiv_dia').val());
			var sactiv_opcion = $.trim($('#sactiv_opcion').val());
			var activ_id = $.trim($('#activ_id').val());
			var sactiv_motivo = $.trim($('#sactiv_motivo').val());
			var sup_rut = rut_supervisor
			
			var operacion = 'INSERT';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							sactiv_dia:sactiv_dia,
							sactiv_opcion:sactiv_opcion,
							activ_id:activ_id,
							sactiv_motivo:sactiv_motivo,
							sup_rut:sup_rut,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxsolicitud.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxsolicitud(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_sactiv').click(function(){
		if (validar_solicitud()){	

			$('#loading').show();
			
			var sactiv_id = $.trim($('#sactiv_id').val());
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());	
			var sactiv_dia = $.trim($('#sactiv_dia').val());
			var sactiv_opcion = $.trim($('#sactiv_opcion').val());
			var activ_id = $.trim($('#activ_id').val());
			var sactiv_motivo = $.trim($('#sactiv_motivo').val());
			var sup_rut = rut_supervisor
			
			var operacion = 'UPDATE';
			parametros = {
							sactiv_id:sactiv_id,
							per_agno:per_agno,
							sem_num:sem_num,
							sactiv_dia:sactiv_dia,
							sactiv_opcion:sactiv_opcion,
							activ_id:activ_id,
							sactiv_motivo:sactiv_motivo,
							sup_rut:sup_rut,
							operacion:operacion
						 }
			console.log(parametros)				
			$.post(
				   "consultas/ges_crud_supxsolicitud.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxsolicitud(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_sactiv').click(function(){

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
				var sactiv_id = $.trim($('#sactiv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								sactiv_id:sactiv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_supxsolicitud.php",
					   parametros,			   
					   function(resp){
							ges_crud_supxsolicitud(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_supxsolicitud(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Solicitud registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Solicitud modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Solicitud eliminada", "success");
			}			
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();
			var sup_rut = $('#sup_rut').val();
			crear_tabla(sem_num, per_agno, sup_rut);

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});