$(document).ready(function(){
	
	$('#login_rut').Rut({
	  on_error: function(){ sweet_alert('Error: Rut inválido'); },
	  format_on: 'keyup' 
	});

	$('#login_rut').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=107 && e.which!=75 && (e.which<48 || e.which>57))return false;	
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

	function validar_login(){
	
		var login_rut = $.trim($('#login_rut').val());	
	
		if(login_rut == ''){
			sweet_alert('Error: Ingresar rut');	
			return false;
		}			
		if(!$.Rut.validar(login_rut)){
			sweet_alert('Error: Rut inválido');	
			return false;		
		}					
		
		return true;
	}	
	
	
	$('#btn_login').click(function(){

		if (validar_login()){	

			$('#loading').show();
			
			var login_rut = $.trim($('#login_rut').val());			

			parametros = {			
							login_rut:login_rut,
							recuperar_clave:'consulta'
						 }	

			$.post(
				   "consultas/read_login.php",
				   parametros,			   
				   function(resp){
						read_login(resp)
				   },"json"
			)
		}	
	})
	
	
	function read_login(resp){
		//console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			swal("Ing-Worlds", 'La clave fue enviada a su email', "success");
		}else{
			var desc_error = resp['desc'];
			swal("Ing-Worlds", desc_error, "error");
		}
	}	
	
});