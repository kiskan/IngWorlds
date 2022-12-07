$(document).ready(function(){

	$('#clon_id').focus();
	
	$("#clon_especie").select2({
		allowClear: true
	});

	$("#clon_estado").select2({
		allowClear: true
	});	
	
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
				//{ targets: [1], visible: true},
				{ targets: '_all', visible: true }			
			],	 
			ajax: "consultas/ges_crud_clones.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'clon_id'},
				{ data:'clon_especie'},
				{ data:'clon_estado'}
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
			$('#clon_id').val(obj_row.clon_id);
			$('#hclon_id').val(obj_row.clon_id);
			$('#clon_especie').val(obj_row.clon_especie).trigger('change');
			$('#clon_estado').val(obj_row.clon_estado).trigger('change');

			$('#btn_reg_clon').hide();
			$('#btn_upd_clon').show();
			$('#btn_del_clon').show();
			$('#btn_can_clon').show();		
			
		});
	}
	
	$('#btn_can_clon').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_clon')[0].reset();
		$('#btn_reg_clon').show();
		$('#btn_upd_clon').hide();
		$('#btn_del_clon').hide();
		$('#btn_can_clon').hide();
		table.$('tr.selected').removeClass('selected');

		$('#clon_id').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('clon_id');	
	
	function validar_clon(){
		var clon_id = $.trim($('#clon_id').val());
		if(clon_id == ''){
			swal({ 
				title: "Error: Ingresar clon",
				text: "Se cerrará en 3 segundos.",
				type: "error", 
				timer: 3000,
				showConfirmButton: false 
			});			
			
			return false;
		}
		return true;
	}
	  
	$('#btn_reg_clon').click(function(){

		if (validar_clon()){	

			$('#loading').show();
			
			var clon_id = $.trim($('#clon_id').val());
			var clon_especie = $.trim($('#clon_especie').val());
			var clon_estado = $.trim($('#clon_estado').val());
			var operacion = 'INSERT';
			parametros = {			
							clon_id:clon_id,
							clon_especie:clon_especie,
							clon_estado:clon_estado,
							operacion:operacion
						 }	
			
			$.post(
				   "consultas/ges_crud_clones.php",
				   parametros,			   
				   function(resp){
						ges_crud_clones(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_clon').click(function(){
		if (validar_clon()){	

			$('#loading').show();
			var clon_id = $.trim($('#clon_id').val());
			var hclon_id = $.trim($('#hclon_id').val());
			var clon_especie = $.trim($('#clon_especie').val());
			var clon_estado = $.trim($('#clon_estado').val());
			var operacion = 'UPDATE';
			parametros = {	
							clon_id:clon_id,
							hclon_id:hclon_id,
							clon_especie:clon_especie,
							clon_estado:clon_estado,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_clones.php",
				   parametros,			   
				   function(resp){
						ges_crud_clones(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_clon').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este clon?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var hclon_id = $.trim($('#hclon_id').val());
				var operacion = 'DELETE';
				parametros = {	
								hclon_id:hclon_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_clones.php",
					   parametros,			   
					   function(resp){
							ges_crud_clones(resp)
					   },"json"
				)
		});	
		
	})		
	
	function ges_crud_clones(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "clon registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "clon modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "clon eliminado", "success");
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