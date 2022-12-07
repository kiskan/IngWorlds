<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	//var data_semanas = <?php echo $load_semanas; ?>;
	//var numeroSemana = <?php echo date("W"); ?>; 	
</script>

<script type="text/javascript" src="js/inf_diario.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Informe Listado de Personal Sabado y Domingo</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_sactiv" data-parsley-validate class="form-horizontal form-label-left">	
					
						<div class="form-group">
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno">	
								</select>								
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
								</select>								
								<div class="help">Semana</div>
							</div>						
							<div class="col-sm-2">
								<button id="" type="button" class="btn btn-success">Informe</button>
								
							</div>								
						</div>							
												
						<div class="ln_solid"></div>							
						<img src="images/loading.gif" id="loading" style="display:none">
						
					</form>					
						
						
					<div class="clearfix"></div>
					<br><br>
												
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