$(document).ready(function(){

	$('#ctrlagua_ph').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		ctrlagua_ph = $('#ctrlagua_ph').val();
		if(e.which==44 && ctrlagua_ph.search( ',' ) != -1)return false;			
	});	
	
	$('#ctrlagua_ce').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#ctrlagua_caudal').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	

	$('#ctrlagua_tk2').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#ctrlagua_tk3').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#ctrlagua_tk4').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#ctrlagua_hora').select2({	});

	var table;	
	
	function crear_tabla(num_sem, per_agno, dia){
		console.log(num_sem +'-'+ per_agno +'-'+ dia)
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_feraguas.php?data="+num_sem+"&per_agno="+per_agno+"&dia="+dia,
			bProcessing: true,
			columns: [
				{ data:'CTRLAGUA_ID'},
				{ data:'SEM_NUM'},
				{ data:'PER_AGNO'},				
				{ data:'CTRLAGUA_DIA'},
				{ data:'CTRLAGUA_HORA'},
				{ data:'CTRLAGUA_TK2'},
				{ data:'CTRLAGUA_TK3'},
				{ data:'CTRLAGUA_TK4'},
				{ data:'CTRLAGUA_PH'},
				{ data:'CTRLAGUA_CE'},				
				{ data:'CTRLAGUA_CAUDAL'},			
				{ data:'CTRLAGUA_COMENTARIO'}
			],			
			
			columnDefs: [
			{ targets: [1,2,3,4,5,6,7,8,9,10], visible: true},
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

			$('#h_ctrlagua_id').val(obj_row.CTRLAGUA_ID);
			
			$('#ctrlagua_hora').val(obj_row.CTRLAGUA_HORA).trigger('change');
			
			$('#ctrlagua_ph').val(obj_row.CTRLAGUA_PH);
			$('#ctrlagua_ce').val(obj_row.CTRLAGUA_CE);
			$('#ctrlagua_caudal').val(obj_row.CTRLAGUA_CAUDAL);
			$('#ctrlagua_comentario').val(obj_row.CTRLAGUA_COMENTARIO);
			
			$('#ctrlagua_tk2').val(obj_row.CTRLAGUA_TK2);
			$('#ctrlagua_tk3').val(obj_row.CTRLAGUA_TK3);
			$('#ctrlagua_tk4').val(obj_row.CTRLAGUA_TK4);
		
			$('#btn_reg_ctrlagua').hide();
			$('#btn_upd_ctrlagua').show();
			$('#btn_del_ctrlagua').show();
			$('#btn_can_ctrlagua').show();		
			
		});
	}


	$('#btn_can_ctrlagua').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_ctrlagua')[0].reset();
		
		$('#h_ctrlagua_id').val('');			
		
		$('#btn_reg_ctrlagua').show();
		$('#btn_upd_ctrlagua').hide();
		$('#btn_del_ctrlagua').hide();
		$('#btn_can_ctrlagua').hide();
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
		
		cancelar();
		$('#datatable-responsive tbody').unbind( "click" );
		//table.destroy();		
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
	
		//console.log(corresponding_week)
		
		$('#sem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
	}
	
	
	$('#sem_num').change(function() {
		//console.log('hola')
		cancelar();
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
		

		
	$('#ctrlagua_dia').change(function() {	
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		var ctrlagua_dia = $('#ctrlagua_dia').val();
		//var ctrlagua_dia = $("#ctrlagua_dia option")[0].value;
		//table.destroy();
		if(typeof table != 'undefined') table.destroy()
		crear_tabla(sem_num,per_agno,ctrlagua_dia);
	})

	

	
	
	
	
	
	
//BOTONES ABM	
	
	
	
	
	
	function validar_ctrlagua(){
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
		var ctrlagua_hora = $('#ctrlagua_hora').val();
		var ctrlagua_tk2 = $('#ctrlagua_tk2').val();
		var ctrlagua_tk3 = $('#ctrlagua_tk3').val();
		var ctrlagua_tk4 = $('#ctrlagua_tk4').val();
		
		var ctrlagua_ph = $('#ctrlagua_ph').val();
		var ctrlagua_ce = $('#ctrlagua_ce').val();
	
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
		
		if(ctrlagua_tk2 == ''){
			sweet_alert('Error: Seleccionar TK2');	
			return false;
		}		
		
		if(ctrlagua_tk3 == ''){
			sweet_alert('Error: Seleccionar TK3');	
			return false;
		}
		
		if(ctrlagua_tk4 == ''){
			sweet_alert('Error: Seleccionar TK4');	
			return false;
		}	
		
		if(ctrlagua_tk2 > 100 || ctrlagua_tk3 > 100 || ctrlagua_tk4 > 100){
			sweet_alert('Error: Los parámetros de inyección deben ser mayor a 100');	
			return false;
		}		
				
		if(ctrlagua_ph == ''){
			sweet_alert('Error: Ingresar PH');	
			return false;
		}		
		
		if(ctrlagua_ce == ''){
			sweet_alert('Error: Ingresar Conductividad Eléctrica');	
			return false;
		}			
		
		return true;
	}
		  
	$('#btn_reg_ctrlagua').click(function(){

		if (validar_ctrlagua()){	

			$('#loading').show();
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
			var ctrlagua_hora = $('#ctrlagua_hora').val();
			
			var ctrlagua_tk2 = $('#ctrlagua_tk2').val();
			var ctrlagua_tk3 = $('#ctrlagua_tk3').val();
			var ctrlagua_tk4 = $('#ctrlagua_tk4').val();
			
			var ctrlagua_ph = $('#ctrlagua_ph').val();
			var ctrlagua_ce = $('#ctrlagua_ce').val();
			var ctrlagua_caudal = $('#ctrlagua_caudal').val();
			
			var ctrlagua_comentario = $.trim($('#ctrlagua_comentario').val());

			var operacion = 'INSERT';			
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							ctrlagua_dia:ctrlagua_dia,
							ctrlagua_hora:ctrlagua_hora,
							ctrlagua_tk2:ctrlagua_tk2,
							ctrlagua_tk3:ctrlagua_tk3,
							ctrlagua_tk4:ctrlagua_tk4,
							ctrlagua_ph:ctrlagua_ph,
							ctrlagua_ce:ctrlagua_ce,
							ctrlagua_caudal:ctrlagua_caudal,
							ctrlagua_comentario:ctrlagua_comentario,
							operacion:operacion
						 }	
			console.log(parametros)

			$.post(
				   "consultas/ges_crud_feraguas.php",
				   parametros,			   
				   function(resp){
						ges_crud_feraguas(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_ctrlagua').click(function(){
		if (validar_ctrlagua()){	

			$('#loading').show();

			var h_ctrlagua_id = $.trim($('#h_ctrlagua_id').val());
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var ctrlagua_dia = $.trim($('#ctrlagua_dia').val());
			var ctrlagua_hora = $('#ctrlagua_hora').val();

			var ctrlagua_tk2 = $('#ctrlagua_tk2').val();
			var ctrlagua_tk3 = $('#ctrlagua_tk3').val();
			var ctrlagua_tk4 = $('#ctrlagua_tk4').val();
			
			var ctrlagua_ph = $('#ctrlagua_ph').val();
			var ctrlagua_ce = $('#ctrlagua_ce').val();
			var ctrlagua_caudal = $('#ctrlagua_caudal').val();
			
			var ctrlagua_comentario = $.trim($('#ctrlagua_comentario').val());	
			
			var operacion = 'UPDATE';
			parametros = {	
							h_ctrlagua_id:h_ctrlagua_id,
							per_agno:per_agno,
							sem_num:sem_num,
							ctrlagua_dia:ctrlagua_dia,
							ctrlagua_hora:ctrlagua_hora,
							ctrlagua_tk2:ctrlagua_tk2,
							ctrlagua_tk3:ctrlagua_tk3,
							ctrlagua_tk4:ctrlagua_tk4,
							ctrlagua_ph:ctrlagua_ph,
							ctrlagua_ce:ctrlagua_ce,
							ctrlagua_caudal:ctrlagua_caudal,
							ctrlagua_comentario:ctrlagua_comentario,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_feraguas.php",
				   parametros,			   
				   function(resp){
						ges_crud_feraguas(resp)
				   },"json"
			)			
			return false;		
		}
	})		

 	$('#btn_del_ctrlagua').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este Control de Agua?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_ctrlagua_id = $.trim($('#h_ctrlagua_id').val());
				var operacion = 'DELETE';
				parametros = {	
								h_ctrlagua_id:h_ctrlagua_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_feraguas.php",
					   parametros,			   
					   function(resp){
							ges_crud_feraguas(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_feraguas(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			cancelar();
			
			var operacion = resp['operacion'];	
			
			if(operacion == 'INSERT'){
				//cancelar();
				swal("Sisconvi-Production", "Control de Agua registrada", "success");
			}else if(operacion == 'UPDATE'){
				//cancelar();
				swal("Sisconvi-Production", "Control de Agua modificada", "success");
			}else if(operacion == 'DELETE'){
				//cancelar();
				swal("Sisconvi-Production", "Control de Agua eliminada", "success");
			}			

			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();	
			var ctrlagua_dia = $('#ctrlagua_dia').val();
			crear_tabla(sem_num,per_agno,ctrlagua_dia);
			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});