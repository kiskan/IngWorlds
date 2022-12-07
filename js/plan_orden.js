$(document).ready(function(){


	var table;	
	
	function crear_tabla(num_sem, per_agno){
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_planxorden.php?num_sem="+num_sem+"&per_agno="+per_agno,
			bProcessing: true,
			columns: [
				{ data:'AREA1'},
				{ data:'ACTIV1'},
				{ data:'SUP1'},
				{ data:'HORAS1'},
				{ data:'AREA2'},
				{ data:'ACTIV2'},
				{ data:'SUP2'},
				{ data:'HORAS2'},	
				{ data:'OPER_RUT'},	
				{ data:'PLAN_DIA'},
				{ data:'OPERADOR'},
				{ data:'ACTIVIDADES'}
			],
	
			columnDefs: [
			{ targets: [9,10,11], visible: true},
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
			fecha = obj_row.PLAN_DIA;
			fecha = fecha.split('-');

			actividad = obj_row.ACTIVIDADES;
			actividad = actividad.split(',');
			
			fecha = fecha[0]+fecha[1]+fecha[2];
			$('#plan_dia').val(fecha).trigger('change');
			
			$('#oper_rut').val(obj_row.OPER_RUT);
			$('#oper_nombre').val(obj_row.OPERADOR);
			
			$('#area1').val(obj_row.AREA1);
			$('#sup1').val(obj_row.SUP1);
			$('#activ1').val(actividad[0]);
			$('#horas1').val(obj_row.HORAS1);
				
			$('#area2').val(obj_row.AREA2);
			$('#sup2').val(obj_row.SUP2);
			$('#activ2').val(actividad[1]);
			$('#horas2').val(obj_row.HORAS2);
			
			$('#activ_id').val(obj_row.ACTIV1);
			
			$('#btn_cambiar_orden').prop('disabled',false);
		});
	}
	
	
	function cancelar(){
		$('#form_planxorden')[0].reset();		
		$('#activ_id').val('');
		$('#plan_dia').val('').trigger('change');
		$('#btn_cambiar_orden').prop('disabled',true);
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
	}
	
	$('#per_agno').change(function() {

		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}		
		clear_combobox('sem_num',1);
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
	
	function carga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#plan_dia').select2({
			allowClear: true,
			data:combobox
		});			
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();

		crear_tabla(sem_num,per_agno);
		sem_txt = $('#sem_num option:selected').text();
		$('#sem_txt').html(sem_txt);
	}
	
	
	
 	$('#btn_cambiar_orden').click(function(){
	
		$('#loading').show();
		var oper_rut = $.trim($('#oper_rut').val());
		var plan_dia = $.trim($('#plan_dia').val());
		var activ_id = $.trim($('#activ_id').val());
		var operacion = 'cambiar_orden';

		parametros = {	
						oper_rut:oper_rut,
						plan_dia:plan_dia,
						activ_id:activ_id,
						operacion:operacion
					 }
		//console.log(parametros)
		
		$.post(
			   "consultas/ges_crud_planxorden.php",
			   parametros,			   
			   function(resp){
					ges_crud_planxorden(resp)
			   },"json"
		)
		
		return false;		
		
	})		


	
	function ges_crud_planxorden(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			cancelar();	
			swal("Sisconvi-Production", "Orden de actividades cambiadas", "success");
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();

			sem_num = $('#sem_num').val();
			per_agno = $('#per_agno').val();
			crear_tabla(sem_num,per_agno);
			
			
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
});