$(document).ready(function(){

	$('#pactiv_id').select2({	});	

	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
			
			
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
				{ targets: [4,5,6,7,8], visible: true},
				{ targets: '_all', visible: false }			
			],	 
			ajax: "consultas/ges_crud_clasactividades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'sfactiv_id'},
				{ data:'pactiv_id'},
				{ data:'activ_id'},
				{ data:'tactiv_id'},
				{ data:'factiv_nombre'},
				{ data:'sfactiv_nombre'},
				{ data:'pactiv_nombre'},
				{ data:'tactiv_nombre'},
				{ data:'activ_nombre'}						
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
			$('#h_tactiv_id').val(obj_row.tactiv_id);
			$('#h_pactiv_id').val(obj_row.pactiv_id);
			$('#h_activ_id').val(obj_row.activ_id);
			
			$('#sfactiv_id').val(obj_row.sfactiv_id).trigger('change');
			//$('#activ_id').val(obj_row.activ_id).trigger('change');
			$('#tactiv_id').val(obj_row.tactiv_id).trigger('change');

			var array_actividades = obj_row.activ_id.split(',');
			//console.log(array_actividades)
			$('#activ_id').val(array_actividades).trigger('change');

			$('#btn_reg_cactiv').hide();
			$('#btn_upd_cactiv').show();
			$('#btn_del_cactiv').show();
			$('#btn_can_cactiv').show();		
			
		});
	}
	
	$('#btn_can_cactiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_cactiv')[0].reset();
		$('#btn_reg_cactiv').show();
		$('#btn_upd_cactiv').hide();
		$('#btn_del_cactiv').hide();
		$('#btn_can_cactiv').hide();
		table.$('tr.selected').removeClass('selected');
		$('#sfactiv_id').val('').trigger('change');
		$('#activ_id').val('').trigger('change');
		$('#tactiv_id').val('').trigger('change');
		clear_combobox('pactiv_id',1);
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
	
	
	carga_activ();
	function carga_activ(){
		var combobox = [];

		for(var i  = 0 ; i < data_areasyactividades.length; i++) {

			activ = [];
			for(var j  = 0 ; j < data_areasyactividades[i].activ.length; j++) {
				activ.push({id:data_areasyactividades[i].activ[j].activ_id, text:data_areasyactividades[i].activ[j].activ_nombre});
			}
			combobox.push({id:data_areasyactividades[i].area_id, text:data_areasyactividades[i].area_nombre, children: activ});
		}	
		
		$('#activ_id').select2({			
			data:combobox
		});			
	}
	

	carga_tipoactividades();
	function carga_tipoactividades(){
		var combobox = [];
		for(var i  = 0 ; i < data_tipoactividades.length; i++) {
			combobox.push({id:data_tipoactividades[i].tactiv_id, text:data_tipoactividades[i].tactiv_nombre});
		}	
		
		$('#tactiv_id').select2({			
			data:combobox
		});			
	}	
	
	
	carga_subfam();
	function carga_subfam(){
		var combobox = [];

		for(var i  = 0 ; i < data_sfamactividades.length; i++) {

			subfam = [];
			for(var j  = 0 ; j < data_sfamactividades[i].subfam.length; j++) {
				subfam.push({id:data_sfamactividades[i].subfam[j].sfactiv_id, text:data_sfamactividades[i].subfam[j].sfactiv_nombre});
			}
			combobox.push({id:data_sfamactividades[i].factiv_id, text:data_sfamactividades[i].factiv_nombre, children: subfam});
		}	
		
		$('#sfactiv_id').select2({			
			data:combobox
		});			
	}	
	
	
	$('#sfactiv_id').change(function() {

		var sfactiv_id = $('#sfactiv_id').val();

		if(sfactiv_id == ""){
			clear_combobox('pactiv_id',1);
		}
		else{
			parametros = {			
				subactiv_id:sfactiv_id
			}		
			clear_combobox('pactiv_id',1);
			$.post(
				"consultas/ges_crud_pactividades.php",
				parametros,			   
				function(resp){
					carga_actividadespadre(resp)
				},"json"
				)	
		}

	});

	function carga_actividadespadre(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].pactiv_id, text:resp[i].pactiv_nombre});
		}	
		
		$('#pactiv_id').select2({			
			data:combobox
		})
		pactiv_selected = $('#h_pactiv_id').val();
		
		if($("#pactiv_id option[value='"+pactiv_selected+"']").length > 0)
			$('#pactiv_id').val(pactiv_selected).trigger('change');
		else
			$('#pactiv_id').val('').trigger('change');		
		
	}	
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}	
	
	
	
	function validar_cactiv(){
		var sfactiv_id = $.trim($('#sfactiv_id').val());
		var pactiv_id = $.trim($('#pactiv_id').val());
		var activ_id = $.trim($('#activ_id').val());
		var tactiv_id = $.trim($('#tactiv_id').val());

		if(sfactiv_id == ''){
			sweet_alert('Error: Seleccionar subfamilia actividad');	
			return false;
		}
		
		if(pactiv_id == ''){
			sweet_alert('Error: Seleccionar actividad padre');	
			return false;
		}		

		if(activ_id == ''){
			sweet_alert('Error: Seleccionar actividad(es)');	
			return false;
		}
		
		if(tactiv_id == ''){
			sweet_alert('Error: Seleccionar tipo actividad');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_cactiv').click(function(){

		if (validar_cactiv()){	

			$('#loading').show();
			
			var pactiv_id = $.trim($('#pactiv_id').val());
			var activ_id = $.trim($('#activ_id').val());
			var tactiv_id = $.trim($('#tactiv_id').val());
			
			var operacion = 'INSERT';
			parametros = {
							pactiv_id:pactiv_id,
							activ_id:activ_id,
							tactiv_id:tactiv_id,
							operacion:operacion
						 }	
			console.log(parametros)				
			$.post(
				   "consultas/ges_crud_clasactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_clasactividades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_cactiv').click(function(){
		if (validar_cactiv()){	

			$('#loading').show();
			var pactiv_id = $.trim($('#pactiv_id').val());
			var activ_id = $.trim($('#activ_id').val());
			var tactiv_id = $.trim($('#tactiv_id').val());
			
			var h_pactiv_id = $.trim($('#h_pactiv_id').val());
			var h_tactiv_id = $.trim($('#h_tactiv_id').val());
			var h_activ_id = $.trim($('#h_activ_id').val());			
			
			var operacion = 'UPDATE';
			parametros = {
							pactiv_id:pactiv_id,
							activ_id:activ_id,
							tactiv_id:tactiv_id,
							h_pactiv_id:h_pactiv_id,
							h_tactiv_id:h_tactiv_id,
							h_activ_id:h_activ_id,							
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_clasactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_clasactividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_cactiv').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta Clasificación actividad?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_pactiv_id = $.trim($('#h_pactiv_id').val());
				var h_tactiv_id = $.trim($('#h_tactiv_id').val());
				var h_activ_id = $.trim($('#h_activ_id').val());	
				var operacion = 'DELETE';
				parametros = {	
								h_pactiv_id:h_pactiv_id,
								h_tactiv_id:h_tactiv_id,
								h_activ_id:h_activ_id,	
								operacion:operacion
							 }	
				console.log(parametros)
				$.post(
					   "consultas/ges_crud_clasactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_clasactividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_clasactividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Clasificación actividad registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Clasificación actividad modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Clasificación actividad eliminada", "success");
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