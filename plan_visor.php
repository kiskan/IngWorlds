<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>

<!-- FullCalendar -->
<link href="../vendors/fullcalendar/fullcalendar.min.css" rel="stylesheet">
<link href="../vendors/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">
<script src="../vendors/fullcalendar/fullcalendar.min.js"></script>
<script src="../vendors/fullcalendar/locale/es.js"></script>
<script type="text/javascript" src="js/plan_visor.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Visor Planificación</h2>

					
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
							
							<div class="col-sm-4" <?php if($_SESSION['USR_TIPO'] == 'SUPERVISOR'){ ?> style="display:none" <?php } ?> >
								<select class="select2_single form-control" tabindex="-1" id="sup_rut"   >
									<option value="" selected>MOSTRAR TODOS</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>							
							
							<div class="col-sm-2"><button id="btn_planvisor" type="button" class="btn btn-success">Visualizar</button></div>							
						</div>
						<div id='calendar'></div>

					</form>
					<div id="con_activ" data-toggle="modal" data-target="#CalenderModalNew"></div>					
				</div>
			</div>
		</div>
	</div>

	
	
    <!-- calendar modal -->
    <!--<div id="CalenderModalNew" class="modal modal-wide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
	
	<div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Operadores Seleccionados</h4>
			
          </div>
          <div class="modal-body">
            <div id="testmodal" style="padding: 5px 20px;">
              <form id="antoform" class="calender" role="form">
			  
				  <div class="row">
					<div class="col-sm-3">
						<label>FECHA</label><br>
						<span id="fecha"></span>
					</div>
					<div class="col-sm-4">
						<label>AREA</label><br>
						<span id="area"></span>
					</div>
					<div class="col-sm-5">
						<label>ACTIVIDAD</label><br>
						<span id="actividad"></span>
					</div>	
					<div class="clearfix"></div><br>
					<div class="col-sm-3">
						<label>META</label><br>
						<span id="meta"></span>
					</div>	
					<div class="col-sm-4">
						<label>UNIDAD</label><br>
						<span id="unidad"></span>
					</div>						
					<div class="col-sm-5">
						<label>SUPERVISOR</label><br>
						<span id="supervisor"></span>
					</div>	
					<div class="clearfix"></div><br>
					<div class="col-sm-3">
						<label>TIPO ACTIVIDAD</label><br>
						<span id="tipo_activ"></span>
					</div>						
					<div class="col-sm-4">
						<label>PRODUCCION</label><br>
						<span id="produccion"></span>
					</div>	
					
				  </div>
			  <!--
					<table>
						<tr><td>FECHA</td><td>: <span id="fecha"></span></td>
						<td>AREA</td><td>: <span id="area"></span></td>
						<td>ACTIVIDAD</td><td>: <span id="actividad"></span></td></tr>
						<tr><td>TIPO ACTIV</td><td>: <span id="tipo_activ"></span></td>
						<td>SUPERVISOR</td><td>: <span id="supervisor"></span></td>
						<td>META</td><td>: <span id="meta"></span></td></tr>
						<tr><td>PRODUCCION </td><td>: <span id="produccion"></span></td>
						<td>UNIDAD</td><td>: <span id="unidad"></span></td></tr>
					</table>
				-->
					<br>
					<table id="datatable-responsive_operadores" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>FECHA</th>
								<th>AREA</th>
								<th>ACTIVIDAD</th>
								<th>SUPERVISOR</th>
								<th>ASIST</th>
								<th>OPERADOR</th>
								<th>CANT</th>
								<th>HR ASIGNADA</th>								
								<th>HR PROD</th>
								<th>OBSERVACIÓN</th>
							</tr>
						</thead>
					</table>        
            
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary antoclose" data-dismiss="modal">Close</button>
      
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