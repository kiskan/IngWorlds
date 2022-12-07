$(document).ready(function(){

	$('#btn_planvisor').click(function(){

		$('#calendar').fullCalendar('destroy');	
		cargar_planvisor();
	})

	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({				
			data:combobox
		});		
		$('#per_agno').val(year_current).trigger('change');
	}
	$('#per_mes').select2({				

	});
	$('#per_mes').val(month_current).trigger('change');
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
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
		
		$('#sup_rut').val(rut_supervisor).trigger('change');

		cargar_planvisor();
	}	
	
	
	//cargar_planvisor();
	function cargar_planvisor(){
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();
		var sup_rut = $('#sup_rut').val();
		//console.log(rut_supervisor)
		//console.log(sup_rut)
		
		parametros = {			
						per_agno:per_agno,
						per_mes:per_mes,
						sup_rut:sup_rut
					 }	
		$.post(
			   "consultas/ges_crud_planvisor.php",
			   parametros,			   
			   function(resp){
					ges_crud_planvisor(resp)
			   },"json"
		)
	}
	
	
	function ges_crud_planvisor(resp){
		//console.log(resp)
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();
		var fecha = per_agno+'-'+per_mes+'-01'		
		
		$('#calendar').fullCalendar({ events: resp,
			//defaultView:'basicWeek',
	
			header: {
				left: '',
				center: '',
				right: 'title'
			},				
			weekends: true,
			//weekNumbers:true,
			//hiddenDays: [0],
			weekNumbersWithinDays:true,		
			eventClick: function(event) {
				activ_split = event.id.split('---');
				fecha = event.start._i.split('-');
				fecha = fecha[2]+'-'+fecha[1]+'-'+fecha[0];				
				$('#fecha').html(fecha);
				$('#area').html(activ_split[2]);
				$('#actividad').html(activ_split[3]);
				$('#supervisor').html(activ_split[1]);
				
				$('#tipo_activ').html(activ_split[4]);
				$('#meta').html(activ_split[6]);
				$('#produccion').html(activ_split[7]);
				$('#unidad').html(activ_split[5]);
												
				clic_actividad(activ_split[0],event.start._i); 
				$('#con_activ').click();
			}
		});	
		$('#calendar').fullCalendar('gotoDate',fecha);
	}
	
	var table;
	function clic_actividad(activ_id,plan_dia){
					
		table = $("#datatable-responsive_operadores").DataTable({

			columnDefs: [
				{ targets: [4,5,6,7,8,9], visible: true},
				{ targets: '_all', visible: false }			
			],	  
			ajax: "consultas/ges_crud_planvisor.php?activ_id="+activ_id+"&plan_dia="+plan_dia,
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'PLAN_DIA'},
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_NOMBRE'},
				{ data:'SUPERVISOR'},
				{ data:'PLANO_ASIST'},
				{ data:'OPERARIO'},
				{ data:'PLANO_CANT'},
				{ data:'PLANO_HORAS'},
				{ data:'PLANO_HORASPROD'},
				{ data:'PLANO_OBS'}
			],

			searching:true,
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
	
	$("#CalenderModalNew").on("hidden.bs.modal", function () {
		table.destroy();
	});	

	
});