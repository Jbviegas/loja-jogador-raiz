<?php

class AddCarrinho
{
   private int $id;
   private array $data;
   private bool $resultado;
   private const BD = 'carrinho';

   /**
    * Insere os dados no carrinho.
    */
   public function inserir(array $data): bool
   {
      $this->data = $data;

      // Verifica se há campos vazios
      if ($this->verificaCamposVazios($this->data)) {
         $this->resultado = false;
         return false;
      }

      // Filtra e valida os dados
      $this->filtroBanco();

      // Salva os dados no banco
      return $this->salvaNoBanco();
   }

   public function excluirCarrinho(int $id): bool
   {
      $this->id = $id;
      if (!$this->id) {
         return $this->resultado = false;
         exit();
      }

      return $this->removendoDoBanco();
   }

   /**
    * Retorna o resultado da operação.
    */
   public function getResultado(): bool
   {
      return $this->resultado;
   }

   /**
    * Verifica se há campos vazios no array.
    */
   private function verificaCamposVazios(array $data): bool
   {
      return in_array('', $data, true); // Verifica com rigor (strict)
   }

   /**
    * Filtra e prepara os dados para o banco.
    */
   private function filtroBanco(): void
   {
      // Remove espaços em branco e aplica proteção contra XSS
      $this->data = array_map('trim', $this->data);
      $this->data = array_map('htmlspecialchars', $this->data);

      // Converte e sanitiza os campos específicos
      $this->data['id_produto'] = (int) ($this->data['id_produto'] ?? 0);
      $this->data['capa'] = (string) $this->data['capa'];
      $this->data['titulo'] = (string) $this->data['titulo'];
      $this->data['qtde'] = (int) ($this->data['qtde'] ?? 1);
      $this->data['valor_final'] = (float) ($this->data['valor_final'] ?? 0);
      $this->data['valor'] = (float) ($this->data['valor'] ?? 0);
      $this->data['tamanho'] = htmlspecialchars((string) ($this->data['tamanho'] ?? ''));
      $this->data['nome_camisa'] = htmlspecialchars((string) ($this->data['nome_camisa'] ?? ''));
      $this->data['personaliza_foto'] = htmlspecialchars((string) ($this->data['personaliza_foto'] ?? ''));
      $this->data['numero_camisa'] = htmlspecialchars((string) ($this->data['numero_camisa'] ?? ''));
      $this->data['id_sessao'] = htmlspecialchars((string) ($this->data['id_sessao'] ?? ''));
      $this->data['id_cliente'] = (int) ($this->data['id_cliente'] ?? 0);
      $this->data['peso_correio'] = (float) ($this->data['peso_correio'] ?? 0);
      $this->data['comprimento_correios'] = (float) ($this->data['comprimento_correios'] ?? 0);
      $this->data['largura_correios'] = (float) ($this->data['largura_correios'] ?? 0);
      $this->data['altura_correios'] = (float) ($this->data['altura_correios'] ?? 0);

      // Define valores adicionais
      $this->data['status'] = 'P';
      $this->data['data'] = date('Y-m-d H:i:s');
      $this->data['dia'] = date('d');
      $this->data['mes'] = date('m');
      $this->data['ano'] = date('Y');
      $this->data['hora'] = date('H:i');
   }

   /**
    * Salva os dados no banco.
    */
   private function salvaNoBanco(): bool
   {
      $addCarrinho = new Criar();
      $addCarrinho->Criacao(self::BD, $this->data);

      if ($addCarrinho->getResultado()) {
         $this->resultado = true;
         return true;
      } else {
         $this->resultado = false;
         return false;
      }
   }

   private function removendoDoBanco(): bool
   {
      $remover = new Excluir();
      $remover->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
      if ($remover->getResultado()) {
         return $this->resultado = true;
      }
      return false;
   }
}
