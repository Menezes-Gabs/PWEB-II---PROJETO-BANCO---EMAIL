<!DOCTYPE html>
<html>
<head>
	<title>Cadastro</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>
<body>
<?php
session_start();

$nomeVal  = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$cpfVal   = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '';
$emailVal = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$senhaVal = isset($_SESSION['senha']) ? $_SESSION['senha'] : '';

if (isset($_POST['Botao']) && $_POST['Botao'] == "Confirmar Dados")
{
	$nome      = $_POST['nome'];
	$cpf       = $_POST['cpf'];
	$senha     = $_POST['senha'];
	$email     = $_POST['email'];
	$confSenha = $_POST['conf_senha'];

	if ($senha !== $confSenha)
	{
		echo "<script>alert('As senhas não conferem!');</script>";
	}
	else
	{
		include "CONEXAO.PHP";

		try
		{
			if (isset($_SESSION['id_usuario']))
			{
				// Alterar registro já logado
				$idUsuario = $_SESSION['id_usuario'];
				$Comando = $conexao->prepare("UPDATE TB_USUARIO SET EMAIL_USUARIO = ?, SENHA_USUARIO = ? WHERE ID_USUARIO = ?");
				$Comando->bindParam(1, $email);
				$Comando->bindParam(2, $senha);
				$Comando->bindParam(3, $idUsuario);
				$Comando->execute();
			}
			else
			{
				// Registro novo
				$Comando = $conexao->prepare("INSERT INTO TB_USUARIO (EMAIL_USUARIO, SENHA_USUARIO) VALUES (?, ?)");
				$Comando->bindParam(1, $email);
				$Comando->bindParam(2, $senha);
				$Comando->execute();

				$_SESSION['id_usuario'] = $conexao->lastInsertId();
			}

			$_SESSION['nome']  = $nome;
			$_SESSION['cpf']   = $cpf;
			$_SESSION['email'] = $email;
			$_SESSION['senha'] = $senha;

			header('location:SESSION_BANCO.php');
			exit;
		}
		catch (PDOException $erro)
		{
			echo "Erro ao salvar usuário: " . $erro->getMessage();
		}
	}
}
?>

<form  id="form1" name="formCadastro" action="SESSION_CADASTRO.PHP" method="POST">
	<label>NOME:</label><br>
	<input type="text" name="nome" maxlength="60" value="<?php echo $nomeVal; ?>" required><br><br>

	<label>CPF:</label><br>
	<input type="text" name="cpf" maxlength="14" value="<?php echo $cpfVal; ?>" required><br><br>

	<label>SENHA:</label><br>
	<input type="password" name="senha" maxlength="20" value="<?php echo $senhaVal; ?>" required><br><br>

	<label>USUARIO (EMAIL):</label><br>
	<input type="email" name="email" maxlength="40" value="<?php echo $emailVal; ?>" required><br><br>

	<label>CONF.SENHA:</label><br>
	<input type="password" name="conf_senha" maxlength="20" value="<?php echo $senhaVal; ?>" required><br><br>

	<input type="submit" name="Botao" value="Confirmar Dados">
</form>

</body>
</html>