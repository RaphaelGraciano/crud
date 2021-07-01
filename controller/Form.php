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
    $form->set("id", "");
    $form->set("cliente", "");
    $form->set("agencia", "");
    $form->set("conta", "");
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
        if (empty($_POST["id"])) {
        $retorno = $crud->insert(
          "contas",
          "cliente,agencia,conta",
          "{$cliente},{$agencia},{$conta}"
        );
      }else {
        $id = $conexao->quote($_POST["id"]);
        $retorno = $crud->update(
          "contas",
          "cliente={$cliente}, agencia={$agencia}, conta={$conta}",
          "id={$id}"
        );
      }
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
