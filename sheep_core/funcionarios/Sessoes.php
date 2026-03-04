<?php


class Sessoes {

    private $Data;
    private $Cache;
   

    function __construct($Cache = null) {
        session_start();// Inicia a sessão
        $this->Sessao($Cache);// Executa todos os métodos da classe!
    }


    private function Sessao($Cache = null) {
        $this->Data = date('Y-m-d');// Armazena a data atual na variável $Data
        $this->Cache = ( (int) $Cache ? $Cache : 20 );// Tempo padrão de 20 minutos para expiração da sessão

        
        if ($_SESSION['sheep_user'])://Se houver sessão ativa, armazena os dados do usuário na sessão
            $this->sessionUpdate();// Atualiza a sessão do usuário
        endif;// Fim da verificação de sessão

        $this->Data = null;// Limpa a data
    }


     

    //Atualiza sessão do usuário!
    private function sessionUpdate() {// Atualiza a sessão do usuário
        $_SESSION['sheep_user']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        //$_SESSION['sheep_user']['online_startview'] = date('Y-m-d H:i:s'); // Marca o início da visualização da sessão
        $_SESSION['sheep_user']['online_url'] = $_SERVER['REQUEST_URI'];// Armazena a URL atual da sessão
    }


       //Verifica, cria e atualiza o cookie do usuário
       private function getCookie() {
        $Cookie = filter_input(INPUT_COOKIE, 'sheep_user', FILTER_DEFAULT);// Pega o cookie do usuário
        setcookie("sheep_user", base64_encode("sheepPHP"), time() + 86400);// Cria um novo cookie
        if (!$Cookie):// Se o cookie não existir
            return false;// retorna falso
        else:// Se o cookie existir
            return true;// retorna verdadeiro
        endif;
    }

    



    

}

