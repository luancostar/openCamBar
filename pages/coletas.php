<?php
require_once('../conexao.php');
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

function getVolumes()
{
	$id_motorista = $_SESSION['id_motorista'];
	$entregas_agendadas = [];

	$sql = "SELECT id FROM tracking WHERE id_motorista='$id_motorista'";
	$result = abrirBanco()->query($sql);
	while ($row = $result->fetch_assoc()) {
		$id_tracking = $row['id'];
		$sql2 = "SELECT codigo_barras FROM tracking_mercadorias WHERE id_saida_entrega='$id_tracking' AND id_entrega = 0";
		$result2 = abrirBanco()->query($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$entregas_agendadas[] = $row2['codigo_barras'];
		}
	}
	return $entregas_agendadas;
}

function getEntregasAgendadas()
{
	$volumes = getVolumes();
	$entregas_agendadas = [];

	foreach ($volumes as $codigo_barras) {
		$sql = "SELECT * FROM tracking_etiquetas WHERE codigo_barras='$codigo_barras'";
		$result = abrirBanco()->query($sql);
		$row = $result->fetch_assoc();

		$row['nome_cidade'] = getNomeCidade($row['id_cidade_destino']);
		$entregas_agendadas[] = $row;
	}

	return $entregas_agendadas;
}

function getNomeCidade($id_cidade)
{
	$sql = "SELECT nome FROM cadastro_cidades WHERE id='$id_cidade'";
	$result = abrirBanco()->query($sql);
	$row = $result->fetch_assoc();
	$nome_cidade = $row['nome'];

	return $nome_cidade;
}

$motorista = getMotoristaById($_SESSION['id_motorista']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/7a8d54eabc.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/coletas.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>VB - Motoristas</title>
</head>

<body>
	<nav>
		<div class="nav-content">
			<!-- <div class="initial-nav">
				<img src="../img/logo_vb.png" alt="">
				<p id="tag">Motoristas</p>
			</div> -->
			<div class="final-nav">
			<div class="dataDiv">
			<img src="../img/user.png" alt="">
				<h6>
					<?= $motorista['nome'] ?><p>
						<?= $motorista['cpf'] ?>
					</p>
				</h6>
			</div>
	 
				<button id="logout-btn">Sair <i class="fas fa-sign-out-alt"></i></button>
	
			</div>
		</div>
	</nav>
	<div class="container mt-5">
	<div id="data-hora"></div>
	<script>
			// Função para formatar 1 em 01
			const zeroFill = n => {
				return ('0' + n).slice(-2);
			}

			// Cria intervalo
			const interval = setInterval(() => {
				// Pega o horário atual
				const now = new Date();

				// Formata a data conforme dd/mm/aaaa hh:ii:ss
				const dataHora = zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now.getFullYear() + ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' + zeroFill(now.getSeconds());

				// Exibe na tela usando a div#data-hora
				document.getElementById('data-hora').innerHTML = dataHora;
			}, 1000);
		</script>
		<div class="row mt-5">
			<div class="col-12 col-lg-8">
				<h1 class="display-4">Entregas Agendadas</h1>
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

						<?php foreach (getEntregasAgendadas() as $volume) : ?>
							<tr>
								<td><i class="fas fa-truck"></i></td>
								<td class="searchable"><a href="volumes.php"> <?= $volume['destinatario'] ?></a></td>
								<td><?= $volume['nota_fiscal'] ?></td>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
				<?php
				if (empty(getEntregasAgendadas())) {
					echo 'Não há entregas agendadas no momento';
				}
				?>
			</div>
		</div>
	</div>

	<script src="../js/searchTab.js"></script>
</body>

</html>