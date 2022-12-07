<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>
<!--
<script type="text/javascript" src="Informes/fusioncharts.js"></script>
<script type="text/javascript" src="Informes/fusioncharts.charts.js"></script>
<script type="text/javascript" src="Informes/fusioncharts.theme.fint.js"></script>
-->
<script type="text/javascript" src="js/casistencia.js"></script>

<script type="text/javascript">

/*
FusionCharts.ready(function () {
    var yearlyData = {
        "lastyear": {
            "chart": {
                "caption": "Split of Revenue by Product Categories",
                    "subCaption": "Last year",
                    "numberPrefix": "$",
                    "theme": "fint",
                    "captionFontSize": "13",
                    "subcaptionFontSize": "12",
                    "subcaptionFontBold": "0"
            },
                "data": [{
                "label": "Food",
                    "value": "28504"
            }, {
                "label": "Apparels",
                    "value": "14633"
            }, {
                "label": "Electronics",
                    "value": "10507"
            }, {
                "label": "Household",
                    "value": "4910"
            }]
        },
            "thisyear": {
            "chart": {
                "caption": "Split of Revenue by Product Categories",
                    "subCaption": "This year",
                    "numberPrefix": "$",
                    "theme": "fint",
                    "captionFontSize": "13",
                    "subcaptionFontSize": "12",
                    "subcaptionFontBold": "0"
            },
                "data": [{
                "label": "Food",
                    "value": "5000"
            }, {
                "label": "Apparels",
                    "value": "14633"
            }, {
                "label": "Electronics",
                    "value": "1000"
            }, {
                "label": "Household",
                    "value": "20000"
            }]
        }
    };
    var revenueChart = new FusionCharts({
        type: 'doughnut2d',
        renderAt: 'chart-container',
        width: '300',
        height: '300',
        dataFormat: 'json',
        dataSource: yearlyData.lastyear
    }).render();


    var year = document.getElementById("set_json_data");

    function change() {
        var data = yearlyData[year.value];
        revenueChart.setJSONData(data);
    }
    year.addEventListener("change", change);

});
*/





/*
FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'msbar3d',
        renderAt: 'chart-container',
        width: '650',
        height: '650',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Split of Sales by Product Category",
                "subCaption": "In top 5 stores last month",
                "yAxisname": "Sales (In USD)",
                "numberPrefix": "$",
                "paletteColors": "#0075c2,#1aaf5d",
                "bgColor": "#ffffff",
                "legendBorderAlpha": "0",
                "legendBgAlpha": "0",
                "legendShadow": "0",
                "placevaluesInside": "1",
                "valueFontColor": "#ffffff",                
                "alignCaptionWithCanvas": "1",
                "showHoverEffect":"1",
                "canvasBgColor": "#ffffff",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "divlineColor": "#999999",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "showAlternateHGridColor": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },            
            "categories": [
                {
                    "category": [
                        {
                            "label": "Bakersfield Central"
                        }, 
                        {
                            "label": "Garden Groove harbour"
                        }, 
                        {
                            "label": "Los Angeles Topanga"
                        }, 
                        {
                            "label": "Compton-Rancho Dom"
                        }, 
                        {
                            "label": "Daly City Serramonte"
                        }
                    ]
                }
            ],           
            "dataset": [
                {
                    "seriesname": "Food Products",
                    "data": [
                        {
                            "value": "17000"
                        }, 
                        {
                            "value": "19500"
                        }, 
                        {
                            "value": "12500"
                        }, 
                        {
                            "value": "14500"
                        }, 
                        {
                            "value": "17500"
                        }
                    ]
                }, 
                {
                    "seriesname": "Non-Food Products",
                    "data": [
                        {
                            "value": "25400"
                        }, 
                        {
                            "value": "29800"
                        }, 
                        {
                            "value": "21800"
                        }, 
                        {
                            "value": "19500"
                        }, 
                        {
                            "value": "11500"
                        }
                    ]
                }
            ]
        }
    })
    .render();
});
*/


</script>



<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Monitoreo Asistencia</h2>

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
								<!--<option value="-1">TODAS</option>-->
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
					
					
					
					<div id="chart-container"></div>
					 
					
					
<!-- This sample shows the usage of the setJSONData() method. 
<div id="indicatorDiv">Method Name: <b>setJSONData()</b>

    <br>
    <br>Sets chart data in the JSON data format. Click <a href="http://www.fusioncharts.com/dev/api/fusioncharts/fusioncharts-methods.html#setJSONData" target="_blank">here</a> to read more about the <b>setJSONData()</b> method.</br>
    <br>For this implementation, the JSON chart data changes according to the year selected.</br>
    <br>Select a year from the drop-down given below. The chart is re-rendered to reflect the data for the selected year.</br>
    <br>
    <center>
        <center>
            <label id="label">Select a year:
                <select id="set_json_data">
                    <option value="lastyear">2014</option>
                    <option value="thisyear">2015</option>
                </select>
            </label>
            </br>
        </center>
        <div id="chart-container">FusionCharts will render here</div>
</div>					
-->					
					
					
					
					
				</div>
			</div>
		</div>
	</div>	
</div>
<!-- /page content -->

<?php
include('footer.php');
?>