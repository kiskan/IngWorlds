$(document).ready(function(){
	
	
	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
	}		
		
	
	var table;	

	function crear_tabla(per_agno, sem_num, sprod_dia){
		//console.log(plan_dia)
		table = $('#datatable-scroll').DataTable( {
			ajax: "consultas/cons_tcompra.php?per_agno="+per_agno+"&sem_num="+sem_num+"&sprod_dia="+sprod_dia,
			deferRender:    true,
			scrollY:        500,
			scrollX:        true,
			scrollCollapse: true,
			//scroller:       true,
			//bProcessing: 	true,
			paging: false,			
			
			order:[],
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'SPROD_DIA'},
				
				{ data:'SPROD_ID'},
				{ data:'SOLICITANTE'},
				
				{ data:'CATPROD_NOMBRE'},
				{ data:'PROD_SERV'},
				
				{ data:'COTCOM_CANTIDAD'},
				{ data:'COTCOM_PRECIO'},
				{ data:'COTCOM_PROVEEDOR'},
				{ data:'SPROD_MOTIVO'},
				
				{ data:'SPROD_DIASYSTEM'},
				{ data:'SPRODD_DFINCOTIZ'},
				{ data:'SPRODD_TCOTIZACION'},				
				{ data:'SPRODD_TCOTDIAS'},

				{ data:'SPRODD_DSOLICSAP'},
				{ data:'SPRODD_TSAP'},	
				{ data:'SPRODD_TSAPDIAS'},

				{ data:'SPRODD_DREGSAP'},
				{ data:'SPRODD_TLIBERACION'},
				{ data:'SPRODD_TLIBDIAS'},

				{ data:'SPRODD_DREGHES'},
				{ data:'SPRODD_TLLEGADA'},
				{ data:'SPRODD_THESDIAS'},
				
				{ data:'SPRODD_TIEMPOTOTAL'},
				{ data:'SPRODD_TTOTDIAS'}
			],		
			
			columnDefs: [
				//{ targets: [0,1,2,3,4,5,6,7,8,9,11,12,14,15,17,18,20], visible: true},
				//{ targets: '_all', visible: false }	
				{ targets: [10], visible: false},
				{ targets: '_all', visible: true }
				
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
	
	//CHANGE SEMANA
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();
		clear_combobox('sprod_dia',1);
		
		if(sem_num != ''){
			parametros = {			
				agno:per_agno,
				sem_num_extra:sem_num
			}		
			
			$.post(
				"consultas/ges_crud_periodo.php",
				parametros,			   
				function(resp){
					carga_dias(resp)
				},"json"
			)		
		}
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
	

	
	
	
//CLICK CONSULTAR

	function busqueda_solic(){
		//$('#loading').show();

		var per_agno = $.trim($('#per_agno').val());
		var sem_num = $.trim($('#sem_num').val());		
		var sprod_dia = $.trim($('#sprod_dia').val());		

		if(typeof table != 'undefined') table.destroy();
		
		//console.log(sprod_id +'--'+ solicitante +'--'+ per_agno +'--'+ sem_num +'--'+ sprod_dia +'--'+ UNDVIV_ID )
		
		crear_tabla(per_agno, sem_num, sprod_dia)			
	}
	
	$('#btn_cons_solicitudes').click(function(){
		busqueda_solic();
	})	
	
});