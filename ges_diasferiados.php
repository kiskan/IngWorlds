<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>

<script type="text/javascript" src="js/ges_diasferiados.js"></script>

<style>
.titulo1{font-family:fantasy,Helvetica,sans-serif;font-weight:bold;text-shadow:#eeeeee 3px 2px 2px;color:#2A699D;}@media (min-width:1200px) and (min-height:1000px){.content-col,.footer-col{line-height:1.8}}.footer-col{width:100%;left:0;position:relative;z-index:1;}.footer-col,.faux-footer-col{background:#f7f7f7;margin-top:15px}@media (max-width:599px){.footer-content-2,.footer-content-4{background:#fff}}@media (min-width:600px) and (max-width:900px){.footer-content-2,.footer-content-3{background:#fff}}@media (min-width:901px){.footer-content-2,.footer-content-4{background:#fff}}@media (max-width:1399px){.footer-col{border-top:1px solid #ccc}}@media (min-width:600px) and (max-width:900px){.footer-content-1,.footer-content-3{border-right:1px solid #ccc}[class*="footer-content-"]{border-bottom:1px solid #ccc}}@media (min-width:901px) and (max-width:1399px){.footer-content-1,.footer-content-2,.footer-content-3{border-right:1px solid #ccc}[class*="footer-content-"]{border-bottom:1px solid #ccc}}hr.divider{margin:0;padding:0;box-sizing:border-box;border-color:#ccc;width:100%;clear:both;}hr{border-color:#ddd;}@media (min-width:600px) and (max-width:900px){.faux-col.faux-footer-col{display:none}.footer-col [class*="footer-content-"]{float:left;width:50%;clear:none;}.footer-col hr.divider{display:none}}@media (min-width:901px) and (max-width:1399px){.faux-col.faux-footer-col{display:none}.footer-col [class*="footer-content-"]{float:left;width:25%;clear:none;min-height:180px;}.footer-col hr.divider{display:none}}.footer-col .inner-content{clear:both}.inner-content{padding:20px}@media (max-width:260px){.content-col .inner-content{padding:10px}}@media (min-width:1020px){.content-col .inner-content{padding-top:30px}}@media (min-width:1900px){.content-col .inner-content{padding-top:40px}}.footer h5{text-transform:uppercase;font-weight:bold;letter-spacing:3px;font-size:12px;margin-top:0;margin-bottom:20px;}.footer .copyright{font-size:12px;font-weight:400;}@media (min-width:1200px){.footer .copyright{font-size:11px;}}.semana{font-size:9px;color:gray}.calens{font-size:medium;color:#008cba;}.festivo{color:red;}.fecha_especial{color:blue;}.elmes{border:1px #cccccc solid;background-color:#2A699D;padding:4px 0;margin-top:3px;}.linkmes{color:#ffffff;font-weight:bold;}table{background:#fff;margin-bottom:1.25rem;border:solid 1px #ddd}.tabla_calendario table tr td{padding:3px 3px;text-align:center;}.tabla_calendario table{width:100%;text-align:center;}.tabla_calendario table tr th{padding:3px 3px;text-align:center;}.list-circle{padding-left:0;list-style-type:circle;}.fb-like{overflow:hidden;}.contenido-rel{background-color:#F5F9FD}.contenido-rel span{font-weight:bold;font-size:1.2em;color:#344C72;}/*.div_relacionados_thumb{max-width:140px;border:6px #344C72 solid;line-height:17px;text-align:center;text-decoration:underline;font-size:16px;background-color:#344C72;}.div_relacionados_thumb a{color:white}.div_relacionados_thumb a:hover{color:#93B2E2;}.pad5{padding:5px}.ultimas-noticias span{font-weight:bold;font-size:1.2em;color:#344C72;}.ultimas-noticias a{text-decoration:no;color:#555555;font-size:15px "}*/

.tachado{text-decoration:line-through;}
.cell_select {
    background-color: #FF0000;/*#337ab7;*/
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}

.calendar-day{
    cursor: pointer;
    cursor: hand;
}

</style>	
	
<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Días Feriados</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />	
					
					<div class="col-sm-2">
						<select class="select2_single form-control" tabindex="-1" id="per_agno">	
						</select>								
						<div class="help">Año</div>
					</div>
					
					<div class="col-sm-2"><button id="btn_actdias" type="button" class="btn btn-success">Actualizar</button></div>
					
					<div class="clearfix"></div><br />

					<div id="calendario"></div>
												
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