$(document).ready(function(){
	
	$("#usr_tipo").select2({
		allowClear: true
	});
	
	$("#usr_estado").select2({
		allowClear: true
	});
	
	$('#usr_nombre').focus();
	
	crear_tabla();
	
	var table;
	
	function crear_tabla(){
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_usuarios.php?data=a",
			//bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'USR_ID'},
				{ data:'USR_NOMBRE'},
				{ mData:'USR_RUT'},
				{ mData:'USR_CLAVE'},
				{ mData:'USR_SEXO'},
				{ mData:'USR_EMAIL'},
				{ mData:'USR_TIPO'},
				{ mData:'USR_ESTADO'}				
			],
			columnDefs: [
				{ targets: [0,4], visible: false},
				{ targets: '_all', visible: true }			
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
			$('#usr_id').val(obj_row.USR_ID);
			$('#usr_nombre').val(obj_row.USR_NOMBRE);
			$('#usr_rut').val(obj_row.USR_RUT);
			$('#usr_clave').val(obj_row.USR_CLAVE);
			$('#usr_clave2').val(obj_row.USR_CLAVE);
			$('#usr_clave_h').val(obj_row.USR_CLAVE);
			$('#usr_sexo').val(obj_row.USR_SEXO).trigger('change');
			$('#usr_email').val(obj_row.USR_EMAIL);
			$('#usr_tipo').val(obj_row.USR_TIPO).trigger('change');
			$('#usr_tipo_h').val(obj_row.USR_TIPO);
			$('#usr_estado').val(obj_row.USR_ESTADO).trigger('change');
			$('#usr_rut').prop('disabled',true);

			$('#btn_reg_usuario').hide();
			$('#btn_upd_usuario').show();
			$('#btn_del_usuario').show();
			$('#btn_can_usuario').show();		
			
		});
	}
	
	$('#btn_can_usuario').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_usuario')[0].reset();
		$('#btn_reg_usuario').show();
		$('#btn_upd_usuario').hide();
		$('#btn_del_usuario').hide();
		$('#btn_can_usuario').hide();
		table.$('tr.selected').removeClass('selected');
		$('#usr_rut').prop('disabled',false);
		$('#usr_tipo').val('SUPERVISOR').trigger('change');
		$('#usr_estado').val('ACTIVO').trigger('change');		
		$('#usr_nombre').focus();		
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

	$('#usr_rut').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=107 && e.which!=75 && (e.which<48 || e.which>57))return false;
	});	

	$('#usr_rut').Rut({
		on_error: function(){ sweet_alert('Error: Rut inválido'); },
		format_on: 'keyup' 
	});	
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('usr_rut');
	mayuscula('usr_nombre');
	mayuscula('usr_email');
	
	function validar_usuario(){
		var usr_nombre = $.trim($('#usr_nombre').val());
		var usr_rut = $.trim($('#usr_rut').val());
		var usr_clave = $.trim($('#usr_clave').val());
		var usr_clave2 = $.trim($('#usr_clave2').val());
		var usr_sexo = $.trim($('#usr_sexo').val());
		var usr_email = $.trim($('#usr_email').val());
		var usr_tipo = $.trim($('#usr_tipo').val());
		var usr_estado = $.trim($('#usr_estado').val());
	
		if(usr_nombre == ''){
			sweet_alert('Error: Ingresar nombre');	
			return false;
		}
		
		if(usr_rut == ''){
			sweet_alert('Error: Ingresar username');	
			return false;
		}		

		if(usr_clave == ''){
			sweet_alert('Error: Ingresar contraseña');	
			return false;
		}

		if(usr_sexo == ''){
			sweet_alert('Error: Ingresar sexo del usuario');	
			return false;
		}		
		
		if(usr_email == ''){
			sweet_alert('Error: Ingresar email');	
			return false;
		}		
		
		if(usr_tipo == ''){
			sweet_alert('Error: Ingresar tipo usuario');	
			return false;
		}
		
		if(usr_estado == ''){
			sweet_alert('Error: Ingresar estado usuario');	
			return false;
		}		

		if(!$.Rut.validar(usr_rut)){
			sweet_alert('Error: username(RUT) inválido');	
			return false;		
		}		
		
		if(usr_nombre.length > 100){
			sweet_alert('Error: máximo 100 caracteres en Nombre');	
			return false;
		}
		
		if(usr_clave.length < 5){
			sweet_alert('Error: mínimo 5 caracteres en Clave');	
			return false;
		}		

		if(usr_clave != usr_clave2){
			sweet_alert('Error: Las claves no coinciden');	
			return false;
		}		
		
		if(!validarEmail(usr_email)){
			sweet_alert('Error: formato de email inválido');	
			return false;		
		}
	
		return true;
	}
		  
	$('#btn_reg_usuario').click(function(){

		if (validar_usuario()){	

			$('#loading').show();
			
			var usr_nombre = $.trim($('#usr_nombre').val());
			var usr_rut = $.trim($('#usr_rut').val());
			var usr_clave = $.trim($('#usr_clave').val());
			var usr_sexo = $.trim($('#usr_sexo').val());
			var usr_email = $.trim($('#usr_email').val());
			var usr_tipo = $.trim($('#usr_tipo').val());
			var usr_estado = $.trim($('#usr_estado').val());
			
			var operacion = 'INSERT';
			parametros = {			
							usr_nombre:usr_nombre,
							usr_rut:usr_rut,
							usr_clave:usr_clave,
							usr_sexo:usr_sexo,
							usr_email:usr_email,
							usr_tipo:usr_tipo,
							usr_estado:usr_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_usuarios.php",
				   parametros,			   
				   function(resp){
						ges_crud_usuarios(resp)
				   },"json"
			)
		}		
	})	
	
 	$('#btn_upd_usuario').click(function(){
		if (validar_usuario()){	

			$('#loading').show();
			
			var usr_nombre = $.trim($('#usr_nombre').val());
			var usr_rut = $.trim($('#usr_rut').val());
			var usr_clave = $.trim($('#usr_clave').val());
			var usr_clave_h = $.trim($('#usr_clave_h').val());
			var usr_id = $.trim($('#usr_id').val());
			var usr_sexo = $.trim($('#usr_sexo').val());
			var usr_email = $.trim($('#usr_email').val());
			var usr_tipo = $.trim($('#usr_tipo').val());
			var usr_tipo_h = $.trim($('#usr_tipo_h').val());
			var usr_estado = $.trim($('#usr_estado').val());
			var operacion = 'UPDATE';
			parametros = {	
							usr_id:usr_id,
							usr_nombre:usr_nombre,
							usr_rut:usr_rut,
							usr_clave:usr_clave,
							usr_clave_h:usr_clave_h,
							usr_sexo:usr_sexo,
							usr_email:usr_email,
							usr_tipo:usr_tipo,
							usr_tipo_h:usr_tipo_h,
							usr_estado:usr_estado,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_usuarios.php",
				   parametros,			   
				   function(resp){
						ges_crud_usuarios(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_usuario').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este usuario?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				//var usr_rut = $.trim($('#usr_rut').val());
				//var usr_clave_h = $.trim($('#usr_clave_h').val());
				var usr_id = $.trim($('#usr_id').val());
				var operacion = 'DELETE';
				parametros = {	
								usr_id:usr_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_usuarios.php",
					   parametros,			   
					   function(resp){
							ges_crud_usuarios(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_usuarios(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Usuario registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Usuario modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Usuario eliminado", "success");
			}	
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();
			//table.ajax.reload(null, false);
			//table.fnAdjustColumnSizing();
			//new $.fn.dataTable.FixedHeader( table );

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});