<?php
include('header.php');
$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>


<script type="text/javascript" src="js/bod_cons_tcompra.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Tiempos Proceso Compras</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planvisor" data-parsley-validate class="form-horizontal">								
				
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
							
							<button id="btn_cons_solicitudes" type="button" class="btn btn-success">Consultar</button>
							<img src="images/loading.gif" id="loading" style="display:none">							
							
						</div>
						
						<div class="clearfix"></div>

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
										<th>Solicitante</th>
										
										<th>Categoría</th>
										<th>Material / Servicio</th>

										<th>Cantidad o Días Plazo</th>
										<th>Precio</th>
										<th>Proveedor</th>
										<th>Motivo de Compra</th>
										
										<th>Fecha Solic. Compra</th>
										<th>Fecha Fin Cotización</th>
										<th>Tiempo Cotización</th>
										
										<th>Tiempo Cotización Días</th>
										
										<th>Fecha Confección SAP</th>
										<th>Tiempo Confección SAP</th>
										
										<th>Tiempo Confección Días</th>
										
										<th>Fecha Registro SAP</th>
										<th>Tiempo Liberación</th>
										
										<th>Tiempo Liberación Días</th>
										
										<th>Fecha Código HES</th>									
										<th>Tiempo Llegada Prod.</th>	

										<th>Tiempo Llegada Prod. Días</th>
										
										<th>Tiempo Total Proceso</th>
										<th>Tiempo Total Días</th>
										
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