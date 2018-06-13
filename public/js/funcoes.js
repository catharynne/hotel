$(document).ready(function () {
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
            cpf: cpf
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
function searchUsuario(value){
    if (value.length < 1) {
        return;
    }
    alert(value);
    return;
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

