{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Visualizar agenda</h1>
	<div class="col-md-6 col-md-offset-3 form-horizontal">
		<div class="form-group">
			<div class="form-group">
				<div class="text-danger">
					<div id="div_retorno">
						&nbsp;
					</div>
				</div>
			</div>
			<span>Quem agendou?: </span><label class="control-label"> {{agenda['nomeadmin']}}</label><br>
			<span>Cliente: </span><label class="control-label"> {{agenda['nome']}}</label><br>
			<span>Categoria: </span><label class="control-label"> {{agenda['descricao']}}</label><br>
			<span>Data: </span><label class="control-label"> {{agenda['data']|date("d/m/Y")}}</label><br>
			<span>Hora: </span><label class="control-label"> {{agenda['hora']}}</label><br>
			<span>Título: </span><label class="control-label"> {{agenda['titulo']}}</label><br>
			<label class="control-label">Assunto:</label>
			<textarea style="min-height: 80px;resize: vertical;" class="form-control" rows="5" readonly="true">{{agenda['assunto']}}</textarea>
			<br>
			{% if agenda['status'] == 1 %}
			<span class="alert btn-success">Ativo</span>
			{% else %}
			<span class="alert btn-danger">Cancelada</span>
			{% endif %}
		</div>
		<div class="text-center">
			<a href="{{usuario['tipo'] == 'Administrador' ? '/admin/agenda' : '/agenda'}}" class="btn btn-warning">Voltar</a>
			<div id="processando" style="display: none;">
				<img src="/img/ajax-loader.gif" />
			</div>
		</div>
	</div>
</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}