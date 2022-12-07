$(document).ready(function(){

	$('#hora_activ').select2({	});

	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 3 segundos.",
			type: "error", 
			timer: 3000,
			showConfirmButton: false 
		});			
	}	


	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}	
	
	change_sem_num();
	function change_sem_num(){

		var per_agno = h_per_agno
		var sem_num = h_sem_num

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
			data:combobox
		});			

		$('#sem_txt').html(h_sem_txt);		
		$('#plan_dia').val(h_sactiv_dia).trigger('change');
				
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
	
	carga_sup_activ();
	function carga_sup_activ(){

		parametros = {			
			sup_rut:rut_supervisor,
			activ_id:h_activ_id,
			sup_replanificacion:''
		}	
		console.log(parametros)
		clear_combobox('sup_rut',0);
		$.post(
			"consultas/ges_crud_supervisores.php",
			parametros,			   
			function(resp){
				carga_supervisores(resp)
			},"json"
			)	
		
		clear_combobox('activ_id',0);
		$.post(
			"consultas/ges_crud_actividades.php",
			parametros,			   
			function(resp){
				carga_actividades(resp)
			},"json"
		)					
	}
	

	function carga_supervisores(resp){
		console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
		}	
		
		$('#sup_rut').select2({			
			data:combobox
		})
		
	}	
	
	function carga_actividades(resp){
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].ACTIV_ID, text:resp[i].ACTIV_NOMBRE});
		}	
	
		$('#activ_id').select2({			
			data:combobox
		})
		console.log(resp[0].ACTIV_STANDAR)
		$('#h_activ_standar').val(resp[0].ACTIV_STANDAR);
		load_operadores()
	}	
	
	function load_operadores(){

		$("#lista1_operadores tr").remove();
		$("#lista2_operadores tr").remove();
		$("#lista3_operadores tr").remove();
		
		activ_standar = $('#h_activ_standar').val();
	
		parametros = {			
			plan_dia:h_sactiv_dia,
			activ_id:h_activ_id,
			activ_standar:activ_standar,
			oper_disponibles:''
		}	
		console.log(parametros)
		$.post(
			"consultas/ges_crud_supxactoperadores.php",
			parametros,			   
			function(resp){
				carga_operadores(resp)
			},"json"
		)					
	}	
	
	function carga_operadores(resp){

		console.log(resp)	
		
		var cant_operadores = resp.length;
		var cant_lista1 = Math.round(cant_operadores/3);
		var cant_lista2 = Math.round(cant_operadores/3)*2;
		var i = 0;
		var operadores_ocupados = 0;		
		var disp_oper_lunes = 0;
		var disp_jorn_lunes = 0;
		
		console.log(cant_lista1+'-'+cant_lista2)
		
		while(i < cant_lista1){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			dia = resp[i].DIA[0];
			dia2 = resp[i].DIA[1];
			planificado = (resp[i].PLANIFICADO == 'S')? 'azul':'';
		
			id_diahrdisp = 'diahrdisp_'+resp[i].OPER_RUT;
			id_diahrocup = 'diahrocup_'+resp[i].OPER_RUT;
			hr_dia_disp = '8,5';
			hr_dia_ocup = '0';
			color = 'red';
			dobleactiv_dia = 0;
			//dia_oper = lunes
			if(dia != '0'){				
				dia_oper = dia.split('---');
				area_oper = dia_oper[0];
				activ_oper = dia_oper[1];
				horas_oper = dia_oper[2];
				hr_dia_format = dia_oper[2].replace(',','.');
							
				if(dia_oper[2] != '8,50'){
					imagen = 'work4.png';
				}else{
					imagen = 'work.png';
				}				
				hr_dia_disp = 8.5 - parseFloat(hr_dia_format);
				hr_dia_ocup = hr_dia_disp;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia_disp);
				

				if(dia2 != '0'){
					dia_oper2 = dia2.split('---');			
					
					area_oper = dia_oper[0]+','+dia_oper2[0];
					activ_oper = dia_oper[1]+','+dia_oper2[1];
					horas_oper = dia_oper[2]+'+'+dia_oper2[2];

					hr_dia2_format = dia_oper2[2].replace(',','.');
					
					hr_dia2_disp = 8.5 - parseFloat(hr_dia2_format);
					disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia2_disp);
					hr_dia_total = parseFloat(hr_dia_format) + parseFloat(hr_dia2_format);
					
					hr_dia_disp = 8.5 - hr_dia_total
					hr_dia_ocup = hr_dia_disp;
					
					if(hr_dia_total != 8.5){
						imagen = 'work4.png';
					}else{
						imagen = 'work.png';
					}						
					
				}else{

					if(dia_oper[2] != '8,50'){
						disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;	
					}
				}

				hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				//hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista1_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td id='+resp[i].OPER_RUT+'_x class="col-md-4 '+planificado+'">'+resp[i].OPERARIO+'</td>' +
				  '<td class="col-md-1"">'+dia_selec+'</td>' +
                '</tr>');				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}
		
		//console.log('i:'+i)
		while(i < cant_lista2){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			dia = resp[i].DIA[0];
			dia2 = resp[i].DIA[1];
			planificado = (resp[i].PLANIFICADO == 'S')? 'azul':'';
			console.log('planificado:'+planificado)
		
			id_diahrdisp = 'diahrdisp_'+resp[i].OPER_RUT;
			id_diahrocup = 'diahrocup_'+resp[i].OPER_RUT;
			hr_dia_disp = '8,5';
			hr_dia_ocup = '0';
			color = 'red';
			dobleactiv_dia = 0;
			//dia_oper = lunes
			if(dia != '0'){				
				dia_oper = dia.split('---');
				area_oper = dia_oper[0];
				activ_oper = dia_oper[1];
				horas_oper = dia_oper[2];
				hr_dia_format = dia_oper[2].replace(',','.');
							
				if(dia_oper[2] != '8,50'){
					imagen = 'work4.png';
				}else{
					imagen = 'work.png';
				}				
				hr_dia_disp = 8.5 - parseFloat(hr_dia_format);
				hr_dia_ocup = hr_dia_disp;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia_disp);
				

				if(dia2 != '0'){
					dia_oper2 = dia2.split('---');			
					
					area_oper = dia_oper[0]+','+dia_oper2[0];
					activ_oper = dia_oper[1]+','+dia_oper2[1];
					horas_oper = dia_oper[2]+'+'+dia_oper2[2];

					hr_dia2_format = dia_oper2[2].replace(',','.');
					
					hr_dia2_disp = 8.5 - parseFloat(hr_dia2_format);
					disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia2_disp);
					hr_dia_total = parseFloat(hr_dia_format) + parseFloat(hr_dia2_format);
					
					hr_dia_disp = 8.5 - hr_dia_total
					hr_dia_ocup = hr_dia_disp;
					
					if(hr_dia_total != 8.5){
						imagen = 'work4.png';
					}else{
						imagen = 'work.png';
					}						
					
				}else{

					if(dia_oper[2] != '8,50'){
						disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;	
					}
				}
				hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				//hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista2_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
				  '<td id='+resp[i].OPER_RUT+'_x class="col-md-4 '+planificado+'">'+resp[i].OPERARIO+'</td>' +
				  '<td class="col-md-1"">'+dia_selec+'</td>' +
                '</tr>');				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}


		while(i < cant_operadores){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			dia = resp[i].DIA[0];
			dia2 = resp[i].DIA[1];
			planificado = (resp[i].PLANIFICADO == 'S')? 'azul':'';
		
			id_diahrdisp = 'diahrdisp_'+resp[i].OPER_RUT;
			id_diahrocup = 'diahrocup_'+resp[i].OPER_RUT;
			hr_dia_disp = '8,5';
			hr_dia_ocup = '0';
			color = 'red';
			dobleactiv_dia = 0;
			//dia_oper = lunes
			if(dia != '0'){				
				dia_oper = dia.split('---');
				area_oper = dia_oper[0];
				activ_oper = dia_oper[1];
				horas_oper = dia_oper[2];
				hr_dia_format = dia_oper[2].replace(',','.');
							
				if(dia_oper[2] != '8,50'){
					imagen = 'work4.png';
				}else{
					imagen = 'work.png';
				}				
				hr_dia_disp = 8.5 - parseFloat(hr_dia_format);
				hr_dia_ocup = hr_dia_disp;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia_disp);
				

				if(dia2 != '0'){
					dia_oper2 = dia2.split('---');			
					
					area_oper = dia_oper[0]+','+dia_oper2[0];
					activ_oper = dia_oper[1]+','+dia_oper2[1];
					horas_oper = dia_oper[2]+'+'+dia_oper2[2];

					hr_dia2_format = dia_oper2[2].replace(',','.');
					
					hr_dia2_disp = 8.5 - parseFloat(hr_dia2_format);
					disp_jorn_lunes = parseFloat(disp_jorn_lunes) + parseFloat(hr_dia2_disp);
					hr_dia_total = parseFloat(hr_dia_format) + parseFloat(hr_dia2_format);
					
					hr_dia_disp = 8.5 - hr_dia_total
					hr_dia_ocup = hr_dia_disp;
					
					if(hr_dia_total != 8.5){
						imagen = 'work4.png';
					}else{
						imagen = 'work.png';
					}						
					
				}else{

					if(dia_oper[2] != '8,50'){
						disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;	
					}
				}
				hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				//hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista3_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td id='+resp[i].OPER_RUT+'_x class="col-md-4 '+planificado+'">'+resp[i].OPERARIO+'</td>' +
				  '<td class="col-md-1"">'+dia_selec+'</td>' +
                '</tr>');				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}



	}	


	function clic_operador(e){

		rut_oper = e.id;
		
		hora_activ = $('#hora_activ').val();
		diahr_disp = jornada_disponible(rut_oper,'diahrdisp');

		if($("#"+rut_oper).is(":checked")) {		
		console.log(hora_activ)
		console.log(diahr_disp)			
			if(hora_activ > diahr_disp ){
				$("#"+rut_oper).prop('checked',false)
				sweet_alert('Error: Disponibilidad menor al tiempo requerido');			
			}			
			else{
			
				diahr_disp = (hora_activ==0)?diahr_disp:hora_activ;
				$("#row_"+rut_oper).addClass('negrita');
				oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'SUMA');	
			}
		}else{
			$("#row_"+rut_oper).removeClass('negrita');
			oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'RESTA');
		}
		
	}
	
	function oper_jornada(id,id_ocup,i,disp_sel,oper){

		if(oper == 'SUMA'){
			if(disp_sel > 0) { 
				selec = String(disp_sel).replace('.',',');
				$('#'+id_ocup+'_'+id).html('Selec:'+selec).css('color','green');							
			}			
		}else{ //RESTA
			$('#'+id_ocup+'_'+id).html('Selec:0').css('color','red');			
		}
			
	}
	
	
	
	function jornada_disponible(id,id_disp){
		disponibilidad = $('#'+id_disp+'_'+id).html();
		disponibilidad = disponibilidad.split(':');
		disponibilidad = disponibilidad[1];							
		disponibilidad = String(disponibilidad).replace(',','.');
		return disponibilidad;
	}	
	
//BOTONES ABM	
	
	
	
	
	
	function validar_planxsemana(){
		
		var per_agno = h_per_agno;
		var sem_num = h_sem_num;		
		var plan_dia = $.trim($('#plan_dia').val());
		var sup_rut = $.trim($('#sup_rut').val());
		var activ_id = $.trim($('#activ_id').val());
		var rplan_motivo = $.trim($('#rplan_motivo').val());

		var oper_chequeados = 0;
		$('.check_oper').each( function() {
			if(this.checked) {
				oper_chequeados = oper_chequeados + 1;
			}				
		})
	
		if(per_agno == ''){
			sweet_alert('Error: Ingresar Año');	
			return false;
		}
		
		if(sem_num == ''){
			sweet_alert('Error: Ingresar Semana');	
			return false;
		}		
		
		if(plan_dia == ''){
			sweet_alert('Error: Ingresar día(s) a planificar');	
			return false;
		}
		
		if(sup_rut == ''){
			sweet_alert('Error: Seleccionar supervisor');	
			return false;
		}		
		
		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}	
		
		if(rplan_motivo == ''){
			sweet_alert('Error: Ingresar motivo de actualización');	
			return false;
		}		
		
		if(oper_chequeados == 0){
			sweet_alert('Error: Seleccionar trabajador(es)');	
			return false;
		}		
		
		return true;
	}
		  
	$('#btn_upd_supxactoperadores').click(function(){

		if (validar_planxsemana()){	

			$('#loading').show();
			
			var per_agno = h_per_agno;
			var sem_num = h_sem_num;	
			var plan_dia = $.trim($('#plan_dia').val());
			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var sup_rut = $.trim($('#sup_rut').val());
			var activ_id = $.trim($('#activ_id').val());
			var rplan_motivo = $.trim($('#rplan_motivo').val());			
			
			var oper_chequeados = {};
			var hr_chequeados = {};
			var i = 0; //operador
			
			var k = 0;


			$('.check_oper').each( function() {
				if(this.checked) {
					oper_chequeados[i] = this.id;
					hr_chequeados[i] = jornada_disponible(this.id,'diahrocup');						

					i++;
				}				
			})
			
			var operacion = 'UPDATE';			
			parametros = {			
							plan_dia:plan_dia,
							activ_id:activ_id,
							sup_rut:sup_rut,
							sem_num:sem_num,
							per_agno:per_agno,
							rplan_motivo:rplan_motivo,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/ges_crud_supxactoperadores.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxactoperadores(resp)
				   },"json"
			)
		}		
	})	
	
	function ges_crud_supxactoperadores(resp){
		//console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			var operacion = resp['operacion'];			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Actualización de operadores registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Actualización de operadores registrada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Nueva actividad eliminada", "success");
			}	

			load_operadores();

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}

	$('#btn_ir_supxactoperadores').click(function(){
		
		window.location.href = 'sup_actividades.php';
	})
	

/*	
	$('#btn_chk_supxactoperadores').click(function(){
		
		$('.azul').each( function() {
			id_chkazul = this.id	
			rut_oper1 = id_chkazul.split('_')
			rut_oper = rut_oper1[0]
			$('#'+rut_oper).prop('checked',true);			
			diahr_disp = jornada_disponible(rut_oper,'diahrdisp');
			$("#row_"+rut_oper).addClass('negrita');
			oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'SUMA');
		})	
		$('#btn_chk_supxactoperadores').hide();
		$('#btn_dchk_supxactoperadores').show();
	})
*/
	
	$('#btn_chk_supxactoperadores').click(function(){
		hora_activ = $('#hora_activ').val();
		$('.azul').each( function() {
			id_chkazul = this.id	
			rut_oper1 = id_chkazul.split('_')
			rut_oper = rut_oper1[0]			
						
			diahr_disp = jornada_disponible(rut_oper,'diahrdisp');
			
			if(hora_activ <= diahr_disp ){
				diahr_disp = (hora_activ==0)?diahr_disp:hora_activ;
				$("#row_"+rut_oper).addClass('negrita');
				oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'SUMA');
				//$('#'+rut_oper).prop('checked',true);
			}else{
				diahr_disp = jornada_disponible(rut_oper,'diahrdisp');
				$("#row_"+rut_oper).addClass('negrita');
				oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'SUMA');			
			}
			$('#'+rut_oper).prop('checked',true);
		})	
		$('#btn_chk_supxactoperadores').hide();
		$('#btn_dchk_supxactoperadores').show();
	})	
	
	$('#btn_dchk_supxactoperadores').click(function(){
		
		$('.azul').each( function() {
			id_chkazul = this.id	
			rut_oper1 = id_chkazul.split('_')
			rut_oper = rut_oper1[0]
			$('#'+rut_oper).prop('checked',false);
			$("#row_"+rut_oper).removeClass('negrita');
			oper_jornada(rut_oper,'diahrocup',0,0,'RESTA');			
		})
		$('#btn_dchk_supxactoperadores').hide();
		$('#btn_chk_supxactoperadores').show();
				
	})	
	
	
});