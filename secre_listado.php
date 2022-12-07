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

<script type="text/javascript" src="js/secre_listado.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Listado Operadores Actividades Extras</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />			
				
					<div class="form-group">
					
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="per_agno"></select>															
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4">
							<select class="select2_single form-control" tabindex="-1" id="sem_num"></select>															
							<div class="help">Semana</div>
						</div>																	

						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="plan_dia">
								<option value="" selected>TODOS</option>
							</select>								
							<div class="help">Día</div>
						</div>
						
						<div class="col-sm-2"><button id="btn_secre_listado" type="button" class="btn btn-success">Consultar</button></div>

						<div class="clearfix"></div>						
						<br>								
						<img src="images/loading.gif" id="loading" style="display:none">
						<span id="error" style="display:none; color:red" />								
					
					</div>	
					
					<div class="clearfix"></div>					

					<div class="x_panel">
						<div class="x_title">
							<h2>Resultado Consulta - Sotrosur</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<!--<table id="datatable-scroll-2" class="table table-striped table-bordered nowrap"  cellspacing="0" width="100%" >-->
							<table id="datatable-scroll-2" class="table-striped table-bordered nowrap" style="width:100%">
								<thead>
									<tr>	
										<th>RUT</th>
										<th>OPERADOR</th>		
										<th>AREA</th>
										<th>ACTIVIDAD</th>
										<th>COMUNA</th>																						
										<th>JEFE_GRUPO</th>												
										<th>ASIGNADOR</th>
										<th>FECHA</th>
										<th>DIA</th>
										<th>TIPO_JORNADA</th>
										<th>HORAS</th>
										<th>DIRECCION</th>
										<th>TIPO_JEFEGRUPO</th>
										<th>FONO_JEFEGRUPO</th>	
									</tr>
								</thead>
							</table>
						</div>
					</div>						
				
					
					
					
					
					
					
					
					
					
					
	
					<div class="clearfix"></div>					

					<div class="x_panel">
						<div class="x_title">
							<h2>Resultado Consulta - Guardia</h2>

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
										<th>RUT</th>
										<th>DV</th>		
										<th>COD_PERSONA</th>
										<th>NOMBRES</th>
										<th>APELLIDOS</th>																						
										<th>TELEFONO</th>												
										<th>CELULAR</th>
										<th>ANEXO</th>
										<th>EMAIL</th>
										<th>COD_EMPRESA</th>
										<th>COD_AREA</th>
										<th>COD_PLANTA</th>
										<th>EXTRANJERO</th>										
										<th>TARJETA</th>
										<th>PERSONAL_PLANTA</th>
										<th>COD_ZONA_TRABAJO</th>
										<th>PERSONAL_PROVEEDOR</th>
										<th>COD_PROVEEDOR</th>
										<th>VISITA</th>
										<th>PERSONAL_CONTRATISTA</th>										
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