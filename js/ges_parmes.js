$(document).ready(function(){
	$('#form_parmes').hide();
	var table;
	
	function crear_tabla(){
	
		per_agno = $('#per_agno').val()
		table = $("#datatable-responsive").DataTable({
			columnDefs: [
				{ targets: [1,2,3,4,5,6], visible: true},
				{ targets: '_all', visible: false }			
			],	  
			ajax: "consultas/ges_crud_parmes.php?per_agno="+per_agno,
			bPaginate:false,
			bProcessing: true,
			columns: [
				{ data:'per_mes'},
				{ data:'per_agno'},
				{ data:'nom_mes'},
				{ data:'meta_mini'},
				{ data:'meta_pino'},
				{ data:'meta_macro'},
				{ data:'num_setos'}
			],

			searching:true,
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
			
			$('#form_parmes').show();
			var obj_row = table.row(this).data();	
			meta_mini = obj_row.meta_mini
			meta_mini = meta_mini.replace('.','');

			meta_pino = obj_row.meta_pino
			meta_pino = meta_pino.replace('.','');
			
			meta_macro = obj_row.meta_macro
			meta_macro = meta_macro.replace('.','');

			num_setos = obj_row.num_setos
			num_setos = num_setos.replace('.','');			
			
			$('#per_mes').val(obj_row.per_mes).trigger('change');
			$('#meta_mini').val(meta_mini);
			$('#meta_pino').val(meta_pino);
			$('#meta_macro').val(meta_macro);
			$('#num_setos').val(num_setos);
	
			$('#per_mes').select2({	});
			
		});
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
	
	$('#meta_mini').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#meta_mini').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});
	
	$('#meta_pino').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#meta_pino').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});
	
	$('#meta_macro').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#meta_macro').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	
	$('#num_setos').keypress(function(e){
		if(e.which!=8 && e.which!=0 && e.which!=44 && (e.which<48 || e.which>57))return false;	
		cantidad = $('#num_setos').val();
		if(e.which==44 && cantidad.search( ',' ) != -1)return false;			
	});	
	
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
		crear_tabla();
	}
	
	//$('#per_mes').select2({	});
	//$('#per_mes').val(month_current).trigger('change');
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}	
	
	

	$('#per_agno').change(function() {	
		$('#form_parmes').hide();
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		crear_tabla();
		
	})	
	
	$('#btn_modmeta').click(function(){
		per_agno = $('#per_agno').val();
		per_mes = $('#per_mes').val();
		meta_mini = $('#meta_mini').val();
		meta_pino = $('#meta_pino').val();
		meta_macro = $('#meta_macro').val();
		num_setos = $('#num_setos').val();
		chk_mini = ($("#chk_mini").is(":checked"))?'S':'N';
		chk_pino = ($("#chk_pino").is(":checked"))?'S':'N';
		chk_macro = ($("#chk_macro").is(":checked"))?'S':'N';
		chk_setos = ($("#chk_setos").is(":checked"))?'S':'N';
		
		meta_mini = meta_mini.replace(',','.');
		meta_pino = meta_pino.replace(',','.');
		meta_macro = meta_macro.replace(',','.');
		num_setos = num_setos.replace(',','.');
		
		if(meta_mini == '' || meta_pino == '' || meta_macro == ''){
			sweet_alert('Error: Ingresar todas las metas');	
		}
		else{
	
			parametros = {			
							per_agno:per_agno,
							per_mes:per_mes,
							meta_mini:meta_mini,
							meta_pino:meta_pino,
							meta_macro:meta_macro,
							num_setos:num_setos,
							chk_mini:chk_mini,
							chk_pino:chk_pino,
							chk_macro:chk_macro,
							chk_setos:chk_setos
						 }		
			$.post(
				   "consultas/ges_crud_parmes.php",
				   parametros,			   
				   function(resp){
						ges_crud_parmes(resp)
				   },"json"
			)	
		}
	})
	
	function ges_crud_parmes(resp){
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){

			swal("Sisconvi-Production", "Parámetros actualizados", "success");
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();

		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}			
});