<?php
require_once('conexao.php');
session_start();

if (!isset($_SESSION['id_motorista'])) {
	header('Location: index.php');
	exit();
}

function getMotoristaById($id)
{
	$sql = "SELECT * FROM cadastro_motoristas WHERE id='$id'";
	$result = abrirBanco()->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$motorista = $row;
		return $motorista;
	}
	return [];
}

$motorista = getMotoristaById($_SESSION['id_motorista'])
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/7a8d54eabc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/coletas.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>VB - Motoristas</title>
</head>

<body>
	<nav>
		<div class="nav-content">
			<div class="initial-nav">
				<img src="img/logo_vb.png" alt="">
				<p id="tag">Motoristas</p>
			</div>
			<div class="final-nav">
				<h6><?= $motorista['nome'] ?><p>
						<?= $motorista['cpf'] ?>
					</p>
				</h6>

				<img src="img/user.png" alt="">
				<a href=""> <i class="fas fa-sign-out-alt">Sair</i> </a>
			</div>
		</div>
	</nav>
	<div class="container mt-5">
		<div class="row mt-5">
			<div class="col-12 col-lg-8">
				<h1 class="display-4">Coletas Agendadas</h1>
			</div>

			<div class="col-12 mt-4">
				<form class="form">
					<input class="form-control" id="search" type="search" placeholder="Procure por destinatário..." aria-label="Search">
				</form>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col">
				<table class="table search-table">
					<thead>
						<tr>
							<th></th>
							<th>Destinatário</th>
							<th>Nota Fiscal</th>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="fas fa-truck"></i></td>
							<td class="searchable">Cliente da Silva</td>
							<td>123654</td>

						</tr>
						<tr>
							<td><i class="fas fa-truck"></i></td>
							<td class="searchable">Cliente da Silva</td>
							<td>123654</td>

						</tr>
						<tr>
							<td><i class="fas fa-truck"></i></td>
							<td class="searchable">Cliente da Silva</td>
							<td>123654</td>

						</tr>
						<tr>
							<td><i class="fas fa-truck"></i></td>
							<td class="searchable">Cliente da Silva</td>
							<td>123654</td>

						</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script src="js/searchTab.js"></script>
</body>

</html>