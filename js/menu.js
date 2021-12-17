jQuery(document).ready(function(){
	jQuery('#usuario').on('click', function(){
		jQuery('#contenedor').load('vista/admusuarios.php')
	});
	jQuery('#perfiles').on('click', function(){
		jQuery('#contenedor').load('vista/admperfil.php')
	});
	jQuery('#programas').on('click', function(){
		jQuery('#contenedor').load('vista/admprogramas.php')
	});
});
