<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
if(!$error){

?>

<script type="text/javascript">

	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>

<script type="text/javascript" src="js/fer_aguas.js"></script>
<?php } ?>
<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Control de Agua Fertilización Semanal</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
				<?php if(!$error){ ?>	
				
				
					<div class="form-group">
						<label class="col-sm-12">DIA DE FERTILIZACION</label>
						
						<div class="col-sm-2"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>>
							<select class="select2_single form-control" tabindex="-1" id="per_agno">	
							</select>								
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>>
							<select class="select2_single form-control" tabindex="-1" id="sem_num">	
							</select>								
							<div class="help">Semana</div>
						</div>		
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="ctrlagua_dia"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> disabled <?php } ?>></select>							
							<div class="help">Día</div>
						</div>	
						<div class="col-sm-2"  >
							<select class="select2_single form-control" tabindex="-1" id="ctrlagua_hora">	<option value="">HORA</option>
								<option value="00:00">00:00</option><option value="00:30">00:30</option><option value="01:00">01:00</option><option value="01:30">01:30</option>
								<option value="02:00">02:00</option><option value="02:30">02:30</option><option value="03:00">03:00</option><option value="03:30">03:30</option>
								<option value="04:00">04:00</option><option value="04:30">04:30</option><option value="05:00">05:00</option><option value="05:30">05:30</option>
								<option value="06:00">06:00</option><option value="06:30">06:30</option><option value="07:00">07:00</option><option value="07:30">07:30</option>
								<option value="08:00">08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
								<option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option>
								
								<option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option>
								<option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option>
								<option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option>
								<option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option>
								<option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option>
								<option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option>

							</select>							
							<div class="help">Hora Registro</div>
						</div>							
						
						
					</div>	
					<div class="clearfix"></div>
					<div class="ln_solid"></div>
					<div class="clearfix"></div>
					<form id="form_ctrlagua" data-parsley-validate class="form-horizontal">	
						
						<input type="hidden" id="h_ctrlagua_id" value="" />
						
						<div class="form-group">
							<label class="col-sm-12">DATOS DE INYECCION</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_tk2">
									<div class="help">TK2</div>
								</div>								
								
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_tk3">
									<div class="help">TK3</div>
								</div>						
								
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_tk4">
									<div class="help">TK4</div>
								</div>						
						</div>							
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>

						<div class="form-group">
							<label class="col-sm-12">DATOS DE AGUA FERTILIZACION</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_ph">
									<div class="help">PH</div>
								</div>								
								
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_ce">
									<div class="help">Conductividad Eléctrica</div>
								</div>						
								
								<div class="col-sm-2">
									<input type="text" class="form-control" id="ctrlagua_caudal">
									<div class="help">Caudal (opcional)</div>
								</div>						
						</div>	
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>						
						
						<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Comentario <br>  (opcional)</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea class="form-control" rows="3" id="ctrlagua_comentario" ></textarea>
							</div>
						</div>	
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>	

						<div class="form-group">
							
								<button id="btn_reg_ctrlagua" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_ctrlagua" type="button" class="btn btn-success" style="display:none" >Modificar</button>
								<button id="btn_del_ctrlagua" type="button" class="btn btn-success" style="display:none" >Eliminar</button>
								<button id="btn_can_ctrlagua" type="button" class="btn btn-success" style="display:none" >Cancelar</button>

								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
	
					</form>
	
					<div class="clearfix"></div>
					<br><br>	
					
					<div class="x_panel">
						<div class="x_title">
							<h2>Listado de Control de Aguas Fertilización</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>	
										<th>ID</th>
										<th>Año</th>
										<th>Semana</th>		
										<th>Día</th>
										<th>Hora</th>
										<th>TK2</th>
										<th>TK3</th>
										<th>TK4</th>
										<th>PH</th>												
										<th>C.Eléctrica</th>
										<th>Caudal</th>
										<th>Comentario</th>
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