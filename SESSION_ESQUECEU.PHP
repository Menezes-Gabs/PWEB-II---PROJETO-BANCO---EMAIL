<!DOCTYPE html>
<html>
<head>
	<title>Esqueceu a Senha</title>
	<meta charset="utf-8">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>
<body>
<?php
if (isset($_POST['Botao']) && $_POST['Botao'] == "Enviar Senha")
{
	include "CONEXAO.PHP";

	$email = $_POST['usuario'];

	$Comando = $conexao->prepare("SELECT SENHA_USUARIO FROM TB_USUARIO WHERE EMAIL_USUARIO = ?");
	$Comando->bindParam(1, $email);
	$Comando->execute();

	if ($Comando->rowCount() > 0)
	{
		$dados = $Comando->fetch(PDO::FETCH_ASSOC);
		$senhaRecuperada = $dados['SENHA_USUARIO'];

		include "SenhaEmail.php";
		require_once("phpmailer/class.phpmailer.php");

		function smtpmailer($para, $de, $de_nome, $assunto, $corpo)
		{
			global $error;
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->Username = USER;
			$mail->Password = PWD;
			$mail->SetFrom($de, $de_nome);
			$mail->Subject = $assunto;
			$mail->Body = $corpo;
			$mail->AddAddress($para);

			if (!$mail->Send())
			{
				$error = 'Mail error: ' . $mail->ErrorInfo;
				return false;
			}
			else
			{
				$error = 'Mensagem enviada!';
				return true;
			}
		}

		$assunto = "Recuperação de Senha";
		$mensagem = "Sua senha cadastrada é: " . $senhaRecuperada;

		if (smtpmailer($email, USER, 'Suporte Sistema', $assunto, $mensagem))
		{
			echo "<script>alert('Senha enviada para o e-mail: $email');</script>";
			echo '<meta http-equiv="refresh" content="0;SESSION_LOGIN.php">';
			exit;
		}
		else
		{
			echo "<script>alert('Erro ao enviar e-mail: $error');</script>";
		}
	}
	else
	{
		echo "<script>alert('E-mail não encontrado no cadastro!');</script>";
	}
}
?>

<form name="formEsqueceu" action="SESSION_ESQUECEU.php" method="POST">
	<label>USUARIO (EMAIL):</label><br>
	<input type="email" name="usuario" maxlength="40" required><br><br>

	<input type="submit" name="Botao" value="Enviar Senha">
</form>

</body>
</html>