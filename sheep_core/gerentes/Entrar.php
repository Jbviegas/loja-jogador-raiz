<?php

class Entrar
{

    private string $email;
    private string $senha;
    private ?array $resultado = null; // pode restornar o valor null
    private const BD = 'usuarios';

    public function acessarPainel(string $email, string $senha): ?array
    {
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->senha = trim($senha);

        if (!Formata::Email($this->email)) {// Verifica se o formato do email é válido
            return $this->resultado = null;// Se o formato do email for inválido, retorna null
            exit();// Encerra a execução do script
        }

        return $this->verificaUsuario();
    }

    /**
     * @return array|null
     */
    public function getResultado(): ?array//Função pra pegar o resultado da validação
    {
        return $this->resultado;//variavel que armazena o resultado
    }



    private function verificaUsuario(): ?array
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE email = :email", "email={$this->email}");/*Verifica na tabela usuários se o email recebido pertence 
        a algum Email cadastrado */
        if ($ler->getResultado() && password_verify($this->senha, $ler->getResultado()[0]['senha'])) {
        // Pega o resultado do email e da senha recebidos e verifica se estão batendo
            return $this->resultado =  $ler->getResultado()[0];// Retorna o resultado do usuário autenticado
        }

        return null;// Se a verificação falhar, retorna null
    }
}
