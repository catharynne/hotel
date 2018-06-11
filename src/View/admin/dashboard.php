{% extends "master.twig" %}
{% block conteudo %}
	<div class="col-md-12">
		<h1 class="text-center text-success">
			Raul Shauber<br>Painel administrativo.
			{{usuario['tipo']}}

		</h1>

	</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}