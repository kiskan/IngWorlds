$(document).ready(function(){

	$('#pis_pm').select2({	});
	$('#activ_id').select2({	});

	var table;	
	crear_tabla( year_current,month_current,week_current,'','','')
	function crear_tabla( per_agno, per_mes, sem_num, plan_dia, pis_pm, activ_id){
		//console.log(plan_dia)
		table = $('#datatable-scroll').DataTable( {
			ajax: "consultas/cons_cprodcosecha.php?per_agno="+per_agno+"&per_mes="+per_mes+"&sem_num="+sem_num+"&plan_dia="+plan_dia+"&pis_pm="+pis_pm+"&activ_id="+activ_id,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,
			order:[],
			columns: [
				{ data:'PLAN_DIA'},
				{ data:'PER_AGNO'},
				{ data:'PER_MES'},
				{ data:'SEM_NUM'},
				{ data:'PIS_PM'},
				{ data:'PIS_ID'},
				{ data:'CLON_ID'},
				{ data:'CANT'},
				{ data:'PIS_ESTADO'},
				{ data:'TIPO_COSECHA'}
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
		} );	

	}
	
//CARGA INICIAL 

	//AÑOS
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
	
	$('#per_mes').select2({	});
	$('#per_mes').val(month_current).trigger('change');	
	$('#per_dia').select2({	});
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}	
	
	//SEMANAS	
	load_semanas(year_current,month_current,'LOAD');
	function load_semanas(per_agno,per_mes,carga){
		
		var cons_periodo = 'carga_inicial'		
		
		parametros = {			
			cons_periodo:cons_periodo,
			agno:per_agno,
			mes:per_mes
			
			}	
		clear_combobox('sem_num',1);
		clear_combobox('per_dia',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_semanas(resp,carga)
			},"json"
		)	
	}

	function carga_semanas(resp,carga){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		
		if(carga == 'LOAD'){
			week_current = parseInt(week_current)
			$('#sem_num').val(week_current).trigger('change');	
		}
		
	}		
	

	
	
	
	
//CHANGES	

	//AÑOS
	$('#per_agno').change(function() {
		$('#per_mes').val('').trigger('change');	
		clear_combobox('sem_num',1);
		clear_combobox('per_dia',1);
	})	
	
	//MESES
	$('#per_mes').change(function() {
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();

		if(per_mes != ''){		
			load_semanas(per_agno,per_mes,'');
		}else{

			clear_combobox('sem_num',1);
			clear_combobox('per_dia',1);	
		}
	})	
	
	//SEMANAS
	$('#sem_num').change(function() {
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();
		clear_combobox('per_dia',1);

		if(sem_num != ''){		
			parametros = {			
				agno:per_agno,
				sem_num:sem_num
			}		
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					carga_dias(resp)
				},"json"
			)
		}
	})

	function carga_dias(resp){
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#per_dia').select2({			
			data:combobox
		});			

	}	
	
	
//CLICK CONSULTAR

	$('#btn_cosecha').click(function(){
		table.destroy();
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();	
		var sem_num = $('#sem_num').val();
		var plan_dia = $('#per_dia').val();
		var pis_pm = $('#pis_pm').val();
		var activ_id = $('#activ_id').val();
		
		console.log(per_agno +'--'+ per_mes +'--'+ sem_num +'--'+ plan_dia +'--'+ pis_pm +'--'+ activ_id)
				
		crear_tabla( per_agno, per_mes, sem_num, plan_dia, pis_pm, activ_id);
	})
	

	
});