<?php

require_once('../sheep_core/config.php');

$estadoId = (int) trim($_POST['estado']);
$lerEstados = new Ler();
$lerEstados->Leitura('app_cidades', "WHERE estado_id = :id", "id={$estadoId}");

sleep(1);

echo "<option value='' disabled selected> Selecione a cidade </option>";
foreach ($lerEstados->getResultado() as $cidade):
    $cidade = (object) $cidade;
    echo "<option value='{$cidade->cidade_id}'>{$cidade->cidade_nome}</option>";


endforeach;
