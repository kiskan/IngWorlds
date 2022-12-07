$(document).ready(function(){
		
	
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
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('usr_nombre');
	mayuscula('usr_email');	
	
	function validar_perfil(){
	
		var usr_nombre = $.trim($('#usr_nombre').val());
		var usr_clave = $.trim($('#usr_clave').val());	
		var usr_clave2 = $.trim($('#usr_clave2').val());
		var usr_email = $.trim($('#usr_email').val());
	
		if(usr_nombre == ''){
			sweet_alert('Error: Ingresar nombre');	
			return false;
		}

		if(usr_clave == ''){
			sweet_alert('Error: Ingresar contraseña');	
			return false;
		}
		
		if(usr_email == ''){
			sweet_alert('Error: Ingresar email');	
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
	
	
	$('#btn_upd_supxperfil').click(function(){

		if (validar_perfil()){	

			$('#loading').show();
			
			var usr_nombre = $.trim($('#usr_nombre').val());
			var usr_clave = $.trim($('#usr_clave').val());	
			var usr_email = $.trim($('#usr_email').val());		

			parametros = {			
							usr_nombre:usr_nombre,
							usr_clave:usr_clave,
							usr_email:usr_email,
							perfil:'update'
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_usuarios.php",
				   parametros,			   
				   function(resp){
						update_perfil(resp)
				   },"json"
			)
		}	
	})
	
	
	function update_perfil(resp){
		//console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			swal("Ing-Worlds", "Perfil actualizado!", "success");
		}else{
			var desc_error = resp['desc'];
			swal("Ing-Worlds", desc_error, "error");
		}
	}	
	
});