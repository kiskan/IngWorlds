
function clic_celda(e){
	console.log(e)
	if ($('#'+e.id).hasClass('cell_select')){
		$('#'+e.id).removeClass('cell_select');
	}else{
		$('#'+e.id).addClass('cell_select');
	}	
}

$(document).ready(function(){

	function carga_calendario(){
		per_agno = $('#per_agno').val();
		
		parametros = {			
						per_agno:per_agno,
						load_calendario:'cargar calendario'
					 }
					console.log(parametros)
		$.post(
			   "consultas/ges_crud_diasnoprod.php",
			   parametros,			   
			   function(resp){
					calendario(resp)
			   },"json"
		)		
		
	}
	
	function calendario(resp){
		console.log(resp)
		$('#calendario').html('')
		$('#calendario').append(resp.tabla);
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
		$('#per_agno').val(year_current).trigger('change');
		carga_calendario();
	}
	

	$('#per_agno').change(function() {	
		carga_calendario();
		
	})	
	
	$('#btn_actdias').click(function(){
		fechas_inhabiles = '';
		i = 0;
		$('.cell_select').each( function() {
			if(i==0){
				fechas_inhabiles = this.id;
			}else{
				fechas_inhabiles = fechas_inhabiles + ',' + this.id;
			}
			i++;				
		})
		
		parametros = {			
						per_agno:per_agno,
						fechas_inhabiles:fechas_inhabiles,
						update_diasnoprod:'acualizacion fechas inhabiles'
					 }
					console.log(parametros)
		$.post(
			   "consultas/ges_crud_diasnoprod.php",
			   parametros,			   
			   function(resp){
					ges_crud_diasnoprod(resp)
			   },"json"
		)
	})
	
	function ges_crud_diasnoprod(resp){
		console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			swal("Sisconvi-Production", "Días No Productivos actualizados", "success");

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}			
});