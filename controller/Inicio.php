<?php
class Inicio
{
  public function controller()
  {
    $inicio = new Template("view/inicio.html");
    $inicio->set("nome", "Gabriel Santos Silva - 3° Informática");
    $retorno["msg"] = $inicio->saida();
    return $retorno;
  }
}
