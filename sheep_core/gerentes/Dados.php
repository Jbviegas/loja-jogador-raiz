<?php

class Dados
{

    private int $id;
    private array $data;
    private bool $resultado;

    private const BD = 'dados';

    public function atualizarDados(int $id, array $data): bool
    {
        $this->id = $id;
        $this->data = $data;

        if (!$this->data) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->atualizaLogo();
        $this->atualizaFavicon();

        return $this->salvaBanco();
    }


    public function getResultado(): bool
    {
        return $this->resultado;
    }


    /**
     * MÉTODOS PRIVADOS DA CLASSE
     */


    private function atualizaLogo(): void
    {
        if (isset($this->data['logo'])) {
            $ler = new Ler();
            $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($ler->getResultado()) {
                $logo = SHEEP_IMG_LOGOMARCA . $ler->getResultado()[0]['logo'];

                if (file_exists($logo) && !is_dir($logo)) {
                    unlink($logo);
                }

                $enviaLogo = new Uploads(SHEEP_IMG_LOGOMARCA);
                $urlLogo =  Formata::Name('nome') . Formata::Name(date('Y-m-d H:i:s') . '-logo-' . time());
                $enviaLogo->Image($this->data['logo'], $urlLogo);
            }
        }

        if (isset($enviaLogo) && $enviaLogo->getResult()) {
            $this->data['logo'] = $enviaLogo->getResult();
        } else {
            unset($this->data['logo']);
        }
    }

    private function atualizaFavicon(): void
    {
        if (isset($this->data['icone'])) {
            $ler = new Ler();
            $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($ler->getResultado()) {
                $icone = SHEEP_IMG_LOGOMARCA . $ler->getResultado()[0]['icone'];

                if (file_exists($icone) && !is_dir($icone)) {
                    unlink($icone);
                }

                $enviaIcone = new Uploads(SHEEP_IMG_LOGOMARCA);
                $urlIcone =  Formata::Name('nome') . Formata::Name(date('Y-m-d H:i') . '-icone-' . time());
                $enviaIcone->Image($this->data['icone'], $urlIcone);
            }
        }

        if (isset($enviaIcone) && $enviaIcone->getResult()) {
            $this->data['icone'] = $enviaIcone->getResult();
        } else {
            unset($this->data['icone']);
        }
    }



    private function filtroBanco(): void
    {
        $logo = $this->data['logo'];
        $favicon = $this->data['icone'];
        $descricao = $this->data['descricao'];

        unset($this->data['sheep_firewall'], $this->data['logo'], $this->data['icone'], $this->data['descricao'], $this->data['id']);
        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['logo'] = $logo;
        $this->data['icone'] = $favicon;
        $this->data['descricao'] = $descricao;
        $this->data['nome'] = (string) $this->data['nome'];
        $this->data['cnpj'] = (string) $this->data['cnpj'];
        $this->data['whatsapp'] = (string) $this->data['whatsapp'];
        $this->data['email'] = (string) $this->data['email'];
        $this->data['endereco'] = (string) $this->data['endereco'];
        $this->data['numero'] = (int) $this->data['numero'];
        $this->data['cep'] = (string) $this->data['cep'];
        $this->data['estado'] = (int) $this->data['estado'];
        $this->data['cidade'] = (int) $this->data['cidade'];
        $this->data['senha_email'] = (string) $this->data['senha_email'];
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['token_correios'] = (string) $this->data['token_correios'];
        $this->data['usuario'] = (int) $this->data['usuario'];
        $this->data['data'] = date('Y-m-d H:i:s');
        $this->data['dia'] = date('d');
        $this->data['mes'] = date('m');
        $this->data['ano'] = date('Y');
    }


    private function salvaBanco(): bool
    {
        $atualiza = new Atualizar();
        $atualiza->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualiza->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
