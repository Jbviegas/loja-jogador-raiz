
<?php

class Faturas
{

    private int $transacao;
    private array $data;
    private bool $resultado;
    private const BD = 'faturas';

    public function enviaRastreio(int $id, array $data): bool
    {
        $this->transacao = $id;
        $this->data = $data;
        if (in_array('', $this->data)) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        return $this->salvarNoBanco();
    }

    public function finalizaFatura(int $id): bool
    {
        $this->transacao = $id;

        if (!$this->transacao) {
            return $this->resultado = false;
            exit();
        }

        return $this->finalizaFaturaDaLoja();
    }

    public function cancelaFatura(int $id): bool
    {
        $this->transacao = $id;

        if (!$this->transacao) {
            return $this->resultado = false;
            exit();
        }

        return $this->cancelaFaturaDaLoja();
    }

    public function getResultado(): bool
    {
        return $this->resultado;
    }


    private function filtroBanco(): void
    {
        unset($this->data['id'], $this->data['sheep_firewall']);
        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['rastreio'] = (string) $this->data['rastreio'];
    }

    private function salvarNoBanco(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE transacao = :id", "id={$this->transacao}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }

    private function finalizaFaturaDaLoja(): bool
    {
        $atualizar = new Atualizar();
        $dados = ['finalizado' => 'S'];
        $atualizar->Atualizando(self::BD, $dados, "WHERE transacao = :id", "id={$this->transacao}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }

    private function cancelaFaturaDaLoja(): bool
    {
        $atualizar = new Atualizar();
        $dados = ['finalizado' => 'C'];
        $atualizar->Atualizando(self::BD, $dados, "WHERE transacao = :id", "id={$this->transacao}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}




?>