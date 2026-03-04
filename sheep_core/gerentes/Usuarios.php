<?php

/**
 * Responsavel por cadastrar, editar e excluir usuarios
 * Empresa: Jogador Raíz jogadorraiz.com.br
 * Criado dia Y
 */
class Usuarios
{
    private int $id;
    private array $data;
    private bool $resultado;

    private const BD = 'usuarios';

    public function enviaClasse(array $data): bool
    {
        $this->data = $data;

        if ($this->verificaExistencia('email') || $this->verificaExistencia('cpf')) {
            return $this->resultado = false;
            exit();
        }

        if ($this->verificaCamposVazios($this->data)) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->enviaFoto();
        return $this->cadastraUsuario();
    }


    public function atualizaUsuario(int $id, array $data): bool
    {
        $this->id = $id;
        $this->data = $data;

        if (empty($this->data['senha'])) {
            unset($this->data['senha']);
        } else {
            $this->data['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT, ['const' => 10]);
        }

        if ($this->verificaExistenciaUp('email') || $this->verificaExistenciaUp('cpf')) {
            return $this->resultado = false;
            exit();
        }

        $this->atualizaFotoUsuario();

        return $this->vamosAtualizarUsuario();
    }


    public function excluirUsuario(int $id): bool
    {
        $this->id = $id;
        if (!$this->id) {
            return $this->resultado = false;
            exit();
        }

        $this->removeFotoUsuario();

        return $this->removendoUsuarioBd();
    }

    public function getResultado(): bool
    {
        return $this->resultado;
    }


    private function verificaCamposVazios(array $data): bool
    {
        return in_array('', $data);
    }

    private function verificaExistencia($campo): array
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE {$campo} = :{$campo}", "{$campo}={$this->data[$campo]}");
        return $ler->getResultado();
    }

    private function verificaExistenciaUp($campo): bool
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE {$campo} = :{$campo}", "{$campo}={$this->data[$campo]}");
        return $ler->getContaLinhas() > 1;
    }


    //responsavel por enviar uma foto do cliente
    private function enviaFoto(): void
    {
        if (isset($this->data['foto'])) {
            $enviaFoto = new Uploads(SHEEP_IMG_USUARIOS);
            $nomeFoto = Formata::Name($this->data['nome']) . '-' . Formata::Name($this->data['sobrenome']) . '-' . Formata::Name(date('Y-m-d')) . '-' . time();
            $enviaFoto->Image($this->data['foto'], $nomeFoto);

            if ($enviaFoto->getResult()) {
                $this->data['foto'] = $enviaFoto->getResult();
            } else {
                $this->data['foto'] = null;
            }
        }
    }


    private function atualizaFotoUsuario(): void
    {
        if (isset($this->data['foto'])) {
            $lerFoto = new Ler();
            $lerFoto->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($lerFoto->getResultado()) {
                $foto = SHEEP_IMG_USUARIOS . $lerFoto->getResultado()[0]['foto'];
                if (file_exists($foto) && !is_dir($foto)) {
                    unlink($foto);
                }

                $enviaFoto = new Uploads(SHEEP_IMG_USUARIOS);
                $nomeFoto = Formata::Name($this->data['nome']) . '-' . Formata::Name($this->data['sobrenome']) . '-' . Formata::Name(date('Y-m-d')) . '-' . time();
                $enviaFoto->Image($this->data['foto'], $nomeFoto);
            }
        }

        if (isset($enviaFoto) && $enviaFoto->getResult()) {
            if (isset($this->data['foto'])) {
                $this->data['foto'] = $enviaFoto->getResult();
            } else {
                unset($this->data['foto']);
            }
        } else {
            unset($this->data['foto']);
        }
    }

    private function removeFotoUsuario(): void
    {
        $lerFoto = new Ler();
        $lerFoto->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($lerFoto->getResultado()) {
            $foto = SHEEP_IMG_USUARIOS . $lerFoto->getResultado()[0]['foto'];
            if (file_exists($foto) && !is_dir($foto)) {
                unlink($foto);
            }
        }
    }

    private function filtroBanco(): void
    {

        $foto = $this->data['foto'];
        unset($this->data['foto'], $this->data['sheep_firewall'], $this->data['id']);

        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['nome'] = (string) $this->data['nome'];
        $this->data['sobrenome'] = (string) $this->data['sobrenome'];
        $this->data['cpf'] = (string) $this->data['cpf'];
        $this->data['nascimento'] = $this->data['nascimento'];
        $this->data['email'] = (string) $this->data['email'];
        $this->data['whatsapp'] = (string) $this->data['whatsapp'];
        $this->data['endereco'] = (string) $this->data['endereco'];
        $this->data['numero'] = (int) $this->data['numero'];
        $this->data['cep'] = (string) $this->data['cep'];
        $this->data['status'] = (string) $this->data['status'];
        $this->data['estado'] = (int) $this->data['estado'];
        $this->data['cidade'] = (int) $this->data['cidade'];
        $this->data['bairro'] = (string) $this->data['bairro'];
        $this->data['nivel'] = (string) $this->data['nivel'];
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['foto'] = $foto;

        if ($this->data['tipo_cadastro'] == 'criar') {
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia'] = date('d');
            $this->data['mes'] = date('m');
            $this->data['ano'] = date('Y');
        }

        if (isset($this->data['senha'])) {
            $this->data['senha'] = password_hash($this->data['senha'], PASSWORD_DEFAULT, ['const' => 10]);
        }
    }

    private function cadastraUsuario(): bool
    {
        $criar = new Criar();
        $criar->Criacao(self::BD, $this->data);
        if ($criar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }


    private function vamosAtualizarUsuario(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }

    private function removendoUsuarioBd(): bool
    {

        $excluir = new Excluir();
        $excluir->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($excluir->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
