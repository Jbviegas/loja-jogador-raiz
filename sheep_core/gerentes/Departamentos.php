<?php

class Departamentos
{
    private int $id;
    private array $data;
    private bool $resultado;
    private const BD = 'categorias';

    public function criarDepartamento(array $data): bool
    {
        $this->data = $data;

        if ($this->camposVazios($this->data)) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        return $this->salvarNoBanco();
    }


    public function atualizaDepartamento(int $id, array $data): bool
    {
        $this->id = $id;
        $this->data = $data;

        if ($this->camposVazios($this->data)) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        return $this->atualizaNoBanco();
    }

    public function excluirDepartamento(int $id): bool
    {
        $this->id = $id;
        if (!$this->id) {
            return $this->resultado = false;
            exit();
        }

        return $this->removerDoBanco();
    }

    public function getResultado(): bool
    {
        return $this->resultado;
    }


    private function camposVazios(array $data): bool
    {
        return in_array('', $data);
    }

    private function filtroBanco(): void
    {

        unset($this->data['id'], $this->data['sheep_firewall']);
        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['nome'] = (string) $this->data['nome'];
        $this->data['url'] = (string) Formata::Name($this->data['nome']);
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['usuario'] = (int) $this->data['usuario'];

        if ($this->data['tipo_cadastro'] == 'criar') {
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia'] = date('d');
            $this->data['mes'] = date('m');
            $this->data['ano'] = date('Y');
        }
    }


    private function salvarNoBanco(): bool
    {
        $criar = new Criar();
        $criar->Criacao(self::BD, $this->data);
        if ($criar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }

    private function atualizaNoBanco(): bool
    {
        $atualiza = new Atualizar();
        $atualiza->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualiza->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }

    private function removerDoBanco(): bool
    {
        $remover = new Excluir();
        $remover->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($remover->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
