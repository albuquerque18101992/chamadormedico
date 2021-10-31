<?php
include_once("../../conexao.php");

$txtbuscar = '%' . @$_POST['txtbuscar'] . '%';


echo '<table class="table table-sm mt-3">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Especialidade</th>
                <th scope="col">CRM</th>
                <th scope="col">CPF</th>
                <th scope="col">Telefone</th>
                <th scope="col">Email</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>';

if ($txtbuscar == '') {
    $resultado = $pdo->query("SELECT * FROM medicos ORDER BY id DESC");
} else {
    $resultado = $pdo->query("SELECT * FROM medicos WHERE nome LIKE '$txtbuscar' OR crm LIKE '$txtbuscar' ORDER BY nome DESC");
}
$dados = $resultado->fetchALL(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($dados); $i++) {
    foreach ($dados[$i] as $key => $value) {
    }
    $id = $dados[$i]['id'];
    $nome = $dados[$i]['nome'];
    $especialidade = $dados[$i]['especialidade'];
    $crm = $dados[$i]['crm'];
    $cpf = $dados[$i]['cpf'];
    $telefone = $dados[$i]['telefone'];
    $email = $dados[$i]['email'];

    echo '    <tr>
                    <td>' . $nome . '</td>
                    <td>' . $especialidade . '</td>
                    <td>' . $crm . '</td>
                    <td>' . $cpf . '</td>
                    <td>' . $telefone . '</td>
                    <td>' . $email . '</td>
                    <td>
                        <a href="#"><i class="fas fa-edit text-info"></i></a>
                        <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                    </td>
                </tr>';
}
echo '
            </tbody>
        </table>';


        $num_total = count($dados);

?>
<tfoot>
    <div class="float-right mr-4">
        Total de cadastros <?php echo $num_total; ?>
    </div>
</tfoot>