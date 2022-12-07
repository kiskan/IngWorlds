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
/*
	//SUPERVISORES	
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
	}	
*/	
	
//CHANGES	

	//AÑOS
	$('#per_agno').change(function() {
		$('#per_mes').val('01').trigger('change');	
		clear_combobox('sem_num',0);
		//clear_combobox('sem_num',1);
		//clear_combobox('per_dia',1);
		//$('#sup_rut').val('').trigger('change');
		//clear_combobox('sup_rut',1);
		//clear_combobox('activ_id',1);
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
			//$('#sup_rut').val('').trigger('change');
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
		parametros = {	
						per_agno:per_agno,
						per_mes:per_mes,
						sem_num:sem_num
					 }		
		$.post(
			   "consultas/cons_mrendimiento.php",
			   parametros,			   
			   function(resp){
					cons_rendmiento(resp)
			   },"json"
		)		
			
	})
	
	function cons_rendmiento(resp){
		var cod_resp = resp['cod'];
		$('#oper_top').html('')
		$('#oper_bottom').html('')
		if(cod_resp == 'ok'){
			
			console.log(resp['actividad'][0])
			
			
			x0 = resp['actividad'][0][0];$('#activ_1').html(x0);
			x1 = resp['actividad'][1][0];$('#activ_2').html(x1);
			x2 = resp['actividad'][2][0];$('#activ_3').html(x2);
			x3 = resp['actividad'][3][0];$('#activ_4').html(x3);
			x4 = resp['actividad'][4][0];$('#activ_5').html(x4);
			x5 = resp['actividad'][5][0];$('#activ_6').html(x5);
		
			
			
			
			$('#resp_sinhr').hide();
			$('#resp_cmrendimiento').show();
			console.log(resp)
			//$('#oper_top').innerHTML = '';
			x = ''
			num_top = resp['operadores_top'].length
			for(i=0;i<num_top;i++){
				largo = resp['operadores_top'][i].length
				k=1
				x = x=x+'<div class="col-md-2" style="font-size:9px">'
				for(j=0;j<largo;j++){
					nombre = resp['operadores_top'][i][j].split("->")
					//console.log(nombre[0])
					cumplimiento = String(myNamespace.round(nombre[1],2)).replace('.',',')+'%'
					//console.log(cumplimiento)
					 x=x+'<div class="row" ><center><div class="col-md-1"><img src="images/'+k+'-verde.png" /></div></center><div class="col-md-10"><span>'+nombre[0]+'</span></div><div class="col-md-1" style="font-size:12px; font-weight:bold">'+cumplimiento+'</div></div>'
					k++
				}
				x=x+'</div>'
			}
			//console.log(x)
			$('#oper_top').html(x)
			


			x = ''
			num_bottom = resp['operadores_bottom'].length
			for(i=0;i<num_bottom;i++){
				largo = resp['operadores_bottom'][i].length
				k=1
				x = x=x+'<div class="col-md-2" style="font-size:9px">'
				for(j=0;j<largo;j++){
					nombre_bottom = resp['operadores_bottom'][i][j].split("->")
					//console.log(nombre[0])
					cumplimiento = String(myNamespace.round(nombre_bottom[1],2)).replace('.',',')+'%'
					//console.log(cumplimiento)
					 x=x+'<div class="row" ><center><div class="col-md-1"><img src="images/'+k+'-rojo.png" /></div></center><div class="col-md-10"><span>'+nombre_bottom[0]+'</span></div><div class="col-md-1" style="font-size:12px; font-weight:bold">'+cumplimiento+'</div></div>'
					k++
				}
				x=x+'</div>'
			}
			//console.log(x)
			$('#oper_bottom').html(x)


			x0 = resp['operadores_80'][0];$('#oper80_1').html(x0);
			x1 = resp['operadores_80'][1];$('#oper80_2').html(x1);
			x2 = resp['operadores_80'][2];$('#oper80_3').html(x2);
			x3 = resp['operadores_80'][3];$('#oper80_4').html(x3);
			x4 = resp['operadores_80'][4];$('#oper80_5').html(x4);
			x5 = resp['operadores_80'][5];$('#oper80_6').html(x5);

			
			x0 = resp['operadores_50'][0];$('#oper50_1').html(x0);
			x1 = resp['operadores_50'][1];$('#oper50_2').html(x1);
			x2 = resp['operadores_50'][2];$('#oper50_3').html(x2);
			x3 = resp['operadores_50'][3];$('#oper50_4').html(x3);
			x4 = resp['operadores_50'][4];$('#oper50_5').html(x4);
			x5 = resp['operadores_50'][5];$('#oper50_6').html(x5);	

			
			
			
		}else{
			$('#resp_cmrendimiento').hide();
			$('#resp_sinhr').show();
		}
		

	}


var myNamespace = {};

myNamespace.round = function(number, precision) {
    var factor = Math.pow(10, precision);
    var tempNumber = number * factor;
    var roundedTempNumber = Math.round(tempNumber);
    return roundedTempNumber / factor;
};

	
});