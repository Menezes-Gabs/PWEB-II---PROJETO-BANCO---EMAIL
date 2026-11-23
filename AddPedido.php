<?php
session_start();

$id_usuario = intval($_SESSION['id_usuario']);
$nome       = $_SESSION['nome'];
$cpf        = $_SESSION['cpf'];
$banco      = $_SESSION['banco'];
$conta      = $_SESSION['conta'];

$taxa = doubleval($_SESSION['taxa']);
$meses = intval($_SESSION['tempo']);
$capital = doubleval(number_format($_SESSION['valor'], 2, '.', ''));
$rendimento = doubleval(number_format($_SESSION['rendimento'], 2, '.', ''));
$total = doubleval(number_format($_SESSION['total'], 2, '.', ''));

$cadastro = new CadastroPedido($id_usuario, $nome, $cpf, $banco, $conta, $taxa, $meses, $capital, $rendimento, $total);

class CadastroPedido
{
	public $id_usuario, $nome, $cpf, $banco, $conta, $taxa, $meses, $capital, $rendimento, $total;

	public function __construct($id_usuario, $nome, $cpf, $banco, $conta, $taxa, $meses, $capital, $rendimento, $total)
	{
		$this->id_usuario = $id_usuario;
		$this->nome       = $nome;
		$this->cpf        = $cpf;
		$this->banco      = $banco;
		$this->conta      = $conta;
		$this->taxa       = $taxa;
		$this->meses      = $meses;
		$this->capital    = $capital;
		$this->rendimento = $rendimento;
		$this->total      = $total;
	}

	public function incluirPedido()
	{
		try
		{
			include "conexao.php";

			$Comando = $conexao->prepare("INSERT INTO TB_PEDIDO
			(ID_USUARIO, NOME_PEDIDO, CPF_PEDIDO, BANCO_PEDIDO, CONTA_PEDIDO, TAXA_PEDIDO, MESES_PEDIDO, CAPITAL_PEDIDO,
			RENDIMENTO_PEDIDO, TOTAL_PEDIDO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			$Comando->bindParam(1, $this->id_usuario);
			$Comando->bindParam(2, $this->nome);
			$Comando->bindParam(3, $this->cpf);
			$Comando->bindParam(4, $this->banco);
			$Comando->bindParam(5, $this->conta);
			$Comando->bindParam(6, $this->taxa);
			$Comando->bindParam(7, $this->meses);
			$Comando->bindParam(8, $this->capital);
			$Comando->bindParam(9, $this->rendimento);
			$Comando->bindParam(10, $this->total);

			if ($Comando->execute() && $Comando->rowCount() > 0)
			{
				header('location:SESSION_CONFIRMACAO.php');
				exit;
			}
		}
		catch (PDOException $erro)
		{
			echo "Erro: " . $erro->getMessage();
		}
	}
}

$cadastro->incluirPedido();
?>