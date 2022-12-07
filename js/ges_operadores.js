$(document).ready(function(){
	
	$('#oper_rut').focus();
	
	$('#oper_rut').Rut({
	  on_error: function(){ sweet_alert('Error: Rut inválido'); },
	  format_on: 'keyup' 
	});
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
			table = $("#datatable-responsive").DataTable({
		
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_operadores.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'OPER_RUT'},
				{ data:'OPERARIO'},			
				{ data:'OPER_ESTADO'},
				{ data:'CMN_CODIGO'},
				{ data:'OPER_NOMBRES'},
				{ data:'OPER_PATERNO'},			
				{ data:'OPER_MATERNO'},
				{ data:'OPER_SEXO'},
				{ data:'OPER_FECHANAC'},	
				{ data:'OPER_DIRECCION'},
				{ data:'OPER_FONO'},
				{ data:'OPER_EMAIL'},
				{ data:'OPER_CIVIL'}
			],	

			columnDefs: [
				{ targets: [0,1,2], visible: true},
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
				"sSortAscending":  ": operar para ordenar la columna de manera ascendente",
				"sSortDescending": ": operar para ordenar la columna de manera descendente"
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
			
			$('#oper_rut').val(obj_row.OPER_RUT);
			$('#oper_rut').prop('disabled',true);
			$('#oper_nombres').val(obj_row.OPER_NOMBRES);
			$('#oper_paterno').val(obj_row.OPER_PATERNO);
			$('#oper_materno').val(obj_row.OPER_MATERNO);
			
			$('#oper_sexo').val(obj_row.OPER_SEXO).trigger('change');;
			$('#oper_civil').val(obj_row.OPER_CIVIL).trigger('change');;
			$('#oper_fechanac').data('daterangepicker').setStartDate(obj_row.OPER_FECHANAC);	
			$('#oper_direccion').val(obj_row.OPER_DIRECCION);
			$('#oper_comuna').val(obj_row.CMN_CODIGO).trigger('change');
			$('#oper_fono').val(obj_row.OPER_FONO);
			$('#oper_email').val(obj_row.OPER_EMAIL);	
			$('#oper_estado').val(obj_row.OPER_ESTADO).trigger('change');
			
			$('#btn_reg_operador').hide();
			$('#btn_upd_operador').show();
			$('#btn_del_operador').show();
			$('#btn_can_operador').show();		
			
		});
	}
	
	$('#btn_can_operador').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_operador')[0].reset();

		$('#btn_reg_operador').show();
		$('#btn_upd_operador').hide();
		$('#btn_del_operador').hide();
		$('#btn_can_operador').hide();
		table.$('tr.selected').removeClass('selected');
		$('#oper_sexo').val('F').trigger('change');
		$('#oper_civil').val('SOLTERO').trigger('change');
		$('#oper_comuna').val('').trigger('change');
		$('#oper_estado').val('VIGENTE').trigger('change');
		
		$('#oper_rut').prop('disabled',false);
		$('#oper_rut').focus();		
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

	function validarEmail(email){
		var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;		
		if (regex.test(email)) {
			return true;
		}
		else { //mail no válido
			return false;
		}		
	}	

	$('#oper_rut').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=107 && e.which!=75 && (e.which<48 || e.which>57))return false;	
	});	
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	mayuscula('oper_rut');
	mayuscula('oper_nombres');
	mayuscula('oper_paterno');
	mayuscula('oper_materno');
	mayuscula('oper_direccion');
	mayuscula('oper_email');

	$('#oper_fechanac').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		//showWeekNumbers: true,
		
		locale: {
			separator:'-',
			format: 'DD-MM-YYYY',
			daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			firstDay: 1
		}
		}, function(start, end, label) {
			//console.log(start)
			//console.log(start.toISOString(), end.toISOString(), label);
			var years = moment().diff(start, 'years');
			$('#oper_edad').html(years+' años')
	});
	
	
	$('#oper_sexo').select2({			
		allowClear: true
	});	

	$('#oper_civil').select2({			
		allowClear: true
	});	

	$('#oper_estado').select2({			
		allowClear: true
	});	
	
	
	carga_comunas();
	function carga_comunas(){
		var combobox = [];
		for(var i  = 0 ; i < data_comunas.length; i++) {
			combobox.push({id:data_comunas[i].cmn_codigo, text:data_comunas[i].cmn_nombre});
		}	
		
		$('#oper_comuna').select2({			
			allowClear: true,	
			data:combobox
		});			
	}		
	
	function validar_operador(){
	
		var oper_rut = $.trim($('#oper_rut').val());
		var oper_nombres = $.trim($('#oper_nombres').val());		
		var oper_paterno = $.trim($('#oper_paterno').val());
		var oper_materno = $.trim($('#oper_materno').val());
		var oper_sexo = $.trim($('#oper_sexo').val());		
		var oper_civil = $.trim($('#oper_civil').val());
		var oper_fechanac = $.trim($('#oper_fechanac').val());
		var oper_direccion = $.trim($('#oper_direccion').val());		
		var cmn_codigo = $.trim($('#oper_comuna').val());		
		var oper_fono = $.trim($('#oper_fono').val());
		var oper_email = $.trim($('#oper_email').val());
		var oper_estado = $.trim($('#oper_estado').val());

	
		if(oper_rut == ''){
			sweet_alert('Error: Ingresar rut');	
			return false;
		}
		
		if(oper_nombres == ''){
			sweet_alert('Error: Ingresar nombres');	
			return false;
		}		

		if(oper_paterno == ''){
			sweet_alert('Error: Ingresar apellido paterno');	
			return false;
		}
		
		if(oper_materno == ''){
			sweet_alert('Error: Ingresar apellido materno');	
			return false;
		}		
		
		if(cmn_codigo == ''){
			sweet_alert('Error: Ingresar comuna');	
			return false;
		}	
						
		if(oper_nombres.length > 100){
			sweet_alert('Error: máximo 100 caracteres en nombres');	
			return false;
		}

		if(oper_paterno.length > 100){
			sweet_alert('Error: máximo 100 caracteres en apellido paterno');	
			return false;
		}		
		
		if(oper_materno.length > 100){
			sweet_alert('Error: máximo 100 caracteres en apellido materno');	
			return false;
		}

		if(oper_direccion.length > 250){
			sweet_alert('Error: máximo 250 caracteres en direccón');	
			return false;
		}			
		
		if(oper_fono.length > 100){
			sweet_alert('Error: máximo 100 caracteres en fono');	
			return false;
		}
		
		if(oper_email.length > 100){
			sweet_alert('Error: máximo 100 caracteres en email');	
			return false;
		}		
		
		if(!$.Rut.validar(oper_rut)){
			sweet_alert('Error: Rut inválido');	
			return false;		
		}		
		
		if(oper_email != '' && !validarEmail(oper_email)){
			sweet_alert('Error: formato de email inválido');	
			return false;		
		}		
		
		
		return true;
	}
		  
	$('#btn_reg_operador').click(function(){

		if (validar_operador()){	

			$('#loading').show();
			
			var oper_rut = $.trim($('#oper_rut').val());
			var oper_nombres = $.trim($('#oper_nombres').val());		
			var oper_paterno = $.trim($('#oper_paterno').val());
			var oper_materno = $.trim($('#oper_materno').val());
			var oper_sexo = $.trim($('#oper_sexo').val());		
			var oper_civil = $.trim($('#oper_civil').val());
			var oper_fechanac = $.trim($('#oper_fechanac').val());
			var oper_direccion = $.trim($('#oper_direccion').val());		
			var cmn_codigo = $.trim($('#oper_comuna').val());		
			var oper_fono = $.trim($('#oper_fono').val());
			var oper_email = $.trim($('#oper_email').val());
			var oper_estado = $.trim($('#oper_estado').val());
			
			var operacion = 'INSERT';
			parametros = {			
							oper_rut:oper_rut,
							oper_nombres:oper_nombres,
							oper_paterno:oper_paterno,
							oper_materno:oper_materno,
							oper_sexo:oper_sexo,
							oper_civil:oper_civil,
							oper_fechanac:oper_fechanac,
							oper_direccion:oper_direccion,
							cmn_codigo:cmn_codigo,
							oper_fono:oper_fono,
							oper_email:oper_email,
							oper_estado:oper_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_operadores.php",
				   parametros,			   
				   function(resp){
						ges_crud_operadores(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_operador').click(function(){
		if (validar_operador()){	

			$('#loading').show();
			
			var oper_rut = $.trim($('#oper_rut').val());
			var oper_nombres = $.trim($('#oper_nombres').val());		
			var oper_paterno = $.trim($('#oper_paterno').val());
			var oper_materno = $.trim($('#oper_materno').val());
			var oper_sexo = $.trim($('#oper_sexo').val());		
			var oper_civil = $.trim($('#oper_civil').val());
			var oper_fechanac = $.trim($('#oper_fechanac').val());
			var oper_direccion = $.trim($('#oper_direccion').val());		
			var cmn_codigo = $.trim($('#oper_comuna').val());		
			var oper_fono = $.trim($('#oper_fono').val());
			var oper_email = $.trim($('#oper_email').val());
			var oper_estado = $.trim($('#oper_estado').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							oper_rut:oper_rut,
							oper_nombres:oper_nombres,
							oper_paterno:oper_paterno,
							oper_materno:oper_materno,
							oper_sexo:oper_sexo,
							oper_civil:oper_civil,
							oper_fechanac:oper_fechanac,
							oper_direccion:oper_direccion,
							cmn_codigo:cmn_codigo,
							oper_fono:oper_fono,
							oper_email:oper_email,
							oper_estado:oper_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_operadores.php",
				   parametros,			   
				   function(resp){
						ges_crud_operadores(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_operador').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este operador?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var oper_rut = $.trim($('#oper_rut').val());
				var operacion = 'DELETE';
				parametros = {	
								oper_rut:oper_rut,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_operadores.php",
					   parametros,			   
					   function(resp){
							ges_crud_operadores(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_operadores(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Operador registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Operador modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Operador eliminado", "success");
			}			
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});