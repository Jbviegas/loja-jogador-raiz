<?php
session_start();
ob_start();
//conexão 
require_once('../sheep_core/config.php');

//chma o efi banco digital
require_once('./vendor/autoload.php');
$sheep = new Ler();

//token de proteção do site 
$tokenPagamentoSite = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
if ($_SESSION['token_pagamentos'] != $tokenPagamentoSite):
	header("Location: " . HOME);
	exit();
endif;

if ($tokenPagamentoSite == null):
	header("Location: " . HOME);
	exit();
endif;


if ($_SESSION['token_pagamentos'] === $tokenPagamentoSite):
	null;
else:
	header("Location: " . HOME);
	exit();
endif;
?>
<!doctype html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pagamento Seguro Banco Digital Efí | <?= SITENAME ?></title>

	<!-- Bootstrap core CSS -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

	<!-- CDN JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

	<style>
		.nav-link {

			color: blueviolet !important;
		}

		.nav-link.active {
			background-color: blueviolet !important;
			color: #fff !important;
		}

		.nav-link.active:hover {
			background-color: black !important;
		}
	</style>
</head>

<body>
	<script type="text/javascript">
		var base_url = "<?= HOME ?>";
	</script>

	<div class="container">

		<!-- INICIO TOPO PAGAMENTO MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR -->
		<header class="p-3 text-white">
			<div class="container">
				<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
					<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
						<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
							<use xlink:href="#bootstrap" />
						</svg>
					</a>

					<style>
						.text-orange {
							color: #ff8000 !important;
							/* Laranja */
						}
					</style>

					<img src="logo-efi-pay.svg" alt="<?= SITENAME ?>" style="border-radius: 8%; width:100px; margin-right:100px">

					<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-top: 20px; width:100%; border:#ff8000 solid; display:flex; align-items:center">

						<li><a href="<?= HOME ?>" class="nav-link px-2 text-orange">Início</a></li>

						<li><a href="<?= HOME ?>/contato" class="nav-link px-2 text-orange">Contatos</a></li>

						<li>
							<?php if (isset($_SESSION['sheep_user'])): ?>
								<a href="<?= HOME ?>/cliente/sheep.php" style="text-decoration: none;">Minha Conta</a>
							<?php else: ?>
								<a href="<?= HOME ?>/cliente/" style="text-decoration: none; margin-left:10px">Entrar</a>
							<?php endif; ?>
						</li>
					</ul>

				</div>
			</div>
		</header>
		<div class="b-example-divider"></div>
		<!-- FIM TOPO PAGAMENTO MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR -->

		<main>


			<style>
				.bg-orange {
					background-color: #ff8000 !important;
					/* Laranja forte */
					color: white !important;
					border: none !important;
					/* Remove a borda caso necessário */
				}

				/* Estilo específico para botão ativo */
				.nav-tabs .nav-link.active {
					background-color: #ff8000 !important;
					color: white !important;
					border: none !important;
				}
			</style>

			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link p2 rounded" href="<?= HOME ?>/pagamentos/index.php?token=<?= $_SESSION['token_pagamentos']  ?>" style="background-color: #666666;">
						<span style="color: orange;"> Cartão de Crédito</span>
					</a>
				</li>
				<?php
				//$cursoCripitografiaCartaoCredito = base64_encode($curso);
				?>
				<li class="nav-item" role="presentation" style="margin-left: 10px;">
					<button class="nav-link rounded bg-orange" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">PIX / Boleto</button>
				</li>
			</ul>

			<div class="tab-content" id="myTabContent">

				<!-- INICIO PAGAMENTO BOLETO E PIX MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<br>

					<?php
					/**
					 * 
					 * fORMULARIO USUARIO LOGADO
					 * 
					 */
					if (isset($_SESSION['sheep_user'])):
						$ler = new Ler();
						$ler->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
						if ($ler->getResultado()):
							foreach ($ler->getResultado() as $cliente);
							$cliente = (object) $cliente;
						endif;

					?>

						<div class="col-md-12 py-5 text-center">
							<div class="alert alert-warning">Atenção! Caso você queira mudar seus dados pessoais e o endereço da entrega clique
                        em "Minha Conta" acesse o "Painel do Cliente" e depois clique em "Configurações -> Minha Conta" e mude seus dados pessoais ou o endereço da
                        entrega, ou ambos, não se esqueça de mudar o "Número" e o "CEP" do local da entrega.</div>
							<br>
						</div>

						<form class="needs-validation" action="./confirmar_pagamento_pix_logado.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>" method="post">
							<div class="row g-5">


								<div class="col-md-12">
									<h4 class="mb-3">Dados do Pagador:</h4>


									<div class="row g-3">

										<div class="col-sm-4">
											<label for="nome_cliente" class="form-label">Nome</label>
											<input type="text" class="form-control" name="nome" placeholder="Seu primeiro nome" value="<?= $cliente->nome ?>"  required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="nome_cliente" class="form-label">Sobrenome</label>
											<input type="text" class="form-control" name="sobrenome" placeholder="Seu sobrenome" value="<?= $cliente->sobrenome ?>" required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="cpf" class="form-label">CPF</label>
											<input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF válido" value="<?= $cliente->cpf ?>"  required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="email" class="form-label">E-mail</label>
											<input type="email" class="form-control" name="email" placeholder="Seu e-mail" value="<?= $cliente->email ?>"  required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="telefone" class="form-label">Whatsapp / Celular</label>
											<input type="text" class="form-control" name="whatsapp" id="cel" placeholder="Seu celular" value="<?= $cliente->whatsapp?>"  required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="nascimento" class="form-label">Data de nascimento</label>
											<input type="date" class="form-control" name="nascimento"
												placeholder="Nascimento" value="<?= $cliente->nascimento ?>"  required readonly>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="id" class="form-label"></label>
											<input type="hidden" class="form-control" name="id" value="<?= $cliente->id ?>" required>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>


										<hr class="my-4">
										<h4 class="mb-3">Endereço de entrega</h4>
										<div class="col-sm-6">
											<label for="rua" class="form-label">Rua</label>
											<input type="text" class="form-control" name="endereco"
												value="<?= isset($cliente->endereco) ? $cliente->endereco : '' ?>"
												<?= isset($cliente->endereco) && $cliente->endereco ? 'readonly' : '' ?> required>
										</div>

										<div class="col-sm-2">
											<label for="numero" class="form-label">Número</label>
											<input type="number" class="form-control" name="numero"
												value="<?= isset($cliente->numero) ? $cliente->numero : '' ?>"
												<?= isset($cliente->numero) && $cliente->numero ? 'readonly' : '' ?> required>
										</div>

										<div class="col-sm-4">
											<label for="bairro" class="form-label">Bairro</label>
											<input type="text" class="form-control" name="bairro"
												value="<?= isset($cliente->bairro) ? $cliente->bairro : '' ?>"
												<?= isset($cliente->bairro) && $cliente->bairro ? 'readonly' : '' ?> required>
										</div>

										<div class="col-sm-3">
											<label for="cep" class="form-label">CEP</label>
											<input type="text" class="form-control cepmj" name="cep"
												value="<?= isset($cliente->cep) ? $cliente->cep : '' ?>"
												<?= isset($cliente->cep) && $cliente->cep ? 'readonly' : '' ?> required>
										</div>

										<div class="col-sm-4">
											<label for="cidade" class="form-label">Estado</label>
											<select class="form-select load_estados" name="estado" id="estado" required disabled>
												<option value="0">Selecione o Estado</option>
												<?php
												$sheep->Leitura('app_estados', "ORDER BY estado_nome ASC");
												if ($sheep->getResultado()):
													foreach ($sheep->getResultado() as $estado):
														$estado = (object) $estado;
												?>
														<option value="<?= isset($estado->estado_id) ?>" <?= $cliente->estado == $estado->estado_id ? 'selected' : null;  ?>><?= $estado->estado_nome ?></option>
												<?php
													endforeach;
												endif;
												?>

											</select>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-5">
											<label for="cidade" class="form-label">Cidade</label>
											<select class="form-select load_cidades" name="cidade" id="cidade" required disabled>
												<option value="0">Selecione a Cidade</option>

												<?php
												$sheep->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
												$cidadesPagamento = Formata::Resultado($sheep);
												if ($cidadesPagamento):
													foreach ($sheep->getResultado() as $cidade):
														$cidade = (object) $cidade;
												?>
														<option value="<?= isset($cidade->cidade_id) ?>" <?= $cliente->cidade == $cidade->cidade_id ? 'selected' : null;  ?>><?= $cidade->cidade_nome ?></option>
												<?php
													endforeach;
												endif;
												?>
											</select>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

									</div>

									<span id="mensagem"></span>

									<?php
									// Obtém o ID da sessão atual do usuário
									$idSessaoAtual = session_id();

									// Formata o valor total
									$mudaValor = Formata::vr($_SESSION['total_valor']); // Exemplo: 76,88
									$valorModificado = str_replace([',', '.'], '', $mudaValor); // Exemplo: 7688
									$valorFinal = (int) $valorModificado; // Converte para inteiro

									// Obtém o ID da sessão na tabela carrinho correspondente à sessão atual do usuário
									$lerIdsessao = new Ler();
									$query = "SELECT id_sessao FROM carrinho WHERE id_sessao = '$idSessaoAtual' LIMIT 1"; // Consulta corrigida

									$lerIdsessao->LeituraCompleta($query);

									$idsessao = $idSessaoAtual; // Define o ID da sessão padrão como a sessão atual
									if ($lerIdsessao->getResultado()) {
										$resultado = $lerIdsessao->getResultado()[0];
										$idsessao = $resultado['id_sessao'] ?? $idSessaoAtual; // Caso não tenha resultado, mantém a sessão atual
									}
									?>

									<input type="hidden" name="valor_total" id="valor_total" value="<?= $valorFinal ?>" required>
									<input type="hidden" name="id_sessao" value="<?= htmlspecialchars($idsessao) ?>">
									<input type="hidden" name="total_valor" value="<?= htmlspecialchars($_SESSION['total_valor']) ?>">
									<input type="hidden" name="total_qtde" value="<?= htmlspecialchars($_SESSION['total_qtde']) ?>">


									<br>
									<br>
									<div id="areaBotoes" class="row g-3 ">
										<div class="col-12 ">
											<button class="w-100 btn btn-success btn-lg" type="submit" name="sendPagamento">Confirmar pagamento</button>
										</div>
									</div>
								</div>
							</div>
						</form>


					<?php
						/**
						 * 
						 * FORMULARIO USUARIO SEM CADATRO
						 * 
						 */
					else:
					?>

						<div class="col-md-12 py-5 text-center">
							<div class="alert alert-warning">Atenção! Você saiu do Painel do Cliente. </div>
							<br>
						</div>

						<form class="needs-validation" id="formulario_pagamento" method="post"
							action="./confirmar_pagamento_pix.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>">
							<div class="row g-5">


								<div class="col-md-12">
									<h4 class="mb-3">Dados do Pagador:</h4>

									<!-- INICIO VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
									<?php
									$emailExiste = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_BOOLEAN);
									if ($emailExiste):
									?>
										<div class="alert alert-danger" role="alert">
											Este e-mail já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
										</div>
									<?php endif; ?>
									<!-- FIM VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->

									<!-- INICIO VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
									<?php
									$cpfExiste = filter_input(INPUT_GET, 'cpf', FILTER_VALIDATE_BOOLEAN);
									if ($cpfExiste):
									?>
										<div class="alert alert-danger" role="alert">
											Este CPF já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
										</div>
									<?php endif; ?>
									<!-- FIM VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->


									<div class="row g-3">
										<div class="col-sm-4">
											<label for="nome_cliente" class="form-label">Nome</label>
											<input type="text" class="form-control" name="nome" placeholder="Seu primeiro nome" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="nome_cliente" class="form-label">Sobrenome</label>
											<input type="text" class="form-control" name="sobrenome" placeholder="Seu sobrenome" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="cpf" class="form-label">CPF</label>
											<input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF válido" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="email" class="form-label">E-mail</label>
											<input type="email" class="form-control" name="email" placeholder="Seu e-mail" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="telefone" class="form-label">Whatsapp / Celular</label>
											<input type="text" class="form-control" name="whatsapp" id="cel" placeholder="Seu celular" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="nascimento" class="form-label">Data de nascimento</label>
											<input type="date" class="form-control" name="nascimento"
												placeholder="Nascimento" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>



										<hr class="my-4">
										<h4 class="mb-3">Endereço de entrega</h4>

										<div class="col-sm-6">
											<label for="rua" class="form-label">Rua</label>
											<input type="text" class="form-control" name="endereco" id="rua"
												placeholder="Seu Endereço" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-2">
											<label for="numero" class="form-label">Número</label>
											<input type="number" class="form-control" name="numero" id="numero" placeholder="Número" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="numero" class="form-label">Bairro</label>
											<input type="text" class="form-control" name="bairro" id="numero" placeholder="Número" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>


										<div class="col-sm-3">
											<label for="cep" class="form-label">CEP</label>
											<input type="text" class="form-control cepmj" name="cep" placeholder="Seu CEP" value="" required disabled>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-4">
											<label for="cidade" class="form-label">Estado</label>
											<select class="form-select load_estados" name="estado" id="estado" required disabled>
												<option value="0">Selecione o Estado</option>
												<?php
												$sheep->Leitura('app_estados', "ORDER BY estado_nome ASC");
												if ($sheep->getResultado()):
													foreach ($sheep->getResultado() as $estado):
														$estado = (object) $estado;
												?>
														<option value="<?= $estado->estado_id ?>"><?= $estado->estado_nome ?></option>
												<?php
													endforeach;
												endif;
												?>

											</select>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

										<div class="col-sm-5">
											<label for="cidade" class="form-label">Cidade</label>
											<select class="form-select load_cidades" name="cidade" id="cidade" required disabled>
												<option value="0">Selecione a Cidade</option>

												<?php
												$sheep->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
												$cidadesPagamento = Formata::Resultado($sheep);
												if ($cidadesPagamento):
													foreach ($sheep->getResultado() as $cidade):
														$cidade = (object) $cidade;
												?>
														<option value="<?= $cidade->cidade_id ?>"><?= $cidade->cidade_nome ?></option>
												<?php
													endforeach;
												endif;
												?>
											</select>
											<div class="invalid-feedback">
												Este campo é obrigatório.
											</div>
										</div>

									</div>

									<hr class="my-4">

									<br>
									<br>

									<h4 class="mb-3">Senha de acesso(minimo 8 digitos letras, números e caracteres especiais)</h4>

									<div class="col-sm-12">
										<label for="rua" class="form-label">Sua Senha</label>
										<input type="password" class="form-control" name="senha"
											placeholder="Senha no minimo 8 digitos letras, números e caracteres especiais" id="senha1" oninput="verificarSenhas();" required disabled>
										<small>Sugestão de Senha: <b> <?= Formata::GerarSimbolos(20) . '@' . random_int(10, 100) . '_' . date('s'); ?> </b> </small>
										<div class="invalid-feedback">
											Este campo é obrigatório.
										</div>
									</div>

									<br>

									<div class="col-sm-12">
										<label for="numero" class="form-label">Confirmar Senhas</label>
										<input type="password" class="form-control" placeholder="Confirmar a senha" id="senha2" name="senha2" oninput="verificarSenhas();" required disabled>
										<div class="invalid-feedback">
											Este campo é obrigatório.
										</div>
									</div>

									<span id="mensagem"></span>
								</div>

								<?php
								$mudaValor = Formata::vr($_SESSION['total_valor']); // 76,88
								$valorOriginal = $mudaValor;
								$valorModificado = str_replace([",", "."], "", $valorOriginal); // 7688
								$valorFinal = (int) $valorModificado; // 7688

								$lerIdsessao = new Ler();
								$lerIdsessao->LeituraCompleta("SELECT id_sessao FROM carrinho ORDER BY id_sessao DESC");

								// Verifica se o resultado é válido
								if ($lerIdsessao->getResultado()):
									// Obtém o array associativo completo
									$resultado = $lerIdsessao->getResultado()[0];

									// Acessa diretamente o valor da chave 'id_sesao'
									$idsessao = $resultado['id_sessao'];

									// Converte o valor para string
									//$idSessaoString = strval($idsessao);

								?>
								<?php
								endif;
								?>

								<input type="hidden" name="valor_total" id="valor_total" value="<?= $valorFinal  ?>" required>
								<input type="hidden" name="id_sessao" value="<?= $idsessao ?>">
								<input type="hidden" name="total_valor" value="<?= $_SESSION['total_valor'] ?>">
								<input type="hidden" name="total_qtde" value="<?= $_SESSION['total_qtde'] ?>">



								<br>
								<br>
								<div id="areaBotoes" class="row g-3" style="margin-left: 2px;">
									<div class="col-12 ">
										<button class="w-100 btn btn-success btn-lg" type="submit" name="sendPagamento" disabled>Confirmar pagamento</button>
									</div>
								</div>
							</div>
				</div>
				</form>

			<?php endif; ?>


			</div>
			<!-- FIM PAGAMENTO BOLETO E PIX MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->

	</div>


	</main>

	<footer class="my-5 pt-5 text-muted text-center text-small">
		<a href="https://gerencianet.com.br/" target="_blank">
			<img style="height: 50px;" src="compra-segura.png" alt="Gerencianet - Conceito em Pagamentos">
		</a>
	</footer>
	</div>

	<!-- Modal Container -->
	<!-- INICIO JANELA MODAL MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->
	<div class="modal fade" id="suporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Para Alunos</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="embed-responsive embed-responsive-16by9">
						<video width="100%" height="350" controls>
							<source src="<?= HOME ?>/pagamento-msflix/suporte/suporte-aluno.mp4" type="video/mp4">
							<source src="<?= HOME ?>/pagamento-msflix/suporte/suporte-aluno.mp4" type="video/ogg">
							Não tem suporte o seu navegador!
						</video>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>

				</div>
			</div>
		</div>
	</div>
	<!-- FIM JANELA MODAL MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->


	<script src="./js/scripsts.js"></script>

	<!--- INICIOCOMBO SELECIONA ESTADO E CIDADE WEBTECPR.COM.BR--->

	<script src="./js/custom.js"></script>
	<!--- FIMCOMBO SELECIONA ESTADO E CIDADE WEBTECPR.COM.BR--->

	<script>
		document.querySelector("form").addEventListener("submit", function() {
			document.querySelectorAll(":disabled").forEach(el => el.removeAttribute("disabled"));
		});
	</script>

	<script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js"></script>

	<script src="https://getbootstrap.com/docs/5.1/examples/checkout/form-validation.js"></script>


</body>

</html>