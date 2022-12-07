<?php
include('header.php');
$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');

$solicitantes = 'carga inicial';
$destinatarios = 'carga inicial';
include('consultas/ges_crud_usuarios.php');
/*
$categoria = 'carga inicial';
include('consultas/bod_crud_catproducto.php');
*/
$load_prod = 'carga inicial';
include('consultas/bod_crud_productos.php');
?>

<script type="text/javascript">
	var data_viveros = <?php echo $load_viveros; ?>;
	var data_destinatarios = <?php echo $load_destinatarios; ?>;
	//var data_categorias = <?php echo $load_categorias; ?>;
	var data_solicitantes = <?php echo $load_solicitantes; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	
	var data_productos = <?php echo $load_productos; ?>;
	var data_sap = <?php echo $load_sap; ?>;	
	
</script>


<script type="text/javascript" src="js/bod_cons_solic.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Monitoreo Ordenes Solicitudes</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planvisor" data-parsley-validate class="form-horizontal">
					
						<div class="form-group">
							<label class="col-sm-12">NRO DE SOLICITUD</label>
							
							<div class="col-sm-2">
								<input type="text" id="sprod_id" class="form-control">							
							</div>
							
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="sprod_estado">	
								<option value="">TODOS</option>
								<option value="PENDIENTE">PENDIENTE</option>
								<option value="ACEPTADA">ACEPTADA</option>
								<option value="ENTREGADA">ENTREGADA</option>
								<option value="RECHAZADA">RECHAZADA</option>
								</select>								
								<div class="help">Estado Solicitud</div>
							</div>												

							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="usr_id_solic">	
								<option value="">TODOS</option>
								</select>								
								<div class="help">Solicitante</div>
							</div>												
							
							
							<button id="btn_cons_solicitudes" type="button" class="btn btn-success">Consultar</button>
							<img src="images/loading.gif" id="loading" style="display:none">
																			
																						
						</div>									
				
						<div class="form-group">
							<label class="col-sm-12">DIA DE SOLICITUD</label>
							
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno">	
								</select>								
								<div class="help">Año</div>
							</div>
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sem_num">
								<option value="">TODOS</option>
								</select>								
								<div class="help">Semana</div>
							</div>		
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="sprod_dia">
									<option value="">TODOS</option>
								</select>
								<div class="help">Día</div>
							</div>	
						</div>
						
						<div class="clearfix"></div>
						
						<div class="form-group">
							<label class="col-xs-12">DATOS SOLICITUD</label>
							
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="UNDVIV_ID">	
									<option value="">TODOS</option>
								</select>								
								<div class="help">Unidad</div>
							</div>
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="sprod_id_dest">	
									<option value="">TODOS</option>
								</select>								
								<div class="help">Destinatario: Operador/Administrativo</div>
							</div>

						</div>
						
						
						
						<div class="form-group">
							<label class="col-xs-12">DATOS MATERIALES</label>
							
							<div class="col-sm-3" style="display:none">
								<select class="select2_single form-control" tabindex="-1" id="catprod_id">	
									<option value="">TODOS</option>
								</select>								
								<div class="help">Categoría</div>
							</div>
							
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="prod_cod">	
									<option value="">-</option>
								</select>								
								<div class="help">Material</div>
							</div>
							
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="sap_cod">	
									<option value="">-</option>
								</select>								
								<div class="help">Material</div>
							</div>							

						</div>						


					</form>

					<div class="clearfix"></div>
					<br><br>
					
					<div class="x_panel">
						<div class="x_title">
							<h2>Resultado Consulta</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<!--<table id="datatable-scroll" class="table table-striped table-bordered nowrap"  cellspacing="0" width="100%" >-->
							<table id="datatable-scroll" class="table-striped table-bordered nowrap" style="width:100%">
								<thead>
									<tr>	
										<th>Año</th>		
										<th>Semana</th>		
										<th>Día</th>
										<th>Nro Solicitud</th>
										<th>Resolución Solicitud</th>										
										<th>Unidad</th>
										<th>Solicitante</th>
										<th>Resolución Material</th>
										<th>Material Sisconvi</th>
										<th>Material SAP</th>
										<th>Cant Solicitada</th>
										<th>Cant Aceptada</th>
										<th>Valor Material</th>
										<th>Costo Total</th>
										<th>Destinatario</th>
										<th>Día/Hora Entrega</th>
										<th>Día/Hora Entrega Real</th>
										<th>Quien Retira</th>
										<th>Comentario</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>	
					
				</div>
			</div>
		</div>
	</div>	
</div>
<!-- /page content -->

<?php
include('footer.php');
?>