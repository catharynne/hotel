{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Agendas</h1>
	<div class="row">
		<div class="col-md-6">
			<a href="/admin/agenda/novo" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo</a>
		</div>
		<div class="col-md-6">
			<input id="pesquisa" onkeyup="searchagenda(this.value)" type="text" class="form-control datepicker" name="pesquisa" maxlength="50"  placeholder="Pesquisa" autofocus>
		</div>
	</div>
	<div class="table-responsive">
		<table id="table" class="table table-sm table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr style="background-color: #CCCCCC">
					<th class="text-center">Id</th>
					<th class="text-center">Data</th>
					<th class="text-center">Hora</th>
					<th class="text-center">Titulo</th>
					<th class="text-center">Assunto</th>
					<th class="text-center">Cliente</th>
					<th class="text-center">Categoria</th>
					<th class="text-center">Ações</th>
				</tr>
			</thead>
			<!-- str_limit($orcamento->title, $limit = 50, $end = '...') -->
			<tbody id="conteudo">
				{% for agenda in agendas %}
				<tr>
					<td>{{agenda['id']}}</td>
					<td>{{agenda['data']|date("d/m/Y") }}</td>
					<td>{{agenda['hora']}}</td>
					<td>{{agenda['titulo']}}</td>
					<td>{{agenda['assunto']|slice(0,30)~'...' }}</td>
					<td>{{agenda['nome']}}</td>
					<td>{{agenda['descricao']}}</td>
					<td>
						<a href="/admin/agenda/editar/{{agenda['id']}}" class="btn btn-warning glyphicon glyphicon-pencil btn-xs"></a>
					</td>
				</tr>
				{% endfor %}
			</tbody>

		</table>
		<div class="form-group">
			<div class="text-danger">
				<div id="div_retorno">
					&nbsp;
				</div>
			</div>
		</div>
		<div id="processando" style="display: none;">
			<img src="/img/ajax-loader.gif" />
			</div>
		<span id ="detalhes" class="">Total de: {{agenda|length}} registro(s).</span>
	</div>


</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}