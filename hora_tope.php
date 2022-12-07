<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
if(!$error){
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');

?>

<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	//var corresponding_week = <?php echo date("W"); ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>

<script type="text/javascript" src="js/plan_semana.js"></script>
<?php } ?>
<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Hora Tope de Asiganación Personal</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
				<?php if(!$error){ ?>	
				
				
					<div class="form-group" <?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>  >
						<label class="col-sm-12">SEMANA </label>
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="per_agno">	
							</select>								
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4">
							<select class="select2_single form-control" tabindex="-1" id="sem_num">	
							</select>								
							<div class="help">Semana</div>
						</div>							
					</div>					
				
					<form id="form_planxsemana" data-parsley-validate class="form-horizontal">	
						
						<input type="hidden" id="h_activ_id" value="" />
						<input type="hidden" id="h_plan_dia" value="" />
						<input type="hidden" id="h_sup_rut" value="" />
						<input type="hidden" id="h_rut_oper" value="" />

						
						<div class="form-group">
							<label class="col-sm-12">DIA DE HORA TOPE (<span id="sem_txt"></span>)</label>
							<div class="col-sm-5">
								<select multiple class="form-control" tabindex="-1" id="plan_dia"></select>								
								<div class="help">Día(s)</div>
							</div>					
						</div>							
						
						<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="hora_activ">	
									<option value="0">TODA DISP.</option><option value="8.5">8,5 HORAS</option><option value="8">8,0 HORAS</option>
									<option value="7.5">7,5 HORAS</option><option value="7">7,0 HORAS</option><option value="6.5">6,5 HORAS</option>
									<option value="6">6,0 HORAS</option><option value="5.5">5,5 HORAS</option><option value="5">5,0 HORAS</option>
									<option value="4.5">4,5 HORAS</option><option value="4">4,0 HORAS</option><option value="3.5">3,5 HORAS</option>
									<option value="3">3,0 HORAS</option><option value="2.5">2,5 HORAS</option><option value="2">2,0 HORAS</option>
									<option value="1.5">1,5 HORAS</option><option value="1">1,0 HORAS</option><option value="0.5">0,5 HORAS</option>
								</select>							
								<div class="help">HoraTope</div>
							</div>	
						
						
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>

						<div class="form-group">
							
								<button id="" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_planxsemana" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_planxsemana" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_planxsemana" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
	
						<div class="ln_solid"></div>	
						
	

					</form>
	
					<div class="clearfix"></div>
					<br><br>
					<!--
					<div class="form-group" <?php //if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php //} ?>  >
						<label class="col-sm-12">SEMANA DE PLANIFICACION</label>
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="per_agno">	
							</select>								
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4">
							<select class="select2_single form-control" tabindex="-1" id="sem_num">	
							</select>								
							<div class="help">Semana</div>
						</div>							
					</div>		
					-->
					<div class="x_panel">
						<div class="x_title">
							<h2>Listado de Horas Tope</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>	
										
										<th>Semana</th>		
										<th>Día</th>
										<th>Hora</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					 
				<?php }else{ echo "Solicitar a un Administrador registra período siguiente. (Año: $next_year)";} ?>	
					
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>