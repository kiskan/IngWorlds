$(document).ready(function(){

	
	
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
	//$('#per_dia').select2({	});
	$('#activ_id').select2({ });
	
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
		//clear_combobox('sem_num',1);
		//clear_combobox('per_dia',1);
		
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
		$('#per_mes').val('01').trigger('change');	
		clear_combobox('sem_num',0);
	})	
	
	//MESES
	$('#per_mes').change(function() {
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();

		if(per_mes != ''){		
			load_semanas(per_agno,per_mes,'');
		}else{
			clear_combobox('sem_num',0);
			//clear_combobox('sem_num',1);
			//clear_combobox('per_dia',1);
			$('#sup_rut').val('').trigger('change');
			//clear_combobox('sup_rut',1);
			//clear_combobox('activ_id',1);			
		}
	})	
	
	//SEMANAS
	/*
	$('#sem_num').change(function() {
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();
		clear_combobox('per_dia',1);
		$('#sup_rut').val('').trigger('change');
		//clear_combobox('sup_rut',1);
		//clear_combobox('activ_id',1);		
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
	
	//DIAS
	$('#per_dia').change(function() {
		$('#sup_rut').val('').trigger('change');
		//clear_combobox('sup_rut',1);
		//clear_combobox('activ_id',1);	
	})
	
	//SUPERVISORES	
	$('#sup_rut').change(function() {
		var sup_rut = $('#sup_rut').val();
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();
		var sem_num = $('#sem_num').val();
		var plan_dia = $('#per_dia').val();
		clear_combobox('activ_id',1);
		
		if(sup_rut != ''){		
			parametros = {			
				per_agno:per_agno,
				per_mes:per_mes,
				sem_num:sem_num,
				plan_dia:plan_dia,
				sup_rut:sup_rut,
				cons_prod:''
			}		
			$.post(
				"consultas/ges_crud_supervisores.php",
				parametros,			   
				function(resp){
					carga_actividades(resp)
				},"json"
			)
		}
	})

	function carga_actividades(resp){
		console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].ACTIV_ID, text:resp[i].ACTIV_NOMBRE});
		}	

		$('#activ_id').select2({			
			data:combobox
		});			

	}	
*/	
//CLICK CONSULTAR

	$('#btn_monitoreo').click(function(){
		
		var per_agno = $('#per_agno').val();
		var per_mes = $('#per_mes').val();	
		var sem_num = $('#sem_num').val();
		//var plan_dia = $('#per_dia').val();
		//var sup_rut = $('#sup_rut').val();
		//var activ_id = $('#activ_id').val();
		
		var url = '/proyecto/sisconvi-production/Informes/informe_asistencia.php?per_agno='+per_agno+'&per_mes='+per_mes+'&sem_num='+sem_num;	
		$('#link_informe_asistencia').prop( "href", url );
		document.getElementById('link_informe_asistencia').click();			
	})
	

	
});