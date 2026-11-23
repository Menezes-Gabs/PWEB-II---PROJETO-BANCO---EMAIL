<?php
session_start();

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['Botao'] ?? '') === 'Registrar Pedido') {

    header('Location: AddPedido.php');
    exit;
}

// Recuperando os dados da sessão
$Capital = (float) ($_SESSION['valor'] ?? 0);
$Total = (float) ($_SESSION['rendimento'] ?? 0);

// Calculando o rendimento
$Rendimento = $Total - $Capital;

// Salvando o total na sessão
$_SESSION['total'] = $Total;

// Formatando os valores em reais
$CapitalFormatado = number_format($Capital, 2, ',', '.');
$RendimentoFormatado = number_format($Rendimento, 2, ',', '.');
$TotalFormatado = number_format($Total, 2, ',', '.');

// Recuperando os dados do pedido
$Dados = [
    'Nome' => $_SESSION['nome'] ?? '',
    'CPF' => $_SESSION['cpf'] ?? '',
    'E-mail' => $_SESSION['email'] ?? '',
    'Banco' => $_SESSION['banco'] ?? '',
    'Conta' => $_SESSION['conta'] ?? '',
    'Taxa ao mês' => ($_SESSION['taxa'] ?? '') . '%',
    'Tempo em meses' => ($_SESSION['tempo'] ?? '')
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação do Pedido</title>
    <link rel="stylesheet" href="style.css">
	<link rel="icon" href="https://julio-basilio.github.io/Universal/Sahur.ico" type="image/x-icon">   
</head>

<body>

    <main id="form1">

        <section id="card-pedido">

            <h1>Confirmação do Pedido</h1>

            <section id="resumo-financeiro">

                <h2>Resumo financeiro</h2>

                <div id="valores-financeiros">
                    <p>
                        Capital aplicado:
                        <strong>R$ <?= $CapitalFormatado ?></strong>
                    </p>

                    <p>
                        Rendimento:
                        <strong>R$ <?= $RendimentoFormatado ?></strong>
                    </p>

                    <p>
                        Total disponível:
                        <strong>R$ <?= $TotalFormatado ?></strong>
                    </p>
                </div>

            </section>

            <section id="dados-pedido">

                <h2>Dados recebidos</h2>

                <div id="lista-dados">

                    <?php foreach ($Dados as $Titulo => $Valor) { ?>

                        <p>
                            <strong><?= htmlspecialchars($Titulo, ENT_QUOTES, 'UTF-8') ?>:</strong>
                            <?= htmlspecialchars((string) $Valor, ENT_QUOTES, 'UTF-8') ?>
                        </p>

                    <?php } ?>

                </div>

            </section>

            <section id="mensagem-resposta">

                <h2>Mensagem de resposta</h2>

                <p>
                    Seus dados estão prontos para serem registrados.
                    Confira as informações e clique no botão abaixo.
                </p>

                <form id="form-pedido" action="" method="POST">

                    <button id="botao-registrar" type="submit" name="Botao"
                        value="Registrar Pedido">
                        Registrar Pedido
                    </button>

                </form>

            </section>

        </section>

    </main>

</body>
</html>