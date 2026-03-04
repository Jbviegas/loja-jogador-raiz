<?php

class ProdutosCriar
{

    private array $data;
    private int $id;
    private $resultado;
    private const BD = 'produto';

    public function criarProduto(array $data): bool
    {
        $this->data = $data;

        $seguranca = 2;

        if ($seguranca == 1) {
            if (!$this->data) {
                return $this->resultado = false;
                exit();
            }
        } else {
            if ($this->verificaCampos($this->data)) {
                return $this->resultado = false;
                exit();
            }
        }

        $this->filtroBanco();
        $this->enviaCapa();
        return $this->salvarNoBanco();
    }

    public function atualizarProduto(int $id, array $data): bool
    {
        $this->id = $id;
        $this->data = $data;

        if (!$this->data) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->atualizaCapa();
        return $this->atualizarNoBanco();
    }

    public function vamosExcluir(int $id): bool
    {
        $this->id = $id;
        if (!$this->id) {
            return $this->resultado = false;
            exit();
        }

        $this->removeCapa();
        return $this->removeBancoDeDados();
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    private function verificaCampos(array $data)
    {
        return in_array('', $data);
    }


    private function enviaCapa(): void
    {
        if (isset($this->data['capa'])) {
            $enviaCapa = new Uploads(SHEEP_IMG_PRODUTOS);
            $urlCapa =  Formata::Name($this->data['titulo']) . '-msflix-' . time() . '-' . rand();
            $enviaCapa->Image($this->data['capa'], $urlCapa);
        }

        if (isset($enviaCapa) && $enviaCapa->getResult()) {
            $this->data['capa'] = $enviaCapa->getResult();
        } else {
            unset($this->data['capa']);
        }
    }

    private function atualizaCapa(): void
    {
        if (isset($this->data['capa'])) {

            $ler = new Ler();
            $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($ler->getResultado()) {
                $urlImagem = SHEEP_IMG_PRODUTOS . $ler->getResultado()[0]['capa'];
                if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                    unlink($urlImagem);
                }

                $enviaCapa = new Uploads(SHEEP_IMG_PRODUTOS);
                $urlCapa =  Formata::Name($this->data['titulo']) . '-msflix-' . time() . '-' . rand();
                $enviaCapa->Image($this->data['capa'], $urlCapa);
            }
        }

        if (isset($enviaCapa) && $enviaCapa->getResult()) {
            $this->data['capa'] = $enviaCapa->getResult();
        } else {
            unset($this->data['capa']);
        }
    }

    private function removeCapa(): void
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($ler->getResultado()) {
            $urlImagem = SHEEP_IMG_PRODUTOS . $ler->getResultado()[0]['capa'];
            if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                unlink($urlImagem);
            }
        }
    }

    private function filtroBanco(): void
    {
        $capa = $this->data['capa'];
        $descricao = $this->data['descricao'];

        unset($this->data['capa'], $this->data['descricao'], $this->data['id'], $this->data['sheep_firewall']);

        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['url'] = Formata::Name($this->data['titulo']) . '-msflix-' . time() . '-' . rand();
        $this->data['titulo'] = (string) $this->data['titulo'];
        $this->data['capa'] = $capa;
        $this->data['descricao'] = $descricao;
        $this->data['id_categoria'] = (int) $this->data['id_categoria'];
        $this->data['valor'] = $this->data['valor'];
        $this->data['tags'] = (string) $this->data['tags'];
        $this->data['status'] = (string) $this->data['status'];
        $this->data['peso_correio'] = $this->data['peso_correio'];
        $this->data['diametro_correios'] = $this->data['diametro_correios'];
        $this->data['comprimento_correios'] = $this->data['comprimento_correios'];
        $this->data['largura_correios'] = $this->data['largura_correios'];
        $this->data['altura_correios'] = $this->data['altura_correios'];
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['estoque'] = (int) $this->data['estoque'];
        $this->data['usuario'] = (int) $this->data['usuario'];

        if ($this->data['tipo_cadastro'] == 'criar') {
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia'] = date('d');
            $this->data['mes'] = date('m');
            $this->data['ano'] = date('Y');
        }
    }

    private function salvarNoBanco()
    {
        $salvar = new Criar();
        $salvar->Criacao(self::BD, $this->data);
        if ($salvar->getResultado()) {
            return $this->resultado = $salvar->getResultado();
            return true;
        }
    }


    private function atualizarNoBanco(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }


    private function removeBancoDeDados(): bool
    {
        $excluir = new Excluir();
        $excluir->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($excluir->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
