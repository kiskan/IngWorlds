$(document).ready(function(){

	$("#prod_cod").select2({
		allowClear: true
	});	
	
	$('#prod_stock').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});		

	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/bod_crud_stock.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'CATPROD_ID'},
				{ data:'CATPROD_NOMBRE'},
				{ data:'PROD_COD'},
				{ data:'PROD_NOMBRE'},						
				{ data:'PROD_STOCK'},
				{ data:'PROD_STOCKMIN'},
				{ data:'PROD_UNIDAD'},
				{ data:'PROD_VALOR'}
			],	
			
			columnDefs: [
				{ targets: [1,2,3,4,5,7], visible: true},
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
				"sSortAscending":  ": supar para ordenar la columna de manera ascendente",
				"sSortDescending": ": supar para ordenar la columna de manera descendente"
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
			$('#h_prod_cod').val(obj_row.PROD_COD);
			$('#catprod_id').val(obj_row.CATPROD_ID).trigger('change');
			$('#prod_cod').val(obj_row.PROD_COD).trigger('change');
			$('#prod_stock').val(obj_row.PROD_STOCK);
				
			$('#btn_reg_stock').hide();
			$('#btn_upd_stock').show();
			$('#btn_del_stock').show();
			$('#btn_can_stock').show();		
			
		});
	}
	
	$('#btn_can_stock').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_stock')[0].reset();

		$('#btn_reg_stock').show();
		$('#btn_upd_stock').hide();
		$('#btn_del_stock').hide();
		$('#btn_can_stock').hide();
		table.$('tr.selected').removeClass('selected');
		$('#catprod_id').val('').trigger('change');
		clear_combobox('prod_cod',1);	
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

	
	$('#catprod_id').change(function() {

		var catprod_id = $('#catprod_id').val();
		
		if(catprod_id == ""){
			clear_combobox('prod_cod',1);
		}
		else{
			parametros = {			
				catprod_id:catprod_id
			}		
			clear_combobox('prod_cod',1);
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					carga_productos(resp)
				},"json"
				)	
		}

	});

	function carga_productos(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].PROD_COD, text:resp[i].PROD_NOMBRE});
		}	
		
		$('#prod_cod').select2({			
			data:combobox
		})
		prod_selected = $('#h_prod_cod').val();
		$('#prod_cod').val(prod_selected).trigger('change');		
	}

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}



	
	
	function validar_stock(){

		var catprod_id = $.trim($('#catprod_id').val());
		var prod_cod = $.trim($('#prod_cod').val());
		var prod_stock = $.trim($('#prod_stock').val());
		
		
		if(catprod_id == ''){
			sweet_alert('Error: Seleccionar categoría');	
			return false;
		}
		
		if(prod_cod == ''){
			sweet_alert('Error: Seleccionar producto');	
			return false;
		}		

		if(prod_stock == ''){
			sweet_alert('Error: Ingresar stock');	
			return false;
		}
		
		return true;
	}
		  
	$('#btn_reg_stock').click(function(){

		if (validar_stock()){	

			$('#loading').show();

			var prod_cod = $.trim($('#prod_cod').val());
			var prod_stock = $.trim($('#prod_stock').val());
			
			var operacion = 'INSERT';
			parametros = {			
							prod_cod:prod_cod,
							prod_stock:prod_stock,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/bod_crud_stock.php",
				   parametros,			   
				   function(resp){
						bod_crud_stock(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_stock').click(function(){
		if (validar_stock()){	

			$('#loading').show();
			
			var h_prod_cod = $.trim($('#h_prod_cod').val());
			var prod_cod = $.trim($('#prod_cod').val());
			var prod_stock = $.trim($('#prod_stock').val());
			
			var operacion = 'UPDATE';
			parametros = {
							h_prod_cod:h_prod_cod,
							prod_cod:prod_cod,
							prod_stock:prod_stock,
							operacion:operacion
						 }		
			$.post(
				   "consultas/bod_crud_stock.php",
				   parametros,			   
				   function(resp){
						bod_crud_stock(resp)
				   },"json"
			)
			
			return false;		
		}
	})		
/*
 	$('#btn_del_stock').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar este?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var met_id = $.trim($('#met_id').val());
				var operacion = 'DELETE';
				parametros = {	
								met_id:met_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/bod_crud_stock.php",
					   parametros,			   
					   function(resp){
							bod_crud_stock(resp)
					   },"json"
				)
		});	
		
	})		
*/	
	function bod_crud_stock(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Stock registrado", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Stock modificado", "success");
			}/*else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Stock eliminado", "success");
			}*/			
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}	
	
	
});