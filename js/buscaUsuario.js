function checkCodigoBarras() {
    var codigo_barras = $("#resultado").val();
  
    $.ajax({
      url: "../buscaDestinatario.php",
      method: "POST",
      data: { codigo_barras: codigo_barras },
      success: function(response) {
        if (response === "not_found") {
            $("#destinatario_status").text("Não encontrado");
            $("#enviar_button").prop("disabled", true);
        } else {
            $("#destinatario_status").text(response);
            $("#enviar_button").prop("disabled", false);
        }
      },
      error: function(xhr, status, error) {
        console.log("An error occurred while checking codigo_barras: " + error);
      }
    });
  }