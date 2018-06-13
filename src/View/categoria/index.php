{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Categorias</h1>
	<div class="row">
		<div class="col-md-6">
			<a href="/admin/categoria/novo" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo</a>
		</div>
		<div class="col-md-6">
			<input id="pesquisacateg" onkeyup="searchCateg(this.value)" type="text" class="form-control" name="pesquisacateg" maxlength="50"  placeholder="Pesquisa" autofocus>
		</div>
	</div>
	<div class="table-responsive">
		<table id="table" class="table table-sm table-striped table-condensed table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr style="background-color: #CCCCCC">
					<th class="text-center">Id</th>
					<th class="text-center">Descricao</th>
					<th class="text-center">Ações</th>
				</tr>
			</thead>
			<tbody id="conteudocateg">
				{% for categoria in categorias %}
				<tr>
					<td>{{categoria['id']}}</td>
					<td>{{categoria['descricao']}}</td>
					<td>
						<a href="/admin/categoria/editar/{{categoria['id']}}" class="btn btn-warning glyphicon glyphicon-pencil btn-xs"></a>
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
		<span id ="detalhescateg" class="">Total de: {{categorias|length}} registro(s).</span>
	</div>


</div>
{% endblock %}

{% block rodape %}
{{ parent() }}
{% endblock %}