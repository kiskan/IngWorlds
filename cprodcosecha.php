<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>


<script type="text/javascript" src="js/cprodcosecha.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Monitoreo Cosecha</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planvisor" data-parsley-validate class="form-horizontal">	
						<div class="form-group">

							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno"></select>								
								<div class="help">Año</div>
							</div>
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_mes">
								<option value="">TODOS</option>
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
								</select>								
								<div class="help">Mes</div>
							</div>
							
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sem_num">	
									<option value="" selected>TODAS</option>
								</select>								
								<div class="help">Semana</div>
							</div>							

							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_dia">
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Día</div>
							</div>	

							<div class="col-sm-2"><button id="btn_cosecha" type="button" class="btn btn-success">Consultar</button></div>							
						
						</div>
						
						<div class="form-group">
						
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="pis_pm">	
									<option value="" selected>TODAS</option>
									<option value="PM1">PM1</option>
									<option value="PM2">PM2</option>
									<option value="PM3">PM3</option>
									<option value="PM4">PM4</option>
									<option value="PM5">PM5</option>
									<option value="PM6">PM6</option>
									<option value="PM7">PM7</option>
									<option value="PM8">PM8</option>
									<option value="PM9">PM9</option>									
								</select>								
								<div class="help">Planta Madre</div>
							</div>
					
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="activ_id">	
									<option value="" selected>TODAS</option>
									<option value="240">COSECHA GLOBULUS</option>
									<option value="241">COSECHA GLONI</option>	
									<option value="62">COSECHA RAMAS PM</option>
								</select>								
								<div class="help">Tipo Cosecha</div>
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

							<table id="datatable-scroll" class="table table-striped table-bordered nowrap"  cellspacing="0" width="100%" >
								<thead>
									<tr>	
										<th>Fecha</th>
										<th>Año</th>											
										<th>Mes</th>
										<th>Semana</th>
										<th>Planta Madre</th>											
										<th>Piscina</th>
										<th>Clon</th>
										<th>Cantidad</th>
										<th>Estado</th>	
										<th>Tipo Cosecha</th>
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