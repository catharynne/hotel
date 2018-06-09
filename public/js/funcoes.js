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
                if(dados == "errologin"){
                    $("#div_retorno").html("Usuário ou senha inválido.");
                }else{
                    window.location.href = "/produtos";
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

