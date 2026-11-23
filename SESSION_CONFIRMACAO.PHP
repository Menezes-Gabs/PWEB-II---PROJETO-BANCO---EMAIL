<!DOCTYPE html>
<html>
<head>
	<title>Confirmação</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>
<body>
<?php
session_start();

if (isset($_POST['Botao']) && $_POST['Botao'] == "Ver Pedidos")
{
	header('location:SESSION_GERENCIAR.php');
	exit;
}
?>



<form id=form1 name="formConfirmacao" action="SESSION_CONFIRMACAO.php" method="POST">
	<p>Registro realizado com sucesso</p>
<hr>
	<input type="submit" name="Botao" value="Ver Pedidos">
</form>

</body>
</html>