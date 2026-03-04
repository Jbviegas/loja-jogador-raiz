<?php

class Banners
{
    private int $id;
    private array $data;
    private bool $resultado;
    private const BD = 'banners';

    public function criarBanner(array $data): bool
    {
        $this->data = $data;

        if (!$this->data) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->addCapa();
        return $this->salvarNoBanco();
    }


    public function atualizaBanner(int $id, array $data): bool
    {
        $this->id = $id;
        $this->data = $data;

        if (!$this->data) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->atualizaCapa();
        return $this->atualizaNoBanco();
    }

    public function excluirBanner(int $id): bool
    {
        $this->id = $id;
        if (! $this->id) {
            return $this->resultado = false;
            exit();
        }

        $this->removerCapa();
        return $this->excluirDoBanco();
    }


    public function getResultado(): bool
    {
        return $this->resultado;
    }



    private function addCapa(): void
    {
        if (isset($this->data['capa'])) {
            $enviaCapa = new Uploads(SHEEP_IMG_BANNERS);
            $url = Formata::Name($this->data['titulo_um']) . '-banner-destaque-' . time() . '-' . date('Y-m-d');
            $enviaCapa->Image($this->data['capa'], $url);

            if (isset($enviaCapa) && $enviaCapa->getResult()) {
                $this->data['capa'] = $enviaCapa->getResult();
            } else {
                $this->data['capa'] = null;
            }
        }
    }

    private function atualizaCapa(): void
    {
        if (isset($this->data['capa'])) {
            $lerCapa = new Ler();
            $lerCapa->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($lerCapa->getResultado()) {
                $urlCapa = SHEEP_IMG_BANNERS . $lerCapa->getResultado()[0]['capa'];
                if (file_exists($urlCapa) && !is_dir($urlCapa)) {
                    unlink($urlCapa);
                }

                $enviaCapa = new Uploads(SHEEP_IMG_BANNERS);
                $url = Formata::Name($this->data['titulo_um']) . '-banner-destaque-' . time() . '-' . date('Y-m-d');
                $enviaCapa->Image($this->data['capa'], $url);
            }
        }

        if (isset($enviaCapa) && $enviaCapa->getResult()) {
            $this->data['capa'] = $enviaCapa->getResult();
        } else {
            unset($this->data['capa']);
        }
    }

    private function removerCapa(): void
    {
        $lerCapa = new Ler();
        $lerCapa->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($lerCapa->getResultado()) {
            $urlCapa = SHEEP_IMG_BANNERS . $lerCapa->getResultado()[0]['capa'];
            if (file_exists($urlCapa) && !is_dir($urlCapa)) {
                unlink($urlCapa);
            }
        }
    }

    private function filtroBanco(): void
    {
        $capa = $this->data['capa'];
        unset($this->data['capa'], $this->data['id'], $this->data['sheep_firewall']);

        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['titulo_um'] = (string) $this->data['titulo_um'];
        $this->data['link'] = (string) $this->data['link'];
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['local'] = (string) $this->data['local'];
        $this->data['capa'] = $capa;

        if (isset($this->data['titulo_dois'])) {
            $this->data['titulo_dois'] = (string) $this->data['titulo_dois'];
        }

        if (isset($this->data['titulo_tres'])) {
            $this->data['titulo_tres'] = (string) $this->data['titulo_tres'];
        }

        if (isset($this->data['titulo_quatro'])) {
            $this->data['titulo_quatro'] = (string) $this->data['titulo_quatro'];
        }

        if (isset($this->data['titulo_cinco'])) {
            $this->data['titulo_cinco'] = (string) $this->data['titulo_cinco'];
        }

        if (isset($this->data['titulo_seis'])) {
            $this->data['titulo_seis'] = (string) $this->data['titulo_seis'];
        }

        if ($this->data['tipo_cadastro'] == 'criar') {
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia'] = date('d');
            $this->data['mes'] = date('m');
            $this->data['ano'] = date('Y');
        }
    }

    private function salvarNoBanco(): bool
    {
        $salvar = new Criar();
        $salvar->Criacao(self::BD, $this->data);
        if ($salvar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }


    private function atualizaNoBanco(): bool
    {
        $salvar = new Atualizar();
        $salvar->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($salvar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }


    private function excluirDoBanco(): bool
    {
        $salvar = new Excluir();
        $salvar->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($salvar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
