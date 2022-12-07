<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>

<script type="text/javascript" src="js/ges_parmes.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Parámetros Mensuales</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_parmes" data-parsley-validate class="form-horizontal form-label-left">	

						<div class="form-group">
							
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_mes">
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
						</div>		
						
						<div class="clearfix"></div>
						
						<div class="form-group">
							<label class="col-sm-12">Metas Informe Diario</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="meta_mini">								
								<div class="help">Meta Mini</div>
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="meta_pino">								
								<div class="help">Meta Pino</div>
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="meta_macro">								
								<div class="help">Meta Macro</div>
							</div>		
							<div class="col-sm-2">
								<input type="text" class="form-control" id="num_setos">								
								<div class="help">Núm Setos</div>
							</div>								
						</div>						

						<br />
						
						<div class="col-sm-12">	
							<p style="display:block;text-align:justify;">
								<input type="checkbox" id="chk_mini">&nbsp;Replicar Meta Mini de aquí en adelante para este año
							</p>
						</div>		
						<div class="col-sm-12">	
							<p style="display:block;text-align:justify;">
								<input type="checkbox" id="chk_pino">&nbsp;Replicar Meta Pino de aquí en adelante para este año
							</p>
						</div>	
						<div class="col-sm-12">	
							<p style="display:block;text-align:justify;">
								<input type="checkbox" id="chk_macro">&nbsp;Replicar Meta Macro de aquí en adelante para este año
							</p>
						</div>
						<div class="col-sm-12">	
							<p style="display:block;text-align:justify;">
								<input type="checkbox" id="chk_setos">&nbsp;Replicar Número de Setos de aquí en adelante para este año
							</p>
						</div>						
						<div class="clearfix"></div>
						<br />
						
						<div class="col-sm-2"><button id="btn_modmeta" type="button" class="btn btn-success">Actualizar</button></div>	
							
						<div class="clearfix"></div>						
						<div class="ln_solid"></div>							
						<img src="images/loading.gif" id="loading" style="display:none">
					
					</form>					
					
					<div class="col-sm-2">
						<select class="select2_single form-control" tabindex="-1" id="per_agno">	
						</select>								
						<div class="help">Año</div>
					</div>					
					<div class="clearfix"></div><br />
					<div class="col-md-10 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2>Metas Informe Diario</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">

								<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>NumMes</th>
											<th>Año</th>
											<th>Mes</th>
											<th>Meta Mini</th>
											<th>Meta Pino</th>
											<th>Meta Macro</th>
											<th>Núm Setos</th>
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
</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>