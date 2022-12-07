
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}
	
	function RealizarActiv(id_activ){
		//console.log(id_activ)
		plan_dia = $('#plan_dia').val();
		$('#plan_dia').prop('disabled',true);
		$('#btn_actividades').hide();	
		$('#listado_activ').hide();
		
		$('#h_activ_id').val(id_activ)
		
		$('#sup_rut').prop('disabled',true)
		$('#btn_atras').show();				
		
		area_actividad = $('#'+id_activ).val();
		area_activ_split = area_actividad.split('---');
		$('#area_nombre').html(area_activ_split[0])
		$('#activ_nombre').html(area_activ_split[1])
		$('#produccion_esperada').html(area_activ_split[2])
		$('#area_activ').show();	
		
		$('#plan_dia_new').select2({});	
		$('#id_activ_new').select2({});
		
		$('#faena').show();

		activ_standar = area_activ_split[3]
	
		estado = area_activ_split[4];
		area_id = area_activ_split[5];
		
		$('#h_area_id').val(area_id)
		
		oper_combo = 'cargar operadores'
		parametros_oper = {			
			oper_combo2:oper_combo,
			activ_id:id_activ,
			activ_standar:activ_standar
		}	
		
		
		
		clear_combobox('oper_faltante',0);
		$.post(
			"consultas/ges_crud_operadores.php",
			parametros_oper,			   
			function(resp){
				Operadores_Combobox(resp)
			},"json"
		)		
		
		/*
		$('#oper_actividad').empty();
		oper_table = 'cargar operadores'
		parametros = {			
			oper_table:oper_table,
			activ_id:id_activ,
			plan_dia:plan_dia
		}	
		$.post(
			"consultas/ges_crud_operadores.php",
			parametros,			   
			function(resp){
				Operadores_Table(resp,estado)
			},"json"
		)		
		*/
		call_Operadores_Table(id_activ,plan_dia,estado);
	}
	
	function Operadores_Combobox(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].OPER_RUT, text:resp[i].OPERARIO});
		}	
		
		$('#oper_faltante').select2({			
			data:combobox
		});	
	}	
	

	function call_Operadores_Table(id_activ,plan_dia,estado){
		$('#oper_actividad').empty();
		oper_table = 'cargar operadores'
		parametros = {			
			oper_table:oper_table,
			activ_id:id_activ,
			plan_dia:plan_dia
		}	
		$.post(
			"consultas/ges_crud_operadores.php",
			parametros,			   
			function(resp){
				Operadores_Table(resp,estado)
			},"json"
		)		
	}
	
	
	function Operadores_Table(resp,estado){
		console.log(resp)	
		
		per_agno = $('#per_agno').val();
		sem_num = $('#sem_num').val();
		plan_dia = $('#plan_dia').val();
		activ_id = $('#h_activ_id').val()		 
		
		var horas = ['07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23']
		j=0;
		hora_inicial = '';
		while (j<horas.length){
			
			if(horas[j] == '08'){
				hora_inicial = hora_inicial + '<option value="'+horas[j]+'" selected>'+horas[j]+'</option>';	
			}
			else{
				hora_inicial = hora_inicial + '<option value="'+horas[j]+'">'+horas[j]+'</option>';	
			}
			j++;
		}
		$("#hr_ini_all").empty();
		$('#hr_ini_all').append(hora_inicial);

		j=0;
		hora_final = '';
		while (j<horas.length){
			if(horas[j] == '17'){
				hora_final = hora_final + '<option value="'+horas[j]+'" selected>'+horas[j]+'</option>';	
			}
			else{
				hora_final = hora_final + '<option value="'+horas[j]+'">'+horas[j]+'</option>';	
			}
			j++;
		}
		$("#hr_fin_all").empty();
		$('#hr_fin_all').append(hora_final);		
		
		var minutos = ['00','01','02','03','04','05','06','07','08','09']
		j=0;
		
		min_inicial = '';
		min_inicial_descto = '';
		while (j<minutos.length){
			min_inicial = min_inicial + '<option value="'+minutos[j]+'">'+minutos[j]+'</option>';
			if(minutos[j] == '00'){
				
				min_inicial_descto = min_inicial_descto + '<option value="'+minutos[j]+'" selected>'+minutos[j]+'</option>';
			}
			else{

				min_inicial_descto = min_inicial_descto + '<option value="'+minutos[j]+'">'+minutos[j]+'</option>';
			}
			j++;
		}	
		j=10;
		while (j<60){
			min_inicial_descto = min_inicial_descto + '<option value="'+j+'">'+j+'</option>';
			
			
			if(j == '15'){
				min_inicial = min_inicial + '<option value="'+j+'" selected>'+j+'</option>';
				
			}
			else{
				min_inicial = min_inicial + '<option value="'+j+'">'+j+'</option>';	
			}			
			
			j++;
			
			
		}
		$("#min_ini_all").empty();
		$('#min_ini_all').append(min_inicial);	

		
		j=0;
		min_final = '';
		while (j<minutos.length){
			min_final = min_final + '<option value="'+minutos[j]+'">'+minutos[j]+'</option>';
			j++;
		}	
		j=10;
		while (j<60){
		
			if(j == '30'){
				min_final = min_final + '<option value="'+j+'" selected>'+j+'</option>';
			}
			else{
				min_final = min_final + '<option value="'+j+'">'+j+'</option>';	
			}		
			j++;
		}
		$("#min_fin_all").empty();
		$('#min_fin_all').append(min_final);	
		
		j=0;		
		dscto_hora = '';
		while (j<minutos.length){
			if(minutos[j] == '00'){
				dscto_hora = dscto_hora + '<option value="'+minutos[j]+'" selected>'+minutos[j]+'</option>';	
			}
			else{
				dscto_hora = dscto_hora + '<option value="'+minutos[j]+'">'+minutos[j]+'</option>';	
			}
			j++;
		}
		
	
		i = 0;
		while(i < resp.length){

			id_row = 'row_'+resp[i].OPER_RUT;
			id_obs = 'obs_'+resp[i].OPER_RUT;
			
			hr_ini = 'hini_'+resp[i].OPER_RUT;
			hr_fin = 'hfin_'+resp[i].OPER_RUT;
			
			min_ini = 'mini_'+resp[i].OPER_RUT;
			min_fin = 'mfin_'+resp[i].OPER_RUT;	
			
			oper = 'oper_'+resp[i].OPER_RUT;
			cant = 'cant_'+resp[i].OPER_RUT;
			b1 = 'b1_'+resp[i].OPER_RUT;
			b2 = 'b2_'+resp[i].OPER_RUT;
			col = 'col_'+resp[i].OPER_RUT;
			obs = 'obs_'+resp[i].OPER_RUT;
			
			dscto_hr = 'dhr_'+resp[i].OPER_RUT;
			dscto_min = 'dmin_'+resp[i].OPER_RUT;
			
			hrasig = 'hrasig_'+resp[i].OPER_RUT;
			hrprod = 'hrprod_'+resp[i].OPER_RUT;
			
			//if(estado == 'FINALIZADO'){
				
			asistencia = (resp[i].PLANO_ASIST == 'S' /*|| estado == 'SIN REGISTRAR'*/)?'checked':'';
			cantidad = (resp[i].PLANO_CANT == 0)? '':resp[i].PLANO_CANT;
			b1_check = (resp[i].PLANO_B1 == 'S' /*|| estado == 'SIN REGISTRAR'*/)?'checked':'';
			b2_check = (resp[i].PLANO_B2 == 'S' /*|| estado == 'SIN REGISTRAR'*/)?'checked':'';
			col_check = (resp[i].PLANO_COL == 'S' /*|| estado == 'SIN REGISTRAR'*/)?'checked':'';
			
/*
			//COSECHA: 62
			//COSECHA GLOBULUS: 240
			//COSECHA GLONI: 241
*/			
			if(activ_id == 62 || activ_id == 240 || activ_id == 241){
				$('#oper_actividad').append(
					'<tr id='+id_row+'>'+
						'<td style="text-align:center"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' '+asistencia+'/></td>' +
						'<td><span id='+oper+' data-toggle="modal" data-target=".bs-example-modal-lg">'+resp[i].OPERARIO+'</span></td>' +
						'<td id='+cant+' data-dia="'+plan_dia+'" data-oper="'+resp[i].OPERARIO+'" data-toggle="modal" data-id="'+resp[i].OPER_RUT+'" data-target="#WModal_Cant_Cosecha" style="text-align:center">'+cantidad+'</td>' +
						'<td style="text-align:center; width:70px"><select id="'+hr_ini+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+hora_inicial+'</select><select id="'+min_ini+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_inicial+'</select></td>' +
						'<td style="text-align:center; width:70px"><select id="'+hr_fin+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+hora_final+'</select><select id="'+min_fin+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_final+'</select></td>' +
						'<td style="text-align:center; width:70px"><select id="'+dscto_hr+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+dscto_hora+'</select><select id="'+dscto_min+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_inicial_descto+'</select></td>' +
						'<td style="text-align:center"><span id="'+hrasig+'">'+resp[i].PLANO_HORAS+' </span></td>' +
						'<td style="text-align:center"><span id="'+hrprod+'">'+resp[i].PLANO_HORASPROD+'</span></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+b1+' '+b1_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+b2+' '+b2_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+col+' '+col_check+' /></td>' +
						'<td id='+id_obs+' data-dia='+plan_dia+' data-activ='+activ_id+' data-oper="'+resp[i].OPERARIO+'" data-toggle="modal" data-id="'+resp[i].OPER_RUT+'" data-target="#WModal_Obs" data-obs="'+resp[i].PLANO_OBS+'">'+resp[i].PLANO_OBS+'</td>' +
				'</tr>');				
			}else{
				$('#oper_actividad').append(
					'<tr id='+id_row+'>'+
						'<td style="text-align:center"><input type="checkbox" class="check_oper" id='+resp[i].OPER_RUT+' '+asistencia+'/></td>' +
						'<td><span id='+oper+' data-toggle="modal" data-target=".bs-example-modal-lg">'+resp[i].OPERARIO+'</span></td>' +
						'<td id='+cant+' data-cant1="'+resp[i].PLANO_CANT1+'" data-cant2="'+resp[i].PLANO_CANT2+'" data-cant3="'+resp[i].PLANO_CANT3+'" data-cant4="'+resp[i].PLANO_CANT4+'" data-oper="'+resp[i].OPERARIO+'" data-toggle="modal" data-id="'+resp[i].OPER_RUT+'" data-target="#WModal_Cant" style="text-align:center">'+cantidad+'</td>' +
						'<td style="text-align:center; width:70px"><select id="'+hr_ini+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+hora_inicial+'</select><select id="'+min_ini+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_inicial+'</select></td>' +
						'<td style="text-align:center; width:70px"><select id="'+hr_fin+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+hora_final+'</select><select id="'+min_fin+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_final+'</select></td>' +
						'<td style="text-align:center; width:70px"><select id="'+dscto_hr+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+dscto_hora+'</select><select id="'+dscto_min+'" style="width:65px" class="select2_single form-control" tabindex="-1">'+min_inicial_descto+'</select></td>' +
						'<td style="text-align:center"><span id="'+hrasig+'">'+resp[i].PLANO_HORAS+' </span></td>' +
						'<td style="text-align:center"><span id="'+hrprod+'">'+resp[i].PLANO_HORASPROD+'</span></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+b1+' '+b1_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+b2+' '+b2_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+col+' '+col_check+' /></td>' +
						'<td id='+id_obs+' data-dia='+plan_dia+' data-activ='+activ_id+' data-oper="'+resp[i].OPERARIO+'" data-toggle="modal" data-id="'+resp[i].OPER_RUT+'" data-target="#WModal_Obs" data-obs="'+resp[i].PLANO_OBS+'">'+resp[i].PLANO_OBS+'</td>' +
				'</tr>');
				
			}
			
			// <textarea id='+obs+'>'+resp[i].PLANO_OBS+'</textarea>
			
			if(resp[i].PLANO_ASIST == 'N'){
				$('#'+cant).prop('disabled',true)
			}else{
				$('#'+cant).prop('disabled',false)
			}
			
			if(resp[i].PLANO_HRINI){
				$('#'+hr_ini).val(resp[i].PLANO_HRINI)
			}
			
			if(resp[i].PLANO_MININI){
				$('#'+min_ini).val(resp[i].PLANO_MININI)
			}			
			
			if(resp[i].PLANO_HRFIN){
				$('#'+hr_fin).val(resp[i].PLANO_HRFIN)
			}

			if(resp[i].PLANO_MINFIN){
				$('#'+min_fin).val(resp[i].PLANO_MINFIN)
			}
			
			if(resp[i].PLANO_HRDSCTO){
				$('#'+dscto_hr).val(resp[i].PLANO_HRDSCTO)
			}

			if(resp[i].PLANO_MINDSCTO){
				$('#'+dscto_min).val(resp[i].PLANO_MINDSCTO)
			}			

			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_asistencia(this); });

			$('#oper_'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

//Btn_Cons_Operador(oper_rut)

			i++;
		}
		
		
		if(estado == 'FINALIZADO'){
			
			//$("#oper_actividad").hide();
			$('#btn_reg_faena').hide();
			$('#btn_upd_faena').show();		/*
			$("#oper_actividad").find("input,textarea,select").prop("disabled", true);*/			
		}else{
			$('#btn_upd_faena').hide();
			$('#btn_reg_faena').show();		
			//$("#oper_actividad").find("input,textarea,select").prop("disabled", false);			
		}		
		
	}
	


	
	function clic_asistencia(e){

		rut_oper = e.id;
		cant = 'cant_'+rut_oper;
		if($('#'+rut_oper).is(":checked")){
			$('#'+cant).prop('disabled',false)			
		}else{
			$('#'+cant).val('')
			$('#'+cant).prop('disabled',true)			
		}
	}
	
	function clic_operador(e){
		console.log(e)
		rut_oper = e.id;
		operador = rut_oper.split('_');
		oper_rut = operador[1];
		console.log(oper_rut)
		Btn_Cons_Operador(oper_rut)
	}	
	
	function Btn_Cons_Operador(oper_rut){
		var plan_dia = $('#plan_dia').val();
		if(oper_rut == ''){
			sweet_alert('Error: Seleccionar operador');	
		}else{		
		
			oper_faltante = 'info operador'
			parametros = {			
				oper_faltante:oper_faltante,
				plan_dia:plan_dia,
				oper_rut:oper_rut
			}	
			$('#table_operador').empty();

			console.log(parametros)
			$.post(
				"consultas/ges_crud_operadores.php",
				parametros,			   
				function(resp){
					Consulta_Operador(resp)
				},"json"
			)
		}		
	}	
	
	
	function Consulta_Operador(resp){
		console.log(resp)
		//operador = resp[0].OPERARIO		
		//operador = $('#oper_faltante option:selected').text();
		//$('#nom_oper').html(operador)
		
		plan_dia = $('#plan_dia').val();
		dia = plan_dia.substring(6);
		mes = plan_dia.substring(4,6);
		agno = plan_dia.substring(0,4);
		dia_format = dia+'-'+mes+'-'+agno
		$('#dia_planif').html(dia_format)
		
		if(resp.length == 0){
			operador = $('#oper_faltante option:selected').text();
			$('#nom_oper').html(operador)			
			$('#table_operador').append(
				'<tr>'+
				  '<td colspan="5">No se han planificado actividades en este día para este operador.</td>' +
			'</tr>');
		}
		else{
			operador = resp[0].OPERARIO	
			$('#nom_oper').html(operador)
			i = 0;
			sum_horas_prod = 0;
			sum_horas_asig = 0;
			while(i < resp.length){
				horas_prod = resp[i].PLANO_HORASPROD.replace(',','.')
				sum_horas_prod = sum_horas_prod + parseFloat(horas_prod);
				
				horas_asig = resp[i].PLANO_HORAS.replace(',','.')
				sum_horas_asig = sum_horas_asig + parseFloat(horas_asig);				
				
				$('#table_operador').append(
					'<tr>'+
					  '<td>'+resp[i].AREA_NOMBRE+'</td>' +
					  '<td>'+resp[i].SUPERVISOR+'</td>' +
					  '<td>'+resp[i].ACTIV_NOMBRE+'</td>' +
					  '<td>'+resp[i].PLANO_HORAS+'</td>' +
					  '<td>'+resp[i].PLANO_HORASPROD+'</td>' +
				'</tr>');
				i++;
			}
			sum_horas_prod = String(sum_horas_prod).replace('.',',');
			sum_horas_asig = String(sum_horas_asig).replace('.',',');
			$('#table_operador').append(
				'<tr>'+
				  '<td></td>' +
				  '<td></td>' +
				  '<td></td>' +
				  '<td style="font-weight:bold;color:red;">'+sum_horas_asig+'</td>' +
				  '<td style="font-weight:bold;color:red;">'+sum_horas_prod+'</td>' +
			'</tr>');
		}
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
	
	function QuitarOper(oper_rut){
		//console.log(oper_rut)
		id_row = 'row_'+oper_rut;
		$('#'+id_row).remove();
	}
	
	

$(document).ready(function(){
	
	
	//$('#sel_hrxtrab').select2({	});
	//$('#sel_hrxdesc').select2({	});
	
	function separador_miles(num){
		resultado = num;
		if(num > 999){
		
			num = String(num).split('.');
			entero = num[0]
			while (/(\d+)(\d{3})/.test(entero)) {
				entero = entero.replace(/(\d+)(\d{3})/, '$1' + '.' + '$2');
			}
			resultado = entero;
			if(num.length == 2){
				resultado = entero + ',' + num[1];
			}			
			
		}
		return resultado;
	}
	
	$('#btn_consprod').click(function(){
		suma_cant = 0;
		suma_prod = 0;
        $("#oper_actividad tr").each(function () 
        {
			cantidad = $(this).find("td").eq(2).html();
			if(cantidad != ''){
				suma_cant = suma_cant + parseFloat(cantidad);
				horas = $(this).find("td").eq(7).html();
				if(horas != ''){
					suma_prod = suma_prod + parseFloat(horas);
				}
			}
        })

		total_cant = separador_miles(suma_cant)
		$('#cant_total').val(total_cant);
		
		if(suma_prod > 0){
			prodxHr = suma_cant/suma_prod;
			suma_prod = Math.round(prodxHr * 100) / 100;
			suma_prod = separador_miles(suma_prod)
			
		}
		$('#prom_total').val(suma_prod);
	})
	
	
	
	$("#WModal_Cant").on('show.bs.modal', function(event){
	
		var identificador = $(event.relatedTarget);
		var rut_operador = identificador.data('id');		
		var nom_operador = identificador.data('oper');
		
		var cantidad1 = identificador.data('cant1');
		var cantidad2 = identificador.data('cant2');
		var cantidad3 = identificador.data('cant3');
		var cantidad4 = identificador.data('cant4');

		$('#h_oper_clic').val(rut_operador);
		$('#title_cant').html(nom_operador)
		
		$('#cant_10am').val(cantidad1);
		$('#cant_col').val(cantidad2);
		$('#cant_15pm').val(cantidad3);
		$('#cant_cierre').val(cantidad4);
	/*
			$('#'+cant).bind('keypress',function(e){ 
				if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
				cantidad = $('#'+this.id).val();
				if(e.which==44 && cantidad.search( ',' ) != -1)return false;
			})	
	*/
    });		
	
	

	
	



	$('#cant_10am').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#cant_10am').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	
	$('#cant_col').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#cant_col').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	$('#cant_15pm').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#cant_15pm').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	$('#cant_cierre').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#cant_cierre').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	

	
	
	$('#btn_reg_cant').click(function(){
		var oper_rut = $('#h_oper_clic').val();
		var plan_dia = $('#plan_dia').val();
		var activ_id = $('#h_activ_id').val();
		var plano_cant1 = $('#cant_10am').val();
		var plano_cant2 = $('#cant_col').val();
		var plano_cant3 = $('#cant_15pm').val();
		var plano_cant4 = $('#cant_cierre').val();

		var prod_hrini = $('#hini_'+oper_rut).val();
		var prod_minini = $('#mini_'+oper_rut).val();
		var prod_hrfin = $('#hfin_'+oper_rut).val();
		var prod_minfin = $('#mfin_'+oper_rut).val();
		var prod_hrdscto = $('#dhr_'+oper_rut).val();
		var prod_mindscto = $('#dmin_'+oper_rut).val();	
		var prod_b1 = ($('#b1_'+oper_rut).is(":checked")) ? 'S' : 'N';
		var prod_b2 = ($('#b2_'+oper_rut).is(":checked")) ? 'S' : 'N';
		var prod_col = ($('#col_'+oper_rut).is(":checked")) ? 'S' : 'N';		

		if( plano_cant1 == '' || plano_cant2 == '' || plano_cant3 == '' || plano_cant4 == '') {
			sweet_alert('Error: cantidad vacía');
		}	
		if( plano_cant1 == '0' && plano_cant2 == '0' && plano_cant3 == '0' && plano_cant4 == '0') {
			$('#WModal_Cant').modal('hide');
		}		
		else{
			
			parametros = {			
				plan_dia:plan_dia,
				oper_rut:oper_rut,
				activ_id:activ_id,
				plano_cant1:plano_cant1,
				plano_cant2:plano_cant2,
				plano_cant3:plano_cant3,
				plano_cant4:plano_cant4,		
				prod_hrini:prod_hrini,
				prod_minini:prod_minini,
				prod_hrfin:prod_hrfin,
				prod_minfin:prod_minfin,
				prod_hrdscto:prod_hrdscto,
				prod_mindscto:prod_mindscto,
				prod_b1:prod_b1,
				prod_b2:prod_b2,
				prod_col:prod_col,				
				operacion:'UPDATE CANT'
			}		
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxactividades(resp)
				   },"json"
			)
			
		}
	})
	
	
	
	

	$("#WModal_Obs").on('show.bs.modal', function(event){

		$("#permiso").prop("checked", false);
		$("#vacaciones").prop("checked", false);
		$("#licencia").prop("checked", false);
		$("#otro").prop("checked", false);
		$('#modal_obs').val('')
		$('#modal_obs').prop('disabled',true)
	
		var identificador = $(event.relatedTarget);
		//console.log(identificador)
		var rut_operador = identificador.data('id');		
		var nom_operador = identificador.data('oper');
		var observacion = identificador.data('obs');
		//console.log(observacion)
		$('#h_oper_clic').val(rut_operador);
		//$(this).find('.modal-title').text(nom_operador);
		$('#title_obs').html(nom_operador)

		if(observacion != ''){
			switch(observacion){
				
				case 'PERMISO':
					$("#permiso").prop("checked", true);
				break;
				case 'VACACIONES':
					$("#vacaciones").prop("checked", true);
				break;				
				case 'LICENCIA':
					$("#licencia").prop("checked", true);
				break;
				default:
					$("#otro").prop("checked", true);
					$('#modal_obs').prop('disabled',false)
					$('#modal_obs').val(observacion)
				break;					
			}
		}
    });
	
	$("input[name='obs_oper']").click(function(){

		var opcion = $('input:radio[name=obs_oper]:checked').val()

		if(opcion == "OTRO"){
			$('#modal_obs').prop('disabled',false)
		}else{
			$('#modal_obs').val('')
			$('#modal_obs').prop('disabled',true)
		}
	});	
	

	$('#btn_reg_obs').click(function(){
		var oper_rut = $('#h_oper_clic').val();
		var plan_dia = $('#plan_dia').val();
		var activ_id = $('#h_activ_id').val();
		
		var opcion = $('input:radio[name=obs_oper]:checked').val()
		if (!$('input[name="obs_oper"]').is(':checked')) {
			sweet_alert('Error: Seleccione una opción');
		}	
		else if(opcion == 'OTRO' && $.trim($('#modal_obs').val()) == ''){
			sweet_alert('Error: Ingrese una observación para la opción "OTRO"');
		}
		else{
			if(opcion == "OTRO"){
				obs = $('#modal_obs').val();
				//$('#obs_'+rut_oper).html(obs);
				//$('#obs_'+rut_oper).attr('data-obs', obs);
			}else{
				obs = opcion;
				//$('#obs_'+rut_oper).html(opcion);
				//$('#obs_'+rut_oper).attr('data-obs', opcion);
			}
			
			parametros = {			
				plan_dia:plan_dia,
				oper_rut:oper_rut,
				activ_id:activ_id,
				plano_obs:obs,
				operacion:'UPDATE OBS'
			}		
			//console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxactividades(resp)
				   },"json"
			)
			
		}
	})

	$('#btn_del_obs').click(function(){
		
		oper_rut = $('#h_oper_clic').val()
		plano_obs = $.trim($('#obs_'+oper_rut).html());
		//$('#obs_'+rut_oper).html('');
		//$('#obs_'+rut_oper).attr('data-obs', '');

		if(plano_obs != ''){
			parametros = {			
				plan_dia:plan_dia,
				oper_rut:oper_rut,
				activ_id:activ_id,
				plano_obs: '',
				operacion:'DELETE OBS'
			}		
			//console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxactividades(resp)
				   },"json"
			)			
		}else{
			$('#WModal_Obs').modal('hide');
		}	
		
		
	})	
	
	$('#btn_oper_faena').click(function(){
		
		var index_dia = $("#plan_dia").prop('selectedIndex') 	
		var length_option_dias = $('#plan_dia > option').length;
		
		if(index_dia == 0 && length_option_dias == 7){
			sweet_alert('Error: No es posible actualizar operadores de semanas anteriores');
		}else{
		
			sem_txt = $('#sem_num option:selected').text()
			$('#h_sem_txt').val(sem_txt);
			 per_agno = $('#per_agno').val();
			 sem_num = $('#sem_num').val();
			 plan_dia = $('#plan_dia').val();
			// area_id = $('#sem_num').val();
			 //activ_id = $('#sem_num').val();
			 
			 $('#h_per_agno').val(per_agno);
			 $('#h_sem_num').val(sem_num);
			 $('#h_sactiv_dia').val(plan_dia);
			 $('#h_sup_rut').val(rut_supervisor);
			// $('#h_activ_id').val(activ_id);
			
			$('#form_control').submit();
		}
	})


	$('#btn_atras').click(function(){
		//location.reload();
		$('#area_activ').hide();
		$('#faena').hide();
		$('#listado_activ').show();
		//$('#btn_actividades').click();
		actividades_faena();
		$('#plan_dia').prop('disabled',false);
		$('#sup_rut').prop('disabled',false);
		$('#btn_atras').hide();
		$('#btn_actividades').show();
		
		
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

	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_especial:sem_num
		}		
		clear_combobox('plan_dia',0);
		clear_combobox('plan_dia_new',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}
	
	$('#sem_num').change(function() {
		change_sem_num();
		$("#listado_activ").empty();
	});	
	
	function carga_dias(resp){
		console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#plan_dia').select2({			
			placeholder: "SELECCIONE DIA(S)",
			data:combobox
		});		


		$('#plan_dia_new').select2({			
			data:combobox
		});	
		
		//$('#id_activ_new').select2({});
		
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
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
		}	
		
		$('#sup_rut').select2({			
			data:combobox
		})
		console.log(rut_supervisor)
		$('#sup_rut').val(rut_supervisor).trigger('change');
	}


	function actividades_faena(){
		
		var rut_supervisor = $('#sup_rut').val();
		var plan_dia = $('#plan_dia').val();
		var planif_activ = 'planif_activ'
		
		if(rut_supervisor == ''){
			sweet_alert('Error: Seleccionar supervisor');	
		}else{
			$('#loading3').show();
			parametros = {			
				rut_supervisor:rut_supervisor,
				plan_dia:plan_dia,
				planif_activ:planif_activ
			}	
			//console.log(parametros)
			$("#listado_activ").empty();
			
			$.post(
				"consultas/ges_crud_supervisores.php",
				parametros,			   
				function(resp){
					cajas_actividades(resp)
				},"json"
			)
		}		
		
	}
	
	
	
	$('#btn_actividades').click(function(){
	
		actividades_faena();
	})
		
	
	function cajas_actividades(resp){

		//console.log(resp)
		$('#loading3').hide();
		if(resp.length == 0){
			$('#sin_actividades').show();
		}else{
			$('#sin_actividades').hide();
			i = 0;
			actividad_new = '';
			while(i < resp.length){
		
				num_operadores = resp[i].NUM_OPERADOR;
				actividad = resp[i].ACTIV_NOMBRE;
				nom_area = resp[i].AREA_NOMBRE;
				activ_standar = resp[i].ACTIV_STANDAR;
				prod_esperada = resp[i].PRODUCCION;
				id_activ = resp[i].ACTIV_ID;
				id_area = resp[i].AREA_ID;
				
				estado = resp[i].PROD_EXISTE;
				
				//estado = 'SIN REGISTRAR';
				//estado = 'FINALIZADO';
				color = resp[i].COLOR;
				
				value_hidden = nom_area+'---'+actividad+'---'+prod_esperada+'---'+activ_standar+'---'+estado+'---'+id_area;

				if(estado == 'SIN REGISTRAR'){
					clase_estado = 'sin_registrar';
					$('#btn_reg_faena').show();
					$('#btn_upd_faena').hide();						
				}else{
					clase_estado = 'finalizado';
					$('#btn_reg_faena').hide();
					$('#btn_upd_faena').show();						
				}
				
				$('#listado_activ').append(
					'<div class="col-md-4 col-xs-6">'+
						'<div class="small-box well" style="background-color:#'+color+'">'+
							'<div class="inner" style="padding-bottom:50px;">'+
								'<h3>'+num_operadores+' oper.</h3>'+
								'<p>'+actividad+'</p>'+
							'</div>'+
							'<div class="footer-div">'+
								'<p class="'+clase_estado+'">ESTADO: '+estado+'</p>'+
								'<a href="#" class="small-box-footer" onclick="RealizarActiv('+id_activ+')">Registrar control <i class="fa fa-arrow-circle-right"></i></a>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<input type="hidden" id="'+id_activ+'" value="'+value_hidden+'" />'
					);
					
					
				actividad_new = actividad_new + '<option value="'+id_activ+'">'+actividad+' - ESTADO:'+estado+'</option>';
				
				i++;
			}

			clear_combobox('id_activ_new',1);			
			$('#id_activ_new').append(actividad_new);
				
			var heights = $(".well").map(function() {
				return $(this).height();
			}).get(),
		 
			maxHeight = Math.max.apply(null, heights);	 
			$(".well").height(maxHeight);

		}	
	}
	
	
	
	$('#btn_consoper').click(function(){
		var oper_rut = $('#oper_faltante').val();
		Btn_Cons_Operador(oper_rut)
	})
	/*
	function Btn_Cons_Operador(oper_rut){
		var plan_dia = $('#plan_dia').val();
		if(oper_rut == ''){
			sweet_alert('Error: Seleccionar operador');	
		}else{		
		
			oper_faltante = 'info operador'
			parametros = {			
				oper_faltante:oper_faltante,
				plan_dia:plan_dia,
				oper_rut:oper_rut
			}	
			$('#table_operador').empty();

			//console.log(parametros)
			$.post(
				"consultas/ges_crud_operadores.php",
				parametros,			   
				function(resp){
					Consulta_Operador(resp)
				},"json"
			)
		}		
	}
	
	
	function Consulta_Operador(resp){
		//console.log(resp)
				
		operador = $('#oper_faltante option:selected').text();
		$('#nom_oper').html(operador)
		
		plan_dia = $('#plan_dia').val();
		dia = plan_dia.substring(6);
		mes = plan_dia.substring(4,6);
		agno = plan_dia.substring(0,4);
		dia_format = dia+'-'+mes+'-'+agno
		$('#dia_planif').html(dia_format)
		
		if(resp.length == 0){
			$('#table_operador').append(
				'<tr>'+
				  '<td colspan="4">No se han planificado actividades en este día para este operador.</td>' +
			'</tr>');
		}
		else{
			
			i = 0;
			while(i < resp.length){
				$('#table_operador').append(
					'<tr>'+
					  '<td>'+resp[i].AREA_NOMBRE+'</td>' +
					  '<td>'+resp[i].SUPERVISOR+'</td>' +
					  '<td>'+resp[i].ACTIV_NOMBRE+'</td>' +
					  '<td>'+resp[i].PLANO_HORAS+'</td>' +
				'</tr>');
				i++;
			}
		}
	}
*/	
	
	$('#btn_consprodxhr').click(function(){
		
		var plan_dia = $('#plan_dia').val();
		var activ_id = $('#h_activ_id').val()	
		var det_prodxhr = 'info detalle prod'
		parametros = {			
			det_prodxhr:det_prodxhr,
			plan_dia:plan_dia,
			activ_id:activ_id
		}	
		$('#table_detprod').empty();
		$('#dprod_cant').val('');
		$('#dprod_hr').val('');

		//console.log(parametros)
		$.post(
			"consultas/ges_crud_operadores.php",
			parametros,			   
			function(resp){
				Consulta_OperadorProd(resp)
			},"json"
		)
		
		
	})		

	
	function Consulta_OperadorProd(resp){
		console.log(resp)
	
		if(resp.length == 0){
			$('#table_detprod').append(
				'<tr>'+
				  '<td colspan="5">No se registran operadores asistentes a la actividad.</td>' +
			'</tr>');
		}
		else{
			
			i = 0;
			while(i < resp.length){
				id_select = resp[i].OPER_RUT + '_select';
				$('#table_detprod').append(
					'<tr>'+
					  '<td style="display:none">'+resp[i].OPER_RUT+'</td>' +
					  '<td>'+resp[i].OPERARIO+'</td>' +
					  '<td class="text-right">'+resp[i].PLANO_CANT+'</td>' +
					  '<td class="text-center"></td>' +
					  '<td>' +
							'<select class="select2_single form-control" tabindex="-1" id="'+id_select+'">'+
								'<option value="0" selected>Sin descuentos</option><option value="0.25">15 MIN</option><option value="0.5">30 MIN</option><option value="0.75">45 MIN</option>'+
								'<option value="1">1,0 HR</option><option value="1.25">1 HR y 15 MIN</option><option value="1.5">1 HR y 30 MIN</option><option value="1.75">1 HR y 45 MIN</option>'+
								'<option value="2">2,0 HR</option><option value="2.25">2 HR y 15 MIN</option><option value="2.5">2 HR y 30 MIN</option><option value="2.75">2 HR y 45 MIN</option>'+
								'<option value="3">3,0 HR</option><option value="3.25">3 HR y 15 MIN</option><option value="3.5">3 HR y 30 MIN</option><option value="3.75">3 HR y 45 MIN</option>'+
								'<option value="4">4,0 HR</option><option value="4.25">4 HR y 15 MIN</option><option value="4.5">4 HR y 30 MIN</option><option value="4.75">4 HR y 45 MIN</option>'+
								'<option value="5">5,0 HR</option><option value="5.25">5 HR y 15 MIN</option><option value="5.5">5 HR y 30 MIN</option><option value="5.75">5 HR y 45 MIN</option>'+
								'<option value="6">6,0 HR</option><option value="6.25">6 HR y 15 MIN</option><option value="6.5">6 HR y 30 MIN</option><option value="6.75">6 HR y 45 MIN</option>'+
								'<option value="7">7,0 HR</option><option value="7.25">7 HR y 15 MIN</option><option value="7.5">7 HR y 30 MIN</option><option value="7.75">7 HR y 45 MIN</option>'+
								'<option value="8">8,0 HR</option>'+
							'</select>'+				  
					  '</td>' +
					  '<td class="text-right"></td>' +
				'</tr>');
				i++;
			}
		}
	}	
	
	
	
	$('#btn_filtro').click(function(){
		//error_hr_descto = 0;
		
		hr_trab = $('#sel_hrxtrab').val();
		descto = $('#sel_hrxdesc').val();
		
		if(hr_trab < descto){
			sweet_alert('Error: El descuento es mayor a las horas trabajadas');
		}			
		else{
			$("#table_detprod tr").each(function () 
			{
				rut_oper = $(this).find("td").eq(0).html();
				id_select = rut_oper + '_select';
				
				$(this).find("td").eq(3).html(hr_trab);
				$('#'+id_select).val(descto);
			})
		}
		
	})	
	
	
	$('#btn_calc_prod').click(function(){
		
		suma_cant = 0;
		suma_prod = 0;
		error_trab = 0;
		error_hr_descto = 0;
        $("#table_detprod tr").each(function (){
			
			cantidad = $(this).find("td").eq(2).html();
			if(cantidad != ''){
				suma_cant = suma_cant + parseFloat(cantidad);
				horas = $(this).find("td").eq(3).html();
				
				rut_oper = $(this).find("td").eq(0).html();
				id_select = rut_oper + '_select';
				descto = $('#'+id_select).val();

				if(horas != ''){
					
					horas = parseFloat(horas);
					descto = parseFloat(descto);
					
					if(horas < descto){
						error_hr_descto = 1;
					}else{
						suma_prod = suma_prod + (horas - descto);
					}										
				}else{
					error_trab = 1;
				}
				
			}
        })
		
		if(error_trab == 1){
			sweet_alert('Error: Aplicar filtro general');
		}
		else if(error_hr_descto == 1){
			sweet_alert('Error: En al menos un caso, el descuento es mayor a las horas trabajadas');
		}else{
			total_cant = separador_miles(suma_cant)
			$('#dprod_cant').val(total_cant);
			
			if(suma_prod > 0){
				prodxHr = suma_cant/suma_prod;
				suma_prod = Math.round(prodxHr * 100) / 100;
				suma_prod = separador_miles(suma_prod)
				
			}
			$('#dprod_hr').val(suma_prod);


        $("#table_detprod tr").each(function (){
			
			cantidad = $(this).find("td").eq(2).html();
			if(cantidad != ''){

				horas = $(this).find("td").eq(3).html();
				
				rut_oper = $(this).find("td").eq(0).html();
				id_select = rut_oper + '_select';
				descto = $('#'+id_select).val();

				horas = parseFloat(horas);
				descto = parseFloat(descto);
				cantidad = parseFloat(cantidad);

				total_prod_hr = cantidad / (horas - descto);
				prodxoper = Math.round(total_prod_hr * 100) / 100;
				prodxoper = separador_miles(prodxoper)
				
				$(this).find("td").eq(5).html(prodxoper);
				
			}
        })



			
		}
		
	})	
	
	
	
		

	function validar_faena(){
			
		var cant_ing = 'S';
		$('.check_oper').each( function() {
			if(this.checked) {
				oper_rut = this.id;
				cant = $('#cant_'+oper_rut).html();
				if(cant ==''){
					sweet_alert('Error: Ingresar las cantidades producidas por los operadores presentes');	
					cant_ing = 'N';
					return false; //sale del ciclo each
				}
			}				
		})
		
		if(cant_ing == 'S'){
			return true;
		}else{
			return false;
		}

	}


	$('#btn_upd_faena').click(function(){
		actualizar_faena('UPDATE')
	})
	
	$('#btn_reg_faena').click(function(){
		actualizar_faena('INSERT')
	})
	
	function actualizar_faena(param_oper){
	
		if (validar_faena()){
			
			var oper_asist = 'N';		
			$('.check_oper').each( function() {
				if(this.checked) {
					oper_asist = 'S';
				}				
			})
			
			if(oper_asist == 'N'){
			
				swal({   
					title: "¿Seguro que deseas registrar que ningún operador asistió a esta actividad?",   
					text: "",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						registrar_faena(param_oper,1);
				});				
			
			}else{
				registrar_faena(param_oper,1);
			}
		}
	}
	
	
	function registrar_faena(param_oper,marca){
		
		$('#loading').show();
		
		var activ_id = $.trim($('#h_activ_id').val());	
		var plan_dia = $.trim($('#plan_dia').val());
		
		var oper_rut = {};
		var prod_asist = {};
		var prod_cant = {};
		var prod_hrini = {};
		var prod_minini = {};
		var prod_hrfin = {};
		var prod_minfin = {};
		var prod_hrdscto = {};
		var prod_mindscto = {};
		var prod_b1 = {};
		var prod_b2 = {};
		var prod_col = {};
		var prod_obs = {};
		//var prod_addoper = {};
		
		var i = 0; 
				
		$('.check_oper').each( function() {
			
			oper_rut[i] = this.id;
			//prod_obs[i] = $('#obs_'+oper_rut[i]).val();
			prod_obs[i] = $('#obs_'+oper_rut[i]).html();
			hrasig = $.trim($('#hrasig_'+oper_rut[i]).html());
			//prod_addoper[i] = (hrasig == '-') ? 'S' : 'N';	
			
			if(this.checked) {
				prod_asist[i] = 'S'					
				prod_cant[i] = $('#cant_'+oper_rut[i]).html();
				prod_hrini[i] = $('#hini_'+oper_rut[i]).val();
				prod_minini[i] = $('#mini_'+oper_rut[i]).val();
				prod_hrfin[i] = $('#hfin_'+oper_rut[i]).val();
				prod_minfin[i] = $('#mfin_'+oper_rut[i]).val();
				prod_hrdscto[i] = $('#dhr_'+oper_rut[i]).val();
				prod_mindscto[i] = $('#dmin_'+oper_rut[i]).val();	
				prod_b1[i] = ($('#b1_'+oper_rut[i]).is(":checked")) ? 'S' : 'N';
				prod_b2[i] = ($('#b2_'+oper_rut[i]).is(":checked")) ? 'S' : 'N';
				prod_col[i] = ($('#col_'+oper_rut[i]).is(":checked")) ? 'S' : 'N';
										
			}else{
				prod_asist[i] = 'N'
				prod_cant[i] = '';
				prod_hrini[i] = '';
				prod_minini[i] = '';
				prod_hrfin[i] = '';
				prod_minfin[i] = '';
				prod_hrdscto[i] = '';
				prod_mindscto[i] = '';	
				prod_b1[i] = '';
				prod_b2[i] = '';
				prod_col[i] = '';				
			}

			i++;
		})
			
		
		var operacion = param_oper;			
		parametros = {	
						operacion:operacion,
						plan_dia:plan_dia,
						activ_id:activ_id,							
						oper_rut:oper_rut,
						prod_asist:prod_asist,
						prod_cant:prod_cant,
						prod_hrini:prod_hrini,
						prod_minini:prod_minini,
						prod_hrfin:prod_hrfin,
						prod_minfin:prod_minfin,
						prod_hrdscto:prod_hrdscto,
						prod_mindscto:prod_mindscto,
						prod_b1:prod_b1,
						prod_b2:prod_b2,
						prod_col:prod_col,
						prod_obs:prod_obs,
						marca:marca

					 }	
		console.log(parametros)
		
		$.post(
			   "consultas/ges_crud_supxactividades.php",
			   parametros,			   
			   function(resp){
					ges_crud_supxactividades(resp)
			   },"json"
		)			
			
	}
/* //aun no está hecha
	$('#btn_del_faena').click(function(){
		swal({   
			title: "¿Seguro que deseas eliminar esta producción?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var activ_id = $.trim($('#h_activ_id').val());	
				var plan_dia = $.trim($('#plan_dia').val());
				var operacion = 'DELETE';

				$('#oper_actividad').empty();
				oper_table = 'cargar operadores'
				parametros = {			
					oper_table:oper_table,
					activ_id:id_activ,
					plan_dia:plan_dia
				}	
				$.post(
					"consultas/ges_crud_operadores.php",
					parametros,			   
					function(resp){
						Operadores_Table(resp,estado)
					},"json"
				)				
				
				
		});			
	})
*/

	function ges_crud_supxactividades(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];

		if(cod_resp == 'ok'){
			
			var activ_id = $.trim($('#h_activ_id').val());	
			var plan_dia = $.trim($('#plan_dia').val());		
			
			call_Operadores_Table(activ_id,plan_dia,'FINALIZADO');			
			
			var operacion = resp['operacion'];			
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Producción registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Producción modificada", "success");
			}else if(operacion == 'UPDATE OBS'){
				$('#WModal_Obs').modal('hide');
				swal("Sisconvi-Production", "Observación registrada", "success");
			}else if(operacion == 'DELETE OBS'){
				$('#WModal_Obs').modal('hide');
				swal("Sisconvi-Production", "Observación eliminada", "success");
			}else if(operacion == 'UPDATE CANT'){
				$('#WModal_Cant').modal('hide');
				swal("Sisconvi-Production", "Cantidad registrada", "success");
			}			

		}
		else if(cod_resp == 'advertencia'){
			var rut_operadores = resp['rut_operadores'];
			console.log(rut_operadores)
			var desc_error = resp['desc'];
			//var ruts = resp['grupo_rut_operadores'];
			//console.log(ruts)
			//swal("Sisconvi-Production", desc_error, "warning");	
			
			$('.check_oper').each( function() {				
				oper = 'oper_'+this.id;
				hrprod = 'hrprod_'+this.id;
				$('#'+oper).removeClass('color_rojo');
				$('#'+hrprod).removeClass('color_rojo');
			})
			
			$.each(rut_operadores, function (ind, elem) { 
				oper = 'oper_'+elem;
				hrprod = 'hrprod_'+elem;
				$('#'+oper).addClass('color_rojo');
				$('#'+hrprod).addClass('color_rojo');
			}); 			
			//title: desc_error + " ¿Seguro que deseas registrar esta producción?", 
			swal({   
				title: desc_error + " ¿Estás seguro?",   
				text: "No podrás deshacer este paso...",   
				type: "warning",   
				showCancelButton: true,
				cancelButtonText: "Mmm... mejor revisaré",   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "¡Adelante!",   
				closeOnConfirm: false }, 

				function(){   
					registrar_faena('INSERT',0);				
				});
			
		}
		else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}
/*	
	$('#btn_upd_faena').click(function(){
	
		$('#btn_upd_faena').hide();
		$('#btn_reg_faena').show();		
		$("#oper_actividad").find("input,textarea,select").prop("disabled", false);
	})
*/	







//COSECHA ///////////////////////////////////////////////////

/*

oper_rut
plan_dia
activ_id

PLANIFICACION_OPER - PISCINA

planta_madre
piscina

cantidad

*la sumatoria de cantidad = plano_cant
*/

	var table;
	
	function crear_tabla_cosecha(){

		var plan_dia = $('#h_sactiv_dia').val();	
		var activ_id = $('#h_activ_id').val();
		var oper_rut = $('#h_oper_clic').val();		
		console.log(plan_dia)
		table = $("#datatable-responsive").DataTable({
			

			buttons: [
			{
			  extend: "excel",
			  className: "btn-sm"
			},			
			{
			  extend: "copy",
			  className: "btn-sm"
			},
			{
			  extend: "print",
			  className: "btn-sm"
			}
			],			

			
			columnDefs: [
				{ targets: '_all', visible: true}/*,
				{ targets: '_all', visible: false }	*/		
			],	 
			ajax: "consultas/ges_crud_plantamadre.php?oper_rut="+oper_rut+"&plan_dia="+plan_dia+"&activ_id="+activ_id,	
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'pis_pm'},
				{ data:'pis_id'},
				{ data:'clon_id'},
				{ data:'pisop_cant'}
			],

			searching:true,
			dom: "Bfrtip",


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
			$('#pm_plantas').val(obj_row.pis_pm).trigger('change');
			$('#pm_piscinas').val(obj_row.pis_id).trigger('change');
			$('#pm_clon').val(obj_row.clon_id);
			$('#pm_cantidad').val(obj_row.pisop_cant);
			
			$('#hpm_plantas').val(obj_row.pis_pm);
			$('#hpm_piscinas').val(obj_row.pis_id);			

			$('#btn_reg_pm').hide();
			$('#btn_upd_pm').show();
			$('#btn_del_pm').show();
			$('#btn_can_pm').show();		
			
		});
	}





	$('#pm_cantidad').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		//cantidad = $('#pm_cantidad').val();
		//if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	

	$("#WModal_Cant_Cosecha").on('show.bs.modal', function(event){
	
		var identificador = $(event.relatedTarget);
		var oper_rut = identificador.data('id');
		var plan_dia = identificador.data('dia');
		$('#h_sactiv_dia').val(plan_dia)
		//var plan_dia = $('#h_sactiv_dia').val()
		var nom_operador = identificador.data('oper');	
		var activ_id = $('#h_activ_id').val()
		
		load_clon(plan_dia);
		
		console.log(plan_dia)

		$('#h_oper_clic').val(oper_rut);
		$('#title_cosecha').html(nom_operador)
		//$('#h_pm_dia').val(h_pm_dia);
		//console.log(oper_rut +'-'+ plan_dia +'-'+ activ_id)
		//console.log(table)
		if(typeof table != 'undefined') table.destroy()
		crear_tabla_cosecha();
    });	
	
	$('#pm_plantas').change(function() {
		//var fecha = $('#h_pm_dia').val();
		var fecha = $('#h_sactiv_dia').val();
		load_clon(fecha)
	})	

	$('#pm_piscinas').change(function() {
		//var fecha = $('#h_pm_dia').val();
		var fecha = $('#h_sactiv_dia').val();
		load_clon(fecha)
	})	

	function load_clon(fecha){
		
		var pm_plantas = $.trim($('#pm_plantas').val());
		var pm_piscinas = $.trim($('#pm_piscinas').val());		
		var cons_clon = 'carga'	
				
		parametros = {			
			cons_clon:cons_clon,
			pm_plantas:pm_plantas,
			pm_piscinas:pm_piscinas,
			fecha:fecha			
		}
		console.log(parametros)		

		$.post(
			"consultas/ges_crud_plantamadre.php",
			parametros,			   
			function(resp){
				carga_clon(resp)
			},"json"
		)	
	}

	function carga_clon(resp){
		
		console.log(resp)
		
		var cod_resp = resp['cod'];
		var clon_id = resp['clon_id'];
		
		$('#pm_clon').val(clon_id)
		
	}

	function validar_pm(){

		var pm_plantas = $.trim($('#pm_plantas').val());
		var pm_piscinas = $.trim($('#pm_piscinas').val());
		var pm_clon = $.trim($('#pm_clon').val());
		var pm_cantidad = $.trim($('#pm_cantidad').val());
		
		if(pm_plantas == ''){
			sweet_alert('Error: Seleccionar planta madre');	
			return false;
		}
		
		if(pm_piscinas == ''){
			sweet_alert('Error: Seleccionar piscina');	
			return false;
		}		

		if(pm_clon == ''){
			sweet_alert('Error: Clon no encontrado en planta madre y piscina seleccionada');
			return false;
		}
		
		if(pm_cantidad == ''){
			sweet_alert('Error: Ingresar cantidad');	
			return false;
		}		

		return true;
	}	

	
	$('#btn_reg_pm').click(function(){

		if (validar_pm()){	

			$('#loading2').show();
			
			var pm_plantas = $.trim($('#pm_plantas').val());
			var pm_piscinas = $.trim($('#pm_piscinas').val());
			var pm_cantidad = $.trim($('#pm_cantidad').val());
			
			var plan_dia = $('#h_sactiv_dia').val();	
			var activ_id = $('#h_activ_id').val();
			var oper_rut = $('#h_oper_clic').val();			
			
			var prod_hrini = $('#hini_'+oper_rut).val();
			var prod_minini = $('#mini_'+oper_rut).val();
			var prod_hrfin = $('#hfin_'+oper_rut).val();
			var prod_minfin = $('#mfin_'+oper_rut).val();
			var prod_hrdscto = $('#dhr_'+oper_rut).val();
			var prod_mindscto = $('#dmin_'+oper_rut).val();	
			var prod_b1 = ($('#b1_'+oper_rut).is(":checked")) ? 'S' : 'N';
			var prod_b2 = ($('#b2_'+oper_rut).is(":checked")) ? 'S' : 'N';
			var prod_col = ($('#col_'+oper_rut).is(":checked")) ? 'S' : 'N';			
			
			var operacion = 'REGISTRAR CANT COSECHA';
			parametros = {			
							pm_plantas:pm_plantas,
							pm_piscinas:pm_piscinas,
							pm_cantidad:pm_cantidad,
							plan_dia:plan_dia,
							activ_id:activ_id,
							oper_rut:oper_rut,
							
							prod_hrini:prod_hrini,
							prod_minini:prod_minini,
							prod_hrfin:prod_hrfin,
							prod_minfin:prod_minfin,
							prod_hrdscto:prod_hrdscto,
							prod_mindscto:prod_mindscto,
							prod_b1:prod_b1,
							prod_b2:prod_b2,
							prod_col:prod_col,							
							
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_plantamadre(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_pm').click(function(){
		if (validar_pm()){	

			$('#loading2').show();
			
			var hpm_plantas = $.trim($('#hpm_plantas').val());
			var hpm_piscinas = $.trim($('#hpm_piscinas').val());
			var pm_plantas = $.trim($('#pm_plantas').val());
			var pm_piscinas = $.trim($('#pm_piscinas').val());
			var pm_cantidad = $.trim($('#pm_cantidad').val());
			
			var plan_dia = $('#h_sactiv_dia').val();	
			var activ_id = $('#h_activ_id').val();
			var oper_rut = $('#h_oper_clic').val();	
			
			var prod_hrini = $('#hini_'+oper_rut).val();
			var prod_minini = $('#mini_'+oper_rut).val();
			var prod_hrfin = $('#hfin_'+oper_rut).val();
			var prod_minfin = $('#mfin_'+oper_rut).val();
			var prod_hrdscto = $('#dhr_'+oper_rut).val();
			var prod_mindscto = $('#dmin_'+oper_rut).val();	
			var prod_b1 = ($('#b1_'+oper_rut).is(":checked")) ? 'S' : 'N';
			var prod_b2 = ($('#b2_'+oper_rut).is(":checked")) ? 'S' : 'N';
			var prod_col = ($('#col_'+oper_rut).is(":checked")) ? 'S' : 'N';			
			
			var operacion = 'MODIFICAR CANT COSECHA';
			parametros = {
							hpm_plantas:hpm_plantas,
							hpm_piscinas:hpm_piscinas,			
							pm_plantas:pm_plantas,
							pm_piscinas:pm_piscinas,
							pm_cantidad:pm_cantidad,
							plan_dia:plan_dia,
							activ_id:activ_id,
							oper_rut:oper_rut,
							
							prod_hrini:prod_hrini,
							prod_minini:prod_minini,
							prod_hrfin:prod_hrfin,
							prod_minfin:prod_minfin,
							prod_hrdscto:prod_hrdscto,
							prod_mindscto:prod_mindscto,
							prod_b1:prod_b1,
							prod_b2:prod_b2,
							prod_col:prod_col,								
							
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_plantamadre(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_pm').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta cantidad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading2').show();
				var hpm_plantas = $.trim($('#hpm_plantas').val());
				var hpm_piscinas = $.trim($('#hpm_piscinas').val());	
				var plan_dia = $('#h_sactiv_dia').val();	
				var activ_id = $('#h_activ_id').val();
				var oper_rut = $('#h_oper_clic').val();		
				
				var prod_hrini = $('#hini_'+oper_rut).val();
				var prod_minini = $('#mini_'+oper_rut).val();
				var prod_hrfin = $('#hfin_'+oper_rut).val();
				var prod_minfin = $('#mfin_'+oper_rut).val();
				var prod_hrdscto = $('#dhr_'+oper_rut).val();
				var prod_mindscto = $('#dmin_'+oper_rut).val();	
				var prod_b1 = ($('#b1_'+oper_rut).is(":checked")) ? 'S' : 'N';
				var prod_b2 = ($('#b2_'+oper_rut).is(":checked")) ? 'S' : 'N';
				var prod_col = ($('#col_'+oper_rut).is(":checked")) ? 'S' : 'N';				
				
				
				var operacion = 'ELIMINAR CANT COSECHA';
				parametros = {	
								hpm_plantas:hpm_plantas,
								hpm_piscinas:hpm_piscinas,			
								plan_dia:plan_dia,
								activ_id:activ_id,
								oper_rut:oper_rut,		
								
								prod_hrini:prod_hrini,
								prod_minini:prod_minini,
								prod_hrfin:prod_hrfin,
								prod_minfin:prod_minfin,
								prod_hrdscto:prod_hrdscto,
								prod_mindscto:prod_mindscto,
								prod_b1:prod_b1,
								prod_b2:prod_b2,
								prod_col:prod_col,									
								
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_supxactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_plantamadre(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_plantamadre(resp){
		$('#loading2').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'REGISTRAR CANT COSECHA'){
				swal("Sisconvi-Production", "Cantidad registrada", "success");
			}else if(operacion == 'MODIFICAR CANT COSECHA'){
				swal("Sisconvi-Production", "Cantidad modificada", "success");
			}else if(operacion == 'ELIMINAR CANT COSECHA'){
				swal("Sisconvi-Production", "Cantidad eliminada", "success");
			}		
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla_cosecha();
			
			var activ_id = $.trim($('#h_activ_id').val());	
			var plan_dia = $('#h_sactiv_dia').val();		
			
			call_Operadores_Table(activ_id,plan_dia,'FINALIZADO');			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}		

	$('#btn_can_pm').click(function(){
		cancelar();
	})	
	
	function cancelar(){
		//$('#form_plantamadre')[0].reset();

		$('#btn_reg_pm').show();
		$('#btn_upd_pm').hide();
		$('#btn_del_pm').hide();
		$('#btn_can_pm').hide();

		table.$('tr.selected').removeClass('selected');

		$('#pm_cantidad').val('')
		
	}		
	
	
	$('#asist_all').click(function(){		
		if ($('#asist_all').is(":checked"))
		{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#'+oper_rut).prop('checked',true);								
			})	
		}else{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#'+oper_rut).prop('checked',false);								
			})			
		}				
	})	
	
	$('#b1_all').click(function(){		
		if ($('#b1_all').is(":checked"))
		{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#b1_'+oper_rut).prop('checked',true);								
			})	
		}else{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#b1_'+oper_rut).prop('checked',false);								
			})			
		}				
	})

	$('#b2_all').click(function(){		
		if ($('#b2_all').is(":checked"))
		{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#b2_'+oper_rut).prop('checked',true);								
			})	
		}else{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#b2_'+oper_rut).prop('checked',false);								
			})			
		}				
	})

	$('#col_all').click(function(){		
		if ($('#col_all').is(":checked"))
		{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#col_'+oper_rut).prop('checked',true);								
			})	
		}else{
			$('.check_oper').each( function() {				
				oper_rut = this.id;
				$('#col_'+oper_rut).prop('checked',false);								
			})			
		}				
	})

	$('#btn_hora_all').click(function(){	

		var hr_ini_all = $('#hr_ini_all').val();
		var min_ini_all = $('#min_ini_all').val();
		var hr_fin_all = $('#hr_fin_all').val();
		var min_fin_all = $('#min_fin_all').val();
		
		hora_inicial = hr_ini_all+':'+min_ini_all
		hora_final = hr_fin_all+':'+min_fin_all
		
		var format = 'HH:mm'
		
		hora_inicial = moment(hora_inicial,format)
		hora_final = moment(hora_final,format)
		
		//console.log('hora_inicial:'+hora_inicial)
		//console.log('hora_final:'+hora_final)
		
	//BREAK1
		b1i= '10:00'
		b1i = moment(b1i,format)
		//console.log('b1i:'+b1i)
		
		b1f= '10:15'
		b1f = moment(b1f,format)
		//console.log('b1f:'+b1f)		
		
		if( moment(b1i,format).isBetween(hora_inicial,hora_final)&& moment(b1f,format).isBetween(hora_inicial,hora_final) ){
			break1 = true
		}else{
			break1 = false
		}	
		
	//BREAK2
		b2i= '15:00'
		b2i = moment(b2i,format)
		
		b2f= '15:15'
		b2f = moment(b2f,format)	
		
		if( moment(b2i,format).isBetween(hora_inicial,hora_final)&& moment(b2f,format).isBetween(hora_inicial,hora_final) ){
			break2 = true
		}else{
			break2 = false
		}	
		
	//COLACION
		coli= '12:00'
		coli = moment(coli,format)
		
		colf= '14:30'
		colf = moment(colf,format)	
		
		if( moment(coli,format).isBetween(hora_inicial,hora_final)&& moment(colf,format).isBetween(hora_inicial,hora_final) ){
			col = true
		}else{
			col = false
		}		
		
		
		/*
		moment('2010-10-20').isBetween('2010-01-01', '2012-01-01', 'year'); // false - The match is exclusive
		moment('2010-10-20').isBetween('2009-12-31', '2012-01-01', 'year'); // true
		moment('2010-10-20').isBetween('2010-10-19', '2010-10-25'); // true
		*/

		$('.check_oper').each( function() {				
			oper_rut = this.id;
			
			if($('#'+oper_rut).is(":checked")){
			
				$('#hini_'+oper_rut).val(hr_ini_all);
				$('#mini_'+oper_rut).val(min_ini_all);
				$('#hfin_'+oper_rut).val(hr_fin_all);
				$('#mfin_'+oper_rut).val(min_fin_all);
				
				$('#hini_'+oper_rut).addClass('color_negro');
				$('#mini_'+oper_rut).addClass('color_negro');
				$('#hfin_'+oper_rut).addClass('color_negro');
				$('#mfin_'+oper_rut).addClass('color_negro');
				
				if(break1){ $('#b1_'+oper_rut).prop('checked',true); }
				else{ $('#b1_'+oper_rut).prop('checked',false);}
				
				if(break2){ $('#b2_'+oper_rut).prop('checked',true); }
				else{ $('#b2_'+oper_rut).prop('checked',false);}			

				if(col){ $('#col_'+oper_rut).prop('checked',true); }
				else{ $('#col_'+oper_rut).prop('checked',false);}
			}
		})	
			
	})

	$('#btn_new_activ').click(function(){
		
		id_activ_new = $('#id_activ_new').val();
		
		if(id_activ_new == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}	
		
		if(plan_dia_new == ''){
			sweet_alert('Error: Seleccionar día');	
			return false;
		}		
		
		plan_dia_new = $('#plan_dia_new').val();
		$('#plan_dia').val(plan_dia_new).trigger('change');		
		RealizarActiv(id_activ_new);
	})





	$('#plan_dia_new').change(function(){
		
		var rut_supervisor = $('#sup_rut').val();
		var plan_dia = $('#plan_dia_new').val();
		var planif_activ = 'planif_activ'
		
		if(rut_supervisor == ''){
			sweet_alert('Error: Seleccionar supervisor');	
		}else{
			$('#loading3').show();
			parametros = {			
				rut_supervisor:rut_supervisor,
				plan_dia:plan_dia,
				planif_activ:planif_activ
			}	
			
			$.post(
				"consultas/ges_crud_supervisores.php",
				parametros,			   
				function(resp){
					new_actividades(resp)
				},"json"
			)
		}		
		
	})

	function new_actividades(resp){

		$('#loading3').hide();

		i = 0;
		actividad_new = '';
		while(i < resp.length){
			actividad = resp[i].ACTIV_NOMBRE;
			id_activ = resp[i].ACTIV_ID;
			estado = resp[i].PROD_EXISTE;
			actividad_new = actividad_new + '<option value="'+id_activ+'">'+actividad+' - ESTADO:'+estado+'</option>';		
			i++;
		}

		clear_combobox('id_activ_new',1);			
		$('#id_activ_new').append(actividad_new);
	
	}	

});