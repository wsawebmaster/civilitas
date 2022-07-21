// Testar Ajax
//$(function () {
//  alert("OK");
//});

$(function () {
  $("button#btnEntrar").on("click", function (e) {
    e.preventDefault();

    var campoLogin = $("form#formularioLogin #login").val();
    var campoSenha = $("form#formularioLogin #senha").val();

    if (campoLogin.trim() == "" || campoSenha.trim() == "") {
      $("div#mensagem")
        .show()
        .removeClass("red")
        .html("Preencha todos os campos.");
    } else {
      $.ajax({
        url: "acoes/login.php",
        type: "POST",
        data: {
          type: "login",
          login: campoLogin,
          senha: campoSenha,
        },

        success: function (retorno) {
          retorno = JSON.parse(retorno);

          if (retorno["erro"]) {
            $("div#mensagem").show().addClass("red").html(retorno["mensagem"]);
          } else {
            window.location = "dashboard.php";
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