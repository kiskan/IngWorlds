<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>

<script type="text/javascript" src="js/cmrendimiento.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Monitoreo Rendimiento</h2>

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
								<!--<option value="">TODOS</option>-->
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
									<!--<option value="" selected>TODAS</option>-->
								</select>								
								<div class="help">Semana</div>
							</div>							
						<!--
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_dia">
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Día</div>
							</div>	
						-->
							<div class="col-sm-2"><button id="btn_monitoreo" type="button" class="btn btn-success">Consultar</button>
							<a target="_blank" id="link_informe_asistencia" style="display:none">Informe</a>
							</div>							
						
						</div>
						<!--
						<div class="form-group">

							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sup_rut" >
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>	
							<div class="col-sm-8">
								<select class="select2_single form-control" tabindex="-1" id="activ_id" >	
									<option value="" selected>TODAS</option>
								</select>								
								<div class="help">Actividad Planificada</div>
							</div>
						
						</div>	
						-->
					</form>

					<div class="clearfix"></div>
					<br><br>
					
					

<div id="resp_sinhr" style="display:none">
	No existen horas de producción en semana buscada.
</div>					
					
					
					
					
<div id="resp_cmrendimiento" style="display:none">
	<center><span style="font-size:18px; font-weight:bold;">RANKING TRABAJADORES POR ACTIVIDAD</span></center>		
	<hr>		

<div class="row" style="font-size:11px; font-weight:bold">
<center><div class="col-md-2" id="activ_1"></div></center>
<center><div class="col-md-2" id="activ_2"></div></center>
<center><div class="col-md-2" id="activ_3"></div></center>
<center><div class="col-md-2" id="activ_4"></div></center>
<center><div class="col-md-2" id="activ_5"></div></center>
<center><div class="col-md-2" id="activ_6"></div></center>
</div>
<br>	
	
	<span style="font-size:18px; font-weight:bold; padding:10px">TOP 5</span>		
	<br><br>		
			<div class="row" id="oper_top">
			  <?php //$i = 0; while($i < $rowcount){ ?>	
			  <!--
			  <div class="col-md-2" style="font-size:9px">
			  
				<?php /*$j = 0; while($j < count($operadores_top[$i])){  
				  $oper = explode("->", $operadores_top[$i][$j]);
				  $nom_oper = $oper[0];
				  $cumpl_oper = round($oper[1],0);*/			
				?>
				
				<div class="row" >
					<center><div class="col-md-1"><img src="images/<?php //echo $j+1; ?>-verde.png" /></div></center>
					<div class="col-md-10"><span><?php //echo $nom_oper; ?></span></div>
					<div class="col-md-1" style="font-size:12px; font-weight:bold"><?php //echo $cumpl_oper.'%'; ?></div>
				</div>
				
				<?php //$j++; } ?>
			  </div>-->
			  <?php //$i++; } ?>
			</div>
	<br>
			<div class="row">
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_1"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_2"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_3"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_4"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_5"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <span id="oper80_6"></span> </div></center>
			</div>
	<br>
	<span style="font-size:18px; font-weight:bold; padding:10px">BOTTOM 5</span>		
	<br><br>		
			<div class="row" id="oper_bottom">
			  <?php //$i = 0; while($i < $rowcount){ ?>	
			  <!--
			  <div class="col-md-2" style="font-size:9px">
			  
				<?php/* $j = 0; while($j < count($operadores_bottom[$i])){  
				  $oper = explode("->", $operadores_bottom[$i][$j]);
				  $nom_oper = $oper[0];
				  $cumpl_oper = round($oper[1],0);	*/		
				?>
				<div class="row">
					<center><div class="col-md-1"><img src="images/<?php //echo $j+1; ?>-rojo.png" /></div></center>
					<div class="col-md-10"><span><?php //echo $nom_oper; ?></span></div>
					<div class="col-md-1" style="font-size:12px; font-weight:bold"><?php //echo $cumpl_oper.'%'; ?></div>
				</div>
				<?php //$j++; } ?>
			  </div>-->
			  <?php //$i++; } ?>
			</div>
	<br>

			<div class="row">
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_1"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_2"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_3"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_4"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_5"></span> </div></center>
			  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <span id="oper50_6"></span> </div></center>
			</div>
	<br>					
					
				
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