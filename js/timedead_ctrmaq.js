$(document).ready(function(){
	
	$('#ctrmaq_disphr').select2({	});

	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('ctrmaq_nombre');
	
	var table;
	crear_tabla();
	function crear_tabla(){
	
		table = $("#datatable-responsive").DataTable({
	
			responsive: true,
			order:[],
			ajax: "consultas/time_crud_ctrmaq.php?data=a",
			bProcessing: true,
			columns: [
				{ data:'LIN_NOMBRE'},	
				{ data:'CTRMAQ_NOMBRE'},
				{ data:'CTRMAQ_DISPHR'},
				{ data:'CTRMAQ_REND', sType: "numeric-comma"},
				{ data:'LIN_ID'},		
				{ data:'CTRMAQ_ID'}
			],	
			
			columnDefs: [
				{ targets: [0,1,2,3], visible: true},
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

			$('#ctrmaq_id').val(obj_row.CTRMAQ_ID);

			$('#lin_id').val(obj_row.LIN_ID).trigger('change');			
			$('#ctrmaq_nombre').val(obj_row.CTRMAQ_NOMBRE);
			$('#ctrmaq_disphr').val(obj_row.CTRMAQ_DISPHR).trigger('change');
			$('#ctrmaq_rend').val(obj_row.CTRMAQ_REND);
				
			$('#btn_reg_ctrmaq').hide();
			$('#btn_upd_ctrmaq').show();
			$('#btn_del_ctrmaq').show();
			$('#btn_can_ctrmaq').show();		
			
		});
	}
	
	$('#btn_can_ctrmaq').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_ctrmaq')[0].reset();

		$('#btn_reg_ctrmaq').show();
		$('#btn_upd_ctrmaq').hide();
		$('#btn_del_ctrmaq').hide();
		$('#btn_can_ctrmaq').hide();
		table.$('tr.selected').removeClass('selected');
		$('#lin_id').val('').trigger('change');

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


	$('#ctrmaq_rend').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		meta = $("#ctrmaq_rend").val();
		if(e.which==44 && meta.search( ',' ) != -1)return false;			
	});	


	carga_lineas();
	function carga_lineas(){
		var combobox = [];
		for(var i  = 0 ; i < data_lineas.length; i++) {
			combobox.push({id:data_lineas[i].lin_id, text:data_lineas[i].lin_nombre});
		}	
		
		$('#lin_id').select2({			
			allowClear: true,
			data:combobox
		});			
	}	

	
	function validar_ctrmaq(){

		var lin_id = $.trim($('#lin_id').val());		
		var ctrmaq_nombre = $.trim($('#ctrmaq_nombre').val());
		var ctrmaq_disphr = $.trim($('#ctrmaq_disphr').val());
		var ctrmaq_rend = $.trim($('#ctrmaq_rend').val());
		
		if(lin_id == ''){
			sweet_alert('Error: Seleccionar línea productiva');	
			return false;
		}		

		if(ctrmaq_nombre == ''){
			sweet_alert('Error: Ingresar nombre máquina');	
			return false;
		}
		
		if(ctrmaq_disphr == ''){
			sweet_alert('Error: Seleccionar disponibilidad');	
			return false;
		}		

		if(ctrmaq_rend == ''){
			sweet_alert('Error: Ingresar rendimiento');	
			return false;
		}
		
		return true;
	}
		  
	$('#btn_reg_ctrmaq').click(function(){

		if (validar_ctrmaq()){	

			$('#loading').show();
			
			var lin_id = $.trim($('#lin_id').val());		
			var ctrmaq_nombre = $.trim($('#ctrmaq_nombre').val());
			var ctrmaq_disphr = $.trim($('#ctrmaq_disphr').val());
			var ctrmaq_rend = $.trim($('#ctrmaq_rend').val());
			
			var operacion = 'INSERT';
			parametros = {			
							lin_id:lin_id,
							ctrmaq_nombre:ctrmaq_nombre,
							ctrmaq_disphr:ctrmaq_disphr,
							ctrmaq_rend:ctrmaq_rend,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/time_crud_ctrmaq.php",
				   parametros,			   
				   function(resp){
						time_crud_ctrmaq(resp)
				   },"json"
			)
		}	
	})	
	
 	$('#btn_upd_ctrmaq').click(function(){
		if (validar_ctrmaq()){	

			$('#loading').show();
			
			var ctrmaq_id = $.trim($('#ctrmaq_id').val());
			var lin_id = $.trim($('#lin_id').val());		
			var ctrmaq_nombre = $.trim($('#ctrmaq_nombre').val());
			var ctrmaq_disphr = $.trim($('#ctrmaq_disphr').val());
			var ctrmaq_rend = $.trim($('#ctrmaq_rend').val());
			
			var operacion = 'UPDATE';
			parametros = {
							ctrmaq_id:ctrmaq_id,
							lin_id:lin_id,
							ctrmaq_nombre:ctrmaq_nombre,
							ctrmaq_disphr:ctrmaq_disphr,
							ctrmaq_rend:ctrmaq_rend,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/time_crud_ctrmaq.php",
				   parametros,			   
				   function(resp){
						time_crud_ctrmaq(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_ctrmaq').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta máquina?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var ctrmaq_id = $.trim($('#ctrmaq_id').val());
				var operacion = 'DELETE';
				parametros = {	
								ctrmaq_id:ctrmaq_id,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_ctrmaq.php",
					   parametros,			   
					   function(resp){
							time_crud_ctrmaq(resp)
					   },"json"
				)
		});	
		
	})		
	
	function time_crud_ctrmaq(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		//console.log(resp)
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Máquina registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Máquina modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Máquina eliminada", "success");
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