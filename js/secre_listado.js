$(document).ready(function(){

	var table;
	var table2;

	crear_tabla(corresponding_week,corresponding_agno,date_current);
	function crear_tabla(num_sem, per_agno, fecha){
		//console.log(num_sem);console.log(per_agno);console.log(fecha);
		table = $("#datatable-scroll").DataTable({
			ajax: "consultas/ges_datos_secrexlistado-guardia.php?num_sem="+num_sem+"&per_agno="+per_agno+"&fecha="+fecha,
			deferRender:    true,
			scrollY:        200,
			scrollX:        true,
			scrollCollapse: true,
			//scroller:       true,
			//bProcessing: 	true,
			paging: false,
			order:[],
			columns: [
				{ data:'RUT'},
				{ data:'DV'},
				{ data:'COD_PERSONA'},
				{ data:'NOMBRES'},
				{ data:'APELLIDOS'},
				{ data:'TELEFONO'},
				{ data:'CELULAR'},				
				{ data:'ANEXO'},			
				{ data:'EMAIL'},				
				{ data:'COD_EMPRESA'},			
				{ data:'COD_AREA'},
				{ data:'COD_PLANTA'},
				{ data:'EXTRANJERO'},			
				{ data:'TARJETA'},
				{ data:'PERSONAL_PLANTA'},
				{ data:'COD_ZONA_TRABAJO'},
				{ data:'PERSONAL_PROVEEDOR'},
				{ data:'COD_PROVEEDOR'},
				{ data:'VISITA'},
				{ data:'PERSONAL_CONTRATISTA'}
							
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
			}
		});
	}
	
	
	crear_tabla2(corresponding_week,corresponding_agno,date_current);
	function crear_tabla2(num_sem, per_agno, fecha){
		table2 = $("#datatable-scroll-2").DataTable({
			ajax: "consultas/ges_datos_secrexlistado.php?num_sem="+num_sem+"&per_agno="+per_agno+"&fecha="+fecha,
			deferRender:    true,
			scrollY:        200,
			scrollX:        true,
			scrollCollapse: true,
			//scroller:       true,
			//bProcessing: 	true,
			paging: false,
			order:[],
			columns: [
				{ data:'RUT'},
				{ data:'OPERADOR'},
				{ data:'AREA'},
				{ data:'ACTIVIDAD'},
				{ data:'COMUNA'},
				{ data:'JEFE_GRUPO'},
				{ data:'ASIGNADOR'},				
				{ data:'FECHA'},			
				{ data:'DIA'},	
				{ data:'TIPO_JORNADA'},				
				{ data:'HORAS'},			
				{ data:'DIRECCION'},
				{ data:'TIPO_JEFEGRUPO'},
				{ data:'FONO_JEFEGRUPO'}	
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
			}
		});
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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
	
	$('#per_agno').change(function() {
	
		change_agno()
		
	});
	
	function change_agno(){
		var per_agno = $('#per_agno').val();

		parametros = {			
			per_agno:per_agno
		}	
		//console.log(parametros)
		clear_combobox('sem_num',0);
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
		
		//table.destroy();		
		change_sem_num();
	}

	function clear_combobox(id,i){
		while($('#'+id+' option').length > i) $('#'+id+' option').eq(i).remove();	 
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
		change_sem_num();	
	}
	
	
	$('#sem_num').change(function() {

		//table.destroy();
		change_sem_num();

	});
	
	function change_sem_num(){
		var per_agno = $('#per_agno').val();
		var sem_num = $('#sem_num').val();

		parametros = {			
			agno:per_agno,
			sem_num_extra:sem_num
		}		
		clear_combobox('plan_dia',1);
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

		$('#plan_dia').select2({			
			data:combobox
		});			
		
		var sem_num = $('#sem_num').val();
		var per_agno = $('#per_agno').val();
		
		if(sem_num == corresponding_week){
			$('#plan_dia').val(date_current).trigger('change');
		}		
		
		//var fecha_dia = $("#plan_dia").val();
		//crear_tabla(sem_num,per_agno,fecha_dia);

	}	
		

	
		
//CLICK CONSULTAR

	$('#btn_secre_listado').click(function(){
		table.destroy();
		table2.destroy();
		
		var per_agno = $('#per_agno').val();	
		var sem_num = $('#sem_num').val();
		var plan_dia = $('#plan_dia').val();
		crear_tabla(sem_num,per_agno,plan_dia);
		crear_tabla2(sem_num,per_agno,plan_dia);
	})

	

	

	
	
});