{% extends "master.twig" %}

{% block conteudo %}
{{ parent() }}

<div class="row">
	<div class="col-md-8">
		<h1>RAUL - PROJETO DE PPI2 </h1>

	</div>
	{% if usuario is empty %}
	<div class="col-md-4">
		<div class="form-group">
			<label for="email">Email ou CPF(somente números)</label>
			<input class="form-control" id="email" name="email" type="email" placeholder="Endereço de email cpf somente números">
		</div>
		<div class="form-group">
			<label for="senha">Senha</label>
			<input class="form-control" id="senha" name="senha" type="password" placeholder="Senha">
		</div>
		<div class="form-group">
			<div class="text-danger">
				<div id="div_retorno">
					&nbsp;
				</div>
			</div>
		</div>
		<button class="btn btn-primary btn-block" id="btnLogin">Login</button>
		<br>

		<div class="row container">
		<label class="control-label">Não tem registro?</label>
		<a href="/registro" class="btn btn-success">Cadastre-se</a>
		</div>
		<div id="processando" style="display: none;">
			<img src="img/ajax-loader.gif" />
		</div>
	</div>	
	{% endif%}
</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}