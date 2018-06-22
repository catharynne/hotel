{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">Editar agenda</h1>
	<div class="col-md-6 col-md-offset-3 form-horizontal">
		<div class="form-group">
			<div class="form-group">
				<div class="text-danger">
					<div id="div_retorno">
						&nbsp;
					</div>
				</div>
			</div>
			<input type="hidden" value="{{agenda['id']}}" name="idAgenda" id="idAgenda">
			<label class="control-label">Cliente</label>
			<select id="cliente" name="cliente" class="input-group btn btn-success btn-block">
				{% if agenda is not empty %}
				<option selected="" value="-1">Selecione um cliente</option>
				{% for cliente in clientes %}
				{% if cliente['id'] == agenda['cliente'] %}
				<option selected="" value="{{cliente['id']}}">{{cliente['nome']}} - CPF: {{cliente['cpf']}}</option>
				{% else %}
				<option value="{{cliente['id']}}">{{cliente['nome']}} - CPF: {{cliente['cpf']}}</option>
				{% endif %}
				{% endfor %}
				{% else %}
				<option selected="" value="0">Nenhum cliente cadastrado</option>
				{% endif %}

			</select>
			<label class="control-label">Categoria</label>
			<select id="categoria" name="categoria" class="input-group btn btn-primary btn-block">
				{% if categorias is not empty %}
				<option selected="" value="-1">Selecione uma categoria</option>
				{% for categoria in categorias %}
				{% if categoria['id'] == agenda['categoria'] %}
				<option selected="" value="{{categoria['id']}}">{{categoria['descricao']}}</option>
				{% else %}
				<option value="{{categoria['id']}}">{{categoria['descricao']}}</option>
				{% endif %}
				{% endfor %}
				{% else %}
				<option selected="" value="0">Nenhum categoria cadastrada</option>
				{% endif %}

			</select>
			<label class="control-label">Título</label>
			<input type="text" class="form-control" id="titulo" value="{{agenda['titulo']}}" name="titulo" required>
			<label class="control-label">Assunto</label>
			<textarea style="min-height: 80px;resize: vertical;" class="form-control" placeholder="" name="assunto" rows="5" id="assunto" required>{{agenda['assunto']}}</textarea>
			<label class="control-label">Data</label>
			<input type="text" class="form-control" id="dataatualizar" name="data" value="{{agenda['data']|date("d/m/Y")}}" required readonly="true">
			<label class="control-label">Hora</label>
			<div class="bootstrap-timepicker">
				<input type="text" class="form-control timepicker" value="{{agenda['hora']}}" id="hora" name="hora" required readonly="true">
			</div>
			<label class="control-label">Status</label>
			<select id="status" name="status" class="input-group btn btn-default btn-block">
				{% if agenda['status'] == 1 %}
				<option selected="" value="1">Ativo</option>
				<option value="0">Inativo</option>
				{% else %}
				<option value="1">Ativo</option>
				<option selected="" value="0">Inativo</option>
				{% endif %}
			</select>
		</div>
		<div class="text-center">
			<button class="btn btn-success" id="btnAtualizarAgenda">Salvar</button>
			<a href="/admin/agenda" class="btn btn-danger">Cancelar</a>
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
<script type="text/javascript" src="/js/jquery.inputmask.date.extensions.js"></script>
<script type="text/javascript">
	$('#dataatualizar').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa', "clearIncomplete": true })
	$('#hora').inputmask('99:99', { 'placeholder': 'HH:mm', "clearIncomplete": true })
</script>
{% endblock %}