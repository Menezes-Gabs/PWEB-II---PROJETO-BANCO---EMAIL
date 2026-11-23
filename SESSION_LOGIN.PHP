<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>
<body>
<?php
session_start();

if (isset($_POST['Botao']))
{
	if ($_POST['Botao'] == "CADASTRO")
	{
		session_unset();
		header('location:SESSION_CADASTRO.php');
		exit;
	}

	if ($_POST['Botao'] == "ESQUECEU")
	{
		header('location:SESSION_ESQUECEU.php');
		exit;
	}

	if ($_POST['Botao'] == "LOGAR")
	{
		include "conexao.php";

		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];

		$Comando = $conexao->prepare("SELECT * FROM TB_USUARIO WHERE EMAIL_USUARIO = ? AND SENHA_USUARIO = ?");
		$Comando->bindParam(1, $usuario);
		$Comando->bindParam(2, $senha);
		$Comando->execute();

		if ($Comando->rowCount() > 0)
		{
			$dados = $Comando->fetch(PDO::FETCH_ASSOC);
			$_SESSION['id_usuario'] = $dados['ID_USUARIO'];
			$_SESSION['email'] = $dados['EMAIL_USUARIO'];
			$_SESSION['senha'] = $dados['SENHA_USUARIO'];

			$CmdPedido = $conexao->prepare("SELECT NOME_PEDIDO, CPF_PEDIDO FROM TB_PEDIDO WHERE ID_USUARIO = ? ORDER BY ID_PEDIDO DESC LIMIT 1");
			$CmdPedido->bindParam(1, $dados['ID_USUARIO']);
			$CmdPedido->execute();

			if ($CmdPedido->rowCount() > 0)
			{
				$dadosPedido = $CmdPedido->fetch(PDO::FETCH_ASSOC);
				$_SESSION['nome'] = $dadosPedido['NOME_PEDIDO'];
				$_SESSION['cpf'] = $dadosPedido['CPF_PEDIDO'];
			}

			header('location:SESSION_CADASTRO.php');
			exit;
		}
		else
		{
			echo "<script>alert('Usuário ou senha inválidos!');</script>";
		}
	}
}
?>

<form id="form1" name="formLogin" action="SESSION_LOGIN.php" method="POST">
	<label>USUARIO:</label><br>
	<input type="email" name="usuario" maxlength="40"><br><br>

	<label>SENHA:</label><br>
	<input type="password" name="senha" maxlength="20"><br><br>

	<input type="submit" name="Botao" value="CADASTRO">
	<input type="submit" name="Botao" value="LOGAR">
	<input type="submit" name="Botao" value="ESQUECEU">
</form>

</body>
</html>