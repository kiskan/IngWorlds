$(document).ready(function(){

	$('#sprod_id').keypress(function(e){
		if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))return false;
	});	
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}		
	
	$('#sprod_estado').select2({	});	
	$('#prod_cod').select2({	});	
	
	
	var table;	

	function crear_tabla(sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario, prod_cod, /*catprod_id,*/ sprod_estado){
		//console.log(plan_dia)
		table = $('#datatable-scroll').DataTable( {
			ajax: "consultas/cons_solprod.php?totales=ok&sprod_id="+sprod_id+"&solicitante="+solicitante+"&per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia+"&UNDVIV_ID="+UNDVIV_ID+"&destinatario="+destinatario+"&prod_cod="+prod_cod/*+"&catprod_id="+catprod_id*/+"&sprod_estado="+sprod_estado,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			//scroller:       true,
			//bProcessing: 	true,
			paging: false,
			
			columnDefs: [			
				{ targets: [12,13], visible: false },
				{ targets: '_all', visible: true}			
			],			
			
			order:[],
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},								
				{ data:'SPROD_ID'},
				{ data:'SPROD_ESTADO'},
				{ data:'UNDVIV_NOMBRE'},	
				{ data:'SOLICITANTE'},
				{ data:'SPRODR_ESTADO'},
				{ data:'PROD_NOMBRE'},
				{ data:'SAP_NOMBRE'},
				{ data:'SPRODD_CANT'},	
				{ data:'SPRODR_CANT'},
				{ data:'PROD_VALOR'},
				{ data:'COSTO_TOTAL'},	
				{ data:'DESTINATARIO'},
				{ data:'FECHA_ENTREGA'},
				{ data:'FECHA_RENTREGA'},
				{ data:'QUIEN_RETIRA'},
				{ data:'COMENTARIO'}
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
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			  }
			},

			fnInitComplete: function(oSettings, json) {
			  $('#loading').hide();
			}			
		} );	

	}

//CARGA INICIAL 

	carga_periodos();
	function carga_periodos(){
		var combobox = [];
		for(var i  = 0 ; i < data_periodos.length; i++) {
			combobox.push({id:data_periodos[i].PER_AGNO, text:data_periodos[i].PER_AGNO});
		}	
		
		$('#per_agno').select2({			
			data:combobox
		});	
		
		$('#per_agno').val(corresponding_agno).trigger('change');

	}
	
	$('#per_agno').change(function() { 	change_agno()	});

	
	function change_agno(){
		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		
		clear_combobox('sem_num',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_semanas(resp)
			},"json"
		)		
	}
	
	function carga_semanas(resp){
		
		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].SEM_NUM, text:resp[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		})
		
		//cancelar();
		change_sem_num();
	}
	
	carga_semanas_ini();
	function carga_semanas_ini(){
		var combobox = [];
		for(var i  = 0 ; i < data_semanas.length; i++) {
			combobox.push({id:data_semanas[i].SEM_NUM, text:data_semanas[i].SEMANAS});
		}	
		
		$('#sem_num').select2({			
			data:combobox
		});	
		

		$('#sem_num').val(corresponding_week).trigger('change');
		busqueda_solic();
		change_sem_num();	

	}	
	
	$('#sem_num').change(function() {
		//cancelar();
		change_sem_num();
	});	
	
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('sprod_dia',1);
		$.post(
			"consultas/ges_crud_periodo.php",
			parametros,			   
			function(resp){
				carga_dias(resp)
			},"json"
		)		
	}	
	
	function carga_dias(resp){

		var combobox = [];
		for(var i  = 0 ; i < resp.length; i++) {
			combobox.push({id:resp[i].DIA, text:resp[i].DIA_TEXT});
		}	

		$('#sprod_dia').select2({			
			data:combobox
		});	

		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
/*
		if(sem_num == corresponding_week && year_current == per_agno){
			$('#sprod_dia').val(date_current).trigger('change');
		}		
*/
	}	
	
	//LOAD UNIDADES
	carga_unidades();
	function carga_unidades(){
	//console.log(data_viveros)
		var combobox = [];
		for(var i  = 0 ; i < data_viveros.length; i++) {
			combobox.push({id:data_viveros[i].undviv_id, text:data_viveros[i].undviv_nombre});
		}		
		
		$('#UNDVIV_ID').select2({			
			data:combobox
		});			
		
	}	
	
	//LOAD DESTINATARIOS
	carga_destinatarios();
	function carga_destinatarios(){
		var combobox = [];
		for(var i  = 0 ; i < data_destinatarios.length; i++) {
			combobox.push({id:data_destinatarios[i].ID_DEST, text:data_destinatarios[i].DESTINATARIO});
		}	
		
		$('#sprod_id_dest').select2({			
			allowClear: true,	
			data:combobox
		});				
		
	}		
	
	//LOAD SOLICITANTES
	carga_solicitantes();
	function carga_solicitantes(){
		var combobox = [];
		for(var i  = 0 ; i < data_solicitantes.length; i++) {
			combobox.push({id:data_solicitantes[i].USR_ID, text:data_solicitantes[i].USR_NOMBRE});
		}	
		
		$('#usr_id_solic').select2({			
			data:combobox
		});					
	}		
	
	//LOAD CATEGORIAS
	/*
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
	
	//CHANGE CATEGORIA
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

	}	
	*/
	
	//LOAD PRODUCTOS - SAP
	carga_productos_sap();
	function carga_productos_sap(){
		var combobox = [];
		for(var i  = 0 ; i < data_sap.length; i++) {
			combobox.push({id:data_sap[i].sap_cod, text:data_sap[i].sap_nombre});
		}	
		
		$('#sap_cod').select2({	
			data:combobox
		});			
	}

	//LOAD PRODUCTOS - SISCONVI
	carga_productos_sisconvi();
	function carga_productos_sisconvi(){
		var combobox = [];
		for(var i  = 0 ; i < data_productos.length; i++) {
			combobox.push({id:data_productos[i].prod_cod, text:data_productos[i].prod_nombre});
		}	
		
		$('#prod_cod').select2({	
			data:combobox
		});			
	}

	//CHANGE PRODUCTOS - SAP
	$('#sap_cod').change(function(event) {

		var sap_cod = $('#sap_cod').val();
		
		if(sap_cod == ""){
			$('#prod_cod').val(sap_cod).trigger('change.select2');
		}
		else{
			parametros = {	
				carga_sap_id:'carga',
				sap_cod:sap_cod
			}		
			console.log(parametros)
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					console.log(resp)
					prod_cod = resp['prod_cod'];				
					$('#prod_cod').val(prod_cod).trigger('change.select2');
				},"json"
				)	
		}

	});
	
	//CHANGE PRODUCTOS - SISCONVI
	$('#prod_cod').change(function(event) {

		var prod_cod = $('#prod_cod').val();
		
		if(prod_cod == ""){
			$('#sap_cod').val(prod_cod).trigger('change.select2');
		}
		else{
			parametros = {	
				carga_prod_id:'carga',
				prod_cod:prod_cod
			}		
			console.log(parametros)
			$.post(
				"consultas/bod_crud_productos.php",
				parametros,			   
				function(resp){
					console.log(resp)
					sap_cod = resp['sap_cod'];
					$('#sap_cod').val(sap_cod).trigger('change.select2');
				},"json"
				)	
		}

	});		
	
	
	
	
//CLICK CONSULTAR

	function busqueda_solic(){
		$('#loading').show();

		var sprod_id = $.trim($('#sprod_id').val());
		var solicitante = $.trim($('#usr_id_solic').val());
		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());		
		var UNDVIV_ID = $.trim($('#UNDVIV_ID').val());
		var destinatario = $.trim($('#sprod_id_dest').val());
		var sprod_estado = $.trim($('#sprod_estado').val());
		
		var prod_cod = $.trim($('#prod_cod').val());
		//var catprod_id = $.trim($('#catprod_id').val());

		if(typeof table != 'undefined') table.destroy();
		
		console.log(sprod_id +'--'+ solicitante +'--'+ per_agno +'--'+ sem_num +'--'+ sprod_dia +'--'+ UNDVIV_ID +'--'+ destinatario)
		
		crear_tabla( sprod_id, solicitante, per_agno, sem_num, sprod_dia, UNDVIV_ID, destinatario, prod_cod, /*catprod_id,*/ sprod_estado)			
	}
	
	$('#btn_cons_solicitudes').click(function(){
		busqueda_solic();
	})	
	
});