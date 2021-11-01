<?php
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$especialidade = $_POST['especialidade'];
$crm = $_POST['crm'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cpf_antigo = $_POST['cpf_antigo'];
$crm_antigo = $_POST['crm_antigo'];

if ($cpf_antigo != $cpf) {
    //VERIFICAR SE O MÉDICO JÁ ESTÁ CADASTRADO
    $result_medicos = $pdo->query("SELECT * FROM medicos WHERE cpf = '$cpf'");
    $dados_medicos = $result_medicos->fetchAll(PDO::FETCH_ASSOC);
    $medicos = count($dados_medicos);


    if ($medicos != 0) {
        echo "Este CPF já está cadastrado!";
        exit();
    }
}


if ($crm_antigo != $crm) {
    //VERIFICAR SE O MÉDICO JÁ ESTÁ CADASTRADO
    $result_medicos = $pdo->query("SELECT * FROM medicos WHERE crm = '$crm'");
    $dados_medicos = $result_medicos->fetchAll(PDO::FETCH_ASSOC);
    $medicos = count($dados_medicos);


    if ($medicos != 0) {
        echo "Este CRM já está cadastrado!";
        exit();
    }
}



$result_cadastro_medico = $pdo->prepare("UPDATE medicos SET nome = :nome, especialidade = :especialidade, crm = :crm, cpf = :cpf, telefone = :telefone, email = :email WHERE id  = :id");


$result_cadastro_medico->bindValue(":id", $id);
$result_cadastro_medico->bindValue(":nome", $nome);
$result_cadastro_medico->bindValue(":especialidade", $especialidade);
$result_cadastro_medico->bindValue(":crm", $crm);
$result_cadastro_medico->bindValue(":cpf", $cpf);
$result_cadastro_medico->bindValue(":telefone", $telefone);
$result_cadastro_medico->bindValue(":email", $email);

$result_cadastro_medico->execute();

echo "Editado com sucesso!";
