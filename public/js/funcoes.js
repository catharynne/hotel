$(document).ready(function () {
    $('#data').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      language: 'pt-BR',
      weekStart: 0,
      startDate:'0d',
      todayHighlight: true
  });
     $('#dataatualizar').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      language: 'pt-BR',
      weekStart: 0,
      todayHighlight: true
  });
    $('.makedata').datepicker('setDate', new Date());
    $('#hora').timepicker({
        showInputs: false,
        showMeridian: false,
        defaultTime: 'current',
        minuteStep: 30
    })
    $("#butao1").click(function () {
        $.ajax({
            type: 'GET',
            url: '/texto.html',
            data: "",
            success: function (dados) {
                $("#div_retorno").html(dados);
            },
            beforeSend: function () {
                $("#processando").css({display: "block"});
            },
            complete: function () {
                $("#processando").css({display: "none"});
            },
            error: function () {
                $("#div_retorno").html("Erro em chamar a função.");
                setTimeout(function () {
                    $("#div_retorno").css({display: "none"});
                }, 5000);
            }
        });
    });
    $("#btnLogin").click(function () {
        senha = $("#senha").val();
        email = $("#email").val();
        if(senha == "" || email == ""){
            $("#div_retorno").html("Campo email e senha são de preenchimento obrigatório.");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/validaLogin',
            data: {
                email: email,
                senha: senha,
            },
            success: function (dados) {
                //alert(dados);
                if(dados == "errologin"){
                    $("#div_retorno").html("Usuário ou senha inválido.");
                }else if(dados == "admin"){
                    window.location.href = "/admin";
                }else if(dados == "cliente"){
                    window.location.href = "/agenda";
                }else{
                    window.location.href = "/";
                }
            },
            beforeSend: function () {
                $("#processando").css({display: "block"});
            },
            complete: function () {
                $("#processando").css({display: "none"});
            },
            error: function () {
                $("#div_retorno").html("Erro em chamar a função.");
                setTimeout(function () {
                    $("#div_retorno").css({display: "none"});
                }, 5000);
            }
        });
});
});
$("#btnSalvarUsuario").click(function () {
    senha = $("#senha").val();
    senha2 = $("#senha2").val();
    email = $("#email").val();
    nome = $("#nome").val();
    telefone = $("#telefone").val();
    cpf = $("#cpf").val();
    if(senha == "" || senha2 == "" || email == "" || nome == "" || telefone == "" || cpf == ""){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    if(senha != senha2){
        alert("Os campos senha e confirmação da senha estão diferentes.");
        return;
    }
    if(senha == "" || email == ""){
        $("#div_retorno").html("Campo email e senha são de preenchimento obrigatório.");
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/usuario/salvar',
        data: {
            nome: nome,
            email: email,
            senha: senha,
            telefone: telefone,
            cpf: cpf
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.cpf){
                    alert(erro.cpf);
                    return;
                }
                if(erro.email){
                    alert(erro.email);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Usuário cadastrada com sucesso...");
                    window.location.href = "/admin/usuario";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#btnAtualizarUsuario").click(function () {
    email = $("#email").val();
    idUsuario = $("#idUsuario").val();
    nome = $("#nome").val();
    telefone = $("#telefone").val();
    cpf = $("#cpf").val();
    tipousuario = $("#tipousuario").val();
    if(email == "" || nome == "" || telefone == "" || cpf == ""){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/usuario/atualizar',
        data: {
            idUsuario: idUsuario,
            nome: nome,
            email: email,
            telefone: telefone,
            cpf: cpf,
            tipousuario: tipousuario
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.usuario){
                    alert("Usuário não encontrado...");
                    return;
                }
                if(erro.cpf){
                    alert(erro.cpf);
                    return;
                }
                if(erro.email){
                    alert(erro.email);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Usuário atualizado com sucesso...");
                    window.location.href = "/admin/usuario";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#btnSalvarCategoria").click(function () {
    desc = $("#descricao").val();
    if(desc == ""){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/categoria/salvar',
        data: {
            descricao: desc
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.descricao){
                    alert(erro.descricao);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Categoria cadastrada com sucesso...");
                    window.location.href = "/admin/categoria";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#btnAtualizarCategoria").click(function () {
    desc = $("#descricao").val();
    idCateg = $("#idCategoria").val();
    if(desc == ""){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/categoria/atualizar',
        data: {
            idCategoria: idCateg,
            descricao: desc
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.categ){
                    alert("Categoria não encontrado...");
                    return;
                }
                if(erro.descricao){
                    alert(erro.descricao);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Categoria atualizado com sucesso...");
                    window.location.href = "/admin/categoria";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#btnSalvarAgenda").click(function () {
    titulo = $("#titulo").val();
    assunto = $("#assunto").val();
    data = $("#data").val();
    hora = $("#hora").val();
    categoria = $("#categoria").val();
    cliente = $("#cliente").val();
    if(titulo == "" || assunto == "" || data == "" || hora == "" || cliente <= 0 || categoria <= 0){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    datax = data.toString().split("/");
    d1 = new Date(datax[2]+"-"+datax[1]+"-"+datax[0]+" "+hora);
    d2 = new Date();
    if(d1 < d2){
        alert("A data e a hora, não podem ser menores que a data e a hora atual xD");
        return;
    }
    $.ajax({
        type: 'POST',
        url: '/agenda/salvar',
        data: {
            titulo: titulo,
            assunto: assunto,
            data: data,
            hora: hora,
            cliente: cliente,
            categoria: categoria
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.agenda){
                    alert(erro.agenda);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Agenda cadastrada com sucesso...");
                    window.location.href = "/admin/agenda";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#btnAtualizarAgenda").click(function () {
    titulo = $("#titulo").val();
    assunto = $("#assunto").val();
    data = $("#dataatualizar").val();
    hora = $("#hora").val();
    categoria = $("#categoria").val();
    cliente = $("#cliente").val();
    status = $("#status").val();
    idAgenda = $("#idAgenda").val();
    if(titulo == "" || assunto == "" || data == "" || hora == "" || cliente <= 0 || categoria <= 0){
        alert("Todos os campos são de preenchimento obrigatório");
        return;
    }
    /*datax = data.toString().split("/");
    d1 = new Date(datax[2]+"-"+datax[1]+"-"+datax[0]+" "+hora);
    d2 = new Date();
    if(d1 < d2){
        alert("A data e a hora, não podem ser menores que a data e a hora atual xD");
        return;
    }*/
    $.ajax({
        type: 'POST',
        url: '/agenda/atualizar',
        data: {
            idAgenda: idAgenda,
            status: status,
            titulo: titulo,
            assunto: assunto,
            data: data,
            hora: hora,
            cliente: cliente,
            categoria: categoria
        },
        success: function (dados) {
            erro = JSON.parse(dados);
            if(erro){
                if(erro.agenda){
                    alert(erro.agenda);
                    return;
                }
                if(erro.cadastro == "ok"){
                    alert("Agenda atualizada com sucesso...");
                    window.location.href = "/admin/agenda";
                    return;
                }else if(erro.cadastro == "erro"){
                    alert("Algo deu errado no database");
                    return;
                }
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});

function refreshTable() {
    var value = "";
    $.ajax({
        type: 'GET',
        url: '/admin/usuario',
        data: {
            busca: value
        },
        success: function (data) {
            var usuarios = JSON.parse(data);
            if (usuarios) {
                fillTable(usuarios);
            }
        }
    }).done(function (info) {

    });

}
$("#pesquisa").on('keyup', function (e) {

    if (e.keyCode === 27 || e.keyCode === 13 || (e.keyCode == 8 && $("#pesquisa").val().length < 1) ){
        $("#pesquisa").val("");
        refreshTable();
    } 

});
function searchUsuario(value){
    if (value.length < 1) {
        return;
    }
    //var str = "'%" + value + "%'";
    $.ajax({
        type: 'GET',
        url: '/admin/usuario',
        data: {
            busca: value
        },
        success: function (dados) {
            try {
                var usuarios = JSON.parse(dados);
                if (usuarios[0]) {
                    fillTable(usuarios);
                }else{
                    $("#conteudo").html("");
                    $("#detalhes").html("Nenhum registor encontrado.");
                }
            } catch (err) {
                alert("Nenhum registro encontrado com o texto " + texto);
                $("#pesquisa").val("");
                $("#conteudo").html("");
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
}
function fillTable(row) {
    $("#conteudo").html("");
    for (var i in row) {
        $("#conteudo").append("<tr><td>" + row[i].id +"</td>"+
            "<td>" + row[i].nome + "</td><td>" + row[i].email + "</td><td>" + row[i].cpf + "</td>" +
            "<td>" + row[i].telefone + "</td>"+
            "<td><a class='btn btn-warning glyphicon glyphicon-pencil btn-xs' href='/admin/usuario/editar/" + row[i].id + "'></td>" +
            "</tr>");
        if (row.length > 0) {
            $("#detalhes").html("Total de: " + row.length + " registro(s).");
        } else {
            $("#detalhes").html("Nenhum registor encontrado.");
        }
    }
}
function refreshTableCateg() {
    var value = "";
    $.ajax({
        type: 'GET',
        url: '/admin/categoria',
        data: {
            buscacateg: value
        },
        success: function (data) {
            var categorias = JSON.parse(data);
            if (categorias[0]) {
                fillTableCateg(categorias);
            }
        }
    }).done(function (info) {

    });

}
$("#pesquisacateg").on('keyup', function (e) {

    if (e.keyCode === 27 || e.keyCode === 13 || (e.keyCode == 8 && $("#pesquisacateg").val().length < 1) ){
        $("#pesquisacateg").val("");
        refreshTableCateg();
    } 

});
function searchCateg(value){
    if (value.length < 1) {
        return;
    }
    $.ajax({
        type: 'GET',
        url: '/admin/categoria',
        data: {
            buscacateg: value
        },
        success: function (dados) {
            try {
                var categorias = JSON.parse(dados);
                if (categorias[0]) {
                    fillTableCateg(categorias);
                }else{
                    $("#conteudocateg").html("");
                    $("#detalhescateg").html("Nenhum registor encontrado.");
                }
            } catch (err) {
                alert("Nenhum registro encontrado com o texto " + texto);
                $("#pesquisacateg").val("");
                $("#conteudocateg").html("");
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
}
function fillTableCateg(row) {
    $("#conteudocateg").html("");
    for (var i in row) {
        $("#conteudocateg").append("<tr><td>" + row[i].id +"</td>"+
            "<td>" + row[i].descricao + "</td>"+
            "<td><a class='btn btn-warning glyphicon glyphicon-pencil btn-xs' href='/admin/categoria/editar/" + row[i].id + "'></td>" +
            "</tr>");
        if (row.length > 0) {
            $("#detalhescateg").html("Total de: " + row.length + " registro(s).");
        } else {
            $("#detalhescateg").html("Nenhum registor encontrado.");
        }
    }
}
$("#pesquisaAgenda").on('keyup', function (e) {

    if (e.keyCode === 13 ){
        $("#btnPesquisaAgenda").click();
    } 

});

$("#btnPesquisaAgenda, #btnIconPesquisaAgenda").click(function () {
    palavra = $("#pesquisaAgenda").val();
    categ = $("#categoria").val();
    dataini = $("#datainicial").val();
    datafim = $("#datafinal").val();
    if(dataini != "" && datafim !=""){
        data = dataini.toString().split("/");
        d1 = new Date(data[2]+"-"+data[1]+"-"+data[0]);
        data = datafim.toString().split("/");
        d2 = new Date(data[2]+"-"+data[1]+"-"+data[0]);
        if(d2.getTime() < d1.getTime()){
            alert("Data final não pode ser menor que data inicial...");
            return;
        }
    }
    $.ajax({
        type: 'GET',
        url: '/admin/agenda',
        data: {
            buscaagenda: palavra,
            categoria: categ,
            datainicial: dataini,
            datafinal: datafim
        },
        success: function (dados) {
            try {
                var agendas = JSON.parse(dados);
                if (agendas[0]) {
                    fillTableAgenda(agendas);
                }else{
                    $("#conteudo").html("");
                    $("#detalhes").html("Nenhum registor encontrado.");
                }
            } catch (err) {
                alert("Nenhum registro encontrado com o texto " + palavra);
                $("#pesquisa").val("");
                $("#conteudo").html("");
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});
$("#pesquisaAgenda").on('keyup', function (e) {

    if (e.keyCode === 13 ){
        $("#btnPesquisaAgendaUsuario").click();
    } 

});

$("#btnPesquisaAgendaUsuario, #btnIconPesquisaAgendaUsuario").click(function () {
    palavra = $("#pesquisaAgenda").val();
    categ = $("#categoria").val();
    dataini = $("#datainicial").val();
    datafim = $("#datafinal").val();
    if(dataini != "" && datafim !=""){
        data = dataini.toString().split("/");
        d1 = new Date(data[2]+"-"+data[1]+"-"+data[0]);
        data = datafim.toString().split("/");
        d2 = new Date(data[2]+"-"+data[1]+"-"+data[0]);
        if(d2.getTime() < d1.getTime()){
            alert("Data final não pode ser menor que data inicial...");
            return;
        }
    }
    $.ajax({
        type: 'GET',
        url: '/agenda',
        data: {
            buscaagenda: palavra,
            categoria: categ,
            datainicial: dataini,
            datafinal: datafim
        },
        success: function (dados) {
            try {
                var agendas = JSON.parse(dados);
                if (agendas[0]) {
                    fillTableAgendaUsuario(agendas);
                }else{
                    $("#conteudo").html("");
                    $("#detalhes").html("Nenhum registor encontrado.");
                }
            } catch (err) {
                alert("Nenhum registro encontrado com o texto " + palavra);
                $("#pesquisa").val("");
                $("#conteudo").html("");
            }
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
});

function fillTableAgenda(row) {
    $("#conteudo").html("");
    primeirotd = "";
    for (var i in row) {
        primeirotd = "<tr><td>";
        if(row[i].status == 0){
            primeirotd = "<tr class='alert-danger'><td>";
        }
        $("#conteudo").append(primeirotd + row[i].id +"</td>"+
            "<td>" + row[i].data + "</td><td>" + row[i].hora + "</td><td>" + row[i].titulo + "</td>" +
            "<td>" + row[i].assunto + "</td>"+
            "<td>" + row[i].nome + "</td>"+
            "<td>" + row[i].categdesc + "</td>"+
            "<td><a class='btn btn-warning glyphicon glyphicon-pencil btn-xs' href='/admin/agenda/editar/" + row[i].id + "'></td>" +
            "</tr>");
        if (row.length > 0) {
            $("#detalhes").html("Total de: " + row.length + " registro(s).");
        } else {
            $("#detalhes").html("Nenhum registor encontrado.");
        }
        primeirotd = "<tr><td>"
    }
}
function fillTableAgendaUsuario(row) {
    $("#conteudo").html("");
    primeirotd = "";
    for (var i in row) {
        primeirotd = "<tr><td>";
        if(row[i].status == 0){
            primeirotd = "<tr class='alert-danger'><td>";
        }
        $("#conteudo").append(primeirotd + row[i].id +"</td>"+
            "<td>" + row[i].data + "</td><td>" + row[i].hora + "</td><td>" + row[i].titulo + "</td>" +
            "<td>" + row[i].assunto + "</td>"+
            "<td>" + row[i].nome + "</td>"+
            "<td>" + row[i].categdesc + "</td>"+
            "<td><a class='btn btn-info glyphicon glyphicon-info-sign btn-xs' href='/agenda/show/" + row[i].id + "'></td>" +
            "</tr>");
        if (row.length > 0) {
            $("#detalhes").html("Total de: " + row.length + " registro(s).");
        } else {
            $("#detalhes").html("Nenhum registor encontrado.");
        }
        primeirotd = "<tr><td>"
    }
}
$(document).ready(function () {
    $("#formCadastro").submit(function (e) {
       e.preventDefault(); // evita que o formulário seja submetido
       $.ajax({
        type: 'POST',
        url: '/cadastro',
        data: $("#formCadastro").serializeArray(),
        success: function (dados) {
            alert(dados);
            $("#div_retorno").html(dados);
        },
        beforeSend: function () {
            $("#processando").css({display: "block"});
        },
        complete: function () {
            $("#processando").css({display: "none"});
        },
        error: function () {
            $("#div_retorno").html("Erro em chamar a função.");
            setTimeout(function () {
                $("#div_retorno").css({display: "none"});
            }, 5000);
        }
    });
   });
});

