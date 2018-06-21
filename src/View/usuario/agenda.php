{% extends "master.twig" %}
{% block conteudo %}
<div class="col-md-12">
	<h1 class="text-center text-success">{{usuario['nome']}} - Agenda</h1>
	<div class="form-group">
		<div class="row">
			<div class="col-md-3">
				<label class="control-label">Palavra-chave</label>
				<input id="pesquisaAgenda" type="text" class="form-control" name="buscaagenda" maxlength="50"  placeholder="Pesquisa" autofocus>
			</div>
			<div class="col-md-3">
				<label class="control-label">Categoria</label>
				<select id="categoria" name="categoria" class="input-group btn btn-default btn-block">
					{% if categorias is not empty %}
					<option selected="" value="0">Todas categorias</option>
					{% for categoria in categorias %}
					<option value="{{categoria['id']}}">{{categoria['descricao']}}</option>
					{% endfor %}
					{% else %}
					<option selected="" value="-1">Nenhum categoria cadastrada</option>
					{% endif %}

				</select>
			</div>
			<div class="col-md-2">
				<label class="control-label">Data inicial</label>
				<input type="text" class="form-control" id="datainicial" name="datainicial" required>
			</div>
			<div class="col-md-2">
				<label class="control-label">Data final</label>
				<input type="text" class="form-control" id="datafinal" name="datafinal" required>
			</div>
			<div class="col-md-2">
				<label class="control-label">&nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon btn-primary" id="btnIconPesquisaAgendaUsuario">
						<i class="glyphicon glyphicon-search" style="color: white;"></i>
					</div>
					<input id="btnPesquisaAgendaUsuario" type="button" class="form-control btn btn-primary" value="Buscar">
				</div>
			</div>
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
					<th class="text-center">Quem agendou?</th>
					<th class="text-center">Categoria</th>
					<th class="text-center">Ações</th>
				</tr>
			</thead>
			<tbody id="conteudo">
				{% for agenda in agendas %}
				{% if agenda['status'] == 0 %}
				<tr class="alert-danger">
					{% else %}
					<tr>
						{% endif %}
						<td>{{agenda['id']}}</td>
						<td>{{agenda['data']|date("d/m/Y") }}</td>
						<td>{{agenda['hora']}}</td>
						<td>{{agenda['titulo']}}</td>
						<td>{{agenda['assunto']|slice(0,30)~'...' }}</td>
						<td>{{agenda['nome']}}</td>
						<td>{{agenda['descricao']}}</td>
						<td>
							<a href="/agenda/show/{{agenda['id']}}" class="btn btn-info glyphicon glyphicon-info-sign btn-xs"></a>
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
			<span id ="detalhes" class="">Total de: {{agendas|length}} registro(s).</span>
		</div>


	</div>
	{% endblock %}

	{% block rodape %}
	{{ parent() }}
	<script src="/js/jquery.inputmask.js" type="text/javascript" ></script>
	<script type="text/javascript" src="/js/jquery.inputmask.date.extensions.js"></script>
	<script type="text/javascript">
		$('#datainicial').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa', "clearIncomplete": true });
		$('#datainicial').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			language: 'pt-BR',
			weekStart: 0,
			todayHighlight: true
		});
		$('#datafinal').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/aaaa', "clearIncomplete": true })
		$('#datafinal').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			language: 'pt-BR',
			weekStart: 0,
			todayHighlight: true
		});
	</script>
	{% endblock %}