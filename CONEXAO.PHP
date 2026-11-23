<?php
try 
{
    $conexao = new PDO("mysql:host=localhost;dbname=projeto alpha;charset=utf8", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $erro) 
{
    echo "Erro na conexão: " . $erro->getMessage();
}
?>