<?php $pagina = 'medicos'; ?>
<div class="row botao-novo">
	<div class="col-md-12">
		<a id="btn-novo" data-toggle="modal" data-target="#modal"></a>
		<a href="index.php?acao=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-secondary">Novo Médico</a>
	</div>
</div>

<div class="row mt-4">
	<div class="col-md-6 col-sm-12">
		<div class="float-left">
			<label class="registro" for="exampleFormControlSelect1">Registros</label>
			<select class="form-control-sm" id="exampleFormControlSelect1">
				<option>10</option>
				<option>25</option>
				<option>50</option>
			</select>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		<div class="float-right mr-4">
			<form class="form-inline my-2 my-lg-0" method="post">
				<input class="form-control form-control-sm mr-sm-2" type="search" placeholder="Nome ou CRM" aria-label="Search" name="txtbuscar" id="txtbuscar">
				<button class="btn btn-outline-secondary btn-sm my-2 my-sm-0" name="btn-buscar" id="btn-buscar"><i class="fas fa-search"></i></button>
			</form>
		</div>
	</div>
</div>

<div id="listar">

</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<?php
					if (@$_GET['funcao'] == 'editar') {
						$nome_botao = 'Editar';
						$id_reg = $_GET['id'];

						//BUSCAR DADOS DO REGISTRO A SER EDITADO
						$res = $pdo->query("SELECT * FROM medicos WHERE id = '$id_reg'");
						$dados = $res->fetchAll(PDO::FETCH_ASSOC);
						$nome = $dados[0]['nome'];
						$especialidade = $dados[0]['especialidade'];
						$crm = $dados[0]['crm'];
						$cpf = $dados[0]['cpf'];
						$telefone = $dados[0]['telefone'];
						$email = $dados[0]['email'];
						echo 'Edição de Médicos';
					} else {
						$nome_botao = 'Salvar';
						echo 'Cadastro de Médicos';
					}
					?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<input type="hidden" id="id" name="id" value="<?php echo @$id_reg ?>">
					<input type="hidden" id="cpf_antigo" name="cpf_antigo" value="<?php echo @$cpf ?>">
					<input type="hidden" id="crm_antigo" name="crm_antigo" value="<?php echo @$crm ?>">

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group was-validated">
								<label for="exampleFormControlInput1">Nome</label>
								<input type="text" class="form-control is-invalid" id="nome" placeholder="Insira o Nome" name="nome" value="<?php echo @$nome ?>" required>
							</div>
						</div>

						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlSelect1">Especialidade</label>
								<select class="form-control" id="especialidade" name="especialidade">
									<option>1</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="form-group was-validated">
								<label for="exampleFormControlInput1">CRM</label>
								<input type="text" class="form-control is-invalid" id="crm" name="crm" placeholder="Insira o CRM" value="<?php echo @$crm ?>" required>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group was-validated">
								<label for="exampleFormControlInput1">CPF</label>
								<input type="text" class="form-control is-invalid" id="cpf" name="cpf" placeholder="Insira o CPF" value="<?php echo @$cpf ?>" required>
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="exampleFormControlInput1">Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Insira o Telefone" value="<?php echo @$telefone ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="exampleFormControlInput1">Email</label>
						<input type="email" name="email" class="form-control" id="email" placeholder="Insira o Email" value="<?php echo @$email ?>">
					</div>

					<div id="mensagem" class="col-md-12 text-center mt-3">

					</div>


					<div class="modal-footer">
						<button id="btn-fechar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" id="<?php echo $nome_botao; ?>" name="<?php echo $nome_botao; ?>" class="btn btn-primary" id="btn_salvar"><?php echo $nome_botao; ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--CHAMADA DA MODAL NOVO -->
	<?php
	if (@$_GET['funcao'] == 'novo') {
	?>
		<script>
			$('#btn-novo').click();
		</script>
	<?php
	}
	?>

	<!--CHAMADA DA MODAL EDITAR -->
	<?php
	if (@$_GET['funcao'] == 'editar') {
	?>
		<script>
			$('#btn-novo').click();
		</script>
	<?php
	}
	?>

	<!--MASCARAS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script src="../js/mascaras.js"></script>

	<!--AJAX PARA INSERÇÃO DOS DADOS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var pag = "<?= $pagina ?>";
			$('#Salvar').click(function(event) {
				event.preventDefault(); //Não permite atualização da página

				$.ajax({
					url: pag + "/inserir.php",
					method: "post",
					data: $('form').serialize(),
					dataType: "text",
					success: function(mensagem) {
						//Passando as cores de erro e de sucesso do CSS via JS
						if (mensagem == 'Cadastro realizado com sucesso!') {
							$('#mensagem').removeClass('mensagem-erro')
							$('#mensagem').addClass('mensagem-sucesso')
							$('#nome').val('')
							$('#cpf').val('')
							$('#telefone').val('')
							$('#crm').val('')
							$('#email').val('')


							$('#txtbuscar').val('')
							$('#btn-buscar').click()
							//$('#btn-fechar').click() //Fechar modal ao salvar


						} else {
							$('#mensagem').removeClass('mensagem-sucesso')
							$('#mensagem').addClass('mensagem-erro')
						}
						$('#mensagem').text(mensagem)
					}
				})
			})
		})
	</script>



	<!--AJAX PARA LISTAR OS DADOS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var pag = "<?= $pagina ?>";

			$.ajax({
				url: pag + "/listar.php",
				dataType: "html",
				success: function(result) {
					$('#listar').html(result)
				}
			})
		})
	</script>



	<!--AJAX PARA BUSCAR OS DADOS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var pag = "<?= $pagina ?>";
			$('#btn-buscar').click(function(event) {
				event.preventDefault(); //Não permite atualização da página

				$.ajax({
					url: pag + "/listar.php",
					method: "post",
					data: $('form').serialize(),
					dataType: "html",
					success: function(result) {
						$('#listar').html(result)
					}
				})

			})
		})
	</script>


	<!--AJAX PARA BUSCAR RESULTADOS SEM CLICAR NO BOTÃO -->
	<script type="text/javascript">
		$('#txtbuscar').keyup(function() {
			$('#btn-buscar').click();
		})
	</script>



	<!--AJAX PARA EDIÇÃO DOS DADOS -->
	<script type="text/javascript">
		$(document).ready(function() {

			var pag = "<?= $pagina ?>";
			$('#Editar').click(function(event) {
				event.preventDefault(); //Não permite atualização da página

				$.ajax({
					url: pag + "/editar.php",
					method: "post",
					data: $('form').serialize(),
					dataType: "text",
					success: function(mensagem) {
						//Passando as cores de erro e de sucesso do CSS via JS
						if (mensagem == 'Editado com sucesso!') {
							$('#mensagem').removeClass('mensagem-erro')
							$('#mensagem').addClass('mensagem-sucesso')


							$('#txtbuscar').val('')
							$('#btn-buscar').click()
							$('#btn-fechar').click() //Fechar modal ao editar


						} else {
							$('#mensagem').removeClass('mensagem-sucesso')
							$('#mensagem').addClass('mensagem-erro')
						}
						$('#mensagem').text(mensagem)
					}
				})
			})
		})
	</script>