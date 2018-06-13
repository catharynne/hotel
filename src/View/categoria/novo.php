{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Nova categoria</h1>
	<div class="col-md-6 col-md-offset-3 form-horizontal">
		<div class="form-group">
			<div class="form-group">
				<div class="text-danger">
					<div id="div_retorno">
						&nbsp;
					</div>
				</div>
			</div>
			<label class="control-label">Descrição</label>
			<input type="text" class="form-control" id="descricao" name="descricao" required>
		</div>
		<div class="text-center">
			<button class="btn btn-success" id="btnSalvarCategoria">Salvar</button>
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