$(document).ready(function(){

	$('#hora_tope').select2({	});

	var table;	
	
	function crear_tabla(){
		
		per_agno = $('#per_agno').val()
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_secrexhoratope.php?per_agno="+per_agno,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'DIA'},
				{ data:'DIA_SEMANA'},
				{ data:'HORA_TOPE'}
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
			
			fecha = obj_row.DIA;
			fecha = fecha.split('-');
			fecha = fecha[2]+fecha[1]+fecha[0];	
			
			$('#h_dia').val(fecha);
			
			$('#sem_num').val(obj_row.SEM_NUM).trigger('change');
			$('#hora_tope').val(obj_row.HORA_TOPE).trigger('change');
			
			$('#per_agno').prop('disabled',true);
			$('#sem_num').prop('disabled',true);
			$('#dia').prop('disabled',true);

			$('#btn_reg_horatope').hide();
			$('#btn_upd_horatope').show();
			$('#btn_del_horatope').show();
			$('#btn_can_horatope').show();			
		});
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
	
	
	function cancelar(){

		$('#hora_tope').val('').trigger('change');
		$('#h_dia').val('');
		
		$('#per_agno').prop('disabled',false);
		$('#sem_num').prop('disabled',false);
		$('#dia').prop('disabled',false);
		
		$('#chk_tope').prop('checked',false);
		
		$('#btn_reg_horatope').show();
		$('#btn_upd_horatope').hide();
		$('#btn_del_horatope').hide();
		$('#btn_can_horatope').hide();
		table.$('tr.selected').removeClass('selected');		
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
		crear_tabla();		
	}
	
	$('#per_agno').change(function() {
	
		change_agno()
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		crear_tabla();		
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
		$('#sem_num').val(corresponding_week).trigger('change');
		change_sem_num();	
	}
	
	
	$('#sem_num').change(function() {

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
		clear_combobox('dia',0);
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

		$('#dia').select2({			
			data:combobox
		});			
		
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		
		if(sem_num == corresponding_week){
			$('#dia').val(date_current).trigger('change');
		}	
		
		var h_dia = $('#h_dia').val();
		
		if(h_dia != ''){
			$('#dia').val(h_dia).trigger('change');
		}

	}	

	
	
	function validar_horatope(){
		var dia = $('#dia').val();
		var hora_tope = $('#hora_tope').val();		
	
		if(dia == ''){
			sweet_alert('Error: Ingresar día');	
			return false;
		}
		
		if(hora_tope == ''){
			sweet_alert('Error: Ingresar Hora Tope');	
			return false;
		}		
			
		return true;
	}
		

	$('#btn_reg_horatope').click(function(){

		if (validar_horatope()){	

			$('#loading').show();
			
			var per_agno = $('#per_agno').val();
			var sem_num = $('#sem_num').val();
			var dia = $('#dia').val();
			var hora_tope = $('#hora_tope').val();	
			var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
			
			var operacion = 'INSERT';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							dia:dia,
							hora_tope:hora_tope,
							chk_tope:chk_tope,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_secrexhoratope.php",
				   parametros,			   
				   function(resp){
						ges_crud_horatope(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	

	
 	$('#btn_upd_horatope').click(function(){
		if (validar_horatope()){	

			$('#loading').show();
			
			var per_agno = $('#per_agno').val();
			var sem_num = $('#sem_num').val();
			var dia = $('#dia').val();
			var hora_tope = $('#hora_tope').val();	
			var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
			
			var operacion = 'UPDATE';
			parametros = {	
							per_agno:per_agno,
							sem_num:sem_num,
							dia:dia,
							hora_tope:hora_tope,
							chk_tope:chk_tope,
							operacion:operacion
						 }		
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_secrexhoratope.php",
				   parametros,			   
				   function(resp){
						ges_crud_horatope(resp)
				   },"json"
			)
			
			return false;		
		}
	})	
	
	$('#btn_del_horatope').click(function(){
		swal({   
			title: "¿Seguro que deseas eliminar esta hora tope?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var per_agno = $('#per_agno').val();
				var sem_num = $('#sem_num').val();
				var dia = $('#dia').val();
				var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
				
				var operacion = 'DELETE';
				parametros = {	
								per_agno:per_agno,
								sem_num:sem_num,
								dia:dia,
								chk_tope:chk_tope,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_secrexhoratope.php",
					   parametros,			   
					   function(resp){
							ges_crud_horatope(resp)
					   },"json"
				)
		});	
		
	})	
	
	
	
	
	function ges_crud_horatope(resp){
	console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();

			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Hora Tope registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Hora Tope modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Hora Tope eliminada", "success");
			}
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}
	
	$('#btn_can_horatope').click(function(){
		cancelar();		
	})	
	
});