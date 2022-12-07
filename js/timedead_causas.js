$(document).ready(function(){

	$('#ctiempo_cod').focus();

	$('#ctiempo_cod').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;			
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
				{ targets: [0,2,3], visible: true },
				{ targets: '_all', visible: false },
				{ width: '20%', targets: 0 }
			],	 
			ajax: "consultas/time_crud_causas.php?data=a",
			bPaginate:true,
			bProcessing: true,
			columns: [
				{ data:'ctiempo_cod'},
				{ data:'undviv_id'},
				{ data:'undviv_nombre'},
				{ data:'ctiempo_causa'}
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

			$('#h_ctiempo_cod').val(obj_row.ctiempo_cod);
			$('#ctiempo_cod').val(obj_row.ctiempo_cod);
			$('#undviv_id').val(obj_row.undviv_id).trigger('change');
			$('#ctiempo_causa').val(obj_row.ctiempo_causa);

			$('#btn_reg_ctiempo').hide();
			$('#btn_upd_ctiempo').show();
			$('#btn_del_ctiempo').show();
			$('#btn_can_ctiempo').show();
			
			$('#ctiempo_cod').focus();
		});
	}
	
	
	//UNID VIVEROS
	carga_unidviv();
	function carga_unidviv(){
		var combobox = [];
		for(var i  = 0 ; i < data_unidviv.length; i++) {
			combobox.push({id:data_unidviv[i].undviv_id, text:data_unidviv[i].undviv_nombre});
		}	
		
		$('#undviv_id').select2({			
			data:combobox
		});		
		
	}	
	
	$('#btn_can_ctiempo').click(function(){
		cancelar();
	})
	
	function cancelar(){
		$('#form_ctiempo')[0].reset();
		$('#btn_reg_ctiempo').show();
		$('#btn_upd_ctiempo').hide();
		$('#btn_del_ctiempo').hide();
		$('#btn_can_ctiempo').hide();
		$('#undviv_id').val('').trigger('change');
		table.$('tr.selected').removeClass('selected');

		$('#ctiempo_cod').focus();		
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
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('ctiempo_causa');	
	
	function validar_ctiempo(){
		var ctiempo_cod = $.trim($('#ctiempo_cod').val());
		var undviv_id = $.trim($('#undviv_id').val());
		var ctiempo_causa = $.trim($('#ctiempo_causa').val());

		if(ctiempo_cod == ''){
			sweet_alert('Error: Ingresar código causa');	
			return false;
		}	
		
		if(undviv_id == ''){
			sweet_alert('Error: Seleccionar unidad vivero');	
			return false;
		}		
		
		if(ctiempo_causa == ''){
			sweet_alert('Error: Ingresar causa');	
			return false;
		}		

		return true;
	}
	  
	$('#btn_reg_ctiempo').click(function(){

		if (validar_ctiempo()){	

			$('#loading').show();
			
			var ctiempo_cod = $.trim($('#ctiempo_cod').val());
			var undviv_id = $.trim($('#undviv_id').val());
			var ctiempo_causa = $.trim($('#ctiempo_causa').val());
			var operacion = 'INSERT';
			parametros = {			
							ctiempo_cod:ctiempo_cod,
							undviv_id:undviv_id,
							ctiempo_causa:ctiempo_causa,
							operacion:operacion
						 }		
			$.post(
				   "consultas/time_crud_causas.php",
				   parametros,			   
				   function(resp){
						time_crud_causas(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	
	
 	$('#btn_upd_ctiempo').click(function(){
		if (validar_ctiempo()){	

			$('#loading').show();
			var h_ctiempo_cod = $.trim($('#h_ctiempo_cod').val());
			var ctiempo_cod = $.trim($('#ctiempo_cod').val());
			var undviv_id = $.trim($('#undviv_id').val());
			var ctiempo_causa = $.trim($('#ctiempo_causa').val());
			var operacion = 'UPDATE';
			parametros = {	
							h_ctiempo_cod:h_ctiempo_cod,
							ctiempo_cod:ctiempo_cod,
							undviv_id:undviv_id,
							ctiempo_causa:ctiempo_causa,
							operacion:operacion
						 }
			console.log(parametros)
			$.post(
				   "consultas/time_crud_causas.php",
				   parametros,			   
				   function(resp){
						time_crud_causas(resp)
				   },"json"
			)
			
			return false;		
		}
	})		

 	$('#btn_del_ctiempo').click(function(){

		swal({   
			title: "¿Seguro que deseas eliminar esta causa?",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var h_ctiempo_cod = $.trim($('#h_ctiempo_cod').val());
				var operacion = 'DELETE';
				parametros = {	
								h_ctiempo_cod:h_ctiempo_cod,
								operacion:operacion
							 }		
				$.post(
					   "consultas/time_crud_causas.php",
					   parametros,			   
					   function(resp){
							time_crud_causas(resp)
					   },"json"
				)
		});	
		
	})		
	
	function time_crud_causas(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();
			
			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Causa registrada", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Causa modificada", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Causa eliminada", "success");
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