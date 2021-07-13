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
    $form->set("horario", "");
    $form->set("tarefa", "");
    $form->set("data", "");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["horario"]) && isset($_POST["tarefa"]) && isset($_POST["data"])) {
      try {
        $conexao = Transaction::get();
        $horario = $conexao->quote($_POST["horario"]);
        $tarefa = $conexao->quote($_POST["tarefa"]);
        $data = $conexao->quote($_POST["data"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
        $retorno = $crud->insert(
          "datas",
          "horario,tarefa,data",
          "{$horario},{$tarefa},{$data}"
        );
      }else {
        $id = $conexao->quote($_POST["id"]);
        $retorno = $crud->update(
          "datas",
          "horario={$horario}, tarefa={$tarefa}, data={$data}",
          "id={$id}"
        );
      }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro" . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos!";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
