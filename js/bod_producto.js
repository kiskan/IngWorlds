$(document).ready(function(){
	
	$('#prod_cod').focus();
	
	$('#prod_stockmin').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;			
	});	

	$('#prod_valor').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;			
	});		
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	mayuscula('prod_cod');	
	mayuscula('prod_nombre');	
	mayuscula('prod_unidad');	
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
			table = $("#datatable-responsive").DataTable({
		
			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_productos.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'CATPROD_ID'},
				{ data:'PROD_COD'},
				{ data:'PROD_NOMBRE'},	
				{ data:'CATPROD_NOMBRE'},				
				{ data:'PROD_UNIDAD'},
				{ data:'PROD_STOCKMIN'},
				{ data:'PROD_VALOR'},
				{ data:'SAP_COD'},
				{ data:'SAP_NOMBRE'}
			],	

			columnDefs: [
				{ targets: [1,2/*,3,4,5,6*/,7,8], visible: true},
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
				"sSortAscending":  ": operar para ordenar la columna de manera ascendente",
				"sSortDescending": ": operar para ordenar la columna de manera descendente"
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
			/*
			$('#prod_cod').val(obj_row.PROD_COD);
			$('#h_prod_cod').val(obj_row.PROD_COD);
			$('#prod_nombre').val(obj_row.PROD_NOMBRE);
			*/
			$('#prod_cod').val(obj_row.SAP_COD);
			$('#h_prod_cod').val(obj_row.PROD_COD);
			$('#prod_nombre').val(obj_row.SAP_NOMBRE);			
			
			$('#catprod_id').val(obj_row.CATPROD_ID).trigger('change');
			$('#prod_stockmin').val(obj_row.PROD_STOCKMIN);
			$('#prod_unidad').val(obj_row.PROD_UNIDAD);
			$('#prod_valor').val(obj_row.PROD_VALOR);
			
			$('#btn_reg_prod').hide();
			$('#btn_upd_prod').show();
			$('#btn_del_prod').show();
			$('#btn_can_prod').show();		
			
		});
	}
	
	$('#btn_can_prod').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_prod')[0].reset();

		$('#btn_reg_prod').show();
		$('#btn_upd_prod').hide();
		$('#btn_del_prod').hide();
		$('#btn_can_prod').hide();
		table.$('tr.selected').removeClass('selected');
		$('#catprod_id').val('').trigger('change');
		$('#prod_cod').focus();		
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

	
	
	carga_categorias();
	function carga_categorias(){
		var combobox = [];
		for(var i  = 0 ; i < data_categorias.length; i++) {
			combobox.push({id:data_categorias[i].catprod_id, text:data_categorias[i].catprod_nombre});
		}	
		
		$('#catprod_id').select2({			
			allowClear: true,	
			data:combobox
		});			
	}		
	
	function validar_prod(){
	
		var prod_cod = $.trim($('#prod_cod').val());
		var prod_nombre = $.trim($('#prod_nombre').val());		
		var catprod_id = $.trim($('#catprod_id').val());
		var prod_valor = $.trim($('#prod_valor').val());
	
		if(prod_cod == ''){
			sweet_alert('Error: Ingresar código del producto');	
			return false;
		}
		
		if(prod_nombre == ''){
			sweet_alert('Error: Ingresar nombre del producto');	
			return false;
		}		
/*
		if(catprod_id == ''){
			sweet_alert('Error: Ingresar categoría del producto');	
			return false;
		}
		
		if(prod_valor == ''){
			sweet_alert('Error: Ingresar valor del producto');	
			return false;
		}		
*/								
		return true;
	}
			  
	$('#btn_reg_prod').click(function(){

		if (validar_prod()){	

			$('#loading').show();
			
			var prod_cod = $.trim($('#prod_cod').val());
			var prod_nombre = $.trim($('#prod_nombre').val());		
			var catprod_id = $.trim($('#catprod_id').val());		
			var prod_stockmin = $.trim($('#prod_stockmin').val());		
			var prod_unidad = $.trim($('#prod_unidad').val());
			var prod_valor = $.trim($('#prod_valor').val());

			var operacion = 'INSERT';
			parametros = {			
							prod_cod:prod_cod,
							prod_nombre:prod_nombre,
							catprod_id:catprod_id,
							prod_stockmin:prod_stockmin,
							prod_unidad:prod_unidad,
							prod_valor:prod_valor,
							operacion:operacion
						 }		
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_productos.php",
				   parametros,			   
				   function(resp){
						bod_crud_productos(resp)
				   },"json"
			)
		}	
	})	

 	$('#btn_upd_prod').click(function(){
		if (validar_prod()){	

			$('#loading').show();
			
			var prod_cod = $.trim($('#prod_cod').val());
			var h_prod_cod = $.trim($('#h_prod_cod').val());
			var prod_nombre = $.trim($('#prod_nombre').val());		
			var catprod_id = $.trim($('#catprod_id').val());		
			var prod_stockmin = $.trim($('#prod_stockmin').val());		
			var prod_unidad = $.trim($('#prod_unidad').val());
			var prod_valor = $.trim($('#prod_valor').val());
			
			var operacion = 'UPDATE';
			parametros = {	
							prod_cod:prod_cod,
							h_prod_cod:h_prod_cod,
							prod_nombre:prod_nombre,
							catprod_id:catprod_id,
							prod_stockmin:prod_stockmin,
							prod_unidad:prod_unidad,
							prod_valor:prod_valor,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_productos.php",
				   parametros,			   
				   function(resp){
						bod_crud_productos(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_prod').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este producto?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_prod_cod = $.trim($('#h_prod_cod').val());
				var operacion = 'DELETE';
				parametros = {	
								h_prod_cod:h_prod_cod,
								operacion:operacion
							 }		
				$.post(
					   "consultas/bod_crud_productos.php",
					   parametros,			   
					   function(resp){
							bod_crud_productos(resp)
					   },"json"
				)
		});	
		
	})		
	
	function bod_crud_productos(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Producto registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Producto modificado", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Producto eliminado", "success");
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