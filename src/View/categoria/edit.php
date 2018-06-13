{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Editar categoria</h1>
	<div class="col-md-6 col-md-offset-3 form-horizontal">
		<div class="form-group">
			<div class="form-group">
				<div class="text-danger">
					<div id="div_retorno">
						&nbsp;
					</div>
				</div>
			</div>
			<input type="hidden" id="idCategoria" name="idCategoria" value="{{categoria['id']}}">
			<label class="control-label">Descrição</label>
			<input type="text" class="form-control" id="descricao" name="descricao" required value="{{categoria['descricao']}}">
		</div>
		<div class="text-center">
			<button class="btn btn-success" id="btnAtualizarCategoria">Atualizar</button>
			<a href="/admin/categoria" class="btn btn-danger">Cancelar</a>
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