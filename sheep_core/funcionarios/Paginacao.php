<?php

/*
  Gerente de paginação - Sheep PHP

  É responsável por:

  1  Calcular qual página está sendo acessada.

  2  Definir o LIMIT e OFFSET para a consulta SQL (quantos registros pegar e a partir de qual).

  3  Montar os links de navegação (1, 2, 3, próxima, última etc.) para o usuário poder navegar entre os resultados.
 
 */

class Paginacao
{
    /** DEFINE O PAGER - MAYKON SILVERA WEBTECPR.COM.BR */
    private $Page;
    private $Limit;
    private $Offset;

    /** REALIZAR A LEITURA - MAYKON SILVERA WEBTECPR.COM.BR */
    private $Tabela;
    private $Termos;
    private $Places;

    /** DEFINE O PAGINATOR - MAYKON SILVERA WEBTECPR.COM.BR */
    private $Rows;
    private $Link;
    private $MaxLinks;
    private $First;
    private $Last;


    /** RENDERIZA O PAGINATOR - MAYKON SILVERA WEBTECPR.COM.BR */
    private $Paginator;


    function __construct($Link, $First = null, $Last = null, $MaxLinks = null)
    {
        $this->Link = (string) $Link; // É a URL base para os links da paginação, Exemplo: http://localhost/loja-finalizada/1-torcedor/&p=1
        $this->First = ((string) $First ? $First : " < "); // texto do link da primeira página (padrão <)
        $this->Last = ((string) $Last ? $Last : " > "); // texto do link da última página (padrão >)
        $this->MaxLinks = ((int) $MaxLinks ? $MaxLinks : 5); // quantos links mostrar de cada lado da página atual (padrão 5),< [1] 2 3 4 5 >
    }


    public function LerPaginas($Page, $Limit)
    {
        $this->Page = ((int) $Page ? $Page : 1); //Página atual ($Page)
        $this->Limit = (int) $Limit; //  LIMIT → quantos itens pegar
        $this->Offset = ($this->Page * $this->Limit) - $this->Limit; //  OFFSET → a partir de qual registro buscar

        /* 
        Internamente, ele calcula:

        Página atual ($Page)

        LIMIT → quantos itens pegar

        OFFSET → a partir de qual registro buscar

        ➡️ Exemplo:
        Se você está na página 3 e limitou para 5 por página:

        LIMIT = 5

        OFFSET = (3 * 5) - 5 = 10
        Ou seja, vai trazer do item 11 ao 15
        10 pra chegar a 15 faltam 5 itens na página atual que é pagina 3 (Itens 11,12,13,14,15)
        */
    }

    /*
     * @return LOCATION = Retorna a página
     */

    public function VoltaPaginas()
    {
        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("Location: {$this->Link}{$nPage}");
        endif;
    }


    public function getPaginas() //Retorna a página atual
    {
        return $this->Page;
    }


    public function getLimit() //Retorna o limite de itens por página
    {
        return $this->Limit;
    }


    public function getOffset() //Retorna o offset de itens por página
    {
        return $this->Offset;
    }


    /*
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = Condição da seleção caso tenha
     * @param STRING $ParseString = Prepared Statements
     */

    public function ListarPaginas($Tabela, $Termos = null, $ParseString = null)
    {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        $this->Places = (string) $ParseString;
        $this->getSyntax();

        /* 
       Aqui ele calcula:
       - Quantas páginas no total existem.
       - Quais links precisam ser exibidos.
       - Qual é a primeira página, última página e as páginas vizinhas.
       - E no final, o resultado é guardado em $this->Paginator, que é usado em getPaginacao() para exibir a paginação.
        */
    }


    /*
     * @return HTML = Paginação de resultados
     */

    public function getPaginacao() // Função que é chamada na página para mostrar a paginação
    {
        return $this->Paginator; // Guarda o resultado da paginação vindo de ListarPaginas()
    }


    private function getSyntax() // Gera a sintaxe da paginação, cria links de navegação, cria a estrutura HTML que será exibida
    {
        $read = new Ler();
        $read->Leitura($this->Tabela, $this->Termos, $this->Places); //Executa a consulta na tabela informada em ListarPaginas(...)
        $this->Rows = $read->getContaLinhas(); //Pega o total de registros encontrados(linhas), Ex:se houverem 47 produtos no banco, $this->Rows = 47
        if ($this->Rows > $this->Limit): //Se a quantidade de registros( linhas ) for maior que o limite
            $Paginas = ceil($this->Rows / $this->Limit); //Calcula o número total de páginas, ceil() arredonda para cima.
            //Ex: Total de registros: 47, Limit por página: 5 = 47 / 5 = 9.4 paginas → ceil = 10 páginas

            $MaxLinks = $this->MaxLinks; //Define quantos links vizinhos devem aparecer de cada lado da página atual.
            // Ex: Página atual 3, MaxLinks 5 = < 1 2 [3] 4 5 6 7 >
            // Ex: Página atual 1, MaxLinks 5 = < [1] 2 3 4 5 6 >
            // Ex: Página atual 10, MaxLinks 5 = < 6 7 8 9 [10] 11 12 > 

            $cor = "style='text-decoration:none; color:#000; display: inline-block; border:1px solid #000000ff; margin-left: 10px; width: 40px; height: 40px; text-align: center; line-height: 40px; cursor: pointer;'";
            //Define um estilo inline para todos os botões de paginação
            $this->Paginator = '<div style="margin:0 auto 80px;">';//Abre uma <div> que vai agrupar todos os links da paginação.
            echo '';


            // Link para a página anterior (se não for a primeira), cria o botão
            if ($this->Page > 1) {
                $prev = $this->Page - 1;
                $this->Paginator .= "<a title=\"Anterior\" href=\"{$this->Link}{$prev}\" $cor><b style='color:red;'>{$this->First}</b></a>";
            }
            echo '';

            
            for ($iPag = $this->Page - $MaxLinks; $iPag <= $this->Page - 1; $iPag++):
                if ($iPag >= 1)://Loop que cria os links anteriores à página atual, até o limite definido em $MaxLinks
                    echo '';
                    $this->Paginator .= "<a title=\"Página {$iPag}\" href=\"{$this->Link}{$iPag}\" $cor>{$iPag}</a>";
                    echo '';
                endif;
            endfor;
            echo '';


            $this->Paginator .= "<a $cor><b style='color:red;'>{$this->Page}</b></a>";//Página atual (em destaque), destacada em vermelho
            echo '';


            for ($dPag = $this->Page + 1; $dPag <= $this->Page + $MaxLinks; $dPag++):
                if ($dPag <= $Paginas)://Loop que cria os links posteriores à página atual, até o limite definido em $MaxLinks
                    echo '';
                    $this->Paginator .= "<a title=\"Página {$dPag}\"  href=\"{$this->Link}{$dPag}\" $cor>{$dPag}</a>";
                    echo '';
                endif;
            endfor;
            echo '';


            // Link para a próxima página (se não for a última), cria o botão
            if ($this->Page < $Paginas) {
                $next = $this->Page + 1;
                $this->Paginator .= "<a title=\"Próxima\" href=\"{$this->Link}{$next}\" $cor><b style='color:red;'>{$this->Last}</b></a>";
            }
            echo '';
            $this->Paginator .= "</div>";
        endif;
    }

    /*

    Esse método é chamado automaticamente dentro de ListarPaginas().
        Ele é o responsável por:

        Descobrir quantos registros existem no banco.

        Calcular quantas páginas serão necessárias.

        Montar os links HTML de navegação.
     */
}
