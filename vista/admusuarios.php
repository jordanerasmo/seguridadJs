	<body>
		<form>
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre"  id="nombre" ><br>			
			<label for="apellido">Apellido</label>
			<input type="text" name="apellido"  id="apellido" ><br>			
			<label for="usu">Usuario</label>
			<input type="text" name="usu"  id="usu" ><br>			
			<label for="clave">Clave</label>
			<input type="text" name="clave"  id="clave" ><br>			
			<label for="perfil">Perfil</label>
			<select id="perfil" name="perfil" id="perfil">
				<?php 
					include_once('controlador/usuarioc.php');
					$usuarioc = new UsuarioC();
					echo $usuarioc->select();
				?>
			</select>
			<label for="estado">Estado</label>
			<input type="text" name="estado"  id="estado"><br>			
			<input type="button" name="grabar" class="clase" id="grabar" value="Grabar">
		</form>
		
		<table id="tabla">
			<thead>
				<th>Perfil id</th>
				<th>Descripción</th>
				<th>Estado</th>
				<th>Editar</th>
				<th>Eliminar</th>
			</thead>
			<tbody>
			</tbody>
		</table>
		
			<input type="button" name="addusuario" class="clase" id="addusuario" value="Agregar Usuario">
		
	</body>
</html>
