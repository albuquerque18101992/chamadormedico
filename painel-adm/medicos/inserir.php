<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$especialidade = $_POST['especialidade'];
$crm = $_POST['crm'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];

//VERIFICAR SE O MÉDICO JÁ ESTÁ CADASTRADO
$result_medicos = $pdo->query("SELECT * FROM medicos WHERE cpf = '$cpf'");
$dados_medicos = $result_medicos->fetchAll(PDO::FETCH_ASSOC);
$medicos = count($dados_medicos);
if ($medicos == 0) {
    $result_cadastro_medico = $pdo->prepare("INSERT INTO medicos (nome, especialidade, crm, cpf, telefone, email) VALUES (:nome, :especialidade, :crm, :cpf, :telefone, :email) ");
    $result_cadastro_medico->bindValue(":nome", $nome);
    $result_cadastro_medico->bindValue(":especialidade", $especialidade);
    $result_cadastro_medico->bindValue(":crm", $crm);
    $result_cadastro_medico->bindValue(":cpf", $cpf);
    $result_cadastro_medico->bindValue(":telefone", $telefone);
    $result_cadastro_medico->bindValue(":email", $email);

    $result_cadastro_medico->execute();

    echo "Cadastro realizado com sucesso!";
} else {
    echo "Este médico já está cadastrado!";
}
