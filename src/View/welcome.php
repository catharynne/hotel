{% extends "master.twig" %}



{% block conteudo %}
{{ parent() }}
<div class="row">
	<div class="col-md-8">
		<h1 class="text-center text-success">
			Raul Shauber<br>detonando em<br>Nova York.
		</h1>

	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="email">Email</label>
			<input class="form-control" id="email" name="email" type="email" placeholder="Endereço de email">
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
		<div id="processando" style="display: none;">
			<img src="img/ajax-loader.gif" />
		</div>
	</div>	
</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}