$(document).ready(function(){

	$('#sup_rut').select2({	});
	$('#activ_id').select2({ });
	$('#hora_activ').select2({ });
	$('#tj_grupo').select2({ });
	$('#j_grupo').select2({ });
	$('#tipo_jorn').select2({ });
	

	var table;	
	
	function crear_tabla(num_sem, per_agno){
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_supxasignacion.php?data="+num_sem+"&per_agno="+per_agno,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'PLAN_DIA'},
				{ data:'AREA_NOMBRE'},
				{ data:'ACTIV_NOMBRE'},
				{ data:'TIPO_JEFEGRUPO'},
				{ data:'JEFE_GRUPO'},				
				{ data:'ASIGNADOR'},			
				{ data:'FECHA_ULTREG'},				
				{ data:'AREA_ID'},			
				{ data:'RUT_JEFEGRUPO'},
				{ data:'ACTIV_ID'},
				{ data:'RUT_OPERADORES'}
			],			
			
			columnDefs: [
			{ targets: [0,1,2,3,4,5,6,7,8], visible: true},
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

			console.log(obj_row)
			fecha = obj_row.PLAN_DIA;
			fecha = fecha.split('-');
			fecha = fecha[2]+fecha[1]+fecha[0];
			$('#h_plan_dia').val(obj_row.PLAN_DIA);
			$('#h_activ_id').val(obj_row.ACTIV_ID);
			$('#h_rut_jgrupo').val(obj_row.RUT_JEFEGRUPO);

			$('#h_rut_oper').val(obj_row.RUT_OPERADORES);
			
			$('#plan_dia').val(fecha).trigger('change');
			$('#area_id').val(obj_row.AREA_ID).trigger('change');
			$('#tj_grupo').val(obj_row.TIPO_JEFEGRUPO).trigger('change');
			
			$('#btn_reg_supxasignacion').hide();
			$('#btn_upd_supxasignacion').show();
			$('#btn_del_supxasignacion').show();
			$('#btn_can_supxasignacion').show();		
			
		});
	}


	$('#btn_can_supxasignacion').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_supxasignacion')[0].reset();
		
		$('#h_activ_id').val('');
		$('#h_rut_jgrupo').val('');
		$('#h_plan_dia').val('');
		$('#h_rut_oper').val('');
		
		$('#plan_dia').val('').trigger('change');
		$('#hora_activ').val('0').trigger('change');
		$('#area_id').val('');
		$('#area_id').change();
		$('#activ_id').val('');
		$('#activ_id').change();	
		
		$('#tj_grupo').val('');
		$('#tj_grupo').change();
		$('#j_grupo').val('');
		$('#j_grupo').change();	
		
		$('#hora_activ').val('');
		$('#hora_activ').change();
		$('#tipo_jorn').val('');
		$('#tipo_jorn').change();			
		
		$('#btn_reg_supxasignacion').show();
		$('#btn_upd_supxasignacion').hide();
		$('#btn_del_supxasignacion').hide();
		$('#btn_can_supxasignacion').hide();
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
	
	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		
	}
	
	$('#per_agno').change(function() {
	
		change_agno()
		
	});
	
	function change_agno(){
		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		//console.log(parametros)
		clear_combobox('sem_num',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_semanas(resp)
			},"json"
		)		
	}
	

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
		$('#sem_num').val(corresponding_week).trigger('change');
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
			sem_num_extra:sem_num
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
		crear_tabla(sem_num,per_agno);
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
		
		if(area_id == ""){
			clear_combobox('activ_id',1);
		}
		else{		

			parametros = {			
				plan_area_extra:area_id,fecha_dia:fecha_dia
			}			
			
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
		
		oper_en_activ('T');
	})	
	
	
	function oper_en_activ(disp){
		
		$("#lista1_operadores tr").remove();
		$("#lista2_operadores tr").remove();		
		
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
			var change_activ_extra = '';
			var h_plan_dia = $.trim($('#h_plan_dia').val());
			var h_activ_id = $.trim($('#h_activ_id').val());
			var h_activ_split = '';
			var sem_fill = '';
			var per_agno = $.trim($('#per_agno').val());
						
			if(h_activ_id != ""){
				h_activ_split = h_activ_id.split('---');
				h_activ_split = h_activ_split[0]
			}

			if(activ_id != ""){
			
				activ_split = activ_id.split('---');
				
				parametros = {			
					change_activ_extra:change_activ_extra,disp:disp,h_plan_dia:h_plan_dia,h_activ_id:h_activ_split,fecha_dia:fecha_dia,sem_num:sem_num,plan_dia:plan_dia,activ_id:activ_split[0],rut_oper:rut_oper, activ_standar:activ_split[1], per_agno: per_agno
				}
				console.log(parametros)
				$.post(
					"consultas/ges_crud_operadores.php",
					parametros,			   
					function(resp){
						carga_operadores(resp)
					},"json"
				)
			}	
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
		console.log(activ_selected)
		$('#activ_id').val(activ_selected).trigger('change');
	}	
	
	
	
	
	
	
	
	$('#tj_grupo').change(function() {

		var tj_grupo_id = $('#tj_grupo').val();

		
		if(tj_grupo_id == ""){
			clear_combobox('j_grupo',1);
		}
		else{		
			
			clear_combobox('j_grupo',1);
			
			if(tj_grupo_id == 'SUPERVISOR'){
			
				parametros = {			
					load:''
				}			
				
				$.post(
					"consultas/ges_crud_supervisores.php",
					parametros,			   
					function(resp){
						carga_supervisores(resp)
					},"json"
				)
			}else{
				parametros = {			
					oper_combo2:''
				}			
				
				$.post(
					"consultas/ges_crud_operadores.php",
					parametros,			   
					function(resp){
						carga_operadores_combo(resp)
					},"json"
				)			
			}	
		}
					
	});	
	
	
	
	
	function carga_supervisores(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SUP_RUT, text:resp[i].SUPERVISOR});
			}	
		
		$('#j_grupo').select2({			
			data:combobox
		})
	
		sup_selected = $('#h_rut_jgrupo').val();
		$('#j_grupo').val(sup_selected).trigger('change');

		a = $('#j_grupo').val();
		if(a == null){
			$('#j_grupo').val('').trigger('change');
		}
		
	}	
	
	
	
	function carga_operadores_combo(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].OPER_RUT, text:resp[i].OPERARIO});
			}	
		
		$('#j_grupo').select2({			
			data:combobox
		})

		sup_selected = $('#h_rut_jgrupo').val();
		$('#j_grupo').val(sup_selected).trigger('change');

		a = $('#j_grupo').val();
		if(a == null){
			$('#j_grupo').val('').trigger('change');
		}
		
	}	
	
	
/////////////////////	


	function cargar_oper_dia(dia,dia2,buscar_dia,id_diahrdisp,id_diahrocup,check,plan_dia_text,clase_tooltip){

		hr_dia_disp = '0';
		hr_dia_ocup = '0';
		color = 'red';
		dobleactiv_dia = 0;

		if(dia != '0'){				
			dia = dia.split('---');
			area_oper = dia[0];
			activ_oper = dia[1];
			horas_oper = dia[2];
			hr_dia_format = dia[2].replace(',','.');
			tipo_jornada = dia[3];

			if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dia2 == '0'){
				imagen = 'free7.png';
				hr_dia_disp = hr_dia_format;
				hr_dia_ocup = hr_dia_format;						
			}
			else if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dia2 != '0'){
				imagen = 'work9.png';
				area_selec = $('#area_id option:selected').html();
				activ_selec = $('#activ_id option:selected').html();

				dia2 = dia2.split('---');	
				
				if(area_selec == area_oper && activ_selec == activ_oper){
					horas_oper2 = dia[2];
					area_oper =  dia2[0];
					activ_oper = dia2[1];
					horas_oper = dia2[2];
					tipo_jornada = dia2[3];
				}else{
					horas_oper2 = dia2[2];
				}				
				
				hr_dia_format = horas_oper2.replace(',','.');
				hr_dia_disp = horas_oper; //3
				hr_dia_ocup = horas_oper2; //8
				/*
				hr_dia_disp = horas_oper2; //3
				hr_dia_ocup = horas_oper //8				
				*/
				dia2 = '0';
				dobleactiv_dia = 1;
//Tooltip -> Horas: '+horas_oper				
//Hrs:'+hr_dia_disp+'    Selec:'+hr_dia_ocup				
			}				
			else{				
			
				imagen = 'work9.png';				
				hr_dia_disp = hr_dia_format;
				hr_dia_ocup = hr_dia_format;
			}

			if(dia2 != '0'){
				dia2 = dia2.split('---');			
				
				area_oper = dia[0]+','+dia2[0];
				activ_oper = dia[1]+','+dia2[1];
				horas_oper = dia[2]+'+'+dia2[2];				
				tipo_jornada = dia[3]+','+dia2[3];

				hr_dia2_format = dia2[2].replace(',','.');
				
				//hr_dia2_disp = 8.5 - parseFloat(hr_dia2_format);
				hr_dia_total = parseFloat(hr_dia_format) + parseFloat(hr_dia2_format);
				
				hr_dia_disp = hr_dia_total
				hr_dia_ocup = hr_dia_disp;

				imagen = 'work9.png';
										
				
			}
			
			hr_dia_disp = String(hr_dia_disp).replace('.',',');

			if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dobleactiv_dia == 0){
				color = 'green';
				hr_dia_ocup = String(hr_dia_ocup).replace('.',',');									
				dia_return = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Hrs:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';					
				
			}
			else if(check == 'checked' && $.inArray(buscar_dia, plan_dia_text) !== -1 && dobleactiv_dia == 1){

				color = 'green';
				hr_dia_ocup = String(hr_dia_ocup).replace('.',',');			
				dia_return = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span class="'+clase_tooltip+'">Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+'<br>Tipo Jornada: '+tipo_jornada+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Hrs:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:'+hr_dia_ocup+'</p>';					
			}		
			else{
				
				dia_return = '<abbr class="tip"><div style="padding-left:5px"><img src="images/'+imagen+'" width="25" height="25" alt=""></div><span class="'+clase_tooltip+'">Area: '+area_oper+' <br>Actividad: '+activ_oper+'<br>Horas: '+horas_oper+'<br>Tipo Jornada: '+tipo_jornada+' </span></abbr><div class="clearfix"></div><p id='+id_diahrdisp+' style="margin-top:30px; margin-bottom:0px;">Hrs:'+hr_dia_disp+'</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
			}
			
		}else{
			imagen = 'free7.png';
		
			dia_return = '<img style="display: block; margin: 0 auto;" src="images/'+imagen+'" width="25" height="25" alt=""><div class="clearfix" style="margin-bottom: 5px;"></div><p id='+id_diahrdisp+' style="margin-bottom: 0px;">Hrs:0</p><p id='+id_diahrocup+' style="color:'+color+'; margin-bottom: 0px;">Selec:0</p>';
		}
		
		retorno = dia_return;
		
		return retorno;
		
	}
	
	
//////////////////////////////////	
	
	function carga_operadores(resp){
		console.log(resp)	
		var cant_operadores = resp.length;
		var cant_lista1 = Math.round(cant_operadores/2);
		var i = 0;
		var operadores_ocupados = 0;

		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');				
		
		while(i < cant_lista1){
		
			id_row = 'row_'+resp[i].OPER_RUT;			
			lun = resp[i].LUN[0];	mar = resp[i].MAR[0];	mie = resp[i].MIE[0];
			jue = resp[i].JUE[0];	vie = resp[i].VIE[0];	sab = resp[i].SAB[0];	dom = resp[i].DOM[0];

			lun2 = resp[i].LUN[1];	mar2 = resp[i].MAR[1];	mie2 = resp[i].MIE[1];
			jue2 = resp[i].JUE[1];	vie2 = resp[i].VIE[1];	sab2 = resp[i].SAB[1];	dom2 = resp[i].DOM[1];

			check = '';
			if(resp[i].MARCACHECK == 'checked'){
				check = 'checked';
			}			
			
			clase_tooltip = '';

//LUNES			
			id_lunhrdisp = 'lunhrdisp_'+resp[i].OPER_RUT;
			id_lunhrocup = 'lunhrocup_'+resp[i].OPER_RUT;			
			dia_lunes = cargar_oper_dia(lun,lun2,"LUN",id_lunhrdisp,id_lunhrocup,check,plan_dia_text,clase_tooltip);
			dia_lunes = dia_lunes.split('***');
			lunes = dia_lunes[0];
		
//MARTES			
			id_marhrdisp = 'marhrdisp_'+resp[i].OPER_RUT;
			id_marhrocup = 'marhrocup_'+resp[i].OPER_RUT;			
			dia_martes = cargar_oper_dia(mar,mar2,"MAR",id_marhrdisp,id_marhrocup,check,plan_dia_text,clase_tooltip);
			dia_martes = dia_martes.split('***');
			martes = dia_martes[0];


//MIERCOLES			

			id_miehrdisp = 'miehrdisp_'+resp[i].OPER_RUT;
			id_miehrocup = 'miehrocup_'+resp[i].OPER_RUT;
			dia_miercoles = cargar_oper_dia(mie,mie2,"MIE",id_miehrdisp,id_miehrocup,check,plan_dia_text,clase_tooltip);
			dia_miercoles = dia_miercoles.split('***');
			miercoles = dia_miercoles[0];

			
//JUEVES			
			id_juehrdisp = 'juehrdisp_'+resp[i].OPER_RUT;
			id_juehrocup = 'juehrocup_'+resp[i].OPER_RUT;
			dia_jueves = cargar_oper_dia(jue,jue2,"JUE",id_juehrdisp,id_juehrocup,check,plan_dia_text,clase_tooltip);
			dia_jueves = dia_jueves.split('***');
			jueves = dia_jueves[0];

			
//VIERNES			
			id_viehrdisp = 'viehrdisp_'+resp[i].OPER_RUT;
			id_viehrocup = 'viehrocup_'+resp[i].OPER_RUT;
			dia_viernes = cargar_oper_dia(vie,vie2,"VIE",id_viehrdisp,id_viehrocup,check,plan_dia_text,clase_tooltip);
			dia_viernes = dia_viernes.split('***');
			viernes = dia_viernes[0];

			
//SABADO			
			id_sabhrdisp = 'sabhrdisp_'+resp[i].OPER_RUT;
			id_sabhrocup = 'sabhrocup_'+resp[i].OPER_RUT;
			dia_sabado = cargar_oper_dia(sab,sab2,"SAB",id_sabhrdisp,id_sabhrocup,check,plan_dia_text,clase_tooltip);
			dia_sabado = dia_sabado.split('***');
			sabado = dia_sabado[0];
		

//DOMINGO			
			id_domhrdisp = 'domhrdisp_'+resp[i].OPER_RUT;
			id_domhrocup = 'domhrocup_'+resp[i].OPER_RUT;
			dia_domingo = cargar_oper_dia(dom,dom2,"DOM",id_domhrdisp,id_domhrocup,check,plan_dia_text,clase_tooltip);
			dia_domingo = dia_domingo.split('***');
			domingo = dia_domingo[0];


//LLENADO 1ERA LISTA			
			$('#lista1_operadores').append(
			'<tr id='+id_row+'>'+
			  '<td class="col-md-1"><input type="checkbox" '+check+' class="check_oper" id='+resp[i].OPER_RUT+' /></td>' +
			  '<td class="col-md-4">'+resp[i].OPERARIO+'</td>' +
			  '<td class="col-md-1"">'+lunes+'</td>' +
			  '<td class="col-md-1"">'+martes+'</td>' +
			  '<td class="col-md-1"">'+miercoles+'</td>' +
			  '<td class="col-md-1"">'+jueves+'</td>' +
			  '<td class="col-md-1"">'+viernes+'</td>' +
			  '<td class="col-md-1"">'+sabado+'</td>' +
			  '<td class="col-md-1"">'+domingo+'</td>' +
			'</tr>');				
/*
			if(resp[i].MARCACHECK == 'checked'){
				$("#"+id_row).addClass('negrita');
			}				
*/				
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
			dom = resp[i].DOM[0];

			lun2 = resp[i].LUN[1];
			mar2 = resp[i].MAR[1];
			mie2 = resp[i].MIE[1];
			jue2 = resp[i].JUE[1];
			vie2 = resp[i].VIE[1];
			sab2 = resp[i].SAB[1];
			dom2 = resp[i].DOM[1];

			check = '';
			if(resp[i].MARCACHECK == 'checked'){
				check = 'checked';
			}			
			
			clase_tooltip = 'tip_izq';
//LUNES			
			id_lunhrdisp = 'lunhrdisp_'+resp[i].OPER_RUT;
			id_lunhrocup = 'lunhrocup_'+resp[i].OPER_RUT;			
			dia_lunes = cargar_oper_dia(lun,lun2,"LUN",id_lunhrdisp,id_lunhrocup,check,plan_dia_text,clase_tooltip);
			dia_lunes = dia_lunes.split('***');
			lunes = dia_lunes[0];

		
//MARTES			
			id_marhrdisp = 'marhrdisp_'+resp[i].OPER_RUT;
			id_marhrocup = 'marhrocup_'+resp[i].OPER_RUT;			
			dia_martes = cargar_oper_dia(mar,mar2,"MAR",id_marhrdisp,id_marhrocup,check,plan_dia_text,clase_tooltip);
			dia_martes = dia_martes.split('***');
			martes = dia_martes[0];


//MIERCOLES			

			id_miehrdisp = 'miehrdisp_'+resp[i].OPER_RUT;
			id_miehrocup = 'miehrocup_'+resp[i].OPER_RUT;
			dia_miercoles = cargar_oper_dia(mie,mie2,"MIE",id_miehrdisp,id_miehrocup,check,plan_dia_text,clase_tooltip);
			dia_miercoles = dia_miercoles.split('***');
			miercoles = dia_miercoles[0];

			
//JUEVES			
			id_juehrdisp = 'juehrdisp_'+resp[i].OPER_RUT;
			id_juehrocup = 'juehrocup_'+resp[i].OPER_RUT;
			dia_jueves = cargar_oper_dia(jue,jue2,"JUE",id_juehrdisp,id_juehrocup,check,plan_dia_text,clase_tooltip);
			dia_jueves = dia_jueves.split('***');
			jueves = dia_jueves[0];

			
//VIERNES			
			id_viehrdisp = 'viehrdisp_'+resp[i].OPER_RUT;
			id_viehrocup = 'viehrocup_'+resp[i].OPER_RUT;
			dia_viernes = cargar_oper_dia(vie,vie2,"VIE",id_viehrdisp,id_viehrocup,check,plan_dia_text,clase_tooltip);
			dia_viernes = dia_viernes.split('***');
			viernes = dia_viernes[0];


//SABADO			
			id_sabhrdisp = 'sabhrdisp_'+resp[i].OPER_RUT;
			id_sabhrocup = 'sabhrocup_'+resp[i].OPER_RUT;
			dia_sabado = cargar_oper_dia(sab,sab2,"SAB",id_sabhrdisp,id_sabhrocup,check,plan_dia_text,clase_tooltip);
			dia_sabado = dia_sabado.split('***');
			sabado = dia_sabado[0];
	
			
//DOMINGO			
			id_domhrdisp = 'domhrdisp_'+resp[i].OPER_RUT;
			id_domhrocup = 'domhrocup_'+resp[i].OPER_RUT;
			dia_domingo = cargar_oper_dia(dom,dom2,"DOM",id_domhrdisp,id_domhrocup,check,plan_dia_text,clase_tooltip);
			dia_domingo = dia_domingo.split('***');
			domingo = dia_domingo[0];
			
			

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
				  '<td class="col-md-1"">'+domingo+'</td>' +
                '</tr>');				

/*
			if(resp[i].MARCACHECK == 'checked'){
				$("#"+id_row).addClass('negrita');
			}				
*/				
			//EVENTOS	
			$('#'+resp[i].OPER_RUT).bind('click',function(e){ clic_operador(this); });

			i++;
		}
	}	


	function clic_operador(e){

		var plan_dia = $.trim($('#plan_dia').val());
		var plan_dia_text = $('#plan_dia option:selected').text();
		plan_dia_text = plan_dia_text.split(' ');
		console.log(plan_dia_text)
		rut_oper = e.id;
		hora_disponible = $('#hora_activ').val();
		
		if($("#"+rut_oper).is(":checked")) {	
		
			if(plan_dia == ''){
				$('#'+rut_oper).prop('checked',false);
				sweet_alert('Error: Ingresar día(s) a planificar');	
				return false;
			}
			else if(hora_disponible == ''){
				$('#'+rut_oper).prop('checked',false);
				sweet_alert('Error: Seleccione Jornada');	
				return false;
			}		
			else{						
				error = 0;
				if($.inArray("LUN", plan_dia_text) !== -1 ){
					disponibilidad = jornada_disponible(rut_oper,'lunhrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}			
				if($.inArray('MAR', plan_dia_text) !== -1 ){
				
					disponibilidad = jornada_disponible(rut_oper,'marhrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}
				if($.inArray('MIE', plan_dia_text) !== -1 ){
				
					disponibilidad = jornada_disponible(rut_oper,'miehrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}
				if($.inArray('JUE', plan_dia_text) !== -1 ){
					disponibilidad = jornada_disponible(rut_oper,'juehrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}
				if($.inArray('VIE', plan_dia_text) !== -1 ){
					disponibilidad = jornada_disponible(rut_oper,'viehrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}
				if($.inArray('SAB', plan_dia_text) !== -1 ){
					disponibilidad = jornada_disponible(rut_oper,'sabhrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}				
				if($.inArray('DOM', plan_dia_text) !== -1 ){
					disponibilidad = jornada_disponible(rut_oper,'domhrdisp');
					if($('#btn_reg_supxasignacion').is(':visible') && disponibilidad > 0){
						error = 1;
					}
				}	
				
				if(error == 1){
					$("#"+rut_oper).prop('checked',false);
					sweet_alert('Error: Restricción, operador ya tiene una actividad para, al menos, un día seleccionado');	
					return false;					
				}else{
				
					if($.inArray("LUN", plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'lunhrocup',0,hora_disponible,'SUMA');

					}			
					if($.inArray('MAR', plan_dia_text) !== -1 ){
			
							oper_jornada(rut_oper,'marhrocup',1,hora_disponible,'SUMA');

					}
					if($.inArray('MIE', plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'miehrocup',2,hora_disponible,'SUMA');
						
					}
					if($.inArray('JUE', plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'juehrocup',3,hora_disponible,'SUMA');
						
					}
					if($.inArray('VIE', plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'viehrocup',4,hora_disponible,'SUMA');	
						
					}
					if($.inArray('SAB', plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'sabhrocup',5,hora_disponible,'SUMA');
						
					}				
					if($.inArray('DOM', plan_dia_text) !== -1 ){
				
							oper_jornada(rut_oper,'domhrocup',6,hora_disponible,'SUMA');	
						
					}				
				
				}				
				
				
			}
			//$("#row_"+rut_oper).addClass('negrita');

			
		}
		else{

			//$("#row_"+rut_oper).removeClass('negrita');
			
			if($.inArray("LUN", plan_dia_text) !== -1 ){
				$('#lunhrocup_'+rut_oper).html('Selec:0').css('color','red');
			}
			if($.inArray('MAR', plan_dia_text) !== -1 ){
				$('#marhrocup_'+rut_oper).html('Selec:0').css('color','red');
			}
			if($.inArray('MIE', plan_dia_text) !== -1 ){
				$('#miehrocup_'+rut_oper).html('Selec:0').css('color','red');
			}
			if($.inArray('JUE', plan_dia_text) !== -1 ){
				$('#juehrocup_'+rut_oper).html('Selec:0').css('color','red');
			}
			if($.inArray('VIE', plan_dia_text) !== -1 ){
				$('#viehrocup_'+rut_oper).html('Selec:0').css('color','red');
			}
			if($.inArray('SAB', plan_dia_text) !== -1 ){
				$('#sabhrocup_'+rut_oper).html('Selec:0').css('color','red');
			}				
			if($.inArray('DOM', plan_dia_text) !== -1 ){
				$('#domhrocup_'+rut_oper).html('Selec:0').css('color','red');
			}	
		}
		
	}
	
	function oper_jornada(id,id_ocup,i,disp_sel,oper){
		if(oper == 'SUMA'){
			if(disp_sel > 0) { 
				selec = String(disp_sel).replace(',','.');
				$('#'+id_ocup+'_'+id).html('Selec:'+selec).css('color','green');							
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
				$("#domhrocup_"+rut_oper).html('Selec:0').css('color','red');
				$("#"+rut_oper).prop('checked',false)
				$("#row_"+rut_oper).removeClass('negrita');
			}				
		})
	}
	
	
		
	$('#plan_dia').change(function() {	
		limpiar_tabla();
	})

	
	
	function jornada_disponible(id,id_disp){
		disponibilidad = $('#'+id_disp+'_'+id).html();
		disponibilidad = disponibilidad.split(':');
		disponibilidad = disponibilidad[1];							
		disponibilidad = String(disponibilidad).replace(',','.');
		return disponibilidad;
	}
	
	
	
	
	
	
//BOTONES ABM	
	
	
	
	
	
	function validar_supxasignacion(){
		
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var plan_dia = $.trim($('#plan_dia').val());
		var activ_id = $.trim($('#activ_id').val());

		var h_activ_id = $.trim($('#h_activ_id').val());
		var tj_grupo = $('#tj_grupo').val();
		var j_grupo = $('#j_grupo').val();
		var tipo_jorn = $('#tipo_jorn').val();

		
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
		
		if(tipo_jorn == ''){
			sweet_alert('Error: Ingresar Tipo Jornada');	
			return false;
		}		
		
		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad');	
			return false;
		}
				
		if(tj_grupo == ''){
			sweet_alert('Error: Seleccionar Tipo Jefe de Grupo');	
			return false;
		}		
		
		if(j_grupo == ''){
			sweet_alert('Error: Seleccionar Jefe de Grupo');	
			return false;
		}		
		
		if(oper_chequeados == 0){
			sweet_alert('Error: Seleccionar trabajador(es)');	
			return false;
		}		
		
		return true;
	}
		  
	$('#btn_reg_supxasignacion').click(function(){

		if (validar_supxasignacion()){	

			$('#loading').show();
			
			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var plan_dia = $.trim($('#plan_dia').val());

			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var activ_id = $.trim($('#activ_id').val());
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];				

			var tj_grupo = $('#tj_grupo').val();
			var j_grupo = $('#j_grupo').val();			
			var tipo_jorn = $('#tipo_jorn').val();
			
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
						j++;
					}						
					if($.inArray('SAB', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'sabhrocup');
						j++;
					}		
					if($.inArray('DOM', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'domhrocup');
						j++;
					}	

					i++;
				}				
			})

			var operacion = 'INSERT';			
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							activ_id:activ_id,
							tipo_jorn:tipo_jorn,
							tj_grupo:tj_grupo,
							j_grupo:j_grupo,
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							operacion:operacion
						 }	
			console.log(parametros)

			$.post(
				   "consultas/ges_crud_supxasignacion.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxasignacion(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_supxasignacion').click(function(){
		if (validar_supxasignacion()){	

			$('#loading').show();

			var per_agno = $.trim($('#per_agno').val());
			var sem_num = $.trim($('#sem_num').val());		
			var plan_dia = $.trim($('#plan_dia').val());
			var plan_dia_text = $('#plan_dia option:selected').text();
			plan_dia_text = plan_dia_text.split(' ');

			var activ_id = $.trim($('#activ_id').val());
			activ_split = activ_id.split('---');			
			activ_id = activ_split[0];
			
			var h_activ_id = $.trim($('#h_activ_id').val());
			h_activ_split = h_activ_id.split('---');			
			h_activ_id = h_activ_split[0];			
			var h_plan_dia = $.trim($('#h_plan_dia').val());
			
			var tj_grupo = $('#tj_grupo').val();
			var j_grupo = $('#j_grupo').val();	
			var tipo_jorn = $('#tipo_jorn').val();	
			
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
						//j++;
					}
					if($.inArray('MAR', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'marhrocup');
						//j++;						
					}
					if($.inArray('MIE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'miehrocup');
						//j++;						
					}
					if($.inArray('JUE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'juehrocup');
						//j++;						
					}
					if($.inArray('VIE', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'viehrocup');
					}						
					if($.inArray('SAB', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'sabhrocup');
					}	
					if($.inArray('DOM', plan_dia_text) !== -1 ){
						hr_chequeados[j][i] = jornada_disponible(this.id,'domhrocup');
					}	
					j++;
					i++;
				}				
			})			
			
			var operacion = 'UPDATE';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,
							plan_dia:plan_dia,
							activ_id:activ_id,
							tipo_jorn:tipo_jorn,
							tj_grupo:tj_grupo,
							j_grupo:j_grupo,							
							oper_chequeados:oper_chequeados,
							hr_chequeados:hr_chequeados,
							h_activ_id:h_activ_id,
							h_plan_dia:h_plan_dia,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_supxasignacion.php",
				   parametros,			   
				   function(resp){
						ges_crud_supxasignacion(resp)
				   },"json"
			)			
			return false;		
		}
	})		

 	$('#btn_del_supxasignacion').click(function(){

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
					   "consultas/ges_crud_supxasignacion.php",
					   parametros,			   
					   function(resp){
							ges_crud_supxasignacion(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_supxasignacion(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			
			//cancelar();
			
			var operacion = resp['operacion'];			
			if(operacion == 'INSERT'){
				//cancelar();
				oper_en_activ('T');
				swal("Sisconvi-Production", "Actividad extra registrada", "success");
			}else if(operacion == 'UPDATE'){
				cancelar();
				swal("Sisconvi-Production", "Actividad extra modificada", "success");
			}else if(operacion == 'DELETE'){
				cancelar();
				swal("Sisconvi-Production", "Actividad extra eliminada", "success");
			}else if(operacion == 'INSERT_ERROR'){
				$('#area_id').change();
				var desc_error = resp['desc'];
				swal("Sisconvi-Production", desc_error, "error");
			}			

			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			
			var sem_num = $('#sem_num').val();
			var per_agno = $('#per_agno').val();			
			crear_tabla(sem_num,per_agno);
			

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});