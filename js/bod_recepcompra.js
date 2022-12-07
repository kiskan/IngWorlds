$(document).ready(function(){


	$("#btn_reg_cot").click(function(event){

		if (validar_cotizacion()){

			if(window.FormData){
				
				$('#operacion').val('REGISTRAR COTIZACION');
				var sprodd_id = $('#h_sprodd_id').val();
				$('#sprodd_id').val(sprodd_id);
				var seleccionado = 'N'
				if($("#cotcom_provsel").is(":checked")) {
					seleccionado = 'S'
				}	
				$('#provsel').val(seleccionado);

				var form_Data = new FormData($("#form_cotiz")[0]);

				$.ajax({
					url: "/proyecto/sisconvi-production/consultas/bod_crud_solcompra.php",
					type: 'POST',
					data: form_Data,
					dataType: 'json',
					async: false,
					cache: false,
					contentType: false,
					processData: false,		
					success: function (returndata) {
						ges_crud_cotizacion(returndata);					
					}
				});	
			}					
		}
	})
	
	
 	$('#btn_upd_cot').click(function(){
		if (validar_cotizacion()){	

			if(window.FormData){
				
				$('#operacion').val('MODIFICAR COTIZACION');
				var cot_id = $('#h_cotcom_id').val();
				$('#h_cot_id').val(cot_id);				
				var sprodd_id = $('#h_sprodd_id').val();
				$('#sprodd_id').val(sprodd_id);
				var seleccionado = 'N'
				if($("#cotcom_provsel").is(":checked")) {
					seleccionado = 'S'
				}	
				$('#provsel').val(seleccionado);

				var form_Data = new FormData($("#form_cotiz")[0]);

				$.ajax({
					url: "/proyecto/sisconvi-production/consultas/bod_crud_solcompra.php",
					type: 'POST',
					data: form_Data,
					dataType: 'json',
					async: false,
					cache: false,
					contentType: false,
					processData: false,		
					success: function (returndata) {
						ges_crud_cotizacion(returndata);					
					}
				});	
			}
		}
	})		
	



	$('#cotcom_precio,#cotcom_cantidad').focusout(function() {
		var tipo_compra = $('#h_sprod_tipocompra').val();
		console.log('cotizacion -> '+tipo_compra)
		if(tipo_compra == 'COMPRA MATERIAL'){
	
			precio = $('#cotcom_precio').val();
			cant = $('#cotcom_cantidad').val();
			if(precio != '' && cant != '' ){
				total = precio * cant;
				$('#cotcom_total').val(total);
			}
		}	
		
	})
	
	$('#com_precio,#com_cantidad').focusout(function() {
		var tipo_compra = $('#h_sprod_tipocompra').val();
		console.log(tipo_compra)
		if(tipo_compra == 'COMPRA MATERIAL'){
	
			precio = $('#com_precio').val();
			cant = $('#com_cantidad').val();
			if(precio != '' && cant != '' ){
				total = precio * cant;
				//$('#com_total').val(total);
				$('#com_acordado').val(total);
			}
		}
		
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
	
			precio = $('#com_precio').val();
			cant = $('#com_cantidad').val();
			com_avance = $('#com_avance').val();
			//console.log(precio + '-' + cant + '-' +  com_avance)
			//if(precio != '' && cant != '' && com_avance != '' ){
			if(precio != '' && com_avance != '' ){
				//total = (precio * cant * com_avance)/100;
				total = (precio * com_avance)/100;
				total = Math.round(total);
				$('#com_acordado').val(total);
			}
			else if(com_avance == ''){
				$('#com_acordado').val(0);
			}			
		}			
		
	})	
	
	$('#com_avance').change(function() {
		precio = $('#com_precio').val();
		cant = $('#com_cantidad').val();
		com_avance = $('#com_avance').val();
		tipo_compra = $('#h_sprod_tipocompra').val();
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){	
			console.log(precio + '-' + cant + '-' +  com_avance)
			if(precio != ''/* && cant != ''*/&& com_avance != '' ){
				//total = (precio * cant * com_avance)/100;
				total = (precio * com_avance)/100;
				total = Math.round(total);
				$('#com_acordado').val(total);
			}
			else if(com_avance == ''){
				$('#com_acordado').val(0);
			}
		}
	});	
	
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('sprodd_servicio');
	mayuscula('sprod_comencotiz');
	mayuscula('cotcom_proveedor');
	mayuscula('com_proveedor');
	mayuscula('psprod_comencompra');
	//mayuscula('com_codigosap');
	

	$("#sprod_tipocompra").select2({
		allowClear: true
	});	
	
	$("#sprod_prioridad").select2({
		allowClear: true
	});
	
	$("#sprod_tipomant").select2({
		allowClear: true
	});		
	
	$("#psprod_tipocompra").select2({
		allowClear: true
	});	
	
	$("#psprod_prioridad").select2({
		allowClear: true
	});
	
	$("#psprod_tipomant").select2({
		allowClear: true
	});	

	$("#tsprod_tipocompra").select2({
		allowClear: true
	});	
	
	$("#tsprod_prioridad").select2({
		allowClear: true
	});
	
	$("#tsprod_tipomant").select2({
		allowClear: true
	});	
	
	$('#asprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	$('#psprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});			
	
	$('#tsprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#cotcom_precio').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		

	$('#cotcom_cantidad').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#cotcom_acordado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	
	$('#com_precio').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		

	$('#com_cantidad').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#com_acordado').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		
	
	$('#com_hes').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});			
	
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

	
////////////TABLA SOLICITUDES/////////////////	
	
	var tabla_solicitudes;
	crear_tabla();
	function crear_tabla(){

		tabla_solicitudes = $("#tabla_solicitudes").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_solcompra.php?cotiz=pendientes",
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'SPROD_COMENCOTIZ'},
				{ data:'UNDVIV_ID'}
			],	
			
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true},
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
				"sSortAscending":  ": supar para ordenar la columna de manera ascendente",
				"sSortDescending": ": supar para ordenar la columna de manera descendente"
			  }
			}
		});
	
  
		$('#tabla_solicitudes tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			cancelar();
			var obj_row = tabla_solicitudes.row(this).data();	
			$('#sprod_id').val(obj_row.SPROD_ID);	
			$('#usr_solic').val(obj_row.SOLICITANTE);			
			$('#UNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#sprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#sprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#sprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#sprod_motivo').val(obj_row.SPROD_MOTIVO);
			$('#sprod_comencotiz').val(obj_row.SPROD_COMENCOTIZ);
			
			$('#h_sprod_id').val(obj_row.SPROD_ID);
			
			carga_productos(obj_row.SPROD_ID);
		});
	}
	

	function carga_productos(sprod_id){
		console.log(sprod_id)
		$('#productos_solicitados').empty();
		
		tipo_compra = $('#sprod_tipocompra').val();
		
		parametros = {	
			cotizacion:'',
			tipo_compra:tipo_compra,
			sprod_id:sprod_id
		}		
		console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				crear_tabla_productos(resp)
			},"json"
			)		
	}
	

	
	function crear_tabla_productos(resp){
		console.log(resp)
		$('#productos_solicitados').empty();
		total_cotiz = 0;
		tipo_compra = $('#sprod_tipocompra').val();
		console.log(tipo_compra)
		if(tipo_compra == 'COMPRA MATERIAL'){
		//sd.SPRODD_ID, p.PROD_COD, p.PROD_NOMBRE, sd.SPRODD_CANT, sd.CC_ID, c.COTCOM_PROVEEDOR, c.COTCOM_ACORDADO
			i = 0;
			
			while(i < resp.length){
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				prov = 'prov_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].PROD_NOMBRE;
				elim = 'elim_'+resp[i].SPRODD_ID;
				cot = 'cotc_'+resp[i].SPRODD_ID;
				sap = 'sapc_'+resp[i].SPRODD_ID;
				cot_check = (resp[i].CHECK_COT == 1)?'checked':'';
				sap_check = (resp[i].CHECK_SAP == 1)?'checked':'';

				$('#productos_solicitados').append(
					'<tr>'+
						'<td style="text-align:center"><input type="checkbox" id='+cot+' class="cot_seleccion" '+cot_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+sap+' class="sap_seleccion" '+sap_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+elim+' class="elim_seleccion"/></td>' +
						'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center"><select class="select2_single form-control cot_cuenta_contable" tabindex="-1" id='+cc+'><option value=""></option></select></td>' +
						'<td id='+prov+' data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="PENDIENTE" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });
				$('#'+cot).bind('click',function(e){ clic_fecha_fin_cotizacion(this); });
				$('#'+sap).bind('click',function(e){ clic_fecha_solic_sap(this); });				
				carga_cc(cc)									
				$('#'+cc).val(resp[i].CC_ID).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
	
				i++;
			}
		}
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
		//SELECT  sd.SPRODD_ID, sd.SPRODD_SERVICIO, sd.SPRODD_CANT, sd.CC_ID
			i = 0;
			while(i < resp.length){
			
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				prov = 'prov_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].SPRODD_SERVICIO;
				elim = 'elim_'+resp[i].SPRODD_ID;
				cot = 'cotc_'+resp[i].SPRODD_ID;
				sap = 'sapc_'+resp[i].SPRODD_ID;
				cot_check = (resp[i].CHECK_COT == 1)?'checked':'';
				sap_check = (resp[i].CHECK_SAP == 1)?'checked':'';
				
				$('#productos_solicitados').append(
					'<tr>'+
						'<td style="text-align:center"><input type="checkbox" id='+cot+' class="cot_seleccion" '+cot_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+sap+' class="sap_seleccion" '+sap_check+' /></td>' +					
						'<td style="text-align:center"><input type="checkbox" id='+elim+' class="elim_seleccion"/></td>' +
						'<td id='+prod+'>'+resp[i].SPRODD_SERVICIO+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center"><select class="select2_single form-control cot_cuenta_contable" tabindex="-1" id='+cc+'><option value=""></option></select></td>' +
						'<td id='+prov+' data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="PENDIENTE" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });	
				$('#'+cot).bind('click',function(e){ clic_fecha_fin_cotizacion(this); });
				$('#'+sap).bind('click',function(e){ clic_fecha_solic_sap(this); });
				carga_cc(cc)									
				$('#'+cc).val(resp[i].CC_ID).trigger('change');
				
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
	
				i++;
			}
		}
		
		$('#sprod_total').val(total_cotiz)
		
	}
	
	function clic_fecha_fin_cotizacion(e){
		$('#cloading').show();
		id_cot = e.id	
		sprodd_id1 = id_cot.split('_')
		sprodd_id = sprodd_id1[1]		
		
		var operacion = 'BORRAR FECHA FIN COTIZ';
		if($('#'+id_cot).is(":checked")){
			var operacion = 'REGISTRAR FECHA FIN COTIZ';			
		}	
		parametros = {	
			operacion:operacion,
			sprodd_id:sprodd_id
		}		
		//console.log(parametros)
		$.post(
			"consultas/bod_crud_solcompra.php",
			parametros,			   
			function(resp){
				actualizar_fecha_solic_sap_o_fin_cotizacion(resp)
			},"json"
		)	
	}	
	
	
	function clic_fecha_solic_sap(e){
		$('#cloading').show();
		id_sap = e.id	
		sprodd_id1 = id_sap.split('_')
		sprodd_id = sprodd_id1[1]		
		
		var operacion = 'BORRAR FECHA SOLIC SAP';
		if($('#'+id_sap).is(":checked")){
			var operacion = 'REGISTRAR FECHA SOLIC SAP';			
		}	
		parametros = {	
			operacion:operacion,
			sprodd_id:sprodd_id
		}		
		//console.log(parametros)
		$.post(
			"consultas/bod_crud_solcompra.php",
			parametros,			   
			function(resp){
				actualizar_fecha_solic_sap_o_fin_cotizacion(resp)
			},"json"
		)			
	}	

	function actualizar_fecha_solic_sap_o_fin_cotizacion(resp){
		$('#cloading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)

		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			
			if(operacion == 'REGISTRAR FECHA FIN COTIZ'){
				swal("sisconvi-production", "Fecha Fin Cotización Registrada", "success");
			}else if(operacion == 'BORRAR FECHA FIN COTIZ'){
				swal("sisconvi-production", "Fecha Fin Cotización Borrada", "success");
			}else if(operacion == 'REGISTRAR FECHA SOLIC SAP'){
				swal("sisconvi-production", "Fecha Solicitud SAP registrada", "success");
			}else if(operacion == 'BORRAR FECHA SOLIC SAP'){
				swal("sisconvi-production", "Fecha Solicitud SAP Borrada", "success");
			}			
		}else{
			
			if (typeof resp['sprodd_id'] !== 'undefined') {
				var sprodd_id = resp['sprodd_id'];
				if (typeof resp['cot'] !== 'undefined') {
					$('#cotc_'+sprodd_id).prop('checked',false);
				}
				else if (typeof resp['sap'] !== 'undefined') {
					$('#sapc_'+sprodd_id).prop('checked',false);
				}
				else if (typeof resp['cotysap'] !== 'undefined') {
					$('#cotc_'+sprodd_id).prop('checked',true);
				}				
			}
			var desc_error = resp['desc'];			 
			swal("sisconvi-production", desc_error, "error");			
		}		
	}




	
	
	//LOAD CUENTAS CONTABLES

	function carga_cc(id){
		var combobox = [];
		for(var i  = 0 ; i < data_cc.length; i++) {
			combobox.push({id:data_cc[i].cc_id, text:data_cc[i].cc_nombre});
		}	
		
		$('#'+id).select2({			
			data:combobox
		});			
		
	}		
	

//WModal_Cotizacion
	
	$("#WModal_Cotizacion").on('show.bs.modal', function(event){
	/*
		$('#cotcom_proveedor').val('');
		$('#cotcom_precio').val('');
		$('#cotcom_cantidad').val('');
		$('#cotcom_total').val('');
		$('#cotcom_provsel').prop('checked',false);
	*/	
		cancelar_cotiz();
	
		var identificador = $(event.relatedTarget);		
		var sprodd_id = identificador.data('sprodd_id');
		var tipo_compra = identificador.data('tipocompra');
		var prod = 'Cotización: '+identificador.data('prodserv');
		var cotcom = identificador.data('cotcom');
		
		if(cotcom == 'PENDIENTE' || cotcom == 'ENPROCESO'){
			$('#cot_form3').show();
			$('#cot_form2').show();
			$('#cot_form').show();
			$('#bcot1').show();$('#bcot2').show();$('#bcot3').show();
		}
		
		if(cotcom == 'FIN'){
			$('#cot_form3').hide();
			$('#cot_form2').hide();
			$('#cot_form').hide();
			$('#bcot1').hide();$('#bcot2').hide();$('#bcot3').hide();
		}		
		
		$('#title_cotizacion').html(prod)
		
		var cant = 'Cantidad Solicitada: '+identificador.data('cant');
		$('#title_cotcant').html(cant)			
		
		if(tipo_compra == 'COMPRA MATERIAL'){ $('#cot_total').show();$('#cot_cant_plazo').html('Cantidad');} else { $('#cot_total').hide(); $('#cot_cant_plazo').html('Plazo');}

		$('#h_sprodd_id').val(sprodd_id);
		$('#h_sprod_tipocompra').val(tipo_compra);
		$('#h_pestagna').val(cotcom);
		//console.log('cotcom:'+cotcom)
		
		//if(cotcom == 'COT'){		
			if(typeof tabla_cotizacion != 'undefined') tabla_cotizacion.destroy()
			crear_tabla_cotizacion();/*
		}
		
		if(cotcom == 'COM'){		
			if(typeof tabla_compra != 'undefined') tabla_compra.destroy()
			crear_tabla_compra();
			}		*/
		
    });
	
	
	var tabla_cotizacion;
	
	function crear_tabla_cotizacion(){

		var sprodd_id = $('#h_sprodd_id').val();	
		var tipo_compra = $('#h_sprod_tipocompra').val();
		var cotcom_tipo = 'COTIZACION';
		//console.log(sprodd_id)
		tabla_cotizacion = $("#datatable-cotizaciones").DataTable({
			
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
				{ targets: [1,3,4,5,6], visible: true},
				{ targets: '_all', visible: false }			
			], 
			ajax: "consultas/bod_crud_solcompra.php?sprodd_id="+sprodd_id+"&cotcom_tipo="+cotcom_tipo+"&tipo_compra="+tipo_compra,	
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'COTCOM_ID'},
				{ data:'COTCOM_PROVSEL'},
				{ data:'COTCOM_PROVEEDOR_ACORTADO'},	
				{ data:'COTCOM_PROVEEDOR'},						
				{ data:'COTCOM_PRECIO'},
				{ data:'COTCOM_CANTIDAD'},
				{ data:'COTCOM_TOTAL'},
				{ data:'COTCOM_ACORDADO'},
				{ data:'COTCOM_ARCHIVO1'},
				{ data:'COTCOM_ARCHIVO2'},
				{ data:'COTCOM_ARCHIVO3'}
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
	  
		$('#datatable-cotizaciones tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_cotizacion.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			cancelar_cotiz();
			
			var obj_row = tabla_cotizacion.row(this).data();
			console.log(obj_row)

			$('#h_cotcom_id').val(obj_row.COTCOM_ID);
			$('#cotcom_proveedor').val(obj_row.COTCOM_PROVEEDOR);
			$('#cotcom_precio').val(obj_row.COTCOM_PRECIO);
			$('#cotcom_cantidad').val(obj_row.COTCOM_CANTIDAD);
			$('#cotcom_total').val(obj_row.COTCOM_TOTAL);
			/*$('#cotcom_acordado').val(obj_row.COTCOM_ACORDADO);*/
			
			$("#cotcom_provsel").prop("checked", false);
			if(obj_row.COTCOM_PROVSEL == 'S')
				$("#cotcom_provsel").prop("checked", true);
			
			COTCOM_ARCHIVO1 = obj_row.COTCOM_ARCHIVO1;
			COTCOM_ARCHIVO2 = obj_row.COTCOM_ARCHIVO2;
			COTCOM_ARCHIVO3 = obj_row.COTCOM_ARCHIVO3;
//cotiz1			
			visibilidad_files(COTCOM_ARCHIVO1,COTCOM_ARCHIVO2,COTCOM_ARCHIVO3)

			$('#btn_reg_cot').hide();
			$('#btn_upd_cot').show();
			$('#btn_del_cot').show();
			$('#btn_can_cot').show();		
			
		});
	}	

//VISIBILIDAD FILES
//COTIZx UPLOAD
//COTx ARCHIVO
//FILEx ARCHIVO BASE DE DATOS
	function visibilidad_files(file1,file2,file3){
		console.log('file1:'+file1);console.log('file2:'+file2);console.log('file3:'+file3);
		var url = './cotizaciones/';
		var url1 = url + file1;var url2 = url + file2;var url3 = url + file3;
		
		if(file1 == '' && file2 == '' && file3 == ''){
			$('#cotiz1').show();$('#cotiz2').show();$('#cotiz3').show();
			$('#cot1').hide();$('#cot2').hide();$('#cot3').hide();
			$('#acot1').prop('href','');$('#acot2').prop('href','');$('#acot3').prop('href','');
		}
		
		else if(file1 == '' && file2 != '' && file3 != ''){
			$('#cotiz1').show();$('#cotiz2').hide();$('#cotiz3').hide();
			$('#cot1').hide();$('#cot2').show();$('#cot3').show();
			
			//file1 = file2; file2 = file3; 
			//url1 = url + file1;var url2 = url + file2;
			$('#acot1').prop('href','');$('#acot2').prop('href',url2);$('#acot3').prop('href',url3);			
			
			$('#bcot2').bind('click',function(e){ clic_dropfile(file2,2); });
			$('#bcot3').bind('click',function(e){ clic_dropfile(file3,3); });
		}
		
		else if(file1 != '' && file2 == '' && file3 != ''){
			$('#cotiz1').hide();$('#cotiz2').show();$('#cotiz3').hide();
			$('#cot1').show();$('#cot2').hide();$('#cot3').show();
			
			//file2 = file3; 
			//url1 = url + file1;var url2 = url + file2;
			$('#acot1').prop('href',url1);$('#acot2').prop('href','');$('#acot3').prop('href',url3);
						
			$('#bcot1').bind('click',function(e){ clic_dropfile(file1,1); });
			$('#bcot3').bind('click',function(e){ clic_dropfile(file3,3); });			
		}		
		
		else if(file1 != '' && file2 != '' && file3 == ''){
			$('#cotiz1').hide();$('#cotiz2').hide();$('#cotiz3').show();
			$('#cot1').show();$('#cot2').show();$('#cot3').hide();
			
			//file1 = file3;
			//url1 = url + file1;var url2 = url + file2;
			$('#acot1').prop('href',url1);$('#acot2').prop('href',url2);$('#acot3').prop('href','');
						
			$('#bcot1').bind('click',function(e){ clic_dropfile(file1,1); });
			$('#bcot2').bind('click',function(e){ clic_dropfile(file2,2); });			
		}		

		else if(file1 == '' && file2 == '' && file3 != ''){
			$('#cotiz1').show();$('#cotiz2').show();$('#cotiz3').hide();
			$('#cot1').hide();$('#cot2').hide();$('#cot3').show();

			//file1 = file3;
			//url1 = url + file1;
			$('#acot1').prop('href','');$('#acot2').prop('href','');$('#acot3').prop('href',url3);
			
			$('#bcot3').bind('click',function(e){ clic_dropfile(file3,3); });	
		}
		
		else if(file1 != '' && file2 == '' && file3 == ''){
			$('#cotiz1').hide();$('#cotiz2').show();$('#cotiz3').show();
			$('#cot1').show();$('#cot2').hide();$('#cot3').hide();
			
			$('#acot1').prop('href',url1);$('#acot2').prop('href','');$('#acot3').prop('href','');
			$('#bcot1').bind('click',function(e){ clic_dropfile(file1,1); });	
			
		}	
		
		else if(file1 == '' && file2 != '' && file3 == ''){
			$('#cotiz1').show();$('#cotiz2').hide();$('#cotiz3').show();
			$('#cot1').hide();$('#cot2').show();$('#cot3').hide();
			
			//file1 = file2;
			//url1 = url + file1;
			$('#acot1').prop('href','');$('#acot2').prop('href',url2);$('#acot3').prop('href','');
			
			$('#bcot2').bind('click',function(e){ clic_dropfile(file2,2); });	
		}	

		else if(file1 != '' && file2 != '' && file3 != ''){
			$('#cotiz1').hide();$('#cotiz2').hide();$('#cotiz3').hide();
			$('#cot1').show();$('#cot2').show();$('#cot3').show();
			$('#acot1').prop('href',url1);$('#acot2').prop('href',url2);$('#acot3').prop('href',url3);
			$('#bcot1').bind('click',function(e){ clic_dropfile(file1,1); });
			$('#bcot2').bind('click',function(e){ clic_dropfile(file2,2); });	
			$('#bcot3').bind('click',function(e){ clic_dropfile(file3,3); });				
		}
	
	}

//ELIMINACION ARCHIVO COTIZ
	function clic_dropfile(archivo,num){

		swal({   
			title: "¿Seguro que deseas eliminar este documento de cotización?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#h_num').val(num);
				var cotcom_id = $('#h_cotcom_id').val();
				var operacion = 'ELIMINACION ARCHIVO COTIZ';	
				parametros = {	
					operacion:operacion,
					cotcom_id:cotcom_id,
					archivo:archivo
				}		
				console.log(parametros)
				$.post(
					"consultas/bod_crud_solcompra.php",
					parametros,			   
					function(resp){
						//update_pendiente(resp)
						ges_crud_cotizacion(resp)
					},"json"
				)							
				
		});	

	}
	
	
//CUENTA CONTALE	
	$('#btn_reg_ctacble').click(function(){
		
		var num_filas = $("#productos_solicitados tr").length;
		
		if(num_filas == 0){
			sweet_alert('Error: Seleccione una solicitud');
			return 1;
		}
		
		validacion_cc = 0;
		i = 0;
		var cc_sprodd_id = {};
		var cc_id = {};
		$('.cot_cuenta_contable').each( function() {
			id_cc = this.id	
			sprodd_id1 = id_cc.split('_')
			sprodd_id = sprodd_id1[1]
			//console.log(id_cc)	
			//console.log(sprodd_id)	
			
			cc = $('#'+id_cc).val();
			console.log('cc:'+cc)
			cc_sprodd_id[i] = sprodd_id;
			cc_id[i] = cc;
			
			if(cc == '') validacion_cc = 1;
			
			i++;
		})	
		
		if(validacion_cc){
			sweet_alert('Error: Hay cuentas contables sin asignar');
		}else{
		
			var operacion = 'UPDATE CC';			
			parametros = {			
							cc_sprodd_id:cc_sprodd_id,
							cc_id:cc_id,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						update_pendiente(resp)
				   },"json"
			)			
		
		}		
	})
	
	
	
//ELIMINAR SELECCION PENDIENTE	
	$('#btn_reg_elimselpend').click(function(){
		
		var num_filas = $("#productos_solicitados tr").length;
		
		if(num_filas == 0){
			sweet_alert('Error: Seleccione una solicitud');
			return 1;
		}		
		
		validacion = 0;
		i = 0; j = 0;
		var elim_sprodd_id = {};

		$('.elim_seleccion').each( function() {
			id_elim = this.id	
			sprodd_id1 = id_elim.split('_')
			sprodd_id = sprodd_id1[1]
			

			if($('#'+id_elim).is(":checked")){
				validacion = 1;
				elim_sprodd_id[j] = sprodd_id;
				j++;				
			}		
			
			i++;
		})	
		
		if(validacion == 0){
			sweet_alert('Error: No ha seleccionado un material/servicio que eliminar');
		}else{
			
			if(i==j){
				swal({   
					title: "¿Seguro que deseas eliminar la Solicitud completa?",   
					text: "No podrás deshacer este paso...",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						var operacion = 'ELIM SOL_MATERIALoSERVICIO_ALL';	
						sprod_id = $('#h_sprod_id').val();
						parametros = {	
							operacion:operacion,
							sprod_id:sprod_id
						}		
						console.log(parametros)
						$.post(
							"consultas/bod_crud_solcompra.php",
							parametros,			   
							function(resp){
								update_pendiente(resp)
							},"json"
						)							
						
				});				
			}
			else{
				swal({   
					title: "¿Seguro que deseas eliminar lo seleccionado y sus cotizaciones asociadas?",   
					text: "No podrás deshacer este paso...",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						var operacion = 'ELIM SOL_MATERIALoSERVICIO';	
						parametros = {	
							operacion:operacion,
							sprodd_id:elim_sprodd_id
						}		
						console.log(parametros)
						$.post(
							"consultas/bod_crud_solcompra.php",
							parametros,			   
							function(resp){
								update_pendiente(resp)
							},"json"
						)							
						
				});				
			}
		}		
	})	
	
	
	
	
	
	
	
//COMENTARIO COTIZACION	
	$('#btn_reg_comencotiz').click(function(){

		var sprod_comencotiz = $.trim($('#sprod_comencotiz').val());
		var sprod_id = $.trim($('#sprod_id').val());
		if(sprod_comencotiz == ''){
			sweet_alert('Error: Ingresar comentario');
		}else{
		
			var operacion = 'COMENTARIO COTIZACION';			
			parametros = {			
							sprod_comencotiz:sprod_comencotiz,
							sprod_id:sprod_id,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						update_pendiente(resp)
				   },"json"
			)			
		
		}
		
	})	
	
//TERMINAR COTIZACION	
	$('#btn_fin_cotizacion').click(function(){
	
	
		swal({   
			title: "¿Seguro que deseas terminar el Proceso de Cotización?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   

				var sprod_id = $.trim($('#sprod_id').val());
				var operacion = 'COTIZACION TERMINADA';			
				parametros = {			
								sprod_id:sprod_id,
								operacion:operacion
							 }	
				console.log(parametros)
				
				$.post(
					   "consultas/bod_crud_solcompra.php",
					   parametros,			   
					   function(resp){
							update_pendiente(resp)
					   },"json"
				)						
			}			
		);	
	})	
	
	function update_pendiente(resp){
		$('#cloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			
			if(operacion == 'UPDATE CC'){
				swal("sisconvi-production", "Cuenta Contable registrada", "success");
			}else if(operacion == 'COMENTARIO COTIZACION'){
				swal("sisconvi-production", "Comentario registrado", "success");
				$('#tabla_solicitudes tbody').unbind( "click" );
				tabla_solicitudes.destroy();			
				crear_tabla();
			}else if(operacion == 'COTIZACION TERMINADA'){
				swal("sisconvi-production", "Compra En Proceso", "success");
				cancelar();
				//$("#productos_solicitados tr").remove();
				$('#tabla_solicitudes tbody').unbind( "click" );
				tabla_solicitudes.destroy();			
				crear_tabla();					
			}else if(operacion == 'ELIM SOL_MATERIALoSERVICIO_ALL'){
				swal("sisconvi-production", "Solicitud Eliminada", "success");
				cancelar();
				$('#tabla_solicitudes tbody').unbind( "click" );
				tabla_solicitudes.destroy();			
				crear_tabla();					
			}
			else if(operacion == 'ELIM SOL_MATERIALoSERVICIO'){
				swal("sisconvi-production", "Selección Eliminada", "success");
				//cancelar();
				$('#productos_solicitados').empty();
				sprod_id = $('#h_sprod_id').val();
				console.log(sprod_id)
				carga_productos(sprod_id);				
			}			

		}else{
			var desc_error = resp['desc'];
			swal("sisconvi-production", desc_error, "error");
		}
	}	
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	function validar_cotizacion(){

		var cotcom_proveedor = $.trim($('#cotcom_proveedor').val());
		var cotcom_precio = $.trim($('#cotcom_precio').val());
		var cotcom_cantidad = $.trim($('#cotcom_cantidad').val());
		//var cotcom_acordado = $.trim($('#cotcom_acordado').val());
		
		if(cotcom_proveedor == ''){
			sweet_alert('Error: Ingresar proveedor');	
			return false;
		}
		
		if(cotcom_precio == ''){
			sweet_alert('Error: Ingresar precio');	
			return false;
		}		

		if(cotcom_cantidad == ''){
			sweet_alert('Error: Ingresar cantidad');
			return false;
		}
		/*
		if(cotcom_acordado == ''){
			sweet_alert('Error: Ingresar total acordado');	
			return false;
		}		
		*/
		return true;
	}	

/*	
	$('#btn_reg_cot').click(function(){

		if (validar_cotizacion()){	

			$('#cloading').show();
			var sprodd_id = $('#h_sprodd_id').val();
			var cotcom_proveedor = $.trim($('#cotcom_proveedor').val());
			var cotcom_precio = $.trim($('#cotcom_precio').val());
			var cotcom_cantidad = $.trim($('#cotcom_cantidad').val());
			//var cotcom_acordado = $.trim($('#cotcom_acordado').val());	
			var cotcom_provsel = ($('#cotcom_provsel').is(":checked")) ? 'S' : 'N';			
			
			var operacion = 'REGISTRAR COTIZACION';
			parametros = {		
							sprodd_id:sprodd_id,
							cotcom_proveedor:cotcom_proveedor,
							cotcom_precio:cotcom_precio,
							cotcom_cantidad:cotcom_cantidad,
							//cotcom_acordado:cotcom_acordado,
							cotcom_provsel:cotcom_provsel,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						ges_crud_cotizacion(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_cot').click(function(){
		if (validar_cotizacion()){	

			$('#cloading').show();
			var cotcom_id = $('#h_cotcom_id').val();
			var sprodd_id = $('#h_sprodd_id').val();
			var cotcom_proveedor = $.trim($('#cotcom_proveedor').val());
			var cotcom_precio = $.trim($('#cotcom_precio').val());
			var cotcom_cantidad = $.trim($('#cotcom_cantidad').val());		
			var cotcom_provsel = ($('#cotcom_provsel').is(":checked")) ? 'S' : 'N';			
			
			var operacion = 'MODIFICAR COTIZACION';
			parametros = {	
							cotcom_id:cotcom_id,
							sprodd_id:sprodd_id,
							cotcom_proveedor:cotcom_proveedor,
							cotcom_precio:cotcom_precio,
							cotcom_cantidad:cotcom_cantidad,
							cotcom_provsel:cotcom_provsel,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						ges_crud_cotizacion(resp)
				   },"json"
			)
		}
	})		
*/
 	$('#btn_del_cot').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta cotización?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#cloading').show();

				var cotcom_id = $('#h_cotcom_id').val();
				var operacion = 'ELIMINAR COTIZACION';
				parametros = {	
								cotcom_id:cotcom_id,
								operacion:operacion
							 }		
				console.log(parametros)			 
				$.post(
					   "consultas/bod_crud_solcompra.php",
					   parametros,			   
					   function(resp){
							ges_crud_cotizacion(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_cotizacion(resp){
		$('#cloading').hide();
		var cod_resp = resp['cod'];
		console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar_cotiz();
			
			if(operacion == 'REGISTRAR COTIZACION'){
				swal("sisconvi-production", "Cotización registrada", "success");
			}else if(operacion == 'MODIFICAR COTIZACION'){
				swal("sisconvi-production", "Cotización modificada", "success");
			}else if(operacion == 'ELIMINAR COTIZACION'){
				swal("sisconvi-production", "Cotización eliminada", "success");
			}
			
			else if(operacion == 'ELIMINACION ARCHIVO COTIZ'){
				swal("sisconvi-production", "Documento cotización eliminado", "success");
				num_file = $('#h_num').val();
				id_cot = 'cot'+num_file;
				$('#'+id_cot).hide();
				id_cotiz = 'cotiz'+num_file;
				console.log('id_cotiz:'+id_cotiz)
				$('#'+id_cotiz).show();
				$('#h_num').val('');
			}			
			
			
			/*else if(operacion == 'COMENTARIO COTIZACION'){
				swal("sisconvi-production", "Comentario registrado", "success");
			}	*/	
			$('#datatable-cotizaciones tbody').unbind( "click" );
			tabla_cotizacion.destroy();
			crear_tabla_cotizacion();
			/*
			var activ_id = $.trim($('#h_activ_id').val());	
			var plan_dia = $('#h_sactiv_dia').val();		
			
			call_Operadores_Table(activ_id,plan_dia,'FINALIZADO');	*/	
			//sprod_id = $('#sprod_id').val();
			sprod_id = $('#h_sprod_id').val();
			pestagna = $('#h_pestagna').val();			
			//console.log('pestagna:'+pestagna)
			
			if(pestagna == 'PENDIENTE')	carga_productos(sprod_id)
			if(pestagna == 'ENPROCESO')	carga_productos_enproceso(sprod_id)

		}else{
			var desc_error = resp['desc'];
			swal("sisconvi-production", desc_error, "error");
		}
	}		

	$('#btn_can_cot').click(function(){
		cancelar_cotiz();
	})	
	
	function cancelar_cotiz(){
		//$('#form_plantamadre')[0].reset();

		$('#btn_reg_cot').show();
		$('#btn_upd_cot').hide();
		$('#btn_del_cot').hide();
		$('#btn_can_cot').hide();

		//tabla_cotizacion.$('tr.selected').removeClass('selected');

		$('#h_cotcom_id').val('');
		$('#cotcom_proveedor').val('')
		$('#cotcom_precio').val('');
		$('#cotcom_cantidad').val('');
		$('#cotcom_total').val('');
		$('#cotcom_acordado').val('');
		$("#cotcom_provsel").prop("checked", false);
		$('#h_num').val('');		
		
		$('#reset_file1').click();
		$('#reset_file2').click();
		$('#reset_file3').click();
		
		visibilidad_files('','','');
		
	}		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
	
	
	
	
	
	
	
	
	
	


	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});
		
		$('#pper_agno').select2({			
			data:combobox
		});		
		
		$('#tper_agno').select2({			
			data:combobox
		});	
			
		
		$('#per_agno').val(corresponding_agno).trigger('change');
		$('#pper_agno').val(corresponding_agno).trigger('change');
		$('#tper_agno').val(corresponding_agno).trigger('change');

	}
	
	$('#per_agno').change(function() { 	change_agno()	});
	$('#pper_agno').change(function() { pchange_agno()	});
	$('#tper_agno').change(function() { tchange_agno()	});
	
	function change_agno(){
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
	}

	function pchange_agno(){
		var per_agno = $('#pper_agno').val();
		
		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('psem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				pcarga_semanas(resp)
			},"json"
		)		
	}	
	
	function tchange_agno(){
		var per_agno = $('#tper_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('tsem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				tcarga_semanas(resp)
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
		
		//cancelar();
		change_sem_num();
	}
	
	function pcarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#psem_num').select2({			
			data:combobox
		})

		pchange_sem_num();
	}	
	
	function tcarga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#tsem_num').select2({			
			data:combobox
		})

		tchange_sem_num();
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

		$('#psem_num').select2({			
			data:combobox
		});
		
		$('#tsem_num').select2({			
			data:combobox
		});			

		$('#sem_num').val(corresponding_week).trigger('change');
		$('#psem_num').val(corresponding_week).trigger('change');
		$('#tsem_num').val(corresponding_week).trigger('change');

		change_sem_num();	
		pchange_sem_num();
		tchange_sem_num();
	}
	
	
	$('#sem_num').change(function() {
		change_sem_num();
	});
	
	$('#psem_num').change(function() {
		pchange_sem_num();
	});	
	
	$('#tsem_num').change(function() {
		tchange_sem_num();
	});	
		
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('sprod_dia',0);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}
	
	function pchange_sem_num(){
		var per_agno = $('#pper_agno').val();
		var sem_num = $('#psem_num').val();

		if(sem_num == ""){
			clear_combobox('psprod_dia',1);
		}
		else{			
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('psprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					pcarga_dias(resp)
				},"json"
			)
		}
	}	
	
	function tchange_sem_num(){
		var per_agno = $('#tper_agno').val();
		var sem_num = $('#tsem_num').val();
		if(sem_num == ""){
			clear_combobox('tsprod_dia',1);
		}
		else{
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			clear_combobox('tsprod_dia',1);
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					tcarga_dias(resp)
				},"json"
			)
		}
	}			
	
	
	
	function carga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#sprod_dia').select2({			
			data:combobox
		});	

		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();

		if(sem_num == corresponding_week && year_current == per_agno){
			$('#sprod_dia').val(date_current).trigger('change');
		}		

	}
	
	function pcarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#psprod_dia').select2({			
			data:combobox
		});	

	}	
	
	function tcarga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#tsprod_dia').select2({			
			data:combobox
		});	

	}	
		
		
	
	//LOAD UNIDADES
	carga_unidades();
	function carga_unidades(){
	//console.log(data_viveros)
		var combobox = [];
		for(var i  = 0 ; i < data_viveros.length; i++) {
			combobox.push({id:data_viveros[i].undviv_id, text:data_viveros[i].undviv_nombre});
		}	
		
		$('#UNDVIV_ID').select2({			
			data:combobox
		});			
		
		$('#pUNDVIV_ID').select2({			
			data:combobox
		});			

		$('#tUNDVIV_ID').select2({			
			data:combobox
		});				
		
	}		


	//LOAD SOLICITANTES
	carga_solicitantes();
	function carga_solicitantes(){
		var combobox = [];
		for(var i  = 0 ; i < data_solicitantes.length; i++) {
			combobox.push({id:data_solicitantes[i].USR_ID, text:data_solicitantes[i].USR_NOMBRE});
		}			

		$('#pusr_solic').select2({			
			data:combobox
		});		
		
		$('#tusr_solic').select2({			
			data:combobox
		});	
		
	}	
	

//CANCELAR	
	function cancelar(){
		
		$('#sprod_id').val('');
		$('#usr_solic').val('');
		
		$('#UNDVIV_ID').val('').trigger('change');
		$('#sprod_tipocompra').val('').trigger('change');
		$('#sprod_prioridad').val('').trigger('change');
		$('#sprod_tipomant').val('').trigger('change');
		
		$('#sprod_motivo').val('');
		$('#sprod_comencotiz').val('');
		$('#sprod_total').val('');
		
		$('#productos_solicitados').empty();
				
	}
	

	
	
	
	
//TAB SOLICITUDES EN PROCESO Y TERMINADO


	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		
		if(target == "#tab1primary"){ 
			$('#tabla_solicitudes tbody').unbind( "click" );
			tabla_solicitudes.destroy();				
			crear_tabla();			
		}
		if(target == "#tab2primary"){ 
			fix_select_enproceso();
			limpieza_enproceso_full();
			busqueda_solic_enproceso();
		}
		if(target == "#tab3primary"){ 
			fix_select_terminados();
			limpieza_terminados_full();
			busqueda_solic_terminados();
		}
		
	});	
	
	
	fix_select_enproceso();
	function fix_select_enproceso(){
	
		$('#pusr_solic').select2({});
		$('#pper_agno').select2({});
		$('#psem_num').select2({});
		$('#psprod_dia').select2({});
		$('#pUNDVIV_ID').select2({});
		$('#psprod_tipocompra').select2({});
		$('#psprod_prioridad').select2({});
		$('#psprod_tipomant').select2({});
	}
	
	
	fix_select_terminados();
	function fix_select_terminados(){
	
		$('#tusr_solic').select2({});
		$('#tper_agno').select2({});
		$('#tsem_num').select2({});
		$('#tsprod_dia').select2({});
		$('#tUNDVIV_ID').select2({});
		$('#tsprod_tipocompra').select2({});
		$('#tsprod_prioridad').select2({});
		$('#tsprod_tipomant').select2({});
	}	

	$('#btn_cons_enproceso').click(function(){
		busqueda_solic_enproceso();
	})	

	$('#btn_cons_terminados').click(function(){
		busqueda_solic_terminados();
	})	
		
	function busqueda_solic_enproceso(){
		$('#ploading').show();
		limpieza_enproceso();
		var sprod_id = $.trim($('#psprod_id').val());
		var solicitante = $.trim($('#pusr_solic').val());
		var per_agno = $.trim($('#pper_agno').val());
		var sem_num = $.trim($('#psem_num').val());		
		var sprod_dia = $.trim($('#psprod_dia').val());		
		var UNDVIV_ID = $.trim($('#pUNDVIV_ID').val());
		var psprod_tipocompra = $.trim($('#psprod_tipocompra').val());
		var psprod_prioridad = $.trim($('#psprod_prioridad').val());
		var psprod_tipomant = $.trim($('#psprod_tipomant').val());

		if(typeof tabla_solicitudes_enproceso != 'undefined') tabla_solicitudes_enproceso.destroy();
		crear_tabla_enproceso( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, psprod_tipocompra, psprod_prioridad, psprod_tipomant)			
	}
	
	function busqueda_solic_enproceso_sinlimpieza(){
		$('#ploading').show();
		//limpieza_enproceso();
		var sprod_id = $.trim($('#psprod_id').val());
		var solicitante = $.trim($('#pusr_solic').val());
		var per_agno = $.trim($('#pper_agno').val());
		var sem_num = $.trim($('#psem_num').val());		
		var sprod_dia = $.trim($('#psprod_dia').val());		
		var UNDVIV_ID = $.trim($('#pUNDVIV_ID').val());
		var psprod_tipocompra = $.trim($('#psprod_tipocompra').val());
		var psprod_prioridad = $.trim($('#psprod_prioridad').val());
		var psprod_tipomant = $.trim($('#psprod_tipomant').val());

		if(typeof tabla_solicitudes_enproceso != 'undefined') tabla_solicitudes_enproceso.destroy();
		crear_tabla_enproceso( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, psprod_tipocompra, psprod_prioridad, psprod_tipomant)			
	}	
	
	
	function busqueda_solic_terminados(){
		$('#tloading').show();
		limpieza_terminados();
		var sprod_id = $.trim($('#tsprod_id').val());
		var solicitante = $.trim($('#tusr_solic').val());
		var per_agno = $.trim($('#tper_agno').val());
		var sem_num = $.trim($('#tsem_num').val());		
		var sprod_dia = $.trim($('#tsprod_dia').val());		
		var UNDVIV_ID = $.trim($('#tUNDVIV_ID').val());
		var tsprod_tipocompra = $.trim($('#tsprod_tipocompra').val());
		var tsprod_prioridad = $.trim($('#tsprod_prioridad').val());
		var tsprod_tipomant = $.trim($('#tsprod_tipomant').val());
		//var tsprod_codigosap = $.trim($('#tsprod_codigosap').val());
		//console.log('tsprod_codigosap:'+tsprod_codigosap)
		if(typeof tabla_solicitudes_terminados != 'undefined') tabla_solicitudes_terminados.destroy();
		crear_tabla_terminados( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, tsprod_tipocompra, tsprod_prioridad, tsprod_tipomant/*, tsprod_codigosap*/)	
	}
	

	
	
	var tabla_solicitudes_enproceso;	
	function crear_tabla_enproceso( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, psprod_tipocompra, psprod_prioridad, psprod_tipomant){

		tabla_solicitudes_enproceso = $("#tabla_solicitudes_enproceso").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solcompra.php?enproceso=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&psprod_tipocompra="+psprod_tipocompra+"&psprod_prioridad="+psprod_prioridad+"&psprod_tipomant="+psprod_tipomant,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'SPROD_COMENCOTIZ'},
				/*{ data:'SPROD_CODIGOSAP'},*/
				{ data:'SPROD_COMENCOMPRA'},
				{ data:'UNDVIV_ID'},
				{ data:'USR_ID_SOLIC'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true },
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
			},

			fnInitComplete: function(oSettings, json) {
			  $('#ploading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_enproceso tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_enproceso.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			limpieza_enproceso();
			var obj_row = tabla_solicitudes_enproceso.row(this).data();	
			
			$('#psprod_id').val(obj_row.SPROD_ID);	
			$('#pusr_solic').val(obj_row.USR_ID_SOLIC).trigger('change');			
			$('#pUNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#psprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#psprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#psprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#psprod_motivo').val(obj_row.SPROD_MOTIVO);
			$('#psprod_comencotiz').val(obj_row.SPROD_COMENCOTIZ);			
			//$('#com_codigosap').val(obj_row.SPROD_CODIGOSAP);
			$('#psprod_comencompra').val(obj_row.SPROD_COMENCOMPRA);
			
			$('#h_psprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA)
			$('#h_sprod_id').val(obj_row.SPROD_ID);
			
			carga_productos_enproceso(obj_row.SPROD_ID);
		});
	}	
	
//////


	
	var tabla_solicitudes_terminados;	
	function crear_tabla_terminados( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, tsprod_tipocompra, tsprod_prioridad, tsprod_tipomant/*, tsprod_codigosap*/){
		//console.log('tsprod_codigosap:'+tsprod_codigosap)
		tabla_solicitudes_terminados = $("#tabla_solicitudes_terminados").DataTable({
	
			//responsive: true,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			scroller:       true,
			bProcessing: 	true,			
			order:[],
			ajax: "consultas/cons_solcompra.php?terminados=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&tsprod_tipocompra="+tsprod_tipocompra+"&tsprod_prioridad="+tsprod_prioridad+"&tsprod_tipomant="+tsprod_tipomant/*+"&tsprod_codigosap="+tsprod_codigosap*/,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				{ data:'UNDVIV_NOMBRE'},						
				{ data:'SPROD_TIPOCOMPRA'},
				{ data:'SPROD_PRIORIDAD'},
				{ data:'SPROD_TIPOMANT'},
				{ data:'SPROD_MOTIVO'},
				{ data:'SPROD_COMENCOTIZ'},
				/*{ data:'SPROD_CODIGOSAP'},*/
				{ data:'SPROD_COMENCOMPRA'},
				{ data:'UNDVIV_ID'},
				{ data:'USR_ID_SOLIC'}
			],	
		
			columnDefs: [
				{ targets: [1,2,3,4,5,6,7,8], visible: true },
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
			},

			fnInitComplete: function(oSettings, json) {
			  $('#tloading').hide();
			}
		});
	
  
		$('#tabla_solicitudes_terminados tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_solicitudes_terminados.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			limpieza_terminados();
			//$('#tloading').show();
			var obj_row = tabla_solicitudes_terminados.row(this).data();
			console.log(obj_row.USR_ID_SOLIC)
			$('#tsprod_id').val(obj_row.SPROD_ID);	
			$('#tusr_solic').val(obj_row.USR_ID_SOLIC).trigger('change');			
			$('#tUNDVIV_ID').val(obj_row.UNDVIV_ID).trigger('change');
			$('#tsprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA).trigger('change');
			$('#tsprod_prioridad').val(obj_row.SPROD_PRIORIDAD).trigger('change');
			$('#tsprod_tipomant').val(obj_row.SPROD_TIPOMANT).trigger('change');
			$('#tsprod_motivo').val(obj_row.SPROD_MOTIVO);
			$('#tsprod_comencotiz').val(obj_row.SPROD_COMENCOTIZ);			
			//$('#tsprod_codigosap').val(obj_row.SPROD_CODIGOSAP);
			$('#tsprod_comencompra').val(obj_row.SPROD_COMENCOMPRA);
			
			$('#h_psprod_tipocompra').val(obj_row.SPROD_TIPOCOMPRA)
			$('#h_tsprod_id').val(obj_row.SPROD_ID);
			
			carga_productos_terminados(obj_row.SPROD_ID);			
			
		});
	}		
	
	
	
	
	
	
/////


	function carga_productos_enproceso(sprod_id){
		//console.log(sprod_id)
		$('#productos_enproceso').empty();
		
		tipo_compra = $('#h_psprod_tipocompra').val();
		
		parametros = {	
			compra:'',
			tipo_compra:tipo_compra,
			sprod_id:sprod_id
		}		
		//console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				pcrear_tabla_productos(resp)
			},"json"
			)		
	}
	

	
	function pcrear_tabla_productos(resp){
		console.log(resp)
		$('#productos_enproceso').empty();
		total_cotiz = 0;
		tipo_compra = $('#h_psprod_tipocompra').val();
		console.log(tipo_compra)
		
		if(tipo_compra == 'COMPRA MATERIAL'){
		//sd.SPRODD_ID, p.PROD_COD, p.PROD_NOMBRE, sd.SPRODD_CANT, sd.CC_ID, c.COTCOM_PROVEEDOR, c.COTCOM_ACORDADO
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, (c.COTCOM_PRECIO * c.COTCOM_CANTIDAD) COTCOM_TOTAL, c.COTCOM_ACORDADO_PROV
			i = 0;
			
			while(i < resp.length){
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].PROD_NOMBRE;
				sap = 'sap_'+resp[i].SPRODD_ID;
				elim = 'elimp_'+resp[i].SPRODD_ID;
				
				cotp = 'cotp_'+resp[i].SPRODD_ID;
				sapp = 'sapp_'+resp[i].SPRODD_ID;				
				cot_check = (resp[i].CHECK_COT == 1)?'checked':'';
				sap_check = (resp[i].CHECK_SAP == 1)?'checked':'';
								
				$('#productos_enproceso').append(
					'<tr>'+
						'<td style="text-align:center"><input type="checkbox" id='+cotp+' class="cot_seleccion" '+cot_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+sapp+' class="sap_seleccion" '+sap_check+' /></td>' +							
						'<td style="text-align:center"><input type="checkbox" id='+elim+' class="elimp_seleccion"/></td>' +	
						'<td><select class="select2_single form-control sprodr_estado" tabindex="-1" id='+estado+'><option value=""></option><option value="PENDIENTE">PENDIENTE</option><option value="PARCIAL">PARCIAL</option><option value="COMPLETA">COMPLETA</option></select></td>' +
						'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center"><input id='+sap+' type="text" class="form-control text-center" value='+resp[i].SPRODD_CODIGOSAP+'></td>' +
						'<td style="text-align:center"><select class="select2_single form-control cot_cuenta_contable" tabindex="-1" id='+cc+'><option value=""></option></select></td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="ENPROCESO" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].PROD_NOMBRE_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-total="'+resp[i].COTCOM_TOTAL+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-avance="0" data-cotcom="ENPROCESO" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });	
				$('#'+cotp).bind('click',function(e){ clic_fecha_fin_cotizacionp(this); });
				$('#'+sapp).bind('click',function(e){ clic_fecha_solic_sapp(this); });				
				carga_cc(cc)									
				$('#'+cc).val(resp[i].CC_ID).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
				$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				
				mayuscula(sap);
				
				i++;
			}
		}
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
		//SELECT  sd.SPRODD_ID, sd.SPRODD_SERVICIO, sd.SPRODD_CANT, sd.CC_ID
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, c.COTCOM_AVANCE, c.COTCOM_ACORDADO_PROV
			i = 0;
			while(i < resp.length){
			
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].SPRODD_SERVICIO;
				sap = 'sap_'+resp[i].SPRODD_ID;
				elim = 'elimp_'+resp[i].SPRODD_ID;
				
				cotp = 'cotp_'+resp[i].SPRODD_ID;
				sapp = 'sapp_'+resp[i].SPRODD_ID;				
				cot_check = (resp[i].CHECK_COT == 1)?'checked':'';
				sap_check = (resp[i].CHECK_SAP == 1)?'checked':'';				
				
				$('#productos_enproceso').append(
					'<tr>'+
						'<td style="text-align:center"><input type="checkbox" id='+cotp+' class="cot_seleccion" '+cot_check+' /></td>' +
						'<td style="text-align:center"><input type="checkbox" id='+sapp+' class="sap_seleccion" '+sap_check+' /></td>' +						
						'<td style="text-align:center"><input type="checkbox" id='+elim+' class="elimp_seleccion"/></td>' +	
						'<td><select class="select2_single form-control sprodr_estado" tabindex="-1" id='+estado+'><option value=""></option><option value="PENDIENTE">PENDIENTE</option><option value="PARCIAL">PARCIAL</option><option value="COMPLETA">COMPLETA</option></select></td>' +
						'<td id='+prod+'>'+resp[i].SPRODD_SERVICIO+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center"><input id='+sap+' type="text" class="form-control text-center" value='+resp[i].SPRODD_CODIGOSAP+'></td>' +
						'<td style="text-align:center"><select class="select2_single form-control cot_cuenta_contable" tabindex="-1" id='+cc+'><option value=""></option></select></td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="ENPROCESO" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].SPRODD_SERVICIO_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-avance="'+resp[i].COTCOM_AVANCE+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-total="0" data-cotcom="ENPROCESO" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });		
				$('#'+cotp).bind('click',function(e){ clic_fecha_fin_cotizacionp(this); });
				$('#'+sapp).bind('click',function(e){ clic_fecha_solic_sapp(this); });					
				carga_cc(cc)									
				$('#'+cc).val(resp[i].CC_ID).trigger('change');
				$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
				mayuscula(sap);
				i++;
			}
		}				
		$('#psprod_total').val(total_cotiz)
		
	}
	


	function clic_fecha_fin_cotizacionp(e){
		$('#cloading').show();
		id_cot = e.id	
		sprodd_id1 = id_cot.split('_')
		sprodd_id = sprodd_id1[1]		
		
		var operacion = 'BORRAR FECHA FIN COTIZ';
		if($('#'+id_cot).is(":checked")){
			var operacion = 'REGISTRAR FECHA FIN COTIZ';			
		}	
		parametros = {	
			operacion:operacion,
			sprodd_id:sprodd_id
		}		
		//console.log(parametros)
		$.post(
			"consultas/bod_crud_solcompra.php",
			parametros,			   
			function(resp){
				actualizar_fecha_solic_sap_o_fin_cotizacionp(resp)
			},"json"
		)	
	}	
	
	
	function clic_fecha_solic_sapp(e){
		$('#cloading').show();
		id_sap = e.id	
		sprodd_id1 = id_sap.split('_')
		sprodd_id = sprodd_id1[1]		
		
		var operacion = 'BORRAR FECHA SOLIC SAP';
		if($('#'+id_sap).is(":checked")){
			var operacion = 'REGISTRAR FECHA SOLIC SAP';			
		}	
		parametros = {	
			operacion:operacion,
			sprodd_id:sprodd_id
		}		
		//console.log(parametros)
		$.post(
			"consultas/bod_crud_solcompra.php",
			parametros,			   
			function(resp){
				actualizar_fecha_solic_sap_o_fin_cotizacionp(resp)
			},"json"
		)			
	}	

	function actualizar_fecha_solic_sap_o_fin_cotizacionp(resp){
		$('#cloading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)

		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			
			if(operacion == 'REGISTRAR FECHA FIN COTIZ'){
				swal("sisconvi-production", "Fecha Fin Cotización Registrada", "success");
			}else if(operacion == 'BORRAR FECHA FIN COTIZ'){
				swal("sisconvi-production", "Fecha Fin Cotización Borrada", "success");
			}else if(operacion == 'REGISTRAR FECHA SOLIC SAP'){
				swal("sisconvi-production", "Fecha Solicitud SAP registrada", "success");
			}else if(operacion == 'BORRAR FECHA SOLIC SAP'){
				swal("sisconvi-production", "Fecha Solicitud SAP Borrada", "success");
			}			
		}else{
			
			if (typeof resp['sprodd_id'] !== 'undefined') {
				var sprodd_id = resp['sprodd_id'];
				if (typeof resp['cot'] !== 'undefined') {
					$('#cotp_'+sprodd_id).prop('checked',false);
				}
				else if (typeof resp['sap'] !== 'undefined') {
					$('#sapp_'+sprodd_id).prop('checked',false);
				}
				else if (typeof resp['cotysap'] !== 'undefined') {
					$('#cotp_'+sprodd_id).prop('checked',true);
				}		
				else if (typeof resp['sapreg'] !== 'undefined') {
					$('#sapp_'+sprodd_id).prop('checked',true);
				}				
			}
			var desc_error = resp['desc'];			 
			swal("sisconvi-production", desc_error, "error");			
		}		
	}







	
	
	
	
	
	
	
	

	
/////
	
	function carga_productos_terminados(sprod_id){
		console.log(sprod_id)
		$('#productos_terminados').empty();
		
		tipo_compra = $('#h_psprod_tipocompra').val();
		
		parametros = {	
			compra:'',
			tipo_compra:tipo_compra,
			sprod_id:sprod_id
		}		
		console.log(parametros)
		$.post(
			"consultas/bod_crud_productos.php",
			parametros,			   
			function(resp){
				tcrear_tabla_productos(resp)
			},"json"
			)		
	}
	

	
	function tcrear_tabla_productos(resp){
		console.log(resp)
		$('#productos_terminados').empty();
		total_cotiz = 0;
		tipo_compra = $('#h_psprod_tipocompra').val();
		console.log(tipo_compra)
		
		if(tipo_compra == 'COMPRA MATERIAL'){
		//sd.SPRODD_ID, p.PROD_COD, p.PROD_NOMBRE, sd.SPRODD_CANT, sd.CC_ID, c.COTCOM_PROVEEDOR, c.COTCOM_ACORDADO
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, (c.COTCOM_PRECIO * c.COTCOM_CANTIDAD) COTCOM_TOTAL, c.COTCOM_ACORDADO_PROV
			i = 0;
			
			while(i < resp.length){
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].PROD_NOMBRE;
				sap = 'sap_'+resp[i].SPRODD_ID;
				
				$('#productos_terminados').append(
					'<tr>'+
						'<td style="text-align:center">'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].PROD_NOMBRE+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center">'+resp[i].SPRODD_CODIGOSAP+'</td>' +
						'<td style="text-align:center">'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].PROD_NOMBRE_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-total="'+resp[i].COTCOM_TOTAL+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-avance="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');	
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });		
				//carga_cc(cc)									
				//$('#'+cc).val(resp[i].CC_ID).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
				//$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				i++;
			}
		}
		
		if(tipo_compra == 'PRESTACIÓN SERVICIO'){
		//SELECT  sd.SPRODD_ID, sd.SPRODD_SERVICIO, sd.SPRODD_CANT, sd.CC_ID
		//COTCOM_PROVEEDOR_FILL, c.COTCOM_PRECIO, c.COTCOM_CANTIDAD, c.COTCOM_AVANCE, c.COTCOM_ACORDADO_PROV
			i = 0;
			while(i < resp.length){
			
				sprodd_id = resp[i].SPRODD_ID;
				prod = 'prod_'+resp[i].SPRODD_ID;
				cant = 'cant_'+resp[i].SPRODD_ID;
				cc = 'cc_'+resp[i].SPRODD_ID;
				estado = 'estado_'+resp[i].SPRODD_ID;
				total = 'total_'+resp[i].SPRODD_ID;
				producto = resp[i].SPRODD_SERVICIO;
				
				$('#productos_terminados').append(
					'<tr>'+
						'<td>'+resp[i].SPRODR_ESTADO+'</td>' +
						'<td id='+prod+'>'+resp[i].SPRODD_SERVICIO+'</td>' +
						'<td id='+cant+' style="text-align:center">'+resp[i].SPRODD_CANT+'</td>' +
						'<td style="text-align:center">'+resp[i].SPRODD_CODIGOSAP+'</td>' +
						'<td>'+resp[i].CC_NOMBRE+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cotcom="FIN" data-cant="'+resp[i].SPRODD_CANT+'" data-toggle="modal" data-target="#WModal_Cotizacion" style="text-align:center">'+resp[i].COTCOM_PROVEEDOR+'</td>' +
						'<td data-sprodd_id="'+sprodd_id+'" data-tipocompra="'+tipo_compra+'" data-prodserv="'+producto+'" data-cant="'+resp[i].SPRODD_CANT+'" data-prodservfill="'+resp[i].SPRODD_SERVICIO_FILL+'" data-proveedor="'+resp[i].COTCOM_PROVEEDOR_FILL+'" data-precio="'+resp[i].COTCOM_PRECIO+'" data-cantidad="'+resp[i].COTCOM_CANTIDAD_PROV+'" data-avance="'+resp[i].COTCOM_AVANCE+'" data-acordado="'+resp[i].COTCOM_ACORDADO_PROV+'"  data-total="0" data-cotcom="FIN" data-toggle="modal" data-target="#WModal_Compra" style="text-align:center">'+resp[i].COTCOM_CANTIDAD+'</td>' +
						'<td id='+total+' style="text-align:center">'+resp[i].COTCOM_ACORDADO+'</td>' +
				'</tr>');
				
				//$('#'+prov).bind('click',function(e){ clic_cotizacion(this); });		
				//carga_cc(cc)									
				//$('#'+cc).val(resp[i].CC_ID).trigger('change');
				//$('#'+estado).val(resp[i].SPRODR_ESTADO).trigger('change');
				precio = resp[i].COTCOM_ACORDADO;
				if(resp[i].COTCOM_ACORDADO != '') total_cotiz = total_cotiz + parseInt(precio);
	
				i++;
			}
		}				
		$('#tsprod_total').val(total_cotiz)
		
	}
	
	
	
	
	function limpieza_enproceso(){
	
		$('#h_psprod_id').val('');
	
		$('#psprod_motivo').val('');
		$('#psprod_comencotiz').val('');
		//$('#com_codigosap').val('');
		$('#psprod_comencompra').val('');
		$('#psprod_total').val('');
		$('#productos_enproceso').empty();
	}
	
	function limpieza_enproceso_full(){
	
		$('#h_psprod_id').val('');
		$('#psprod_id').val('');
		$('#psprod_motivo').val('');
		$('#psprod_comencotiz').val('');
		//$('#com_codigosap').val('');
		$('#psprod_comencompra').val('');
		$('#psprod_total').val('');
		$('#productos_enproceso').empty();
			
		$('#pusr_solic').val('').trigger('change');			
		$('#pUNDVIV_ID').val('').trigger('change');
		$('#psprod_tipocompra').val('').trigger('change');
		$('#psprod_prioridad').val('').trigger('change');
		$('#psprod_tipomant').val('').trigger('change');			

	}	
	
	function limpieza_terminados(){
		$('#h_tsprod_id').val('');
	
		$('#tsprod_motivo').val('');
		$('#tsprod_comencotiz').val('');
		//$('#tsprod_codigosap').val('');
		$('#tsprod_comencompra').val('');
		$('#tsprod_total').val('');
		$('#productos_terminados').empty();
	}		
	
	function limpieza_terminados_full(){
		$('#h_tsprod_id').val('');
		
		$('#tsprod_motivo').val('');
		$('#tsprod_comencotiz').val('');
		//$('#tsprod_codigosap').val('');
		$('#tsprod_comencompra').val('');
		$('#tsprod_total').val('');
		$('#productos_terminados').empty();
		$('#tsprod_id').val('');	
		$('#tusr_solic').val('').trigger('change');			
		$('#tUNDVIV_ID').val('').trigger('change');
		$('#tsprod_tipocompra').val('').trigger('change');
		$('#tsprod_prioridad').val('').trigger('change');
		$('#tsprod_tipomant').val('').trigger('change');			
		//$('#tsprod_codigosap').val('');
		
		
	}	
	
	$('#com_dentrega').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		showWeekNumbers: true,
		
		locale: {
			separator:'-',
			format: 'DD-MM-YYYY',
			daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			firstDay: 1
		}		
	});	
	
	$("#WModal_Compra").on('show.bs.modal', function(event){
	
		var identificador = $(event.relatedTarget);
		
		var sprodd_id = identificador.data('sprodd_id');
		var tipo_compra = identificador.data('tipocompra');
		
		var prod = 'Compra: '+identificador.data('prodservfill');
		$('#title_compra').html(prod)
		
		var cant = 'Cantidad Solicitada: '+identificador.data('cant');
		$('#title_cant').html(cant)		
		
		var cotcom = identificador.data('cotcom');
				
		if(cotcom == 'FIN'){
			$('#com_form').hide();
		}	

		console.log('sprodd_id:'+sprodd_id);
		console.log('tipo_compra:'+tipo_compra);
		console.log('cotcom:'+cotcom);

		if(cotcom == 'ENPROCESO'){
			$('#com_form').show();			
			$('#com_dentrega').val(fecha_actual_picker)
			$('#com_hentrega').val('08:00').trigger('change');
	
			var proveedor = identificador.data('proveedor');
			console.log('proveedor:'+proveedor);			

			var precio = "";
			var cantidad = "";
			var total = "";
			var acordado = "";
			var avance = "";
			
			if(proveedor != ''){
			
				var precio = identificador.data('precio');
				var cantidad = identificador.data('cantidad');
				var total = identificador.data('total');
				var acordado = identificador.data('acordado');
				
				if(tipo_compra == 'PRESTACIÓN SERVICIO'){ 
					var avance = identificador.data('avance');
				}
			}

			$('#h_com_proveedor').val(proveedor);
			$('#h_com_precio').val(precio);
			
			$('#com_proveedor').val(proveedor);
			$('#com_precio').val(precio);
			$('#com_cantidad').val(cantidad);
			$('#com_total').val(total);
			//$('#com_acordado').val(acordado);
			$('#com_acordado').val(total);
			$('#com_avance').val(avance).trigger('change');				

			
			if(tipo_compra == 'COMPRA MATERIAL'){ 
				$('#div_com_avance').hide();
				$('#div_com_total').show();
				$('#com_cant_plazo').html('Cantidad');
			} 
			else {
				$('#div_com_total').hide(); 
				$('#div_com_avance').show();
				$('#com_cant_plazo').html('Plazo');
			}
		
		}

		$('#h_sprodd_id').val(sprodd_id);
		$('#h_sprod_tipocompra').val(tipo_compra);
		if(typeof tabla_compra != 'undefined') tabla_compra.destroy()
		crear_tabla_compra();
		
    });
	
	
	var tabla_compra;
	
	function crear_tabla_compra(){

		var sprodd_id = $('#h_sprodd_id').val();	
		var tipo_compra = $('#h_sprod_tipocompra').val();
		var cotcom_tipo = 'COMPRA';
		console.log(sprodd_id)
		tabla_compra = $("#datatable-compra").DataTable({
			
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
				{ targets: [1,2,3,5,6,7,9], visible: true},
				{ targets: '_all', visible: false }			
			], 
			ajax: "consultas/bod_crud_solcompra.php?sprodd_id="+sprodd_id+"&cotcom_tipo="+cotcom_tipo+"&tipo_compra="+tipo_compra,	
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'COTCOM_ID'},
				/*{ data:'COTCOM_CODIGOSAP'},*/
				{ data:'COTCOM_HES'},
				{ data:'COTCOM_PROVEEDOR_ACORTADO'},	
				{ data:'COTCOM_PROVEEDOR'},	
				{ data:'FECHA_ENTREGA'},		
				{ data:'COTCOM_PRECIO'},
				{ data:'COTCOM_CANTIDAD'},
				{ data:'COTCOM_TOTAL'},								
				{ data:'COTCOM_ACORDADO'},
				{ data:'COTCOM_AVANCE'}
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
	  
		$('#datatable-compra tbody')
			.on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tabla_compra.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			
			cancelar_compra();
			
			var obj_row = tabla_compra.row(this).data();
			console.log(obj_row)

			$('#h_cotcom_id').val(obj_row.COTCOM_ID);
			$('#com_proveedor').val(obj_row.COTCOM_PROVEEDOR);
			$('#com_precio').val(obj_row.COTCOM_PRECIO);
			$('#com_cantidad').val(obj_row.COTCOM_CANTIDAD);
			//$('#com_total').val(obj_row.COTCOM_TOTAL);
			$('#com_acordado').val(obj_row.COTCOM_ACORDADO);
			//$('#com_acordado').val(obj_row.COTCOM_TOTAL);
			$('#com_hes').val(obj_row.COTCOM_HES);
			//$('#com_codigosap').val(obj_row.COTCOM_CODIGOSAP);

			var fechahora_entrega = obj_row.FECHA_ENTREGA;
			fechahora_entrega = fechahora_entrega.split(' ')
	
			$('#com_dentrega').val(fechahora_entrega[0]);
			$('#com_hentrega').val(fechahora_entrega[1]).trigger('change');			
			
			$('#com_avance').val(obj_row.COTCOM_AVANCE).trigger('change');	

			$('#btn_reg_com').hide();
			$('#btn_upd_com').show();
			$('#btn_del_com').show();
			$('#btn_can_com').show();		
			
		});
	}	

	
	
	
	function validar_compra(){

		var cotcom_proveedor = $.trim($('#com_proveedor').val());
		var cotcom_precio = $.trim($('#com_precio').val());
		var cotcom_cantidad = $.trim($('#com_cantidad').val());
		var cotcom_acordado = $.trim($('#com_acordado').val());
		var cotcom_hes = $.trim($('#com_hes').val());
		//var cotcom_codigosap = $.trim($('#com_codigosap').val());
		var cotcom_dentrega = $.trim($('#com_dentrega').val());
		var cotcom_hentrega = $.trim($('#com_hentrega').val());	
		var cotcom_avance = $.trim($('#com_avance').val());
		var tipo_compra = $('#h_sprod_tipocompra').val();
		
		if(cotcom_proveedor == ''){
			sweet_alert('Error: Ingresar proveedor');	
			return false;
		}
		
		if(cotcom_precio == ''){
			sweet_alert('Error: Ingresar precio');	
			return false;
		}		

		if(cotcom_cantidad == ''){
			sweet_alert('Error: Ingresar cantidad');
			return false;
		}
		
		if(cotcom_acordado == ''){
			sweet_alert('Error: Ingresar total acordado');	
			return false;
		}		

		if(cotcom_hes == ''){
			sweet_alert('Error: Ingresar código HES');	
			return false;
		}			
/*
		if(cotcom_codigosap == ''){
			sweet_alert('Error: Ingresar código SAP');	
			return false;
		}			
*/		
		if(cotcom_dentrega == ''){
			sweet_alert('Error: Ingresar fecha entrega');	
			return false;
		}			
		
		if(cotcom_hentrega == ''){
			sweet_alert('Error: Ingresar hora entrega');	
			return false;
		}
		
		if(cotcom_avance == '' && tipo_compra == 'PRESTACIÓN SERVICIO'){
			sweet_alert('Error: Ingresar % Avance');	
			return false;
		}		
		
		return true;
	}	

	
	$('#btn_reg_com').click(function(){

		if (validar_compra()){	

			$('#comloading').show();
			var sprodd_id = $('#h_sprodd_id').val();
			var cotcom_proveedor = $.trim($('#com_proveedor').val());
			var cotcom_precio = $.trim($('#com_precio').val());
			var cotcom_cantidad = $.trim($('#com_cantidad').val());
			var cotcom_acordado = $.trim($('#com_acordado').val());
			var cotcom_hes = $.trim($('#com_hes').val());
			//var cotcom_codigosap = $.trim($('#com_codigosap').val());
			var cotcom_dentrega = $.trim($('#com_dentrega').val());
			var cotcom_hentrega = $.trim($('#com_hentrega').val());
			var cotcom_avance = $.trim($('#com_avance').val());
			var cotcom_tipo = 'COMPRA';
			var tipo_compra = $('#h_sprod_tipocompra').val();
			
			var operacion = 'REGISTRAR COMPRA';
			parametros = {		
							sprodd_id:sprodd_id,
							cotcom_proveedor:cotcom_proveedor,
							cotcom_precio:cotcom_precio,
							cotcom_cantidad:cotcom_cantidad,
							cotcom_acordado:cotcom_acordado,
							cotcom_hes:cotcom_hes,
							/*cotcom_codigosap:cotcom_codigosap,*/
							cotcom_dentrega:cotcom_dentrega,
							cotcom_hentrega:cotcom_hentrega,
							cotcom_avance:cotcom_avance,
							cotcom_tipo:cotcom_tipo,
							tipo_compra:tipo_compra,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						ges_crud_compra(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_com').click(function(){
		if (validar_compra()){	

			$('#comloading').show();
			var cotcom_id = $('#h_cotcom_id').val();
			var sprodd_id = $('#h_sprodd_id').val();
			var cotcom_proveedor = $.trim($('#com_proveedor').val());
			var cotcom_precio = $.trim($('#com_precio').val());
			var cotcom_cantidad = $.trim($('#com_cantidad').val());
			var cotcom_acordado = $.trim($('#com_acordado').val());
			var cotcom_hes = $.trim($('#com_hes').val());
			//var cotcom_codigosap = $.trim($('#com_codigosap').val());
			var cotcom_dentrega = $.trim($('#com_dentrega').val());
			var cotcom_hentrega = $.trim($('#com_hentrega').val());
			var cotcom_avance = $.trim($('#com_avance').val());
			var cotcom_tipo = 'COMPRA';
			var tipo_compra = $('#h_sprod_tipocompra').val();		
			
			var operacion = 'MODIFICAR COMPRA';
			parametros = {	
							cotcom_id:cotcom_id,
							sprodd_id:sprodd_id,
							cotcom_proveedor:cotcom_proveedor,
							cotcom_precio:cotcom_precio,
							cotcom_cantidad:cotcom_cantidad,
							cotcom_acordado:cotcom_acordado,
							cotcom_hes:cotcom_hes,
							/*cotcom_codigosap:cotcom_codigosap,*/
							cotcom_dentrega:cotcom_dentrega,
							cotcom_hentrega:cotcom_hentrega,
							cotcom_avance:cotcom_avance,
							cotcom_tipo:cotcom_tipo,
							tipo_compra:tipo_compra,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						ges_crud_compra(resp)
				   },"json"
			)
		}
	})		

 	$('#btn_del_com').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta compra?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#comloading').show();

				var cotcom_id = $('#h_cotcom_id').val();
				var tipo_compra = $('#h_sprod_tipocompra').val();
				var operacion = 'ELIMINAR COMPRA';
				parametros = {	
								cotcom_id:cotcom_id,
								tipo_compra:tipo_compra,
								operacion:operacion
							 }		
				console.log(parametros)			 
				$.post(
					   "consultas/bod_crud_solcompra.php",
					   parametros,			   
					   function(resp){
							ges_crud_compra(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_compra(resp){
		$('#comloading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar_compra();
			
			if(operacion == 'REGISTRAR COMPRA'){
				swal("sisconvi-production", "Compra registrada", "success");
			}else if(operacion == 'MODIFICAR COMPRA'){
				swal("sisconvi-production", "Compra modificada", "success");
			}else if(operacion == 'ELIMINAR COMPRA'){
				swal("sisconvi-production", "Compra eliminada", "success");
			}	
			$('#datatable-compra tbody').unbind( "click" );
			tabla_compra.destroy();
			crear_tabla_compra();
			
			sprod_id = $('#h_sprod_id').val();
			carga_productos_enproceso(sprod_id)	

			proveedor = $('#h_com_proveedor').val();
			precio = $('#h_com_precio').val();

			$('#com_proveedor').val(proveedor);	
			$('#com_precio').val(precio);
			$('#com_dentrega').val(fecha_actual_picker)
			$('#com_hentrega').val('08:00').trigger('change');			
		}else{
			var desc_error = resp['desc'];
			swal("sisconvi-production", desc_error, "error");
		}
	}		

	$('#btn_can_com').click(function(){
		cancelar_compra();
	})	
	
	function cancelar_compra(){
		//$('#form_plantamadre')[0].reset();

		$('#btn_reg_com').show();
		$('#btn_upd_com').hide();
		$('#btn_del_com').hide();
		$('#btn_can_com').hide();

		//tabla_cotizacion.$('tr.selected').removeClass('selected');

		$('#h_cotcom_id').val('');
		$('#com_proveedor').val('')
		$('#com_precio').val('');
		$('#com_cantidad').val('');
		//$('#com_total').val('');
		$('#com_acordado').val('0');	
		
		$('#com_hes').val('');	
		//$('#com_codigosap').val('');	
		$('#com_dentrega').val('');	
		$('#com_hentrega').val('');	
		$('#com_avance').val('');
	}			
	

	
	
	
	
	
	
	
//////////////////



	
	
	
	
	
	
//REGISTRAR COMPRA	
	$('#btn_reg_compra').click(function(){
		validacion_cc_estado = 0;
		i = 0;
		var cc_sprodd_id = {};
		var cc_id = {};
		var sprodr_estado = {};
		var sprodd_codigosap = {};
		
		$('.cot_cuenta_contable').each( function() {
			id_cc = this.id	
			sprodd_id1 = id_cc.split('_')
			sprodd_id = sprodd_id1[1]
			
			cc = $('#'+id_cc).val();
			estado = $('#estado_'+sprodd_id).val();
			sap = $('#sap_'+sprodd_id).val();
			
			cc_sprodd_id[i] = sprodd_id;
			cc_id[i] = cc;
			sprodr_estado[i] = estado;
			sprodd_codigosap[i] = sap;
			
			if(cc == '' || estado == '') validacion_cc_estado = 1;
			
			i++;
		})	
		
		if(validacion_cc_estado){
			sweet_alert('Error: Seleccionar estado y cuenta contable por cada Material/Servicio');
		}else{
		
			var operacion = 'UPDATE ESTADO Y CC';			
			parametros = {			
							cc_sprodd_id:cc_sprodd_id,
							cc_id:cc_id,
							sprodr_estado:sprodr_estado,
							sprodd_codigosap:sprodd_codigosap,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						update_enproceso(resp)
				   },"json"
			)			
			
		}
		
	})
	
//COMENTARIO COMPRA	
	$('#btn_reg_sap').click(function(){

		var sprod_comencompra = $.trim($('#psprod_comencompra').val());
		//var sprod_codigosap = $.trim($('#com_codigosap').val());
		var sprod_id = $('#h_sprod_id').val();
		/*
		if(sprod_codigosap == ''){
			sweet_alert('Error: Ingresar Código SAP');
		}else{
		*/
			var operacion = 'COMENTARIO COMPRA';			
			parametros = {			
							sprod_comencompra:sprod_comencompra,
							//sprod_codigosap:sprod_codigosap,
							sprod_id:sprod_id,
							operacion:operacion
						 }	
			console.log(parametros)
			
			$.post(
				   "consultas/bod_crud_solcompra.php",
				   parametros,			   
				   function(resp){
						update_enproceso(resp)
				   },"json"
			)			
		
		//}
		
	})	
	
//TERMINAR COMPRA	
	$('#btn_fin_compra').click(function(){
	
	
		swal({   
			title: "¿Seguro que deseas terminar el Proceso de Compra?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   

					var sprod_id = $('#h_sprod_id').val();
					var tipo_compra = $('#h_psprod_tipocompra').val();
					var operacion = 'COMPRA TERMINADA';			
					parametros = {			
									sprod_id:sprod_id,
									tipo_compra:tipo_compra,
									operacion:operacion
								 }	
					console.log(parametros)
					
					$.post(
						   "consultas/bod_crud_solcompra.php",
						   parametros,			   
						   function(resp){
								update_enproceso(resp)
						   },"json"
					)						
				
		});		
	
		

	})


//ELIMINAR SELECCION EN PROCESO	
	$('#btn_reg_elimselproc').click(function(){
		
		var num_filas = $("#productos_enproceso tr").length;
		
		if(num_filas == 0){
			sweet_alert('Error: Seleccione una solicitud');
			return 1;
		}		
		
		validacion = 0;
		i = 0; j = 0;
		var elim_sprodd_id = {};

		$('.elimp_seleccion').each( function() {
			id_elim = this.id	
			sprodd_id1 = id_elim.split('_')
			sprodd_id = sprodd_id1[1]
			

			if($('#'+id_elim).is(":checked")){
				validacion = 1;
				elim_sprodd_id[j] = sprodd_id;
				j++;				
			}		
			
			i++;
		})	
		
		if(validacion == 0){
			sweet_alert('Error: No ha seleccionado un material/servicio que eliminar');
		}else{
			
			if(i==j){
				swal({   
					title: "¿Seguro que deseas eliminar la Solicitud completa?",   
					text: "No podrás deshacer este paso...",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						var operacion = 'ELIM SOL_MATERIALoSERVICIO_ALL';	
						sprod_id = $('#h_sprod_id').val();
						parametros = {	
							operacion:operacion,
							sprod_id:sprod_id
						}		
						console.log(parametros)
						$.post(
							"consultas/bod_crud_solcompra.php",
							parametros,			   
							function(resp){
								update_enproceso(resp)
							},"json"
						)							
						
				});				
			}
			else{
				swal({   
					title: "¿Seguro que deseas eliminar lo seleccionado y sus cotizaciones asociadas?",   
					text: "No podrás deshacer este paso...",   
					type: "warning",   
					showCancelButton: true,
					cancelButtonText: "Mmm... mejor no",   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "¡Adelante!",   
					closeOnConfirm: false }, 

					function(){   
						var operacion = 'ELIM SOL_MATERIALoSERVICIO';	
						parametros = {	
							operacion:operacion,
							sprodd_id:elim_sprodd_id
						}		
						console.log(parametros)
						$.post(
							"consultas/bod_crud_solcompra.php",
							parametros,			   
							function(resp){
								update_enproceso(resp)
							},"json"
						)							
						
				});				
			}
		}		
	})	
	
	
	function update_enproceso(resp){
		$('#cloading').hide();
		var cod_resp = resp['cod'];
		var tipo_compra = $('#h_psprod_tipocompra').val();
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			
			if(operacion == 'UPDATE ESTADO Y CC'){
				swal("sisconvi-production", "Estado y Cuenta Contable acutualizada", "success");
			}else if(operacion == 'COMENTARIO COMPRA'){
				swal("sisconvi-production", "Comentario registrado", "success");
				//$('#tabla_solicitudes_enproceso tbody').unbind( "click" );
				busqueda_solic_enproceso_sinlimpieza();
				//tabla_solicitudes_enproceso.destroy();			
				//crear_tabla_enproceso();
				//busqueda_solic_enproceso()
			}else if(operacion == 'COMPRA TERMINADA'){
			
				if(tipo_compra == 'COMPRA MATERIAL'){
			
					var sprod_id = resp['sprod_id'];			
					swal("sisconvi-production", "Compra Terminada y se ha generado una Solicitud de Materiales con el número "+sprod_id, "success");
				}
				else{
					swal("sisconvi-production", "Compra Terminada", "success");
				}
				
					
				limpieza_enproceso_full();
				//$("#productos_solicitados tr").remove();
				$('#tabla_solicitudes_enproceso tbody').unbind( "click" );
				//tabla_solicitudes_enproceso.destroy();			
				//crear_tabla_enproceso();
				busqueda_solic_enproceso()							
				
			}else if(operacion == 'ELIM SOL_MATERIALoSERVICIO_ALL'){
				swal("sisconvi-production", "Solicitud Eliminada", "success");
				limpieza_enproceso_full();	
				$('#tabla_solicitudes_enproceso tbody').unbind( "click" );	
				busqueda_solic_enproceso()
			}
			else if(operacion == 'ELIM SOL_MATERIALoSERVICIO'){
				swal("sisconvi-production", "Selección Eliminada", "success");
				sprod_id = $('#h_sprod_id').val();
				carga_productos_enproceso(sprod_id);				
			}			

		}else{
			var desc_error = resp['desc'];
			swal("sisconvi-production", desc_error, "error");
		}
	}	
	
	
///////////////////////

	$('#btn_cambiar_enproceso').click(function(){
		swal({   
			title: "¿Seguro que deseas cambiar esta compra a En Proceso?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
					$('#tloading').show();
					var sprod_id = $('#h_tsprod_id').val();
					var operacion = 'CAMBIAR A EN PROCESO';			
					parametros = {			
									sprod_id:sprod_id,
									operacion:operacion
								 }	
					console.log(parametros)
					
					$.post(
						   "consultas/bod_crud_solcompra.php",
						   parametros,			   
						   function(resp){
								update_fin_a_enproceso(resp)
						   },"json"
					)						
				
		});		
	})
	
	

	function update_fin_a_enproceso(resp){
		$('#tloading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			
			if(operacion == 'CAMBIAR A EN PROCESO'){
				swal("sisconvi-production", "Cambiada esta compra al estado En Proceso", "success");
			}	
			limpieza_terminados_full();
			$('#tabla_solicitudes_terminados tbody').unbind( "click" );
			busqueda_solic_terminados()
		}else{
			var desc_error = resp['desc'];
			swal("sisconvi-production", desc_error, "error");
		}	
	}
		
	
	
});