jQuery(document).ready(function(){
	listar();
	jQuery('#addperfil').on('click',function(){
		jQuery('#descripcion').val('');
		jQuery('#formperfildesc').css('display','block');
		jQuery('#descripcion').css('background-color','red');
		jQuery('#descripcion').css('color','white');
		jQuery('#descripcion').focus();
	});
	jQuery('#grabar').on('click', function(){
		var error = false;
		if(jQuery('#descripcion').val()==''){
			error = true;
			alert('falta la descripcion');
			jQuery('#descripcion').css('background-color','red');
		}
		if(!error){
			var datos = {
				param:20001,
				descripcion:jQuery('#descripcion').val()
			};
			jQuery.ajax({
				type:'post',
				data:datos,
				url:'scripts/seguridad.php',
				dataType:'json',
				success:function(r){
					if(r.success){				
						jQuery('#formperfildesc').css('display','none');
						listar();
					}else{
						alert('Error');
					}
					
				}
			});
		}
	});
	jQuery('#descripcion').on('keypress',function(){
		jQuery(this).css('background-color','black');
	});
});
function listar(){
	jQuery('#tabla tbody').empty();
	jQuery.ajax({
		type:'post',
		url:'scripts/seguridad.php',
		data:{param:20000},
		dataType:'json',
		success:function(r){
			console.log(r);
			jQuery('#tabla tbody').append(r.lista);
		}
	});
}