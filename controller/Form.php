<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["cliente"]) && isset($_POST["agencia"]) && isset($_POST["conta"])) {
      try {
        $conexao = Transaction::get();
        $cliente = $conexao->quote($_POST["cliente"]);
        $agencia = $conexao->quote($_POST["agencia"]);
        $conta = $conexao->quote($_POST["conta"]);
        $crud = new Crud();
        $retorno = $crud->insert(
          "contas",
          "cliente,agencia,conta",
          "{$cliente},{$agencia},{$conta}"
        );
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
