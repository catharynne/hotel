{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Novo usuário</h1>
	<div class="col-md-6 col-md-offset-3 form-horizontal">
		<div class="form-group">
			<div class="form-group">
				<div class="text-danger">
					<div id="div_retorno">
						&nbsp;
					</div>
				</div>
			</div>
			<label class="control-label">Nome</label>
			<input type="text" class="form-control" id="nome" name="nome" required>
			<label class="control-label">Email</label>
			<input type="email" class="form-control" id="email" name="email" required>
			<label class="control-label">Cpf</label>
			<input type="text" class="form-control" id="cpf" name="cpf" required>
			<label class="control-label">Telefone</label>
			<input type="text" class="form-control" id="telefone" name="telefone" required>
			<label class="control-label">Senha</label>
			<input type="password" class="form-control" id="senha" name="senha" required>
			<label class="control-label">Confirme a senha</label>
			<input type="password" class="form-control" id="senha2" name="senha2" required>
		</div>
		<div class="text-center">
			<button class="btn btn-success" id="btnSalvarUsuario">Salvar</button>
			<a href="/admin/usuario" class="btn btn-danger">Cancelar</a>
			<div id="processando" style="display: none;">
				<img src="/img/ajax-loader.gif" />
			</div>
		</div>
	</div>
</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
<script src="/js/jquery.inputmask.js" type="text/javascript" ></script>
<script type="text/javascript">
	$('#cpf').inputmask('999.999.999-99',{'placeholder': '___.___.___-__', "clearIncomplete": true })
	$('#telefone').inputmask('(99) 9 9999-9999',{'placeholder': '(__) _ ____-____', "clearIncomplete": true })
</script>
{% endblock %}