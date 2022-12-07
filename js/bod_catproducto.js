$(document).ready(function(){

	$('#catprod_nombre').focus();
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
			columnDefs: [
				{ targets: [1], visible: true},
				{ targets: '_all', visible: false }			
			],	 
			ajax: "consultas/bod_crud_catproducto.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'catprod_id'},
				{ data:'catprod_nombre'}
			],

			searching:true,
			dom: "Bfrtip",
			
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
			$('#catprod_id').val(obj_row.catprod_id);
			$('#catprod_nombre').val(obj_row.catprod_nombre);

			$('#btn_reg_categoria').hide();
			$('#btn_upd_categoria').show();
			$('#btn_del_categoria').show();
			$('#btn_can_categoria').show();		
			
		});
	}
	
	$('#btn_can_categoria').click(function(){
		cancelar();
	})
	
	function cancelar(){/*
		$('#catprod_id').val('');
		$('#catprod_nombre').val('');*/
		$('#form_categoria')[0].reset();
		$('#btn_reg_categoria').show();
		$('#btn_upd_categoria').hide();
		$('#btn_del_categoria').hide();
		$('#btn_can_categoria').hide();
		table.$('tr.selected').removeClass('selected');

		$('#catprod_nombre').focus();		
	}
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('catprod_nombre');	
	
	function validar_categoria(){
		var catprod_nombre = $.trim($('#catprod_nombre').val());
		if(catprod_nombre == ''){
			swal({ 
				title: "Error: Ingresar Categoria",
				text: "Se cerrará en 3 segundos.",
				type: "error", 
				timer: 3000,
				showConfirmButton: false 
			});			
			
			return false;
		}
		return true;
	}
	  
	$('#btn_reg_categoria').click(function(){

		if (validar_categoria()){	

			$('#loading').show();
			
			var catprod_nombre = $.trim($('#catprod_nombre').val());
			var operacion = 'INSERT';
			parametros = {			
							catprod_nombre:catprod_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/bod_crud_catproducto.php",
				   parametros,			   
				   function(resp){
						bod_crud_catproducto(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_categoria').click(function(){
		if (validar_categoria()){	

			$('#loading').show();
			var catprod_id = $.trim($('#catprod_id').val());
			var catprod_nombre = $.trim($('#catprod_nombre').val());
			var operacion = 'UPDATE';
			parametros = {	
							catprod_id:catprod_id,
							catprod_nombre:catprod_nombre,
							operacion:operacion
						 }		
			$.post(
				   "consultas/bod_crud_catproducto.php",
				   parametros,			   
				   function(resp){
						bod_crud_catproducto(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_categoria').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta categoría?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var catprod_id = $.trim($('#catprod_id').val());
				var operacion = 'DELETE';
				parametros = {	
								catprod_id:catprod_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/bod_crud_catproducto.php",
					   parametros,			   
					   function(resp){
							bod_crud_catproducto(resp)
					   },"json"
				)
		});	
		
	})		
	
	function bod_crud_catproducto(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Categoría registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Categoría modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Categoría eliminada", "success");
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