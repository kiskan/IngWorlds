$(document).ready(function(){

	$('#pactiv_nombre').focus();
	
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
				{ targets: [2,3,4], visible: true},
				{ targets: '_all', visible: false }			
			],	 
			ajax: "consultas/ges_crud_pactividades.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'sfactiv_id'},
				{ data:'pactiv_id'},
				{ data:'factiv_nombre'},
				{ data:'sfactiv_nombre'},
				{ data:'pactiv_nombre'}
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
			$('#pactiv_id').val(obj_row.pactiv_id);
			$('#sfactiv_id').val(obj_row.sfactiv_id).trigger('change');
			$('#pactiv_nombre').val(obj_row.pactiv_nombre);

			$('#btn_reg_pactiv').hide();
			$('#btn_upd_pactiv').show();
			$('#btn_del_pactiv').show();
			$('#btn_can_pactiv').show();		
			
		});
	}
	
	$('#btn_can_pactiv').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_pactiv')[0].reset();
		$('#btn_reg_pactiv').show();
		$('#btn_upd_pactiv').hide();
		$('#btn_del_pactiv').hide();
		$('#btn_can_pactiv').hide();
		table.$('tr.selected').removeClass('selected');
		$('#sfactiv_id').val('').trigger('change');
		$('#pactiv_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('pactiv_nombre');	

	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 3 segundos.",
			type: "error", 
			timer: 3000,
			showConfirmButton: false
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
	
	
	function validar_pactiv(){
		var sfactiv_id = $.trim($('#sfactiv_id').val());
		var pactiv_nombre = $.trim($('#pactiv_nombre').val());

		if(sfactiv_id == ''){
			sweet_alert('Error: Seleccionar subfamilia actividad');	
			return false;
		}
		
		if(pactiv_nombre == ''){
			sweet_alert('Error: Ingresar actividad padre');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_pactiv').click(function(){

		if (validar_pactiv()){	

			$('#loading').show();
			
			var sfactiv_id = $.trim($('#sfactiv_id').val());
			var pactiv_nombre = $.trim($('#pactiv_nombre').val());
			
			var operacion = 'INSERT';
			parametros = {
							sfactiv_id:sfactiv_id,
							pactiv_nombre:pactiv_nombre,
							operacion:operacion
						 }	
			console.log(parametros)				
			$.post(
				   "consultas/ges_crud_pactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_pactividades(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_pactiv').click(function(){
		if (validar_pactiv()){	

			$('#loading').show();
			var sfactiv_id = $.trim($('#sfactiv_id').val());
			var pactiv_id = $.trim($('#pactiv_id').val());
			var pactiv_nombre = $.trim($('#pactiv_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							sfactiv_id:sfactiv_id,
							pactiv_id:pactiv_id,
							pactiv_nombre:pactiv_nombre,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_pactividades.php",
				   parametros,			   
				   function(resp){
						ges_crud_pactividades(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_pactiv').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta actividad Padre?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var pactiv_id = $.trim($('#pactiv_id').val());
				var operacion = 'DELETE';
				parametros = {	
								pactiv_id:pactiv_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_pactividades.php",
					   parametros,			   
					   function(resp){
							ges_crud_pactividades(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_pactividades(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Actividad padre registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Actividad padre modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Actividad padre eliminada", "success");
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