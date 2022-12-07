$(document).ready(function(){

	$('#btn_inf_diario').click(function(){
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();
		var sem_num = $('#sem_num').val();
		var url = '/proyecto/sisconvi-production/Informes/informe_diario.php?per_agno='+per_agno+'&per_mes='+per_mes+'&sem_num='+sem_num;
		window.location.href = url;		
		
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
	
	$('#per_mes').select2({	});
	$('#per_mes').val(month_current).trigger('change');
	
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
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}	
	
	load_semanas(year_current,month_current,'LOAD');
	function load_semanas(per_agno,per_mes,carga){
		
		var cons_periodo = 'carga_inicial'		
		
		parametros = {			
			cons_periodo:cons_periodo,
			agno:per_agno,
			mes:per_mes
			
		}	
		clear_combobox('sem_num',0);

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
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();

		load_semanas(per_agno,per_mes,'');
	})	
	
	//MESES
	$('#per_mes').change(function() {
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();

		load_semanas(per_agno,per_mes,'');
	})		
});