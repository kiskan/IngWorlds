<?php
include('header_manual.php');
include('consultas/funciones_comunes.php');
?>

<script type="text/javascript" src="js/perfil.js"></script>
<style>
.vid {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px; height: 0; overflow: hidden;
}
 
.vid iframe,
.vid object,
.vid embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
					<h2>Diferencia de Conceptos "ELIMINACÓN Y LIBERACION" de operadores</h2>
        
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<div class="well">
					<p>El siguiente tutorial nos presenta la diferenciación de dos conceptos  el de eliminar un operador de una actividad y el de liberar a un operador de una actividad para que pueda ser utilizado por cualquier otro supervisor.</p>
					
					<p>Al momento de liberar a un operador el supervisor modifica las horas asignadas para la actividad actual, y aparecerá disponible las horas complementarias a las que el supervisor a las que se le asigno.</p>

					<p>Por ejemplo supervisor1 “librante” supervisor2 “Solicitante” , entonces el supervisor1 libera a un operador 4 horas , por lo que debe actualizar actividad y  editar las horas de asignación a 4,5 horas , así queda libre 4 horas y al superviros2 le parecerá disponible 4 horas de las 8,5 que tiene la jornada de trabajo.</p>
					
					<p>VER VIDEO</p>
					</div>
					<div style="text-align:center;">
					<iframe width="600" height="355" src="https://www.youtube.com/embed/OTKHPnYE05I" frameborder="0" allowfullscreen></iframe>
					
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