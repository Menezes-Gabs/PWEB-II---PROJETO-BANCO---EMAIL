<!DOCTYPE html>
<html>
<head>
	<title>Gerenciar</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>
<body>
<?php
session_start();
include "conexao.php";

$idUsuario = intval($_SESSION['id_usuario']);

// Lógica de alteração de Nome e Email
if (isset($_POST['Botao']) && $_POST['Botao'] == "Alterar")
{
	$novoNome  = $_POST['nome'];
	$novoEmail = $_POST['email'];

	try
	{
		// Atualiza o Email na TB_USUARIO
		$CmdUser = $conexao->prepare("UPDATE TB_USUARIO SET EMAIL_USUARIO = ? WHERE ID_USUARIO = ?");
		$CmdUser->bindParam(1, $novoEmail);
		$CmdUser->bindParam(2, $idUsuario);
		$CmdUser->execute();

		// Atualiza o Nome nos pedidos do usuário na TB_PEDIDO
		$CmdPed = $conexao->prepare("UPDATE TB_PEDIDO SET NOME_PEDIDO = ? WHERE ID_USUARIO = ?");
		$CmdPed->bindParam(1, $novoNome);
		$CmdPed->bindParam(2, $idUsuario);
		$CmdPed->execute();

		$_SESSION['nome']  = $novoNome;
		$_SESSION['email'] = $novoEmail;

		echo "<script>alert('Dados alterados com sucesso!');</script>";
	}
	catch (PDOException $erro)
	{
		echo "Erro ao alterar: " . $erro->getMessage();
	}
}

$nomeAtual  = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$emailAtual = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Busca todos os pedidos deste usuário
$CmdLista = $conexao->prepare("SELECT * FROM TB_PEDIDO WHERE ID_USUARIO = ? ORDER BY ID_PEDIDO DESC");
$CmdLista->bindParam(1, $idUsuario);
$CmdLista->execute();
$pedidos = $CmdLista->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="container">

<nav>
	<form name="formGerenciar" action="SESSION_GERENCIAR.php" method="POST">
	<label>Nome:</label><br>
	<input type="text" name="nome" maxlength="60" value="<?php echo $nomeAtual; ?>" required><br><br>

	<label>Email:</label><br>
	<input type="email" name="email" maxlength="40" value="<?php echo $emailAtual; ?>" required><br><br>

	<input type="submit" name="Botao" value="Alterar">
</form></nav>

<main>

	<h3>Pedidos</h3>
	<div id="contador">
    <?php echo count($pedidos); ?>
			</div>
<table border="1" cellpadding="6" cellspacing="0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>CPF</th>
			<th>Banco</th>
			<th>Conta</th>
			<th>Taxa (%)</th>
			<th>Tempo (Meses)</th>
			<th>Capital (R$)</th>
			<th>Rendimentos (R$)</th>
			<th>Total Disponível (R$)</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($pedidos) > 0): ?>
			<?php foreach ($pedidos as $p): ?>
				<tr>
					<td><?php echo $p['ID_PEDIDO']; ?></td>
					<td><?php echo $p['NOME_PEDIDO']; ?></td>
					<td><?php echo $p['CPF_PEDIDO']; ?></td>
					<td><?php echo $p['BANCO_PEDIDO']; ?></td>
					<td><?php echo $p['CONTA_PEDIDO']; ?></td>
					<td><?php echo number_format($p['TAXA_PEDIDO'], 1, ',', '.'); ?></td>
					<td><?php echo $p['MESES_PEDIDO']; ?></td>
					<td><?php echo number_format($p['CAPITAL_PEDIDO'], 2, ',', '.'); ?></td>
					<td><?php echo number_format($p['RENDIMENTO_PEDIDO'], 2, ',', '.'); ?></td>
					<td><?php echo number_format($p['TOTAL_PEDIDO'], 2, ',', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="10">Nenhum pedido encontrado para este usuário.</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<br>

</main>

<footer>

<a href="SESSION_LOGIN.php">Sair / Voltar ao Login</a>

</footer>

</div>




</body>
</html>