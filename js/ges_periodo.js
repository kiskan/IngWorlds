$(document).ready(function(){

	$('#ges_periodo').click(function(){
	
	swal({
		title: "Apertura Período",
		text: "Ingrese nuevo año",
		imageUrl: "images/calendario.png",
		type: "input",
		inputPlaceholder: "ingrese año de apertura",
		//inputValue: "2018",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
		}, 
		function (inputValue) {
			if (inputValue === false) return false;
			if (inputValue === "") {
				swal.showInputError("Favor ingresar período de aperura!");
				return false
			}
			if (!/^([0-9])*$/.test(inputValue) || inputValue.length != 4){
				swal.showInputError("Formato de año incorrecto!");
				return false
			}
			var operacion = 'INSERT';
			parametros = {			
							periodo:inputValue,
							operacion:operacion
						 }			
			$.post(
				   "consultas/ges_crud_periodo.php",
				   parametros,			   
				   function(resp){
						var cod_resp = resp['cod'];
						if(cod_resp == 'ok'){
							swal("Apertura de período!", "AÑO: " + inputValue, "success");
						}else{
							var error = resp['desc'];
							swal.showInputError(error);
							return false						
						}
				   },"json"
			)			
			
			//swal("Apertura de período!", "AÑO: " + inputValue, "success");
		});	
	
	})
	
});