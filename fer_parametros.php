<?php
include('header.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>

<script type="text/javascript" src="js/fer_parametros.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Parámetros Control Fertilización</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_paramfer" data-parsley-validate class="form-horizontal form-label-left">				
						<input type="hidden" id="h_paramfer_id" value="" />
											
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">PH*</label>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_iph" class="form-control" maxlength="12">
								<div class="help">Mínimo</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_fph" class="form-control" maxlength="12">
								<div class="help">Máximo</div>
							</div>							
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">C.Eléctrica*</label>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_ice" class="form-control" maxlength="12">
								<div class="help">Mínimo</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_fce" class="form-control" maxlength="12">
								<div class="help">Máximo</div>
							</div>							
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Caudal*</label>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_icaudal" class="form-control" maxlength="12">
								<div class="help">Mínimo</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6">
								<input type="text" id="paramfer_fcaudal" class="form-control" maxlength="12">
								<div class="help">Máximo</div>
							</div>							
						</div>						
						
						<div class="form-group has-feedback">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Inicio Vigencia*</label>
							<div class="col-md-3 col-sm-3 col-xs-12 inner-addon left-addon">
								<input type="text" id="paramfer_inivig" class="form-control" value="" style="cursor:pointer" >
								<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
							</div>
							<label>*Iniciar un día LUNES</label>
							
						</div>											

						<div class="form-group has-feedback">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fin Vigencia</label>
							<div class="col-md-3 col-sm-3 col-xs-12 inner-addon left-addon">
								<input type="text" id="paramfer_finvig" class="form-control" value="" style="cursor:pointer" >
								<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
							</div>					
						</div>
						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_paramfer" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_paramfer" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_paramfer" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_paramfer" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Parámetros Fertilización</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>PH Mín</th>
												<th>PH Máx</th>
												<th>CE Mín</th>
												<th>CE Máx</th>
												<th>Caudal Mín</th>
												<th>Caudal Máx</th>
												<th>Ini Vig</th>																						
												<th>Fin Vig</th>
												<th>Cód Param</th>
											</tr>
										</thead>
									</table>

								</div>
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