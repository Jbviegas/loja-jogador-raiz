<?php
session_start();
ob_start();
//conexao 
require_once('../sheep_core/config.php');

//sdk efí 
require_once __DIR__ . '/vendor/autoload.php';

$sheep = new Ler();

//atualiza status da fatura
$atualizarStatusFatura = new Atualizar();

//atualiza status das minhas compras
$atualizarStatusCompras = new Atualizar();

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

//ExeRead efí msflix
include_once('config.php');


$options = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'sandbox' => $statusBanco // altere conforme o ambiente (true = Homologação e false = producao)

];

/*
* Este token será recebido em sua variável que representa os parâmetros do POST
* Ex.: $_POST['notification']
*/

$token = $_POST["notification"];

$params = [
    'token' => $token
];

try {
    $api = new Gerencianet($options);
    $chargeNotification = $api->getNotification($params, []);
    // Para identificar o status atual da sua transação você deverá contar o número de situações contidas no array, pois a última posição guarda sempre o último status. Veja na um modelo de respostas na seção "Exemplos de respostas" abaixo.

    // Veja abaixo como acessar o ID e a String referente ao último status da transação.

    // Conta o tamanho do array data (que armazena o resultado)
    $i = count($chargeNotification["data"]);
    // Pega o último Object chargeStatus
    $ultimoStatus = $chargeNotification["data"][$i - 1];
    // Acessando o array Status
    $statusFatura = $ultimoStatus["status"];
    // Obtendo o ID da transação        
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo a String do status atual
    $statusAtual = $statusFatura["current"];

    //staus de pagamento
    include_once('retorno-status-pg.php');

    //Leitura de Faturas e reotorno do status atual de pagamaento
    include_once('retorno-faturas.php');


    //status aprovado
    if ($statusAtual == 'paid') {
        //atualiza status das minhas compras
        $dadosMinhasCompras = ['status' => $statusAtual];
        $atualizarStatusCompras->Atualizando('minhas_compras', $dadosMinhasCompras, "WHERE transacao = :id", "id={$charge_id}");

        //Registra o pacote na kangu
        include_once('retorno-kangu.php');

        //Envia email de aprovação de pagamento
        include_once('retorno-email-aprovado.php');
    } //Fecha chave do aprovado

    // echo "O id da transação é: ".$charge_id." seu novo status é: ".$statusAtual;
    header("HTTP/1.1 200");
    //print_r($chargeNotification);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
    header("HTTP/1.1 400");
} catch (Exception $e) {
    print_r($e->getMessage());
    header("HTTP/1.1 401");
}
