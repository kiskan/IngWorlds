$(document).ready(function(){
/*
	$('#sup_rut').select2({	});
	$('#activ_id').select2({ });
*/

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
		//console.log(parametros)
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
		//console.log(resp[0].ACTIV_STANDAR)
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

		$.post(
			"consultas/ges_crud_supxreplanificacion.php",
			parametros,			   
			function(resp){
				carga_operadores(resp)
			},"json"
		)					
	}	
	
	function carga_operadores(resp){

		//console.log(resp)	
		
		var cant_operadores = resp.length;
		var cant_lista1 = Math.round(cant_operadores/3);
		var cant_lista2 = Math.round(cant_operadores/3)*2;
		var i = 0;
		var operadores_ocupados = 0;		
		var disp_oper_lunes = 0;
		var disp_jorn_lunes = 0;
		
		while(i < cant_lista1){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			dia = resp[i].DIA[0];
			dia2 = resp[i].DIA[1];
		
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
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista1_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td class="col-md-4">'+resp[i].OPERARIO+'</td>' +
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
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista2_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td class="col-md-4">'+resp[i].OPERARIO+'</td>' +
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
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');

				dia_selec = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span>Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
				
				
			}else{
				imagen = 'reloj.png';
				
				hr_dia_disp = String(hr_dia_disp).replace('.',',');
				
				dia_selec = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
				disp_oper_lunes = parseFloat(disp_oper_lunes) + 1;
				disp_jorn_lunes = parseFloat(disp_jorn_lunes) + 8.5;
			}

			
			$('#lista3_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td class="col-md-4">'+resp[i].OPERARIO+'</td>' +
				  '<td class="col-md-1"">'+dia_selec+'</td>' +
                '</tr>');				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}



	}	


	function clic_operador(e){

		rut_oper = e.id;
			
		if($("#"+rut_oper).is(":checked")) {						
			$("#row_"+rut_oper).addClass('negrita');
			diahr_disp = jornada_disponible(rut_oper,'diahrdisp');	
			oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'SUMA');				
		}else{
			$("#row_"+rut_oper).removeClass('negrita');
			diahr_disp = jornada_disponible(rut_oper,'diahrdisp');	
			oper_jornada(rut_oper,'diahrocup',0,diahr_disp,'RESTA');
		}
	}
	
	function oper_jornada(id,id_ocup,i,disp_sel,oper){

		if(oper == 'SUMA'){
			if(disp_sel > 0) { 
				selec = String(disp_sel).replace(',','.');
				$('#'+id_ocup+'_'+id).html('Selec:'+selec).css('color','green');							
			}			
		}else{ //RESTA
			selec_jornada = jornada_disponible(id,id_ocup);
			$('#'+id_ocup+'_'+id).html('Selec:0').css('color','red');			
		}
			
	}
/*
	function limpiar_tabla(){
		$('.check_oper').each( function() {
			if(this.checked) {
				rut_oper = this.id;
				$("#lunhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#marhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#miehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#juehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#viehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#"+rut_oper).prop('checked',false)
				$("#row_"+rut_oper).removeClass('negrita');
			}				
		})

		i = 0;
		while(i < 5){
			$('#selec_jorn').children('td').eq(i).text(0);
			$('#selec_oper').children('td').eq(i).text(0);
			$('#selec_prod').children('td').eq(i).text(0);
			i++;
		}	
	}
	
	function calcular_produccion(){
		var meta = $('#plan_meta').val();
		var i = 0;
		meta = String(meta).replace(',','.');
		if(meta > 0){
			while( i < 5 ){
				jornada = $('#selec_jorn').children('td').eq(i).text();
				jornada = String(jornada).replace(',','.');
				produccion = parseFloat(jornada) * parseFloat(meta);
				produccion = Math.round(produccion * 100)/100;
				produccion = String(produccion).replace('.',',');
				$('#selec_prod').children('td').eq(i).text(produccion);
				i++;
			}
		}
	}
	
	function clic_colacion(e){
		
		id_split = e.id;
		id_split = id_split.split('_');
		rut_oper = id_split[1];
		row = 'row_'+rut_oper;
		
		monto_activ = $('#'+row).children('td').eq(7).text();
		monto_activ = String(monto_activ).replace(',','.');
		if($("#col_"+rut_oper).is(":checked")) {			
			monto = parseFloat(monto_activ) - 1;			
		}else{
			monto = parseFloat(monto_activ) + 1;
		}
		monto = String(monto).replace('.',',');
		$('#'+row).children('td').eq(7).text(monto);
		calcular_jornada();
	}	
	
	function carga_jornada(e){
		id_split = e.id;
		id_split = id_split.split('_');
		rut_oper = id_split[1];
		
		row = 'row_'+rut_oper;
		col = 'col_'+rut_oper;
		hrini = $('#hrini_'+rut_oper).val();
		minini = $('#minini_'+rut_oper).val();
		hrfin = $('#hrfin_'+rut_oper).val();
		minfin = $('#minfin_'+rut_oper).val();
		
		var hora_inicio = moment(hrini+':'+minini,'HH:mm');
		var hora_fin = moment(hrfin+':'+minfin,'HH:mm');
		
		resultado = Math.round((hora_fin.diff(hora_inicio, 'minutes')/60) * 100) / 100
				
		//jornada = $('#plan_jornada').val();
		
		//si está chequeado la colación se le resta 1 hora
		if($("#"+col).is(":checked")) {
			resultado = resultado - 1;
		}
		resultado = String(resultado).replace('.',',');
		$('#'+row).children('td').eq(7).text(resultado)
		calcular_jornada();

		if(resultado < 0){			
			sweet_alert('Error: Tiempo de actividad negativo');
			$('#'+rut_oper).prop('checked',false);
			//reset_operador(rut_oper);
		}	
	}
	
	function calcular_jornada(){
	
		var i = 0;
		var monto_chequeado = 0;
		$('.check_oper').each( function() {
			if(this.checked) {
				monto_chequeado = monto_chequeado + 8.5;
				i = i + 1;
			}				
		})
		//$('#plan_operadores').val(i)
		monto_chequeado = String(monto_chequeado).replace('.',',');
		//$('#plan_jornada').val(monto_chequeado);	
		meta = $('#plan_meta').val();
		meta = String(meta).replace(',','.');
		
		if( meta > 0 ) {
			monto_chequeado = String(monto_chequeado).replace(',','.');
			produccion = monto_chequeado * meta;
			produccion = Math.round(produccion * 100)/100;
			produccion = String(produccion).replace('.',',');
			//$('#plan_produccion').val(produccion);		
			//$('#plan_produccion').val('0');
		}else{
			//$('#plan_produccion').val('');
		}	
	}
	
	$('#plan_dia').change(function() {	
		limpiar_tabla();
	})
	
	$('#btn_operadores').click(function() {
		
		var num_operadores = $('#plan_operadores').val();		
		var total_operadores = $("#lista1_operadores tr").length + $("#lista2_operadores tr").length;
		var plan_dia = $.trim($('#plan_dia').val());
		var hora_activ = $('#hora_activ').val();
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');

		if(plan_dia == ''){
			sweet_alert('Error: Ingresar día(s) a planificar');	
			return false;
		}		
		else if(num_operadores == '' || num_operadores < 1){
			sweet_alert('Error: Indicar número mayor a cero');
			return false;
		}	
		else{
			if(num_operadores > total_operadores){
				sweet_alert('Error: Puede indicar un máximo de '+total_operadores+ ' operadores');
				$('#plan_operadores').val('');
				return false;
			}else{	
				limpiar_tabla();		
							
				//Validar que existe la cantidad de operadores necesitados
				if(!validar_oper_disp(num_operadores)){
					sweet_alert('Error: No existe esa cantidad de operadores disponibles en día(s) seleccionado(s) y hora seleccionada');	
					return false;					
				}				

				sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;
				deuda_oper_lun = 0;deuda_oper_mar = 0;deuda_oper_mie = 0;deuda_oper_jue = 0;deuda_oper_vie = 0;
				$('.check_oper').each( function() {
					
					if(num_operadores > 0){ 
						
						if($.inArray("LUN", plan_dia_text) !== -1 ){
							lunhr_disp = jornada_disponible(this.id,'lunhrdisp')
							//if(lunhr_disp > 0){
							if(lunhr_disp > 0 && lunhr_disp >= hora_activ){		
								if(hora_activ > 0){
									lunhr_disp = hora_activ
								}							
								sum_jorn_lun = sum_jorn_lun + parseFloat(lunhr_disp);
								lunhr_disp = String(lunhr_disp).replace('.',',');
								$('#lunhrocup_'+this.id).html('Selec:'+lunhr_disp).css('color','green');								
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_lun++;
							}
						}
						if($.inArray('MAR', plan_dia_text) !== -1 ){
							marhr_disp = jornada_disponible(this.id,'marhrdisp')
							if(marhr_disp > 0 && marhr_disp >= hora_activ){
								if(hora_activ > 0){
									marhr_disp = hora_activ
								}								
								sum_jorn_mar = sum_jorn_mar + parseFloat(marhr_disp); 
								marhr_disp = String(marhr_disp).replace('.',',');
								$('#marhrocup_'+this.id).html('Selec:'+marhr_disp).css('color','green');								
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_mar++;
							}								
						}
						if($.inArray('MIE', plan_dia_text) !== -1 ){
							miehr_disp = jornada_disponible(this.id,'miehrdisp')
							if(miehr_disp > 0 && miehr_disp >= hora_activ){
								if(hora_activ > 0){
									miehr_disp = hora_activ
								}								
								sum_jorn_mie = sum_jorn_mie + parseFloat(miehr_disp);
								miehr_disp = String(miehr_disp).replace('.',',');
								$('#miehrocup_'+this.id).html('Selec:'+miehr_disp).css('color','green');							
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_mie++;
							}								
						}
						if($.inArray('JUE', plan_dia_text) !== -1 ){
							juehr_disp = jornada_disponible(this.id,'juehrdisp')
							if(juehr_disp > 0 && juehr_disp >= hora_activ){
								if(hora_activ > 0){
									juehr_disp = hora_activ
								}								
								sum_jorn_jue = sum_jorn_jue + parseFloat(juehr_disp);
								juehr_disp = String(juehr_disp).replace('.',',');
								$('#juehrocup_'+this.id).html('Selec:'+juehr_disp).css('color','green');							
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_jue++;
							}								
						}
						if($.inArray('VIE', plan_dia_text) !== -1 ){
							viehr_disp = jornada_disponible(this.id,'viehrdisp')
							if(viehr_disp > 0 && viehr_disp >= hora_activ){
								if(hora_activ > 0){
									viehr_disp = hora_activ
								}															
								sum_jorn_vie = sum_jorn_vie + parseFloat(viehr_disp);
								viehr_disp = String(viehr_disp).replace('.',',');
								$('#viehrocup_'+this.id).html('Selec:'+viehr_disp).css('color','green');								 
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_vie++;
							}								
						}

						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}
					}					
					
					num_operadores--;
					
					if(num_operadores < 0 && deuda_oper_lun > 0){
						lunhr_disp = jornada_disponible(this.id,'lunhrdisp')
						//if(lunhr_disp > 0){
						if(lunhr_disp > 0 && lunhr_disp >= hora_activ){		
							if(hora_activ > 0){
								lunhr_disp = hora_activ
							}								
							sum_jorn_lun = sum_jorn_lun + parseFloat(lunhr_disp);
							lunhr_disp = String(lunhr_disp).replace('.',',');
							$('#lunhrocup_'+this.id).html('Selec:'+lunhr_disp).css('color','green');						
							chequear = 'S';
							deuda_oper_lun--;
						}else{
							chequear = 'N';							
						}
						
						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}						
					}
					
					if(num_operadores < 0 && deuda_oper_mar > 0){
						marhr_disp = jornada_disponible(this.id,'marhrdisp')
						if(marhr_disp > 0 && marhr_disp >= hora_activ){
							if(hora_activ > 0){
								marhr_disp = hora_activ
							}
							sum_jorn_mar = sum_jorn_mar + parseFloat(marhr_disp);
							marhr_disp = String(marhr_disp).replace('.',',');
							$('#marhrocup_'+this.id).html('Selec:'+marhr_disp).css('color','green');							
							chequear = 'S';
							deuda_oper_mar--;
						}else{
							chequear = 'N';							
						}
						
						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}						
					}					

					if(num_operadores < 0 && deuda_oper_mie > 0){
						miehr_disp = jornada_disponible(this.id,'miehrdisp')
						if(miehr_disp > 0 && miehr_disp >= hora_activ){
							if(hora_activ > 0){
								miehr_disp = hora_activ
							}
							sum_jorn_mie = sum_jorn_mie + parseFloat(miehr_disp);
							miehr_disp = String(miehr_disp).replace('.',',');
							$('#miehrocup_'+this.id).html('Selec:'+miehr_disp).css('color','green');							
							chequear = 'S';
							deuda_oper_mie--;
						}else{
							chequear = 'N';							
						}
						
						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}						
					}
					
					if(num_operadores < 0 && deuda_oper_jue > 0){
						juehr_disp = jornada_disponible(this.id,'juehrdisp')
						if(juehr_disp > 0 && juehr_disp >= hora_activ){
							if(hora_activ > 0){
								juehr_disp = hora_activ
							}
							sum_jorn_jue = sum_jorn_jue + parseFloat(juehr_disp);
							juehr_disp = String(juehr_disp).replace('.',',');
							$('#juehrocup_'+this.id).html('Selec:'+juehr_disp).css('color','green');							
							chequear = 'S';
							deuda_oper_jue--;
						}else{
							chequear = 'N';							
						}
						
						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}						
					}
					
					if(num_operadores < 0 && deuda_oper_vie > 0){
						viehr_disp = jornada_disponible(this.id,'viehrdisp')
						if(viehr_disp > 0 && viehr_disp >= hora_activ){
							if(hora_activ > 0){
								viehr_disp = hora_activ
							}
							sum_jorn_vie = sum_jorn_vie + parseFloat(viehr_disp);
							viehr_disp = String(viehr_disp).replace('.',',');
							$('#viehrocup_'+this.id).html('Selec:'+viehr_disp).css('color','green');							
							chequear = 'S';
							deuda_oper_vie--;
						}else{
							chequear = 'N';							
						}
						
						if(chequear == 'S'){
							$('#'+this.id).prop('checked',true); 
							$("#row_"+this.id).addClass('negrita');	
						}								
					}
				})	

				num_operadores = $('#plan_operadores').val();
				var meta = $('#plan_meta').val();
				meta = meta.replace(',','.');	
				
				if($.inArray('LUN', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){						
						produccion = sum_jorn_lun * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(0).text(produccion);
					}	
					sum_jorn_lun = String(sum_jorn_lun).replace('.',',');
					$('#selec_jorn').children('td').eq(0).text(sum_jorn_lun);
					$('#selec_oper').children('td').eq(0).text(num_operadores);					
				}
				if($.inArray('MAR', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_mar * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(1).text(produccion);
					}	
					sum_jorn_mar = String(sum_jorn_mar).replace('.',',');
					$('#selec_jorn').children('td').eq(1).text(sum_jorn_mar);
					$('#selec_oper').children('td').eq(1).text(num_operadores);					
				}
				if($.inArray('MIE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_mie * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(2).text(produccion);
					}	
					sum_jorn_mie = String(sum_jorn_mie).replace('.',',');
					$('#selec_jorn').children('td').eq(2).text(sum_jorn_mie);
					$('#selec_oper').children('td').eq(2).text(num_operadores);					
				}
				if($.inArray('JUE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_jue * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(3).text(produccion);
					}	
					sum_jorn_jue = String(sum_jorn_jue).replace('.',',');
					$('#selec_jorn').children('td').eq(3).text(sum_jorn_jue);
					$('#selec_oper').children('td').eq(3).text(num_operadores);					
				}
				if($.inArray('VIE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_vie * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(4).text(produccion);
					}	
					sum_jorn_vie = String(sum_jorn_vie).replace('.',',');
					$('#selec_jorn').children('td').eq(4).text(sum_jorn_vie);
					$('#selec_oper').children('td').eq(4).text(num_operadores);					
				}

			}
		}
	})

	function validar_oper_disp(cant_oper){
	
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');
		var hora_activ = $('#hora_activ').val();
		
		sum_oper_lun = 0;sum_oper_mar = 0;sum_oper_mie = 0;sum_oper_jue = 0;sum_oper_vie = 0;
		$('.check_oper').each( function() {
			
			if($.inArray("LUN", plan_dia_text) !== -1 ){
				lunhr_disp = jornada_disponible(this.id,'lunhrdisp')
				if(lunhr_disp > 0 && lunhr_disp >= hora_activ){sum_oper_lun++}
			}
			if($.inArray('MAR', plan_dia_text) !== -1 ){
				marhr_disp = jornada_disponible(this.id,'marhrdisp')
				if(marhr_disp > 0 && marhr_disp >= hora_activ){sum_oper_mar++}
			}
			if($.inArray('MIE', plan_dia_text) !== -1 ){
				miehr_disp = jornada_disponible(this.id,'miehrdisp')
				if(miehr_disp > 0 && miehr_disp >= hora_activ){sum_oper_mie++}
			}
			if($.inArray('JUE', plan_dia_text) !== -1 ){
				juehr_disp = jornada_disponible(this.id,'juehrdisp')
				if(juehr_disp > 0 && juehr_disp >= hora_activ){sum_oper_jue++}
			}
			if($.inArray('VIE', plan_dia_text) !== -1 ){
				viehr_disp = jornada_disponible(this.id,'viehrdisp')
				if(viehr_disp > 0 && viehr_disp >= hora_activ){sum_oper_vie++}				
			}					
		})
		
		if($.inArray("LUN", plan_dia_text) !== -1 ){
			if(sum_oper_lun < cant_oper)return false;
		}
		if($.inArray('MAR', plan_dia_text) !== -1 ){
			if(sum_oper_mar < cant_oper)return false;
		}
		if($.inArray('MIE', plan_dia_text) !== -1 ){
			if(sum_oper_mie < cant_oper)return false;
		}
		if($.inArray('JUE', plan_dia_text) !== -1 ){
			if(sum_oper_jue < cant_oper)return false;
		}
		if($.inArray('VIE', plan_dia_text) !== -1 ){
			if(sum_oper_vie < cant_oper)return false;			
		}

		return true;
	}
	
	function jornada_disponible(id,id_disp){
		disponibilidad = $('#'+id_disp+'_'+id).html();
		disponibilidad = disponibilidad.split(':');
		disponibilidad = disponibilidad[1];							
		disponibilidad = String(disponibilidad).replace(',','.');
		return disponibilidad;
	}
	
	function validar_jorn_disp(jornada){
	
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');
		var hora_activ = $('#hora_activ').val();
		
		sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;
		$('.check_oper').each( function() {
			
			if($.inArray("LUN", plan_dia_text) !== -1 ){
				lunhr_disp = jornada_disponible(this.id,'lunhrdisp')
				//sum_jorn_lun = sum_jorn_lun + lunhr_disp

				if(lunhr_disp > 0 && lunhr_disp >= hora_activ){		
					if(hora_activ > 0){
						lunhr_disp = hora_activ
					}								
					sum_jorn_lun = sum_jorn_lun + parseFloat(lunhr_disp);
				}	
			}
			if($.inArray('MAR', plan_dia_text) !== -1 ){
				marhr_disp = jornada_disponible(this.id,'marhrdisp')
				//sum_jorn_mar = sum_jorn_mar + marhr_disp
				if(marhr_disp > 0 && marhr_disp >= hora_activ){
					if(hora_activ > 0){
						marhr_disp = hora_activ
					}
					sum_jorn_mar = sum_jorn_mar + parseFloat(marhr_disp);
				}
				
			}
			if($.inArray('MIE', plan_dia_text) !== -1 ){
				miehr_disp = jornada_disponible(this.id,'miehrdisp')
				//sum_jorn_mie = sum_jorn_mie + miehr_disp
				if(miehr_disp > 0 && miehr_disp >= hora_activ){
					if(hora_activ > 0){
						miehr_disp = hora_activ
					}
					sum_jorn_mie = sum_jorn_mie + parseFloat(miehr_disp);
				}
			}
			if($.inArray('JUE', plan_dia_text) !== -1 ){
				juehr_disp = jornada_disponible(this.id,'juehrdisp')
				//sum_jorn_jue = sum_jorn_jue + juehr_disp
				if(juehr_disp > 0 && juehr_disp >= hora_activ){
					if(hora_activ > 0){
						juehr_disp = hora_activ
					}
					sum_jorn_jue = sum_jorn_jue + parseFloat(juehr_disp);
				}
			}
			if($.inArray('VIE', plan_dia_text) !== -1 ){
				viehr_disp = jornada_disponible(this.id,'viehrdisp')
				//sum_jorn_vie = sum_jorn_vie + viehr_disp			
				if(viehr_disp > 0 && viehr_disp >= hora_activ){
					if(hora_activ > 0){
						viehr_disp = hora_activ
					}
					sum_jorn_vie = sum_jorn_vie + parseFloat(viehr_disp);
				}
			}					
		})
		
		if($.inArray("LUN", plan_dia_text) !== -1 ){
			if(sum_jorn_lun < jornada)return false;
		}
		if($.inArray('MAR', plan_dia_text) !== -1 ){
			if(sum_jorn_mar < jornada)return false;
		}
		if($.inArray('MIE', plan_dia_text) !== -1 ){
			if(sum_jorn_mie < jornada)return false;
		}
		if($.inArray('JUE', plan_dia_text) !== -1 ){
			if(sum_jorn_jue < jornada)return false;
		}
		if($.inArray('VIE', plan_dia_text) !== -1 ){
			if(sum_jorn_vie < jornada)return false;			
		}

		return true;
	}		
	
	$('#btn_prod_esperada').click(function() {
		
		var prod_esperada = $('#plan_prod_esperada').val();	
		prod_esperada = prod_esperada.replace(',','.');
		prod_esperada = Math.round(prod_esperada * 100)/100;
		$('#plan_prod_esperada').val(prod_esperada);
		var meta = $('#plan_meta').val();
		meta = meta.replace(',','.');
		var hora_activ = $('#hora_activ').val();

		var plan_dia = $.trim($('#plan_dia').val());
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');

		if(plan_dia == ''){
			sweet_alert('Error: Ingresar día(s) a planificar');	
			return false;
		}		
		else if(prod_esperada == '' || prod_esperada == 0){
			sweet_alert('Error: Indicar número mayor a cero');
			$('#plan_prod_esperada').val('');
		}		
		else{
			if(meta == '' || meta == 0){
				sweet_alert('Error: No existe meta para la producción');
				$('#plan_prod_esperada').val('');	
			}
			else{
				
				jornada = prod_esperada / meta;
				jornada = Math.round(jornada * 100)/100;
				//console.log(jornada)
				
				limpiar_tabla();		
							
				//Validar que existe la jornada esperada
				if(!validar_jorn_disp(jornada)){
					sweet_alert('Error: No existe esa cantidad de jornadas disponibles en día(s) seleccionado(s) y hora seleccionada');	
					return false;					
				}				

				sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;
				sum_oper_lun = 0;sum_oper_mar = 0;sum_oper_mie = 0;sum_oper_jue = 0;sum_oper_vie = 0;
				$('.check_oper').each( function() {

					if($.inArray("LUN", plan_dia_text) !== -1 ){
						if(sum_jorn_lun != jornada){
							lunhr_disp = jornada_disponible(this.id,'lunhrdisp')						
							lunhr_disp2 = jornada_disponible(this.id,'lunhrdisp')
							if(lunhr_disp > 0){// && lunhr_disp >= hora_activ){	
								if(hora_activ > 0){
									lunhr_disp = hora_activ
								}	
								sum_jorn_lun2 = sum_jorn_lun;
								sum_jorn_lun = sum_jorn_lun + parseFloat(lunhr_disp);
								sum_jorn_lun = Math.round(sum_jorn_lun * 100)/100;
								if(sum_jorn_lun > jornada){
									lunhr_disp = lunhr_disp - (sum_jorn_lun - jornada);
									lunhr_disp = Math.round(lunhr_disp * 100)/100;
									sum_jorn_lun = jornada;
								}
								//console.log('lunhr_disp2:'+lunhr_disp2)
								//console.log('lunhr_disp:'+lunhr_disp)
								if(lunhr_disp2 < lunhr_disp){

									sum_jorn_lun = sum_jorn_lun2;
								}else{

									sum_oper_lun++;
									lunhr_disp = String(lunhr_disp).replace('.',',');
									$('#lunhrocup_'+this.id).html('Selec:'+lunhr_disp).css('color','green');						
									$('#'+this.id).prop('checked',true); 
									$("#row_"+this.id).addClass('negrita');	
								}	
							}						
						}
					}
					
					if($.inArray('MAR', plan_dia_text) !== -1 ){				
						if(sum_jorn_mar != jornada){
							marhr_disp = jornada_disponible(this.id,'marhrdisp')
							marhr_disp2 = jornada_disponible(this.id,'marhrdisp')
							if(marhr_disp > 0){// && marhr_disp >= hora_activ){
								if(hora_activ > 0){
									marhr_disp = hora_activ
								}	
								sum_jorn_mar2 = sum_jorn_mar;
								sum_jorn_mar = sum_jorn_mar + parseFloat(marhr_disp);
								sum_jorn_mar = Math.round(sum_jorn_mar * 100)/100;
								if(sum_jorn_mar > jornada){
									//marhr_disp = sum_jorn_mar - jornada;
									marhr_disp = marhr_disp - (sum_jorn_mar - jornada);
									marhr_disp = Math.round(marhr_disp * 100)/100;
									sum_jorn_mar = jornada;
								}
								
								if(marhr_disp2 < marhr_disp){
									sum_jorn_mar = sum_jorn_mar2;
								}else{								
									sum_oper_mar++;
									marhr_disp = String(marhr_disp).replace('.',',');
									$('#marhrocup_'+this.id).html('Selec:'+marhr_disp).css('color','green');						
									$('#'+this.id).prop('checked',true); 
									$("#row_"+this.id).addClass('negrita');	
								}
							}						
						}	
					}
					
					
					if($.inArray('MIE', plan_dia_text) !== -1 ){
						if(sum_jorn_mie != jornada){
							miehr_disp = jornada_disponible(this.id,'miehrdisp')
							miehr_disp2 = jornada_disponible(this.id,'miehrdisp')
							if(miehr_disp > 0 && miehr_disp >= hora_activ){
								if(hora_activ > 0){
									miehr_disp = hora_activ
								}	
								sum_jorn_mie2 = sum_jorn_mie;
								sum_jorn_mie = sum_jorn_mie + parseFloat(miehr_disp);
								sum_jorn_mie = Math.round(sum_jorn_mie * 100)/100;
								if(sum_jorn_mie > jornada){
									//miehr_disp = sum_jorn_mie - jornada;
									miehr_disp = miehr_disp - (sum_jorn_mie - jornada);
									miehr_disp = Math.round(miehr_disp * 100)/100;
									sum_jorn_mie = jornada;
								}
								
								if(miehr_disp2 < miehr_disp){
									sum_jorn_mie = sum_jorn_mie2;
								}else{									
									sum_oper_mie++;
									miehr_disp = String(miehr_disp).replace('.',',');
									$('#miehrocup_'+this.id).html('Selec:'+miehr_disp).css('color','green');						
									$('#'+this.id).prop('checked',true); 
									$("#row_"+this.id).addClass('negrita');
								}
							}						
						}
					}
					
					if($.inArray('JUE', plan_dia_text) !== -1 ){				
						if(sum_jorn_jue != jornada){
							juehr_disp = jornada_disponible(this.id,'juehrdisp')
							juehr_disp2 = jornada_disponible(this.id,'juehrdisp')
							if(juehr_disp > 0 && juehr_disp >= hora_activ){
								if(hora_activ > 0){
									juehr_disp = hora_activ
								}	
								sum_jorn_jue2 = sum_jorn_jue;
								sum_jorn_jue = sum_jorn_jue + parseFloat(juehr_disp);
								sum_jorn_jue = Math.round(sum_jorn_jue * 100)/100;
								if(sum_jorn_jue > jornada){
									//juehr_disp = sum_jorn_jue - jornada;
									juehr_disp = juehr_disp - (sum_jorn_jue - jornada);
									juehr_disp = Math.round(juehr_disp * 100)/100;
									sum_jorn_jue = jornada;
								}
								
								if(juehr_disp2 < juehr_disp){
									sum_jorn_jue = sum_jorn_jue2;
								}else{									
									sum_oper_jue++;
									juehr_disp = String(juehr_disp).replace('.',',');
									$('#juehrocup_'+this.id).html('Selec:'+juehr_disp).css('color','green');						
									$('#'+this.id).prop('checked',true); 
									$("#row_"+this.id).addClass('negrita');
								}
							}						
						}
					}
					
					if($.inArray('VIE', plan_dia_text) !== -1 ){	
						if(sum_jorn_vie != jornada){
							viehr_disp = jornada_disponible(this.id,'viehrdisp')
							viehr_disp2 = jornada_disponible(this.id,'viehrdisp')
							if(viehr_disp > 0 && viehr_disp >= hora_activ){
								if(hora_activ > 0){
									viehr_disp = hora_activ
								}
								sum_jorn_vie2 = sum_jorn_vie;
								sum_jorn_vie = sum_jorn_vie + parseFloat(viehr_disp);
								sum_jorn_vie = Math.round(sum_jorn_vie * 100)/100;
								if(sum_jorn_vie > jornada){
									//viehr_disp = sum_jorn_vie - jornada;
									viehr_disp = viehr_disp - (sum_jorn_vie - jornada);
									viehr_disp = Math.round(viehr_disp * 100)/100;
									sum_jorn_vie = jornada;
								}
								
								if(viehr_disp2 < viehr_disp){
									sum_jorn_vie = sum_jorn_vie2;
								}else{								
									sum_oper_vie++;
									viehr_disp = String(viehr_disp).replace('.',',');
									$('#viehrocup_'+this.id).html('Selec:'+viehr_disp).css('color','green');						
									$('#'+this.id).prop('checked',true); 
									$("#row_"+this.id).addClass('negrita');
								}
							}						
						}
					}	
					
					
				})				



				//num_operadores = $('#plan_operadores').val();
				var meta = $('#plan_meta').val();
				meta = meta.replace(',','.');	
				
				if($.inArray('LUN', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){						
						produccion = sum_jorn_lun * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(0).text(produccion);
					}	
					sum_jorn_lun = String(sum_jorn_lun).replace('.',',');
					$('#selec_jorn').children('td').eq(0).text(sum_jorn_lun);
					$('#selec_oper').children('td').eq(0).text(sum_oper_lun);					
				}
				if($.inArray('MAR', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_mar * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(1).text(produccion);
					}	
					sum_jorn_mar = String(sum_jorn_mar).replace('.',',');
					$('#selec_jorn').children('td').eq(1).text(sum_jorn_mar);
					$('#selec_oper').children('td').eq(1).text(sum_oper_mar);					
				}
				if($.inArray('MIE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_mie * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(2).text(produccion);
					}	
					sum_jorn_mie = String(sum_jorn_mie).replace('.',',');
					$('#selec_jorn').children('td').eq(2).text(sum_jorn_mie);
					$('#selec_oper').children('td').eq(2).text(sum_oper_mie);					
				}
				if($.inArray('JUE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_jue * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(3).text(produccion);
					}	
					sum_jorn_jue = String(sum_jorn_jue).replace('.',',');
					$('#selec_jorn').children('td').eq(3).text(sum_jorn_jue);
					$('#selec_oper').children('td').eq(3).text(sum_oper_jue);					
				}
				if($.inArray('VIE', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_vie * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(4).text(produccion);
					}	
					sum_jorn_vie = String(sum_jorn_vie).replace('.',',');
					$('#selec_jorn').children('td').eq(4).text(sum_jorn_vie);
					$('#selec_oper').children('td').eq(4).text(sum_oper_vie);					
				}



				
			}
		}
	})	
	
*/	
	
	
	
	
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
		
		if(oper_chequeados == 0){
			sweet_alert('Error: Seleccionar trabajador(es)');	
			return false;
		}		
		
		return true;
	}
		  
	$('#btn_reg_supxreplanificacion').click(function(){

		if (validar_planxsemana()){	

			$('#loading').show();
			
			var per_agno = h_per_agno;
			var sem_num = h_sem_num;	
			var plan_dia = $.trim($('#plan_dia').val());
			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var sup_rut = $.trim($('#sup_rut').val());
			var activ_id =$.trim($('#activ_id').val());			
			
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
			
			var operacion = 'INSERT';			
			parametros = {			
							plan_dia:plan_dia,
							activ_id:activ_id,
							sup_rut:sup_rut,
							sem_num:sem_num,
							per_agno:per_agno,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							sactiv_id:sactiv_id,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/ges_crud_supxreplanificacion.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxreplanificacion(resp)
				   },"json"
			)
		}		
	})	
	/*
 	$('#btn_upd_planxsemana').click(function(){
		if (validar_planxsemana()){	

			$('#loading').show();

			var per_agno = h_per_agno;
			var sem_num = h_sem_num;		
			var plan_dia = $.trim($('#plan_dia').val());
			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var sup_rut = $.trim($('#sup_rut').val());
			var activ_id = $.trim($('#activ_id').val());
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];
			
			var h_activ_id = $.trim($('#h_activ_id').val());
			h_activ_split = h_activ_id.split('---');			
			h_activ_id = h_activ_split[0];			
			var h_plan_dia = $.trim($('#h_plan_dia').val());			
			
			var oper_chequeados = {};
			var hr_chequeados = {};
			var i = 0; //operador
			
			var dias_split = plan_dia.split(',');
			var num_dias = dias_split.length
			var k = 0;
			
			while(k < num_dias){
				hr_chequeados[k] = {};
				k++;
			}

			$('.check_oper').each( function() {
				if(this.checked) {
					oper_chequeados[i] = this.id;
					j = 0; //día a planificar

					if($.inArray('LUN', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'lunhrocup');						
						j++;
					}
					if($.inArray('MAR', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'marhrocup');
						j++;						
					}
					if($.inArray('MIE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'miehrocup');
						j++;						
					}
					if($.inArray('JUE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'juehrocup');
						j++;						
					}
					if($.inArray('VIE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'viehrocup');
					}						
					
					i++;
				}				
			})			
			
			var operacion = 'UPDATE';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							sup_rut:sup_rut,
							activ_id:activ_id,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							h_activ_id:h_activ_id,
							h_plan_dia:h_plan_dia,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_planxsemana.php",
				   parametros,			   
				   function(resp){
						ges_crud_planxsemana(resp)
				   },"json"
			)			
			return false;		
		}
	})		

 	$('#btn_del_planxsemana').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta planificación?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_activ_id = $.trim($('#h_activ_id').val());
				h_activ_split = h_activ_id.split('---');			
				h_activ_id = h_activ_split[0];			
				var h_plan_dia = $.trim($('#h_plan_dia').val());
				var operacion = 'DELETE';
				parametros = {	
								h_activ_id:h_activ_id,
								h_plan_dia:h_plan_dia,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_planxsemana.php",
					   parametros,			   
					   function(resp){
							ges_crud_planxsemana(resp)
					   },"json"
				)
		});	
		
	})		
	*/
	function ges_crud_supxreplanificacion(resp){
		//console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			$('#btn_reg_supxreplanificacion').hide();
			$('#btn_ir_supxreplanificacion').show();
			
			var operacion = resp['operacion'];			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Nueva actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Nueva actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Nueva actividad eliminada", "success");
			}		

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}

	$('#btn_ir_supxreplanificacion').click(function(){
		
		window.location.href = 'sup_actividades.php';
	})
	
	
});