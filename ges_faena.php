
<?php
	$pagina = 'solicitud de compra';
	include('header.php');
?>

		
<!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Gestión Faenas</h2>
        
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Área<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select class="select2_single form-control" tabindex="-1" id="area">
								<option></option>
								<option value="AK">Plantas Madres</option>
								<option value="HI">Enraizamiento</option>
								<option value="CA">Crecimiento</option>
								<option value="NV">Sombreadero</option>
								<option value="OR">Interperie</option>
							</select>
						</div>
					</div>					
					  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Faena<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="last-name" name="last-name" class="form-control col-md-6 col-xs-12">
                        </div>
                      </div>

                      <div class="ln_solid"></div>

					<div class="form-group">
						<div class="col-md-5 col-sm-5 col-xs-2"></div>
						<div class="col-md-7 col-sm-7 col-xs-10">
						<button type="button" class="btn btn-success">Registrar Faena</button>
						</div>
					</div>
					
					 <div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Listado de Faenas</h2>
							<ul class="nav navbar-right panel_toolbox">
							  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							  <thead>
								<tr>
								  <th>Area</th>
								  <th>Faena</th>
								</tr>
							  </thead>
							  <tbody>
								<tr>
								  <td>Plantas Madres</td>
								  <td>XxXxXxX</td>
								</tr>
								<tr>
								  <td>Enraizamiento</td>
								  <td>XxXxXxX</td>
								</tr>
								<tr>
								  <td>Crecimiento</td>
								  <td>XxXxXxX</td>
								</tr>
								<tr>
								  <td>Sombreadero</td>
								  <td>XxXxXxX</td>
								</tr>
								<tr>
								  <td>Interperie</td>
								  <td>XxXxXxX</td>
								</tr>
								
							  </tbody>
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