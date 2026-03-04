
<?php

class RelatorioAnual
{

    private int $transacao;
    private array $data;
    private bool $resultado;
    private const BD = 'faturas';

    public function enviaValor(int $id, array $data): bool
    {
        $this->transacao = $id;
        $this->data = $data;
        if (in_array('', $this->data)) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroValor();
        return $this->salvarNoBanco();
    }


    public function getResultado(): bool
    {
        return $this->resultado;
    }


    private function filtroValor(): void
    {
        unset($this->data['id'], $this->data['sheep_firewall']);
        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['faturamentoanual'] = (string) $this->data['faturamentoanual'];
    }

    private function salvarNoBanco(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE transacao = :id", "id={$this->transacao}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false; // Garante retorno booleano sempre
    }
}




?>