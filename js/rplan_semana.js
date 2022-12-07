$(document).ready(function(){

	$('#sup_rut').select2({	});
	$('#activ_id').select2({ });
	$('#hora_activ').select2({ });

	var table;	
	
	function crear_tabla(num_sem, per_agno, fecha){
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_rplanxsemana.php?data="+num_sem+"&per_agno="+per_agno+"&fecha="+fecha,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'PLAN_DIA'},
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_NOMBRE'},
				{ data:'PLAN_PRODUCCION'},
				{ data:'SUPERVISOR'},			
				{ data:'AREA_ID'},			
				{ data:'SUP_RUT'},
				{ data:'ACTIV_ID'},
				{ data:'RUT_OPERADORES'}
			],

			columnDefs: [
			{ targets: [0,1,2,3,4,5,6], visible: true},
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

			//console.log(obj_row)
			fecha = obj_row.PLAN_DIA;
			fecha = fecha.split('-');
			fecha = fecha[2]+fecha[1]+fecha[0];
			$('#h_plan_dia').val(obj_row.PLAN_DIA);
			$('#h_activ_id').val(obj_row.ACTIV_ID);
			$('#h_sup_rut').val(obj_row.SUP_RUT);

			$('#h_rut_oper').val(obj_row.RUT_OPERADORES);
			
			$('#plan_dia').val(fecha).trigger('change');
			$('#area_id').val(obj_row.AREA_ID).trigger('change');	

			PLAN_PRODUCCION = '';
			if(obj_row.PLAN_PRODUCCION != ''){
				PLAN_PRODUCCION = obj_row.PLAN_PRODUCCION.split(' ');
				PLAN_PRODUCCION = PLAN_PRODUCCION[0]
			}			
			
			$('#btn_reg_planxsemana').hide();
			$('#btn_upd_planxsemana').show();
			$('#btn_del_planxsemana').show();
			$('#btn_can_planxsemana').show();		
			
		});
	}

	$('#plan_operadores').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});

	$('#plan_prod_esperada').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		prod_esperada = $('#plan_prod_esperada').val();
		if(e.which==44 && prod_esperada.search( ',' ) != -1)return false;			
	});		
	
	$('#btn_plan_actividad').click(function(){
	
		btn_txt = $('#btn_plan_actividad').html();
		
		if(btn_txt== 'Planificar'){
			dia_seleccionado = $.trim($('#plan_dia').val());

			if(dia_seleccionado == ''){
				sweet_alert('Error: Falta seleccionar el día a planificar');
			}
			else{

				$('#plan_dia').prop('disabled',true);
				$('#btn_plan_actividad').html('Cambiar Día(s)');
				$('#area_id').prop('disabled',false);
			}
		}else{
			$('#form_planxsemana')[0].reset();
			$('#plan_dia').prop('disabled',false);
			$('#btn_plan_actividad').html('Planificar');
			$('#plan_dia').val('').trigger('change');
			$('#area_id').val('');
			$('#area_id').change();
			$('#area_id').prop('disabled',true);

		}	
	})


	$('#btn_can_planxsemana').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_planxsemana')[0].reset();
		
		$('#h_activ_id').val('');
		$('#h_sup_rut').val('');
		$('#h_plan_dia').val('');
		$('#h_rut_oper').val('');
		
		$('#plan_dia').val('').trigger('change');
		$('#hora_activ').val('0').trigger('change');
		$('#area_id').val('');
		$('#area_id').change();
		$('#activ_id').val('');
		$('#activ_id').change();		
		
		$('#btn_reg_planxsemana').show();
		$('#btn_upd_planxsemana').hide();
		$('#btn_del_planxsemana').hide();
		$('#btn_can_planxsemana').hide();
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
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sactiv_motivo');	
	
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});	
		
		$('#per_agno').val(agno_actual).trigger('change');
		
	}
	
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

	function carga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		cancelar();
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();		
		change_sem_num();
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

		cancelar();
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
		//console.log(resp)
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#plan_dia').select2({			
			allowClear: true,
			placeholder: "SELECCIONE DIA(S)",
			data:combobox
		});			
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		var fecha_dia = $("#plan_dia option")[0].value;
		crear_tabla(sem_num,per_agno,fecha_dia);
		sem_txt = $('#sem_num option:selected').text();
		$('#sem_txt').html(sem_txt);
	}	
		
	
	carga_areas();
	function carga_areas(){
		var combobox = [];
		for(var i  = 0 ; i < data_areas.length; i++) {
			combobox.push({id:data_areas[i].area_id, text:data_areas[i].area_nombre});
		}	
		
		$('#area_id').select2({			
			//allowClear: true,
			data:combobox
		});		
		
	}
	
	
	$('#area_id').change(function() {

		var area_id = $('#area_id').val();
		var fecha_dia = $("#plan_dia option")[0].value;
		var activ_id = $('#h_activ_id').val();
		var sem_num = $('#sem_num').val();
		var plan_dia = $.trim($('#plan_dia').val());
		var rut_oper = $.trim($('#h_rut_oper').val());

		$('#plan_meta').val('');
		$('#plan_unidad').val('');
		
		if(area_id == ""){
			clear_combobox('sup_rut',1);
			clear_combobox('activ_id',1);
		}
		else{		

			parametros = {			
				plan_area:area_id,fecha_dia:fecha_dia,sem_num:sem_num,plan_dia:plan_dia,activ_id:activ_id,rut_oper:rut_oper
			}		
			//console.log(parametros)
			clear_combobox('sup_rut',1);
			$.post(
				"consultas/ges_crud_supervisores.php",
				parametros,			   
				function(resp){
					carga_supervisores(resp)
				},"json"
				)	
			
			clear_combobox('activ_id',1);
			$.post(
				"consultas/ges_crud_actividades.php",
				parametros,			   
				function(resp){
					carga_actividades(resp)
				},"json"
			)
		}
					
	});
	
	$('#activ_id').change(function() {
		
		$('#plan_unidad').val('');
		$('#plan_meta').val('');
		
		$("#lista1_operadores tr").remove();
		$("#lista2_operadores tr").remove();

		$("#lista1_disp_operadores tr").remove();
		$("#lista2_disp_jornada tr").remove();
		
		$("#lista1_selec_jornada tr").remove();
		$("#lista3_selec_operadores tr").remove();
		$("#lista2_selec_produccion tr").remove();		
		
		a = $('#activ_id').val();
		if(a == null){
			$('#activ_id').val('');
		}
		else{
			var area_id = $('#area_id').val();
			var fecha_dia = $("#plan_dia option")[0].value;
			var sem_num = $('#sem_num').val();
			var plan_dia = $.trim($('#plan_dia').val());
			var rut_oper = $.trim($('#h_rut_oper').val());
			var activ_id = $.trim($('#activ_id').val());
			var change_activ = '';
			var h_plan_dia = $.trim($('#h_plan_dia').val());
			var h_activ_id = $.trim($('#h_activ_id').val());
			var h_activ_split = '';
			if(h_activ_id != ""){
				h_activ_split = h_activ_id.split('---');
				h_activ_split = h_activ_split[0]
			}
			var per_agno = $('#per_agno').val();

			if(activ_id != ""){
			
				activ_split = activ_id.split('---');
				
				if(activ_split[1] != '0'){
					$('#plan_unidad').val(activ_split[1]);
				}
				
				if(activ_split[2] != '0'){
					$('#plan_meta').val(activ_split[2]);					
					meta = $('#plan_meta').val();						
				}
				
				parametros = {			
					change_activ:change_activ,h_plan_dia:h_plan_dia,h_activ_id:h_activ_split,fecha_dia:fecha_dia,sem_num:sem_num,plan_dia:plan_dia,activ_id:activ_split[0],rut_oper:rut_oper, activ_standar:activ_split[3], per_agno: per_agno
				}
				//console.log(parametros)
				$.post(
					"consultas/ges_crud_operadores.php",
					parametros,			   
					function(resp){
						carga_operadores(resp)
					},"json"
				)
			}	
		}
	})	
	

	function carga_supervisores(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
		}	
		
		$('#sup_rut').select2({			
			data:combobox
		})
		sup_selected = $('#h_sup_rut').val();
		$('#sup_rut').val(sup_selected).trigger('change');

		a = $('#sup_rut').val();
		if(a == null){
			$('#sup_rut').val('').trigger('change');
		}
		
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
		activ_selected = $('#h_activ_id').val();
		$('#activ_id').val(activ_selected).trigger('change');
	}	
	
/////////////////////	


	function cargar_oper_dia(dia,dia2,buscar_dia,id_diahrdisp,id_diahrocup,check,plan_dia_text,disp_oper_dia,disp_jorn_dia,sel_jorn_dia,sel_oper_dia,clase_tooltip){

		hr_dia_disp = '8,5';
		hr_dia_ocup = '0';
		color = 'red';
		dobleactiv_dia = 0;
		
		//console.log('dia:'+dia);console.log('dia2:'+dia2);

		if(dia != '0'){				
			dia = dia.split('---');
			area_oper = dia[0];
			activ_oper = dia[1];
			horas_oper = dia[2];
			hr_dia_format = dia[2].replace(',','.');

			if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dia2 == '0'){
				imagen = 'reloj.png';
				hr_dia_disp = 8.5;
				hr_dia_ocup = hr_dia_format;
				disp_jorn_dia = parseFloat(disp_jorn_dia) + parseFloat(hr_dia_disp);						
			}
			else if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dia2 != '0'){
				imagen = 'work4.png';
				area_selec = $('#area_id option:selected').html();
				activ_selec = $('#activ_id option:selected').html();
				
				dia2 = dia2.split('---');	
				
				if(area_selec == area_oper && activ_selec == activ_oper){
					horas_oper2 = dia[2];
					area_oper =  dia2[0];
					activ_oper = dia2[1];
					horas_oper = dia2[2];						
				}else{
					horas_oper2 = dia2[2];
				}
				
				hr_dia_format = horas_oper2.replace(',','.');
				hr_dia_disp = horas_oper2;
				hr_dia_ocup = hr_dia_format;
				disp_jorn_dia = parseFloat(disp_jorn_dia) + parseFloat(hr_dia_disp);					
				dia2 = '0';
				dobleactiv_dia = 1;
			}				
			else{				
			
				if(dia[2] != '8,50'){
					imagen = 'work4.png';
				}else{
					imagen = 'work.png';
				}				
				hr_dia_disp = 8.5 - parseFloat(hr_dia_format);
				hr_dia_ocup = hr_dia_disp;
				disp_jorn_dia = parseFloat(disp_jorn_dia) + parseFloat(hr_dia_disp);
			}

			if(dia2 != '0'){
				dia2 = dia2.split('---');			
				
				area_oper = dia[0]+','+dia2[0];
				activ_oper = dia[1]+','+dia2[1];
				horas_oper = dia[2]+'+'+dia2[2];

				hr_dia2_format = dia2[2].replace(',','.');
				
				hr_dia2_disp = 8.5 - parseFloat(hr_dia2_format);
				disp_jorn_dia = parseFloat(disp_jorn_dia) + parseFloat(hr_dia2_disp);
				hr_dia_total = parseFloat(hr_dia_format) + parseFloat(hr_dia2_format);
				
				hr_dia_disp = 8.5 - hr_dia_total
				hr_dia_ocup = hr_dia_disp;
				
				if(hr_dia_total != 8.5){
					imagen = 'work4.png';
				}else{
					imagen = 'work.png';
				}						
				
			}else{

				if(dia[2] != '8,50'){
					disp_oper_dia = parseFloat(disp_oper_dia) + 1;	
				}
			}
			hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
			hr_dia_disp = String(hr_dia_disp).replace('.',',');

			if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dobleactiv_dia == 0){
				color = 'green';
				sel_jorn_dia = sel_jorn_dia + parseFloat(hr_dia_ocup);
				hr_dia_ocup = String(hr_dia_ocup).replace('.',',');					
				sel_oper_dia++;					
				dia_return = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';					
				
			}
			else if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dobleactiv_dia == 1){
				color = 'green';
				sel_jorn_dia = sel_jorn_dia + parseFloat(hr_dia_ocup);
				hr_dia_ocup = String(hr_dia_ocup).replace('.',',');
				sel_oper_dia++;					
				dia_return = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span class="'+clase_tooltip+'">Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';					
			}		
			else{
				dia_return = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span class="'+clase_tooltip+'">Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
			}
			
		}else{
			imagen = 'reloj.png';
		
			if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1){
				color = 'green';
				hr_dia_disp = String(hr_dia_disp).replace(',','.');
				hr_dia_disp = Math.round(hr_dia_disp * 100)/100;
				hr_dia_ocup = String(hr_dia_disp).replace('.',',');
				sel_jorn_dia = sel_jorn_dia + parseFloat(hr_dia_disp);
				sel_oper_dia++;
			}	
			
			hr_dia_disp = String(hr_dia_disp).replace('.',',');
			
			dia_return = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Disp:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';
			disp_oper_dia = parseFloat(disp_oper_dia) + 1;
			disp_jorn_dia = parseFloat(disp_jorn_dia) + 8.5;
		}
		
		retorno = dia_return+'***'+disp_oper_dia+'***'+disp_jorn_dia+'***'+sel_jorn_dia+'***'+sel_oper_dia;
		
		return retorno;
		
	}
	
	
//////////////////////////////////	
	
	function carga_operadores(resp){

		//console.log(resp)	
  
		var cant_operadores = resp.length;
		var cant_lista1 = Math.round(cant_operadores/2);
		var i = 0;
		var operadores_ocupados = 0;

		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');		
		
						  
						   
		var disp_oper_lunes = 0;var disp_oper_martes = 0;var disp_oper_miercoles = 0;
						   
		var disp_oper_jueves = 0;var disp_oper_viernes = 0;	var disp_oper_sabado = 0;
		
						  
						   
		var disp_jorn_lunes = 0;var disp_jorn_martes = 0;var disp_jorn_miercoles = 0;
						   
		var disp_jorn_jueves = 0;var disp_jorn_viernes = 0;var disp_jorn_sabado = 0;
		
						 
						  
		var sel_oper_lunes = 0;var sel_oper_martes = 0;var sel_oper_miercoles = 0;
						  
		var sel_oper_jueves = 0;var sel_oper_viernes = 0;var sel_oper_sabado = 0;
		
						 
						  
		var sel_jorn_lunes = 0;	var sel_jorn_martes = 0;var sel_jorn_miercoles = 0;
						  
		var sel_jorn_jueves = 0;var sel_jorn_viernes = 0;var sel_jorn_sabado = 0;
		
						 
						  
		var sel_prod_lunes = 0;	var sel_prod_martes = 0;var sel_prod_miercoles = 0;
						  
		var sel_prod_jueves = 0;var sel_prod_viernes = 0;var sel_prod_sabado = 0;
		
		while(i < cant_lista1){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			lun = resp[i].LUN[0];	mar = resp[i].MAR[0];	mie = resp[i].MIE[0];
			jue = resp[i].JUE[0];	vie = resp[i].VIE[0];	sab = resp[i].SAB[0];
						
						
						

			lun2 = resp[i].LUN[1];	mar2 = resp[i].MAR[1];	mie2 = resp[i].MIE[1];
			jue2 = resp[i].JUE[1];	vie2 = resp[i].VIE[1];	sab2 = resp[i].SAB[1];
						 
						 
						 

			check = '';
			if(resp[i].MARCACHECK == 'checked'){
				check = 'checked';
			}			
			
			clase_tooltip = '';

//LUNES			
			id_lunhrdisp = 'lunhrdisp_'+resp[i].OPER_RUT;
			id_lunhrocup = 'lunhrocup_'+resp[i].OPER_RUT;			
			dia_lunes = cargar_oper_dia(lun,lun2,"LUN",id_lunhrdisp,id_lunhrocup,check,plan_dia_text,disp_oper_lunes,disp_jorn_lunes,sel_jorn_lunes,sel_oper_lunes,clase_tooltip);
										  
			dia_lunes = dia_lunes.split('***');
							 
			lunes = dia_lunes[0];
			disp_oper_lunes = dia_lunes[1];disp_jorn_lunes = dia_lunes[2];
			sel_jorn_lunes = dia_lunes[3];sel_oper_lunes = dia_lunes[4]; 

   
//MARTES			
   
			id_marhrdisp = 'marhrdisp_'+resp[i].OPER_RUT;
			id_marhrocup = 'marhrocup_'+resp[i].OPER_RUT;			
			dia_martes = cargar_oper_dia(mar,mar2,"MAR",id_marhrdisp,id_marhrocup,check,plan_dia_text,disp_oper_martes,disp_jorn_martes,sel_jorn_martes,sel_oper_martes,clase_tooltip);
																
							   
			dia_martes = dia_martes.split('***');
	 						   
			martes = dia_martes[0];
			disp_oper_martes = dia_martes[1];disp_jorn_martes = dia_martes[2];
			sel_jorn_martes = dia_martes[3];sel_oper_martes = dia_martes[4]; 


//MIERCOLES			

			id_miehrdisp = 'miehrdisp_'+resp[i].OPER_RUT;
			id_miehrocup = 'miehrocup_'+resp[i].OPER_RUT;
			dia_miercoles = cargar_oper_dia(mie,mie2,"MIE",id_miehrdisp,id_miehrocup,check,plan_dia_text,disp_oper_miercoles,disp_jorn_miercoles,sel_jorn_miercoles,sel_oper_miercoles,clase_tooltip);

																			
							   
			dia_miercoles = dia_miercoles.split('***');
								 
			miercoles = dia_miercoles[0];
			disp_oper_miercoles = dia_miercoles[1];disp_jorn_miercoles = dia_miercoles[2];
			sel_jorn_miercoles = dia_miercoles[3];sel_oper_miercoles = dia_miercoles[4]; 


			
//JUEVES			
			id_juehrdisp = 'juehrdisp_'+resp[i].OPER_RUT;
			id_juehrocup = 'juehrocup_'+resp[i].OPER_RUT;
			dia_jueves = cargar_oper_dia(jue,jue2,"JUE",id_juehrdisp,id_juehrocup,check,plan_dia_text,disp_oper_jueves,disp_jorn_jueves,sel_jorn_jueves,sel_oper_jueves,clase_tooltip);
					 														
							   
			dia_jueves = dia_jueves.split('***');
						   
			jueves = dia_jueves[0];
			disp_oper_jueves = dia_jueves[1];disp_jorn_jueves = dia_jueves[2];
			sel_jorn_jueves = dia_jueves[3];sel_oper_jueves = dia_jueves[4]; 
	
			
//VIERNES			
			id_viehrdisp = 'viehrdisp_'+resp[i].OPER_RUT;
			id_viehrocup = 'viehrocup_'+resp[i].OPER_RUT;
			dia_viernes = cargar_oper_dia(vie,vie2,"VIE",id_viehrdisp,id_viehrocup,check,plan_dia_text,disp_oper_viernes,disp_jorn_viernes,sel_jorn_viernes,sel_oper_viernes,clase_tooltip);
			dia_viernes = dia_viernes.split('***');
																		 
			viernes = dia_viernes[0];
			disp_oper_viernes = dia_viernes[1];disp_jorn_viernes = dia_viernes[2];
			sel_jorn_viernes = dia_viernes[3];sel_oper_viernes = dia_viernes[4]; 
			
//SABADO			
			id_sabhrdisp = 'sabhrdisp_'+resp[i].OPER_RUT;
			id_sabhrocup = 'sabhrocup_'+resp[i].OPER_RUT;
			dia_sabado = cargar_oper_dia(sab,sab2,"SAB",id_sabhrdisp,id_sabhrocup,check,plan_dia_text,disp_oper_sabado,disp_jorn_sabado,sel_jorn_sabado,sel_oper_sabado,clase_tooltip);
			dia_sabado = dia_sabado.split('***');
			sabado = dia_sabado[0];
			disp_oper_sabado = dia_sabado[1];disp_jorn_sabado = dia_sabado[2];
			sel_jorn_sabado = dia_sabado[3];sel_oper_sabado = dia_sabado[4]; 			
																	  

//LLENADO 1ERA LISTA			

			$('#lista1_operadores').append(
			'<tr id='+id_row+'>'+
			  '<td class="col-md-1"><input type="checkbox" '+check+' class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
			  '<td class="col-md-5">'+resp[i].OPERARIO+'</td>' +
			  '<td class="col-md-1"">'+lunes+'</td>' +
			  '<td class="col-md-1"">'+martes+'</td>' +
			  '<td class="col-md-1"">'+miercoles+'</td>' +
			  '<td class="col-md-1"">'+jueves+'</td>' +
			  '<td class="col-md-1"">'+viernes+'</td>' +
			  '<td class="col-md-1"">'+sabado+'</td>' +
			'</tr>');				


			if(resp[i].MARCACHECK == 'checked'){
				$("#"+id_row).addClass('negrita');
			}				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}
		
		
		while(i < cant_operadores){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			lun = resp[i].LUN[0];
			mar = resp[i].MAR[0];
			mie = resp[i].MIE[0];
			jue = resp[i].JUE[0];
			vie = resp[i].VIE[0];
			sab = resp[i].SAB[0];

			lun2 = resp[i].LUN[1];
			mar2 = resp[i].MAR[1];
			mie2 = resp[i].MIE[1];
			jue2 = resp[i].JUE[1];
			vie2 = resp[i].VIE[1];
			sab2 = resp[i].SAB[1];

			check = '';
			if(resp[i].MARCACHECK == 'checked'){
				check = 'checked';
			}			
			
			clase_tooltip = 'tip_izq';
//LUNES			
			id_lunhrdisp = 'lunhrdisp_'+resp[i].OPER_RUT;
			id_lunhrocup = 'lunhrocup_'+resp[i].OPER_RUT;			
			dia_lunes = cargar_oper_dia(lun,lun2,"LUN",id_lunhrdisp,id_lunhrocup,check,plan_dia_text,disp_oper_lunes,disp_jorn_lunes,sel_jorn_lunes,sel_oper_lunes,clase_tooltip);
														
							   
			dia_lunes = dia_lunes.split('***');
					 
			lunes = dia_lunes[0];
			disp_oper_lunes = dia_lunes[1];disp_jorn_lunes = dia_lunes[2];
			sel_jorn_lunes = dia_lunes[3];sel_oper_lunes = dia_lunes[4]; 

   
   
//MARTES			
   
			id_marhrdisp = 'marhrdisp_'+resp[i].OPER_RUT;
			id_marhrocup = 'marhrocup_'+resp[i].OPER_RUT;			
			dia_martes = cargar_oper_dia(mar,mar2,"MAR",id_marhrdisp,id_marhrocup,check,plan_dia_text,disp_oper_martes,disp_jorn_martes,sel_jorn_martes,sel_oper_martes,clase_tooltip);
																		
							   
			dia_martes = dia_martes.split('***');						  
										   
			martes = dia_martes[0];
			disp_oper_martes = dia_martes[1];disp_jorn_martes = dia_martes[2];
			sel_jorn_martes = dia_martes[3];sel_oper_martes = dia_martes[4]; 
	 


//MIERCOLES			

			id_miehrdisp = 'miehrdisp_'+resp[i].OPER_RUT;
			id_miehrocup = 'miehrocup_'+resp[i].OPER_RUT;
			dia_miercoles = cargar_oper_dia(mie,mie2,"MIE",id_miehrdisp,id_miehrocup,check,plan_dia_text,disp_oper_miercoles,disp_jorn_miercoles,sel_jorn_miercoles,sel_oper_miercoles,clase_tooltip);
												
							   
			dia_miercoles = dia_miercoles.split('***');
	 							
												 
			miercoles = dia_miercoles[0];
			disp_oper_miercoles = dia_miercoles[1];disp_jorn_miercoles = dia_miercoles[2];
			sel_jorn_miercoles = dia_miercoles[3];sel_oper_miercoles = dia_miercoles[4]; 


			
//JUEVES			
			id_juehrdisp = 'juehrdisp_'+resp[i].OPER_RUT;
			id_juehrocup = 'juehrocup_'+resp[i].OPER_RUT;
			dia_jueves = cargar_oper_dia(jue,jue2,"JUE",id_juehrdisp,id_juehrocup,check,plan_dia_text,disp_oper_jueves,disp_jorn_jueves,sel_jorn_jueves,sel_oper_jueves,clase_tooltip);
													
							   
			dia_jueves = dia_jueves.split('***');

			jueves = dia_jueves[0];
			disp_oper_jueves = dia_jueves[1];disp_jorn_jueves = dia_jueves[2];
																	   
			sel_jorn_jueves = dia_jueves[3];sel_oper_jueves = dia_jueves[4]; 

   
//VIERNES			
			id_viehrdisp = 'viehrdisp_'+resp[i].OPER_RUT;
			id_viehrocup = 'viehrocup_'+resp[i].OPER_RUT;
			dia_viernes = cargar_oper_dia(vie,vie2,"VIE",id_viehrdisp,id_viehrocup,check,plan_dia_text,disp_oper_viernes,disp_jorn_viernes,sel_jorn_viernes,sel_oper_viernes,clase_tooltip);
			dia_viernes = dia_viernes.split('***');
																		 
			viernes = dia_viernes[0];
			disp_oper_viernes = dia_viernes[1];disp_jorn_viernes = dia_viernes[2];
			sel_jorn_viernes = dia_viernes[3];sel_oper_viernes = dia_viernes[4]; 


//SABADO			
			id_sabhrdisp = 'sabhrdisp_'+resp[i].OPER_RUT;
			id_sabhrocup = 'sabhrocup_'+resp[i].OPER_RUT;
			dia_sabado = cargar_oper_dia(sab,sab2,"SAB",id_sabhrdisp,id_sabhrocup,check,plan_dia_text,disp_oper_sabado,disp_jorn_sabado,sel_jorn_sabado,sel_oper_sabado,clase_tooltip);
			dia_sabado = dia_sabado.split('***');
			sabado = dia_sabado[0];
			disp_oper_sabado = dia_sabado[1];disp_jorn_sabado = dia_sabado[2];
			sel_jorn_sabado = dia_sabado[3];sel_oper_sabado = dia_sabado[4]; 			

//LLENADO 2DA LISTA			

		
			$('#lista2_operadores').append(
                '<tr id='+id_row+'>'+
                  '<td class="col-md-1"><input type="checkbox" '+check+' class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
                  '<td class="col-md-4">'+resp[i].OPERARIO+'</td>' +
				  '<td class="col-md-1"">'+lunes+'</td>' +
				  '<td class="col-md-1"">'+martes+'</td>' +
				  '<td class="col-md-1"">'+miercoles+'</td>' +
				  '<td class="col-md-1"">'+jueves+'</td>' +
				  '<td class="col-md-1"">'+viernes+'</td>' +
				  '<td class="col-md-1"">'+sabado+'</td>' +
                '</tr>');				


			if(resp[i].MARCACHECK == 'checked'){
				$("#"+id_row).addClass('negrita');
			}				
				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}

		calcular_jornada();
		//calcular_disponibilidad();

		$('#lista1_disp_operadores').append(
			'<tr id="disp_oper">'+
			  '<td style="text-align:center">'+disp_oper_lunes+'</td>' +
			  '<td style="text-align:center">'+disp_oper_martes+'</td>' +
			  '<td style="text-align:center">'+disp_oper_miercoles+'</td>' +
			  '<td style="text-align:center">'+disp_oper_jueves+'</td>' +
			  '<td style="text-align:center">'+disp_oper_viernes+'</td>' +
			  '<td style="text-align:center">'+disp_oper_sabado+'</td>' +
			'</tr>');		

			
		disp_jorn_lunes = parseFloat(String(disp_jorn_lunes).replace(',','.'));
		if(disp_jorn_lunes > 0){
			disp_jorn_lunes = Math.round(disp_jorn_lunes * 100)/100;
		}			
			
		disp_jorn_martes = parseFloat(String(disp_jorn_martes).replace(',','.'));
		if(disp_jorn_martes){
			disp_jorn_martes = Math.round(disp_jorn_martes*100)/100;
		}	

		disp_jorn_miercoles = parseFloat(String(disp_jorn_miercoles).replace(',','.'));
		if(disp_jorn_miercoles){
			disp_jorn_miercoles = Math.round(disp_jorn_miercoles*100)/100;
		}			
			
		disp_jorn_jueves = parseFloat(String(disp_jorn_jueves).replace(',','.'));
		if(disp_jorn_jueves){
			disp_jorn_jueves = Math.round(disp_jorn_jueves*100)/100;
		}
		
		disp_jorn_viernes = parseFloat(String(disp_jorn_viernes).replace(',','.'));
		if(disp_jorn_viernes){
			disp_jorn_viernes = Math.round(disp_jorn_viernes*100)/100;
		}	
		
		disp_jorn_sabado = parseFloat(String(disp_jorn_sabado).replace(',','.'));
		if(disp_jorn_sabado){
			disp_jorn_sabado = Math.round(disp_jorn_sabado*100)/100;
		}			
			
		$('#lista2_disp_jornada').append(
			'<tr id="disp_jorn">'+
			  '<td style="text-align:center">'+String(disp_jorn_lunes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(disp_jorn_martes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(disp_jorn_miercoles).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(disp_jorn_jueves).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(disp_jorn_viernes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(disp_jorn_sabado).replace('.',',')+'</td>' +
			'</tr>');

//OPERACION ACTUAL

		sel_jorn_lunes = parseFloat(String(sel_jorn_lunes).replace(',','.'));
		if(sel_jorn_lunes){
			sel_jorn_lunes = Math.round(sel_jorn_lunes*100)/100;
		}			
			
		sel_jorn_martes = parseFloat(String(sel_jorn_martes).replace(',','.'));
		if(sel_jorn_martes){
			sel_jorn_martes = Math.round(sel_jorn_martes*100)/100;
		}	

		sel_jorn_miercoles = parseFloat(String(sel_jorn_miercoles).replace(',','.'));
		if(sel_jorn_miercoles){
			sel_jorn_miercoles = Math.round(sel_jorn_miercoles*100)/100;
		}			
			
		sel_jorn_jueves = parseFloat(String(sel_jorn_jueves).replace(',','.'));
		if(sel_jorn_jueves){
			sel_jorn_jueves = Math.round(sel_jorn_jueves*100)/100;
		}
		
		sel_jorn_viernes = parseFloat(String(sel_jorn_viernes).replace(',','.'));
		if(sel_jorn_viernes){
			sel_jorn_viernes = Math.round(sel_jorn_viernes*100)/100;
		}

		sel_jorn_sabado = parseFloat(String(sel_jorn_sabado).replace(',','.'));
		if(sel_jorn_sabado){
			sel_jorn_sabado = Math.round(sel_jorn_sabado*100)/100;
		}

		$('#lista1_selec_jornada').append(
			'<tr id="selec_jorn">'+
			  '<td style="text-align:center">'+String(sel_jorn_lunes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(sel_jorn_martes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(sel_jorn_miercoles).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(sel_jorn_jueves).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(sel_jorn_viernes).replace('.',',')+'</td>' +
			  '<td style="text-align:center">'+String(sel_jorn_sabado).replace('.',',')+'</td>' +
			'</tr>');	

		var meta = $('#plan_meta').val();
		meta = parseFloat(String(meta).replace(',','.'));
		if(meta > 0){	
		
			sel_jorn_lunes = parseFloat(String(sel_jorn_lunes).replace(',','.'));
			if(sel_jorn_lunes > 0){
				sel_prod_lunes = sel_jorn_lunes * meta;
				sel_prod_lunes = Math.round(sel_prod_lunes * 100)/100;
			}
			
			sel_jorn_martes = parseFloat(String(sel_jorn_martes).replace(',','.'));
			if(sel_jorn_martes > 0){
				sel_prod_martes = sel_jorn_martes * meta;
				sel_prod_martes = Math.round(sel_prod_martes * 100)/100;
			}			

			sel_jorn_miercoles = parseFloat(String(sel_jorn_miercoles).replace(',','.'));
			if(sel_jorn_miercoles > 0){
				sel_prod_miercoles = sel_jorn_miercoles * meta;
				sel_prod_miercoles = Math.round(sel_prod_miercoles * 100)/100;
			}
			
			sel_jorn_jueves = parseFloat(String(sel_jorn_jueves).replace(',','.'));
			if(sel_jorn_jueves > 0){
				sel_prod_jueves = sel_jorn_jueves * meta;
				sel_prod_jueves = Math.round(sel_prod_jueves * 100)/100;
			}			
	
			sel_jorn_viernes = parseFloat(String(sel_jorn_viernes).replace(',','.'));
			if(sel_jorn_viernes > 0){
				sel_prod_viernes = sel_jorn_viernes * meta;
				sel_prod_viernes = Math.round(sel_prod_viernes * 100)/100;
			}	

			sel_jorn_sabado = parseFloat(String(sel_jorn_sabado).replace(',','.'));
			if(sel_jorn_sabado > 0){
				sel_prod_sabado = sel_jorn_sabado * meta;
				sel_prod_sabado = Math.round(sel_prod_sabado * 100)/100;
			}			
		}
			
			
		$('#lista2_selec_produccion').append(
			'<tr id="selec_prod">'+
			  '<td style="text-align:center">'+sel_prod_lunes+'</td>' +
			  '<td style="text-align:center">'+sel_prod_martes+'</td>' +
			  '<td style="text-align:center">'+sel_prod_miercoles+'</td>' +
			  '<td style="text-align:center">'+sel_prod_jueves+'</td>' +
			  '<td style="text-align:center">'+sel_prod_viernes+'</td>' +
			  '<td style="text-align:center">'+sel_prod_sabado+'</td>' +
			'</tr>');
			
		$('#lista3_selec_operadores').append(
			'<tr id="selec_oper">'+
			  '<td style="text-align:center">'+sel_oper_lunes+'</td>' +
			  '<td style="text-align:center">'+sel_oper_martes+'</td>' +
			  '<td style="text-align:center">'+sel_oper_miercoles+'</td>' +
			  '<td style="text-align:center">'+sel_oper_jueves+'</td>' +
			  '<td style="text-align:center">'+sel_oper_viernes+'</td>' +
			  '<td style="text-align:center">'+sel_oper_sabado+'</td>' +
			'</tr>');			
			
			
		
	}	


	function clic_operador(e){

		var plan_dia = $.trim($('#plan_dia').val());
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');
		console.log(plan_dia_text)
		rut_oper = e.id;
		if(plan_dia == ''){
			$('#'+rut_oper).prop('checked',false);
			sweet_alert('Error: Ingresar día(s) a planificar');	
			return false;
		}else{	
			
			hora_disponible = $('#hora_activ').val();
		
			if($("#"+rut_oper).is(":checked")) {		
				
				error = 0;
	
				if($.inArray("LUN", plan_dia_text) !== -1 ){	
					disponibilidad = jornada_disponible(rut_oper,'lunhrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'lunhrocup',0,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'lunhrocup',0,hora_disponible,'SUMA');
							}							
						}						
					}								
				}			
				if($.inArray('MAR', plan_dia_text) !== -1 && error == 0){

					disponibilidad = jornada_disponible(rut_oper,'marhrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'marhrocup',1,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'marhrocup',1,hora_disponible,'SUMA');
							}							
						}						
					}
				}
				if($.inArray('MIE', plan_dia_text) !== -1 && error == 0 ){

					disponibilidad = jornada_disponible(rut_oper,'miehrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'miehrocup',2,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'miehrocup',2,hora_disponible,'SUMA');
							}							
						}						
					}					
				}
				if($.inArray('JUE', plan_dia_text) !== -1 && error == 0 ){

					disponibilidad = jornada_disponible(rut_oper,'juehrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'juehrocup',3,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'juehrocup',3,hora_disponible,'SUMA');
							}							
						}						
					}					
				}
				if($.inArray('VIE', plan_dia_text) !== -1 && error == 0 ){

					disponibilidad = jornada_disponible(rut_oper,'viehrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'viehrocup',4,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'viehrocup',4,hora_disponible,'SUMA');
							}							
						}						
					}					
				}
				if($.inArray('SAB', plan_dia_text) !== -1 && error == 0 ){

					disponibilidad = jornada_disponible(rut_oper,'sabhrdisp');					
					if(disponibilidad == 0){
						error = 1;
					}
					else{
						if(hora_disponible == '0'){
							oper_jornada(rut_oper,'sabhrocup',5,disponibilidad,'SUMA');	
						}else{
							
							if(disponibilidad < hora_disponible){
								error = 1;
							}else{
								oper_jornada(rut_oper,'sabhrocup',5,hora_disponible,'SUMA');
							}							
						}						
					}					
				}				
				
				if(error == 1){
					$("#"+rut_oper).prop('checked',false);
					sweet_alert('Error: No existe disponibilidad de jornada en día(s) seleccionado(s)');	
					return false;					
				}
				else{
					$("#row_"+rut_oper).addClass('negrita');
					calcular_produccion();
				}
			}else{

				$("#row_"+rut_oper).removeClass('negrita');
				
				if($.inArray("LUN", plan_dia_text) !== -1 ){
					lunhr_disp = jornada_disponible(rut_oper,'lunhrdisp');					
											
					oper_jornada(rut_oper,'lunhrocup',0,lunhr_disp,'RESTA');
				}
				if($.inArray('MAR', plan_dia_text) !== -1 ){
					marhr_disp = jornada_disponible(rut_oper,'marhrdisp');				
					oper_jornada(rut_oper,'marhrocup',1,marhr_disp,'RESTA');
				}
				if($.inArray('MIE', plan_dia_text) !== -1 ){
					miehr_disp = jornada_disponible(rut_oper,'miehrdisp');				
					oper_jornada(rut_oper,'miehrocup',2,miehr_disp,'RESTA');
				}
				if($.inArray('JUE', plan_dia_text) !== -1 ){
					juehr_disp = jornada_disponible(rut_oper,'juehrdisp');					
					oper_jornada(rut_oper,'juehrocup',3,juehr_disp,'RESTA');
				}
				if($.inArray('VIE', plan_dia_text) !== -1 ){
					viehr_disp = jornada_disponible(rut_oper,'viehrdisp');				
					oper_jornada(rut_oper,'viehrocup',4,viehr_disp,'RESTA');
				}
				if($.inArray('SAB', plan_dia_text) !== -1 ){
					sabhr_disp = jornada_disponible(rut_oper,'sabhrdisp');				
					oper_jornada(rut_oper,'sabhrocup',5,sabhr_disp,'RESTA');
				}				
				calcular_produccion();
			}
		}
	}
	
	function oper_jornada(id,id_ocup,i,disp_sel,oper){

		disp_total = $('#selec_jorn').children('td').eq(i).text();
		disp_total = disp_total.replace(',','.');
		//console.log('disp_total:'+disp_total)
		if(oper == 'SUMA'){
			if(disp_sel > 0) { 
				selec = String(disp_sel).replace(',','.');
				$('#'+id_ocup+'_'+id).html('Selec:'+selec).css('color','green');			
				num_oper_sel = $('#selec_oper').children('td').eq(i).text();
				num_oper_sel = parseInt(num_oper_sel) + 1
				$('#selec_oper').children('td').eq(i).text(num_oper_sel)
				jornada = parseFloat(disp_total) + parseFloat(disp_sel);
				jornada = Math.round(jornada * 100)/100;
				jornada = String(jornada).replace('.',',');
				$('#selec_jorn').children('td').eq(i).text(jornada);				
			}			
		}else{ //RESTA
			selec_jornada = jornada_disponible(id,id_ocup);
			//console.log('selec_jornada:'+selec_jornada)
			$('#'+id_ocup+'_'+id).html('Selec:0').css('color','red');
			if(selec_jornada > 0) { 
				num_oper_sel = $('#selec_oper').children('td').eq(i).text();
				num_oper_sel = parseInt(num_oper_sel) - 1				
				$('#selec_oper').children('td').eq(i).text(num_oper_sel)
				
				//jornada = parseFloat(disp_total) - parseFloat(disp_sel);
				jornada = parseFloat(disp_total) - parseFloat(selec_jornada);
				jornada = Math.round(jornada * 100)/100;
				jornada = String(jornada).replace('.',',');
				$('#selec_jorn').children('td').eq(i).text(jornada);				
			}			
		}
		
		
	}


	
	function limpiar_tabla(){
		$('.check_oper').each( function() {
			if(this.checked) {
				rut_oper = this.id;
				$("#lunhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#marhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#miehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#juehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#viehrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#sabhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#"+rut_oper).prop('checked',false)
				$("#row_"+rut_oper).removeClass('negrita');
			}				
		})

		i = 0;
		while(i < 6){
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
			while( i < 6 ){
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

				sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;sum_jorn_sab = 0;
				deuda_oper_lun = 0;deuda_oper_mar = 0;deuda_oper_mie = 0;deuda_oper_jue = 0;deuda_oper_vie = 0;deuda_oper_sab = 0;
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
						if($.inArray('SAB', plan_dia_text) !== -1 ){
							sabhr_disp = jornada_disponible(this.id,'sabhrdisp')
							if(sabhr_disp > 0 && sabhr_disp >= hora_activ){
								if(hora_activ > 0){
									sabhr_disp = hora_activ
								}															
								sum_jorn_sab = sum_jorn_sab + parseFloat(sabhr_disp);
								sabhr_disp = String(sabhr_disp).replace('.',',');
								$('#sabhrocup_'+this.id).html('Selec:'+sabhr_disp).css('color','green');								 
								chequear = 'S';
							}else{
								chequear = 'N';
								deuda_oper_sab++;
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
					
					if(num_operadores < 0 && deuda_oper_sab > 0){
						sabhr_disp = jornada_disponible(this.id,'sabhrdisp')
						if(sabhr_disp > 0 && sabhr_disp >= hora_activ){
							if(hora_activ > 0){
								sabhr_disp = hora_activ
							}
							sum_jorn_sab = sum_jorn_sab + parseFloat(sabhr_disp);
							sabhr_disp = String(sabhr_disp).replace('.',',');
							$('#sabhrocup_'+this.id).html('Selec:'+sabhr_disp).css('color','green');							
							chequear = 'S';
							deuda_oper_sab--;
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
				if($.inArray('SAB', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_sab * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(5).text(produccion);
					}	
					sum_jorn_sab = String(sum_jorn_sab).replace('.',',');
					$('#selec_jorn').children('td').eq(5).text(sum_jorn_sab);
					$('#selec_oper').children('td').eq(5).text(num_operadores);					
				}

			}
		}
	})

	function validar_oper_disp(cant_oper){
	
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');
		var hora_activ = $('#hora_activ').val();
		
		sum_oper_lun = 0;sum_oper_mar = 0;sum_oper_mie = 0;sum_oper_jue = 0;sum_oper_vie = 0;sum_oper_sab = 0;
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
			if($.inArray('SAB', plan_dia_text) !== -1 ){
				sabhr_disp = jornada_disponible(this.id,'sabhrdisp')
				if(sabhr_disp > 0 && sabhr_disp >= hora_activ){sum_oper_sab++}				
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
		if($.inArray('SAB', plan_dia_text) !== -1 ){
			if(sum_oper_sab < cant_oper)return false;			
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
		
		sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;sum_jorn_sab = 0;
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
			
			if($.inArray('SAB', plan_dia_text) !== -1 ){
				sabhr_disp = jornada_disponible(this.id,'sabhrdisp')
				//sum_jorn_sab = sum_jorn_sab + sabhr_disp			
				if(sabhr_disp > 0 && sabhr_disp >= hora_activ){
					if(hora_activ > 0){
						sabhr_disp = hora_activ
					}
					sum_jorn_sab = sum_jorn_sab + parseFloat(sabhr_disp);
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
		if($.inArray('SAB', plan_dia_text) !== -1 ){
			if(sum_jorn_sab < jornada)return false;			
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

				sum_jorn_lun = 0;sum_jorn_mar = 0;sum_jorn_mie = 0;sum_jorn_jue = 0;sum_jorn_vie = 0;sum_jorn_sab = 0;
				sum_oper_lun = 0;sum_oper_mar = 0;sum_oper_mie = 0;sum_oper_jue = 0;sum_oper_vie = 0;sum_oper_sab = 0;
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
					
	
					if($.inArray('SAB', plan_dia_text) !== -1 ){	
						if(sum_jorn_sab != jornada){
							sabhr_disp = jornada_disponible(this.id,'sabhrdisp')
							sabhr_disp2 = jornada_disponible(this.id,'sabhrdisp')
							if(sabhr_disp > 0 && sabhr_disp >= hora_activ){
								if(hora_activ > 0){
									sabhr_disp = hora_activ
								}
								sum_jorn_sab2 = sum_jorn_sab;
								sum_jorn_sab = sum_jorn_sab + parseFloat(sabhr_disp);
								sum_jorn_sab = Math.round(sum_jorn_sab * 100)/100;
								if(sum_jorn_sab > jornada){
									//sabhr_disp = sum_jorn_sab - jornada;
									sabhr_disp = sabhr_disp - (sum_jorn_sab - jornada);
									sabhr_disp = Math.round(sabhr_disp * 100)/100;
									sum_jorn_sab = jornada;
								}
								
								if(sabhr_disp2 < sabhr_disp){
									sum_jorn_sab = sum_jorn_sab2;
								}else{								
									sum_oper_sab++;
									sabhr_disp = String(sabhr_disp).replace('.',',');
									$('#sabhrocup_'+this.id).html('Selec:'+sabhr_disp).css('color','green');						
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

				if($.inArray('SAB', plan_dia_text) !== -1 ){
					if(meta != '' && meta > 0){
						produccion = sum_jorn_sab * meta;
						produccion = Math.round(produccion * 100)/100;
						produccion = String(produccion).replace('.',',');						
						$('#selec_prod').children('td').eq(5).text(produccion);
					}	
					sum_jorn_sab = String(sum_jorn_sab).replace('.',',');
					$('#selec_jorn').children('td').eq(5).text(sum_jorn_sab);
					$('#selec_oper').children('td').eq(5).text(sum_oper_sab);					
				}

				
			}
		}
	})	
	
	
	
	
	
	
	
	
//BOTONES ABM	
	
	
	
	
	
	function validar_planxsemana(){
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var plan_dia = $.trim($('#plan_dia').val());
		var sup_rut = $.trim($('#sup_rut').val());
		var activ_id = $.trim($('#activ_id').val());
		var plan_prod_esperada = $.trim($('#plan_prod_esperada').val());	
		var meta = $.trim($('#plan_meta').val());
		var h_activ_id = $.trim($('#h_activ_id').val());
		var sactiv_motivo = $.trim($('#sactiv_motivo').val());
		
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
		/*
		if(meta != '' && plan_prod_esperada == ''){
			sweet_alert('Error: Ingresar producción esperada');	
			return false;
		}*/	
		
		if(oper_chequeados == 0){
			sweet_alert('Error: Seleccionar trabajador(es)');	
			return false;
		}		

		if(sactiv_motivo == ''){
			sweet_alert('Error: Ingresar motivo de replanificación');	
			return false;
		}		
		
		return true;
	}
		  
	$('#btn_reg_planxsemana').click(function(){

		if (validar_planxsemana()){	

			$('#loading').show();
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var plan_dia = $.trim($('#plan_dia').val());
			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var sup_rut = $.trim($('#sup_rut').val());
			var activ_id = $.trim($('#activ_id').val());
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];				
			var meta = $.trim($('#plan_meta').val());
			var sactiv_motivo = $.trim($('#sactiv_motivo').val());
			
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
					if($.inArray('SAB', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'sabhrocup');
					}						
					i++;
				}				
			})
			
			var operacion = 'INSERT';			
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							sup_rut:sup_rut,
							activ_id:activ_id,
							sactiv_motivo:sactiv_motivo,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							operacion:operacion
						 }	
			//console.log(parametros)
			
			$.post(
				   "consultas/ges_crud_rplanxsemana.php",
				   parametros,			   
				   function(resp){
						ges_crud_planxsemana(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_planxsemana').click(function(){
		if (validar_planxsemana()){	

			$('#loading').show();

			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
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
			var sactiv_motivo = $.trim($('#sactiv_motivo').val());
			var h_sup_rut = $('#h_sup_rut').val();
			
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
					if($.inArray('SAB', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'sabhrocup');
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
							sactiv_motivo:sactiv_motivo,
							activ_id:activ_id,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							h_activ_id:h_activ_id,
							h_plan_dia:h_plan_dia,
							h_sup_rut:h_sup_rut,
							operacion:operacion
						 }
			//console.log(parametros)
			$.post(
				   "consultas/ges_crud_rplanxsemana.php",
				   parametros,			   
				   function(resp){
						ges_crud_planxsemana(resp)
				   },"json"
			)			
			return false;		
		}
	})		

 	$('#btn_del_planxsemana').click(function(){

		var sactiv_motivo = $.trim($('#sactiv_motivo').val());
		if(sactiv_motivo == ''){
			sweet_alert('Error: Ingresar motivo de eliminación de esta actividad planificada');			
		}else{
	
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
					var h_sup_rut = $('#h_sup_rut').val();
					var per_agno = $.trim($('#per_agno').val());
					var sem_num = $.trim($('#sem_num').val());					
					var operacion = 'DELETE';
					parametros = {	
									h_activ_id:h_activ_id,
									h_plan_dia:h_plan_dia,
									h_sup_rut:h_sup_rut,
									sactiv_motivo:sactiv_motivo,
									per_agno:per_agno,
									sem_num:sem_num,								
									operacion:operacion
								 }		
					$.post(
						   "consultas/ges_crud_rplanxsemana.php",
						   parametros,			   
						   function(resp){
								ges_crud_planxsemana(resp)
						   },"json"
					)
			});	
		}
	})		
	
	function ges_crud_planxsemana(resp){
		//console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			//cancelar();
			
			var operacion = resp['operacion'];			
			if(operacion == 'INSERT'){
				cancelar();
				swal("Sisconvi-Production", "Planificación registrada", "success");
			}else if(operacion == 'UPDATE'){
				cancelar();
				swal("Sisconvi-Production", "Planificación modificada", "success");
			}else if(operacion == 'DELETE'){
				cancelar();
				swal("Sisconvi-Production", "Planificación eliminada", "success");
			}else if(operacion == 'INSERT_ERROR'){
				$('#area_id').change();
				var desc_error = resp['desc'];
				swal("Sisconvi-Production", desc_error, "error");
			}			

			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();
			var fecha_dia = $("#plan_dia option")[0].value;			
			crear_tabla(sem_num,per_agno,fecha_dia);
			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});