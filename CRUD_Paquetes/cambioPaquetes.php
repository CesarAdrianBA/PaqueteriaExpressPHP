<!DOCTYPE html>
<html lang="es">
  <head>
     <title>Cambio en los datos de las paquetes</title>
	 <meta charset="utf-8">
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
	 </head>
	 <body>
		<?php
			//include('index.php');
			include('database.php');
			$db = new Database();
			$id="";

			// function test_entrada($data){
			// 	$data = trim($data);
			// 	$data = stripslashes($data);
			// 	$data = htmlspecialchars($data);
			// 	return $data;
			// }
			// if($_SERVER["REQUEST_METHOD"]=="POST"){
			// 	$id = test_entrada($_POST["id"]);
			// }
		?>
		<form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="container">
				<div class="row">
				<div class="col-4">
				<div class="list-group">
						<a href="menu.php" class="list-group-item list-group-item-action active" aria-current="true">
							Administración de paquetes
						</a>
						<a href="altaPaquetes.php" class="list-group-item list-group-item-action">Agregar paquete</a>
						<a href="consultaPaquetes.php" class="list-group-item list-group-item-action">Consultar paquete</a>
						<a href="cambioPaquetes.php" class="list-group-item list-group-item-action">Modificar paquete</a>
						<a href="bajaPaquetes.php" class="list-group-item list-group-item-action">Eliminar paquete</a>
						<a href="../cerrar.php" class="list-group-item list-group-item-action">Cerrar sesión</a>
				</div>
    		</div>
					<div class="col-8">
						<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">id del paquete a modificar:</label>
							<input type="text" class="form-control" id="id" name="id" value="<?php echo $id;?>">

						</div>
						<div class="mb-3">
							<input type="submit" class="btn btn-primary" name ="buscar" id="buscar" value="Buscar ID"/>
						</div>
			<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 1);

				if (isset($_POST['buscar'])) {
					$id = isset($_POST['id']) ? $_POST['id'] : null;

					$query = $db->connect()->prepare('SELECT * FROM paquetes WHERE id = :id');
					$query->setFetchMode(PDO::FETCH_ASSOC);
					$query->execute([':id' => $id]);
					$row = $query->fetch();

					if ($query->rowCount() > 0) {
						echo
						'<div class="mb-3">
							<label for="exampleFormControlInput1" 
								class="form-label">id de noticia a modificar:</label>
							<input type="text" class="form-control" value="'.$row['id'].'" disabled/>
						</div>'.
						'<div class="mb-3">
							<label for="exampleFormControlInput1" 
								class="form-label">código del paquete:</label>
							<input type="text" class="form-control" lang="es" href="qa-html-language-declarations.es"
								name="codigo" value ="'.$row['codigo'].'"/>
						</div>'.
						'<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Fecha de pedido:</label>
							<input type="date" class="form-control" name="fecha" value ="'.$row['fecha'].'">
						</div>'.
						
						'<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">peso:</label>
							<input type="text" class="form-control" name="peso" value ="'.$row['peso'].'">
						</div>'.
						
						'<div class="mb-3">
							<label for="exampleFormControlInput1" class="form-label">Estado:</label>
							<input type="text" class="form-control" name="estado" value ="'.$row['estado'].'">
						</div>'.


						'<div class="mb-3">
							<button type="submit" class="btn btn-primary" name="cambiar">Cambiar datos</button>
						</div>';
					} else {
						echo "No existe esa ID de Paquete.";
					}
				}

				if (isset($_POST['cambiar'])) {
					$id = $_POST['id'];
					$codigo = $_POST['codigo'];
					$peso = $_POST['peso'];
					$estado = $_POST['estado'];
					$fecha = $_POST['fecha'];

					$sql = "UPDATE paquetes SET codigo=?, peso=?, estado=?, fecha=? WHERE id=?";
					$stmt = $db->connect()->prepare($sql);
					$stmt->execute([$codigo, $peso, $estado, $fecha, $id]);

					$errorInfo = $stmt->errorInfo();
					if ($errorInfo[0] !== '00000') {
						// Mostrar o registrar el error
						echo "Error SQL: " . $errorInfo[2];
					}

					if ($stmt->rowCount() > 0) {
						echo "<br/><br/>Los datos fueron modificados con éxito";
						// ... (código para mostrar los detalles actualizados)
					} else {
						echo "No se actualizó el registro!!!";
						echo "ID: " . $id;
					}
				}//boton cambiar
				//mysqli_close($conexion);
			?>
		</form><!--El form cierra hasta aquí por que los datos del reg.
				son parte del formulario-->
				</div> <!--class="col-8"-->
					<div class="col">
					</div>
				</div><!--class="row"-->
			</div><!--class="container"-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
	</body>
</html>