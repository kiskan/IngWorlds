<?php

if(!isset($_POST['sactiv_id']) or !isset($_POST['h_sactiv_dia']) or !isset($_POST['h_area_id']) or 
!isset($_POST['h_activ_id']) or !isset($_POST['h_sem_num']) or !isset($_POST['h_per_agno']) or empty($_POST['h_sup_rut']) ){
	header('Location:index.php');
}

include('header.php');

//if($_SESSION['USR_TIPO'] <> "SUPERVISOR") header('Location:index.php');

$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>

<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var numeroSemana = <?php echo date("W"); ?>;
	
	var sactiv_id = <?php echo $_POST['sactiv_id']; ?>;
	var h_sactiv_dia = "<?php echo $_POST['h_sactiv_dia']; ?>";
	var h_area_id = <?php echo $_POST['h_area_id']; ?>;
	var h_activ_id = <?php echo $_POST['h_activ_id']; ?>;
	var h_sem_num = <?php echo $_POST['h_sem_num']; ?>;
	var h_per_agno = <?php echo $_POST['h_per_agno']; ?>;
	var h_sem_txt = "<?php echo $_POST['h_sem_txt']; ?>";
</script>

<script type="text/javascript" src="js/sup_replanificacion.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Nueva Actividad</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planxsemana" data-parsley-validate class="form-horizontal">	
						
						<input type="hidden" id="h_activ_standar" value="" />
						
						<div class="form-group">
							<label class="col-sm-12">DIA DE PLANIFICACION (<span id="sem_txt"></span>)</label>
							<div class="col-sm-3">
								<select class="form-control" tabindex="-1" id="plan_dia" disabled></select>								
								<div class="help">Día</div>
							</div>					
						</div>							
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>

						<div class="form-group">
							<label class="col-sm-12">ACTIVIDAD DE PLANIFICACION</label>
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="area_id" disabled>	
								</select>								
								<div class="help">Area</div>
							</div>
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sup_rut" disabled>	
								</select>								
								<div class="help">Supervisor</div>
							</div>
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="activ_id" disabled>	
								</select>								
								<div class="help">Actividad</div>
							</div>							
						</div>	
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>	

						<div class="form-group">
							
								<button id="btn_reg_supxreplanificacion" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_ir_supxreplanificacion" type="button" class="btn btn-success" style="display:none">Ir a Control Actividades</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>
						
						<h2 class="sub-header">Listado de Operadores Disponibles</h2>
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>	

						<div class="col-xs-4">
							
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-10">Operador</th>
											<th class="col-md-1" style="text-align:center">Disp</th>			  
										</tr>
									</thead>
									<tbody id="lista1_operadores">			  

									</tbody>
								</table>
							</div>
						</div>
						
						<div class="col-xs-4">
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-10">Operador</th>
											<th class="col-md-1" style="text-align:center">Disp</th>		  
										</tr>
									</thead>
									<tbody id="lista2_operadores">			  

									</tbody>
								</table>
							</div>
						</div>

						<div class="col-xs-4">
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-10">Operador</th>
											<th class="col-md-1" style="text-align:center">Disp</th>			  
										</tr>
									</thead>
									<tbody id="lista3_operadores">			  

									</tbody>
								</table>
							</div>
						</div>

						

					</form>					  
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>