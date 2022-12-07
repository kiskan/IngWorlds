$(document).ready(function(){

	var table;	
	
	function crear_tabla(){
		
		per_agno = $('#per_agno').val()
		
		table = $("#datatable-responsive").DataTable({

			responsive: true,
			order:[],
			ajax: "consultas/ges_crud_secrexresp.php?per_agno="+per_agno,
			bProcessing: true,
			columns: [
				{ data:'PER_AGNO'},
				{ data:'SEM_NUM'},
				{ data:'RESP_PROD'},
				{ data:'RESP_PRODXFONO'},
				{ data:'BRIGAD_SAB'},
				{ data:'BRIGAD_SABXFONO'},
				{ data:'BRIGAD_DOM'},
				{ data:'BRIGAD_DOMXFONO'},				
				{ data:'RESP_MAN1'},
				{ data:'RESP_MANXFONO1'},
				{ data:'RESP_MAN2'},
				{ data:'RESP_MANXFONO2'}			
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
			
			$('#sem_num').val(obj_row.SEM_NUM).trigger('change');
			
			$('#RESP_PROD').val(obj_row.RESP_PROD);
			$('#RESP_PRODXFONO').val(obj_row.RESP_PRODXFONO);
			$('#BRIGAD_SAB').val(obj_row.BRIGAD_SAB);
			$('#BRIGAD_SABXFONO').val(obj_row.BRIGAD_SABXFONO);
			$('#BRIGAD_DOM').val(obj_row.BRIGAD_DOM);
			$('#BRIGAD_DOMXFONO').val(obj_row.BRIGAD_DOMXFONO);
			$('#RESP_MAN1').val(obj_row.RESP_MAN1);
			$('#RESP_MANXFONO1').val(obj_row.RESP_MANXFONO1);
			$('#RESP_MAN2').val(obj_row.RESP_MAN2);
			$('#RESP_MANXFONO2').val(obj_row.RESP_MANXFONO2);			
			
			$('#per_agno').prop('disabled',true);
			$('#sem_num').prop('disabled',true);

			$('#btn_reg_resp').hide();
			$('#btn_upd_resp').show();
			$('#btn_del_resp').show();
			$('#btn_can_resp').show();			
		});
	}
	
	
	function sweet_alert(txt_error){
		swal({ 
			title: txt_error,
			text: "Se cerrará en 3 segundos.",
			type: "error", 
			timer: 3000,
			showConfirmButton: true 
		});			
	}	
	

	function cancelar(){

		//$('#hora_tope').val('').trigger('change');
		
		$('#per_agno').prop('disabled',false);
		$('#sem_num').prop('disabled',false);
		
		$('#RESP_PROD').val('');$('#RESP_PRODXFONO').val('');		
		$('#BRIGAD_SAB').val('');$('#BRIGAD_SABXFONO').val('');		
		$('#BRIGAD_DOM').val('');$('#BRIGAD_DOMXFONO').val('');
		$('#RESP_MAN1').val('');$('#RESP_MANXFONO1').val('');		
		$('#RESP_MAN2').val('');$('#RESP_MANXFONO2').val('');		
		
		$('#chk_tope').prop('checked',false);
		
		$('#btn_reg_resp').show();
		$('#btn_upd_resp').hide();
		$('#btn_del_resp').hide();
		$('#btn_can_resp').hide();
		table.$('tr.selected').removeClass('selected');		
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
		crear_tabla();		
	}
	
	$('#per_agno').change(function() {
	
		change_agno()
		$('#datatable-responsive tbody').unbind( "click" );
		table.destroy();
		crear_tabla();		
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
	}
	
	
	function mayuscula(id){
		$('#'+id).on('input', function(evt) {
			$(this).val(function (_, val) {
			return val.toUpperCase();
		  });
		});		
	}
	
	mayuscula('RESP_PROD');mayuscula('BRIGAD_SAB');mayuscula('BRIGAD_DOM');
	mayuscula('RESP_MAN1');mayuscula('RESP_MAN2');
	
	
	function validar_resp(){
		var RESP_PROD = $('#RESP_PROD').val();
		var RESP_PRODXFONO = $('#RESP_PRODXFONO').val();		
		var BRIGAD_SAB = $('#BRIGAD_SAB').val();
		var BRIGAD_SABXFONO = $('#BRIGAD_SABXFONO').val();	
		var BRIGAD_DOM = $('#BRIGAD_DOM').val();
		var BRIGAD_DOMXFONO = $('#BRIGAD_DOMXFONO').val();
		var RESP_MAN1 = $('#RESP_MAN1').val();
		var RESP_MANXFONO1 = $('#RESP_MANXFONO1').val();	
		var RESP_MAN2 = $('#RESP_MAN2').val();
		var RESP_MANXFONO2 = $('#RESP_MANXFONO2').val();		
		
		if(RESP_PROD == ''){
			sweet_alert('Error: Ingresar Responsable Producción');	
			return false;
		}
		
		if(RESP_PRODXFONO == ''){
			sweet_alert('Error: Ingresar celular del Responsable Producción');	
			return false;
		}	
		
		if(BRIGAD_SAB == '' && BRIGAD_DOM == ''){
			sweet_alert('Error: Ingresar Brigadista');	
			return false;
		}
		
		if(BRIGAD_SAB != '' && BRIGAD_SABXFONO == ''){
			sweet_alert('Error: Ingresar celular del Brigadista Turno Sábado');	
			return false;
		}		
		
		if(BRIGAD_SAB == '' && BRIGAD_SABXFONO != ''){
			sweet_alert('Error: Ingresar Brigadista Turno Sábado');	
			return false;
		}		

		if(BRIGAD_DOM != '' && BRIGAD_DOMXFONO == ''){
			sweet_alert('Error: Ingresar celular del Brigadista Turno Domingo');	
			return false;
		}	
		
		if(BRIGAD_DOM == '' && BRIGAD_DOMXFONO != ''){
			sweet_alert('Error: Ingresar Brigadista Turno Domingo');	
			return false;
		}	
		
		if(RESP_MAN1 == '' && RESP_MAN2 == ''){
			sweet_alert('Error: Ingresar Responsable Mantenimiento');	
			return false;
		}	
				
		if(RESP_MAN1 != '' && RESP_MANXFONO1 == ''){
			sweet_alert('Error: Ingresar celular del Responsable Mantenimiento');	
			return false;
		}		
		
		if(RESP_MAN1 == '' && RESP_MANXFONO1 != ''){
			sweet_alert('Error: Ingresar Responsable Mantenimiento');	
			return false;
			}		

		if(RESP_MAN2 != '' && RESP_MANXFONO2 == ''){
			sweet_alert('Error: Ingresar celular del Responsable Mantenimiento');	
			return false;
		}	
		
		if(RESP_MAN2 == '' && RESP_MANXFONO2 != ''){
			sweet_alert('Error: Ingresar Responsable Mantenimiento');	
			return false;
		}		

		return true;
	}
		

	$('#btn_reg_resp').click(function(){

		if (validar_resp()){	

			$('#loading').show();
			
			var per_agno = $('#per_agno').val();
			var sem_num = $('#sem_num').val();
			var RESP_PROD = $('#RESP_PROD').val();
			var RESP_PRODXFONO = $('#RESP_PRODXFONO').val();		
			var BRIGAD_SAB = $('#BRIGAD_SAB').val();
			var BRIGAD_SABXFONO = $('#BRIGAD_SABXFONO').val();	
			var BRIGAD_DOM = $('#BRIGAD_DOM').val();
			var BRIGAD_DOMXFONO = $('#BRIGAD_DOMXFONO').val();
			var RESP_MAN1 = $('#RESP_MAN1').val();
			var RESP_MANXFONO1 = $('#RESP_MANXFONO1').val();	
			var RESP_MAN2 = $('#RESP_MAN2').val();
			var RESP_MANXFONO2 = $('#RESP_MANXFONO2').val();	
			var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
			
			var operacion = 'INSERT';
			parametros = {			
							per_agno:per_agno,
							sem_num:sem_num,							
							RESP_PROD:RESP_PROD,
							RESP_PRODXFONO:RESP_PRODXFONO,
							BRIGAD_SAB:BRIGAD_SAB,
							BRIGAD_SABXFONO:BRIGAD_SABXFONO,							
							BRIGAD_DOM:BRIGAD_DOM,
							BRIGAD_DOMXFONO:BRIGAD_DOMXFONO,
							RESP_MAN1:RESP_MAN1,
							RESP_MANXFONO1:RESP_MANXFONO1,							
							RESP_MAN2:RESP_MAN2,
							RESP_MANXFONO2:RESP_MANXFONO2,										
							chk_tope:chk_tope,
							operacion:operacion
						 }	
			console.log(parametros)
			$.post(
				   "consultas/ges_crud_secrexresp.php",
				   parametros,			   
				   function(resp){
						ges_crud_resp(resp)
				   },"json"
			)
			
			return false;		
		}	
			
	})	

	
 	$('#btn_upd_resp').click(function(){
		if (validar_resp()){	

			$('#loading').show();
			
			var per_agno = $('#per_agno').val();
			var sem_num = $('#sem_num').val();
			var RESP_PROD = $('#RESP_PROD').val();
			var RESP_PRODXFONO = $('#RESP_PRODXFONO').val();		
			var BRIGAD_SAB = $('#BRIGAD_SAB').val();
			var BRIGAD_SABXFONO = $('#BRIGAD_SABXFONO').val();	
			var BRIGAD_DOM = $('#BRIGAD_DOM').val();
			var BRIGAD_DOMXFONO = $('#BRIGAD_DOMXFONO').val();
			var RESP_MAN1 = $('#RESP_MAN1').val();
			var RESP_MANXFONO1 = $('#RESP_MANXFONO1').val();	
			var RESP_MAN2 = $('#RESP_MAN2').val();
			var RESP_MANXFONO2 = $('#RESP_MANXFONO2').val();
			var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
			
			var operacion = 'UPDATE';
			parametros = {	
							per_agno:per_agno,
							sem_num:sem_num,
							RESP_PROD:RESP_PROD,
							RESP_PRODXFONO:RESP_PRODXFONO,
							BRIGAD_SAB:BRIGAD_SAB,
							BRIGAD_SABXFONO:BRIGAD_SABXFONO,							
							BRIGAD_DOM:BRIGAD_DOM,
							BRIGAD_DOMXFONO:BRIGAD_DOMXFONO,
							RESP_MAN1:RESP_MAN1,
							RESP_MANXFONO1:RESP_MANXFONO1,							
							RESP_MAN2:RESP_MAN2,
							RESP_MANXFONO2:RESP_MANXFONO2,	
							chk_tope:chk_tope,
							operacion:operacion
						 }		
			$.post(
				   "consultas/ges_crud_secrexresp.php",
				   parametros,			   
				   function(resp){
						ges_crud_resp(resp)
				   },"json"
			)
			
			return false;		
		}
	})	
	
	$('#btn_del_resp').click(function(){
		swal({   
			title: "¿Seguro que deseas eliminar a estos Responsables Fin de Semana",   
			text: "No podrás deshacer este paso...",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonText: "Mmm... mejor no",   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "¡Adelante!",   
			closeOnConfirm: false }, 

			function(){   
				$('#loading').show();
				var per_agno = $('#per_agno').val();
				var sem_num = $('#sem_num').val();
				var chk_tope = ($("#chk_tope").is(":checked"))?'S':'N';
				
				var operacion = 'DELETE';
				parametros = {	
								per_agno:per_agno,
								sem_num:sem_num,
								chk_tope:chk_tope,
								operacion:operacion
							 }		
				$.post(
					   "consultas/ges_crud_secrexresp.php",
					   parametros,			   
					   function(resp){
							ges_crud_resp(resp)
					   },"json"
				)
		});	
		
	})	
	
	
	
	
	function ges_crud_resp(resp){
	console.log(resp)
		$('#loading').hide();
		var cod_resp = resp['cod'];
		
		if(cod_resp == 'ok'){
			var operacion = resp['operacion'];
			cancelar();

			if(operacion == 'INSERT'){
				swal("Sisconvi-Production", "Responsables Fin de Semana registrados", "success");
			}else if(operacion == 'UPDATE'){
				swal("Sisconvi-Production", "Responsables Fin de Semana modificaos", "success");
			}else if(operacion == 'DELETE'){
				swal("Sisconvi-Production", "Responsables Fin de Semana eliminados", "success");
			}
			
			$('#datatable-responsive tbody').unbind( "click" );
			table.destroy();
			crear_tabla();			
			
		}else{
			var desc_error = resp['desc'];
			swal("Sisconvi-Production", desc_error, "error");
		}
	}
	
	$('#btn_can_resp').click(function(){
		cancelar();		
	})	
	
});