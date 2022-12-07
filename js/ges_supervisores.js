$(document).ready(function(){
	
	$('#sup_rut').focus();
	
	$('#sup_rut').Rut({
	  on_error: function(){ sweet_alert('Error: Rut inválido'); },
	  format_on: 'keyup' 
	});
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_supervisores.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'SUP_RUT'},
				{ data:'SUPERVISOR'},			
				{ data:'SUP_ESTADO'},
				{ data:'AREAS_A_SUPERVISAR'},
				{ data:'ID_AREAS_A_SUPERVISAR'},			
				{ data:'CMN_CODIGO'},
				{ data:'SUP_NOMBRES'},
				{ data:'SUP_PATERNO'},			
				{ data:'SUP_MATERNO'},
				{ data:'SUP_SEXO'},
				{ data:'SUP_FECHANAC'},	
				{ data:'SUP_DIRECCION'},
				{ data:'SUP_FONO'},
				{ data:'SUP_EMAIL'},
				{ data:'SUP_CIVIL'}
			],	
			
			columnDefs: [
				{ targets: [0,1,2,3], visible: true},
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
		
			$('#sup_rut').val(obj_row.SUP_RUT);
			$('#sup_rut').prop('disabled',true);
			$('#sup_nombres').val(obj_row.SUP_NOMBRES);
			$('#sup_paterno').val(obj_row.SUP_PATERNO);
			$('#sup_materno').val(obj_row.SUP_MATERNO);
			
			$('#sup_sexo').val(obj_row.SUP_SEXO).trigger('change');
			$('#sup_civil').val(obj_row.SUP_CIVIL).trigger('change');
			$('#sup_fechanac').data('daterangepicker').setStartDate(obj_row.SUP_FECHANAC);
			$('#sup_direccion').val(obj_row.SUP_DIRECCION);
			$('#sup_comuna').val(obj_row.CMN_CODIGO).trigger('change');
			$('#sup_fono').val(obj_row.SUP_FONO);
			$('#sup_email').val(obj_row.SUP_EMAIL);
			//$('#sup_area').val(obj_row.AREA_ID).trigger('change');	
			var array_competencias = obj_row.ID_AREAS_A_SUPERVISAR.split(',');
			$('#sup_area').val(array_competencias).trigger('change');
			$('#sup_estado').val(obj_row.SUP_ESTADO).trigger('change');
			
			$('#btn_reg_supervisor').hide();
			$('#btn_upd_supervisor').show();
			$('#btn_del_supervisor').show();
			$('#btn_can_supervisor').show();		
			
		});
	}
	
	$('#btn_can_supervisor').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_supervisor')[0].reset();

		$('#btn_reg_supervisor').show();
		$('#btn_upd_supervisor').hide();
		$('#btn_del_supervisor').hide();
		$('#btn_can_supervisor').hide();
		table.$('tr.selected').removeClass('selected');
		$('#sup_sexo').val('F').trigger('change');
		$('#sup_civil').val('SOLTERO').trigger('change');
		$('#sup_comuna').val('').trigger('change');
		$('#sup_area').val('').trigger('change');
		$('#sup_rut').prop('disabled',false);
		$('#sup_rut').focus();		
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

	$('#sup_rut').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=107 && e.which!=75 && (e.which<48 || e.which>57))return false;	
	});	
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	mayuscula('sup_rut');
	mayuscula('sup_nombres');
	mayuscula('sup_paterno');
	mayuscula('sup_materno');
	mayuscula('sup_direccion');
	mayuscula('sup_email');

	$('#sup_fechanac').daterangepicker({
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
			console.log(start)
			//console.log(start.toISOString(), end.toISOString(), label);
			var years = moment().diff(start, 'years');
			$('#sup_edad').html(years+' años')
	});
		
	
	$('#sup_sexo').select2({			
		allowClear: true
	});	

	$('#sup_civil').select2({			
		allowClear: true
	});	

	$('#sup_estado').select2({			
		allowClear: true
	});	
	
	carga_areas();
	function carga_areas(){
		var combobox = [];
		for(var i  = 0 ; i < data_areas.length; i++) {
			combobox.push({id:data_areas[i].area_id, text:data_areas[i].area_nombre});
		}	
		
		$('#sup_area').select2({			
			allowClear: true,
			placeholder: "SELECCIONA AREA(S)",
			data:combobox
		});			
	}	
	
	carga_comunas();
	function carga_comunas(){
		var combobox = [];
		for(var i  = 0 ; i < data_comunas.length; i++) {
			combobox.push({id:data_comunas[i].cmn_codigo, text:data_comunas[i].cmn_nombre});
		}	
		
		$('#sup_comuna').select2({			
			allowClear: true,	
			data:combobox
		});			
	}		
	
	function validar_supervisor(){
	
		var sup_rut = $.trim($('#sup_rut').val());
		var sup_nombres = $.trim($('#sup_nombres').val());		
		var sup_paterno = $.trim($('#sup_paterno').val());
		var sup_materno = $.trim($('#sup_materno').val());
		var sup_sexo = $.trim($('#sup_sexo').val());		
		var sup_civil = $.trim($('#sup_civil').val());
		var sup_fechanac = $.trim($('#sup_fechanac').val());
		var sup_direccion = $.trim($('#sup_direccion').val());		
		var cmn_codigo = $.trim($('#sup_comuna').val());		
		var sup_fono = $.trim($('#sup_fono').val());
		var sup_email = $.trim($('#sup_email').val());
		var sup_area = $.trim($('#sup_area').val());
		var sup_estado = $.trim($('#sup_estado').val());

	
		if(sup_rut == ''){
			sweet_alert('Error: Ingresar rut');	
			return false;
		}
		
		if(sup_nombres == ''){
			sweet_alert('Error: Ingresar nombres');	
			return false;
		}		

		if(sup_paterno == ''){
			sweet_alert('Error: Ingresar apellido paterno');	
			return false;
		}
		
		if(sup_materno == ''){
			sweet_alert('Error: Ingresar apellido materno');	
			return false;
		}		
		
		if(cmn_codigo == ''){
			sweet_alert('Error: Ingresar comuna');	
			return false;
		}
		
		if(sup_area == ''){
			sweet_alert('Error: Ingresar área(s) a supervisar');	
			return false;
		}		
						
		if(sup_nombres.length > 100){
			sweet_alert('Error: máximo 100 caracteres en nombres');	
			return false;
		}

		if(sup_paterno.length > 100){
			sweet_alert('Error: máximo 100 caracteres en apellido paterno');	
			return false;
		}		
		
		if(sup_materno.length > 100){
			sweet_alert('Error: máximo 100 caracteres en apellido materno');	
			return false;
		}

		if(sup_direccion.length > 250){
			sweet_alert('Error: máximo 250 caracteres en direccón');	
			return false;
		}			
		
		if(sup_fono.length > 100){
			sweet_alert('Error: máximo 100 caracteres en fono');	
			return false;
		}
		
		if(sup_email.length > 100){
			sweet_alert('Error: máximo 100 caracteres en email');	
			return false;
		}		
		
		if(!$.Rut.validar(sup_rut)){
			sweet_alert('Error: Rut inválido');	
			return false;		
		}		
		
		if(sup_email != '' && !validarEmail(sup_email)){
			sweet_alert('Error: formato de email inválido');	
			return false;		
		}		
		
		
		return true;
	}
		  
	$('#btn_reg_supervisor').click(function(){

		if (validar_supervisor()){	

			$('#loading').show();
			
			var sup_rut = $.trim($('#sup_rut').val());
			var sup_nombres = $.trim($('#sup_nombres').val());		
			var sup_paterno = $.trim($('#sup_paterno').val());
			var sup_materno = $.trim($('#sup_materno').val());
			var sup_sexo = $.trim($('#sup_sexo').val());		
			var sup_civil = $.trim($('#sup_civil').val());
			var sup_fechanac = $.trim($('#sup_fechanac').val());
			var sup_direccion = $.trim($('#sup_direccion').val());		
			var cmn_codigo = $.trim($('#sup_comuna').val());		
			var sup_fono = $.trim($('#sup_fono').val());
			var sup_email = $.trim($('#sup_email').val());
			var sup_area = $.trim($('#sup_area').val());
			var sup_estado = $.trim($('#sup_estado').val());
			
			var operacion = 'INSERT';
			parametros = {			
							sup_rut:sup_rut,
							sup_nombres:sup_nombres,
							sup_paterno:sup_paterno,
							sup_materno:sup_materno,
							sup_sexo:sup_sexo,
							sup_civil:sup_civil,
							sup_fechanac:sup_fechanac,
							sup_direccion:sup_direccion,
							cmn_codigo:cmn_codigo,
							sup_fono:sup_fono,
							sup_email:sup_email,
							sup_area:sup_area,
							sup_estado:sup_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_supervisores.php",
				   parametros,			   
				   function(resp){
						ges_crud_supervisores(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_supervisor').click(function(){
		if (validar_supervisor()){	

			$('#loading').show();
			
			var sup_rut = $.trim($('#sup_rut').val());
			var sup_nombres = $.trim($('#sup_nombres').val());		
			var sup_paterno = $.trim($('#sup_paterno').val());
			var sup_materno = $.trim($('#sup_materno').val());
			var sup_sexo = $.trim($('#sup_sexo').val());		
			var sup_civil = $.trim($('#sup_civil').val());
			var sup_fechanac = $.trim($('#sup_fechanac').val());
			var sup_direccion = $.trim($('#sup_direccion').val());		
			var cmn_codigo = $.trim($('#sup_comuna').val());		
			var sup_fono = $.trim($('#sup_fono').val());
			var sup_email = $.trim($('#sup_email').val());
			var sup_area = $.trim($('#sup_area').val());
			var sup_estado = $.trim($('#sup_estado').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							sup_rut:sup_rut,
							sup_nombres:sup_nombres,
							sup_paterno:sup_paterno,
							sup_materno:sup_materno,
							sup_sexo:sup_sexo,
							sup_civil:sup_civil,
							sup_fechanac:sup_fechanac,
							sup_direccion:sup_direccion,
							cmn_codigo:cmn_codigo,
							sup_fono:sup_fono,
							sup_email:sup_email,
							sup_area:sup_area,
							sup_estado:sup_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_supervisores.php",
				   parametros,			   
				   function(resp){
						ges_crud_supervisores(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_supervisor').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este supervisor?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var sup_rut = $.trim($('#sup_rut').val());
				var operacion = 'DELETE';
				parametros = {	
								sup_rut:sup_rut,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_supervisores.php",
					   parametros,			   
					   function(resp){
							ges_crud_supervisores(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_supervisores(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Supervisor registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Supervisor modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Supervisor eliminado", "success");
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