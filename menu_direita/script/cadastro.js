// Testar Ajax
//$(function () {
//  alert("OK");
//});

$(function () {
    $("button#btnCadastrar").on("click", function (e) {
      e.preventDefault();

      var campoNome = $("form#formularioCadastro #nome").val();
      var campoEmail = $("form#formularioCadastro #email").val();
      var campoRe = $("form#formularioCadastro #re").val();
      var campoSenha = $("form#formularioCadastro #senha").val();
      var campoCsenha = $("form#formularioCadastro #csenha").val();

      if (
        campoNome.trim() == "" ||
        campoEmail.trim() == "" ||
        campoRe.trim() == "" ||
        campoSenha.trim() == "" ||
        campoCsenha.trim() == ""
      ) { 
        $("div#mensagem")
          .show()
          .removeClass("red")
          .html("Preencha todos os campos.");
      } else if (campoSenha != campoCsenha) {
        $("div#mensagem").show().removeClass("red").html("As Senhas estão divergentes.");
      } else {
        $.ajax({
          url: "acoes/cadastrarLogin.php",
          type: "POST",
          data: {
            type: "cadastro",
            nome: campoNome,
            email: campoEmail,
            re: campoRe,
            senha: campoSenha,
            csenha: campoCsenha,
          },

          success: function (retorno) {
            retorno = JSON.parse(retorno);

            if (retorno["erro"]) {
              $("div#mensagem")
                .show()
                .addClass("red")
                .html(retorno["mensagem"]);
            } else {
              $("div#mensagem");
              window.location = "index.php";
            }
          },

          error: function () {
            $("div#mensagem")
              .show()
              .addClass("red")
              .html("Ocorreu um erro durante a solicitação");
          },
        });
      }
    });

});