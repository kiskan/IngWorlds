$(document).ready(function(){

	$('#btn_inf_semanal').click(function(){
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();
		var sem_num = $('#sem_num').val();
		var url = '/proyecto/sisconvi-production/Informes/informe_semanal.php?per_agno='+per_agno+'&per_mes='+per_mes+'&sem_num='+sem_num;
		//window.location.href = url;		
		$('#link_informe_semanal').prop( "href", url );
		//$('#link_informe_semanal').click();
		document.getElementById('link_informe_semanal').click();
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
		clear_combobox('sem_num',1);
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
		
		var cons_periodo_inf = 'carga_inicial'		
		
		parametros = {			
			cons_periodo_inf:cons_periodo_inf,
			agno:per_agno,
			mes:per_mes
			
		}	
		clear_combobox('sem_num',1);

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

	//A??OS
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