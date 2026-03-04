<?php

/**********************************************************************
 * ********************************************************************
 * GERENTE DE UPLOADS MAYKONSILVEIRA.COM.BR E MAYKON SILVEIRA
 * 
 * ********************************************************************
 * MAYKONSILVEIRA.COM.BR DEREICIONANDO VOCÊ PARA O CAMINHO DO SUCESSO #*
 * *************MAYKON***SILVEIRA**************************************
 * *************sheep**PHP***********************************
 * ********************************************************************
 * TUDO AQUI FOI CRIADO NO DIA 01-10-2021 POR MAYKON SILVEIRA
 * TODOS OS DIREITOS RESERVADOS E CÓDIGO FONTE RASTREADO COM ARQUIVOS 
 * CRIADO POR MAYKONSILVEIRA.COM.BR DESDE 2007 *********
 * TODA SABEDORIA PARA CRIAR ESTES SISTEMAS VEM DO SANTO E ETERNOR PAI
 * O SANTO SENHOR DEUS DE ABRAÃO, ISSAC E JACÓ E DO MEU ÚNICO SENHOR 
 * O MESSIAS NOSSO SALVADOR, POIS A GLROIA É DO PAI E DO FILHO PARA SEMPRE
 * ********************************************************************
 */
class Uploads
{

    private $File;
    private $Name;
    private $Send;
    private $Width;
    private $Image;
    private $Result;
    private $Error;
    private $Folder;
    private static $BaseDir;

    function __construct($BaseDir = null) // Construtor da classe Uploads
    {

        //para alterar o nome padrão da pasta de uploads de imagens basta alterar para '../uploads/'
        self::$BaseDir = ((string) $BaseDir ? $BaseDir : '../uploads/'); // Define o diretório(pasta) base para uploads
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)) : // Se não existir o diretório e não for um diretório
            mkdir(self::$BaseDir, 0755); // Cria o diretório(pasta) base com permissões 0755

        endif;
    }

    //O que a classe Uploads faz na função Image() (que é a usada no enviaCapa):
    public function Image(array $Image, $Name = null, $Width = null, $Folder = null)
    { // Inicia o processo de upload de imagem
        $this->File = $Image; // Recebe o array $_FILES['capa'] que contém os dados do arquivo enviado
        $this->Name = ((string) $Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')));
        // Define o nome do arquivo, se não for informado, usa o nome original sem a extensão
        // substr($Image['name'], 0, strrpos($Image['name'], '.')); // Pega o nome do arquivo original até o último ponto (sem a extensão)
        // Exemplo: 'imagem.jpg' vira 'imagem'
        $this->Width = ((int) $Width ? $Width : 4000); // Define a largura máxima permitida da imagem em pixels
        $this->Folder = ((string) $Folder ? $Folder : 'images'); // Define a pasta de destino para o upload

        // Verifica o tamanho do arquivo
        $maxSize = 5 * 1024 * 1024 * 1024; // 5GB em bytes
        // Define o tamanho máximo do arquivo como 5GB, se não for informado um tamanho
        if ($this->File['size'] > $maxSize) { // Bloqueia qualquer arquivo maior que 5GB.
            $this->Result = false; // Retorna false para indicar falha no upload
            $this->Error = "O tamanho máximo do arquivo é de 5GB!";
            return;
            // Bloqueia qualquer arquivo maior que 5GB.
        }

        // Indica tipos de arquivos proibidos
        $forbiddenExtensions = [
            '.php',
            '.phtml',
            '.xhtml',
            '.html',
            '.sql',
            '.js',
            '.shell',
            '.jdk',
            '.json',
            '.htaccess',
            '.xml'
        ];

        foreach ($forbiddenExtensions as $extension) { // Chama as extenções proibidas de $extension(arquivos)
            if (strpos($this->File['name'], $extension) !== false) { // Se a extensão do arquivo for proibida, retorna false 
                $this->Result = false;
                $this->Error = "Não aceitamos arquivos do tipo " . trim($extension, ".");
                // Mensagem de erro = "Não aceitamos arquivos do tipo " . trim($extension, ".") = nome da extensão
                // trim($extension, ".") remove o ponto da extensão
                return;
                //Bloqueia extensões perigosas, se o usuário tentar mandar um PHP, JS, SQL, HTML, etc., o upload é negado.
            }
        }

        $this->CheckFolder($this->Folder); //Verifica e cria os diretórios(pastas) caso não existam com base em tipo de arquivo, ano e mês!
        $this->setFileName(); //Usa Formata::Name($this->Name) para gerar um nome de arquivo limpo.
        $this->UploadImage(); //Realiza o upload de imagens redimensionando e validando o tipo MIME(JPG,PNG,GIFT) da mesma.
    }

    /**
     * <b>Enviar Arquivo:</b> Basta envelopar um $_FILES de um arquivo caso queira um nome e um tamanho personalizado.
     * Caso não informe o tamanho será 2mb!
     * @param FILES $File = Enviar envelope de $_FILES (PDF, DOC, XLS, ZIP, RAR, 7Z ou TXT)
     * @param STRING $Name = Nome do arquivo ( ou do artigo ) 
     * @param STRING $Folder = Pasta personalizada
     * @param STRING $MaxFileSize = Tamanho máximo do arquivo (2mb)
     */

    public function File(array $File, $Name = null, $Folder = null, $MaxFileSize = null)
    // Envia um arquivo 
    {
        $this->File = $File; // Recebe o array $_FILES['arquivo'] que contém os dados do arquivo enviado
        $this->Name = $Name ? (string)$Name : substr($File['name'], 0, strrpos($File['name'], '.'));
        // Se o nome não for informado, usa o nome do arquivo enviado sem a extensão
        $this->Folder = $Folder ? (string)$Folder : 'jr_arquivos';
        // Se a pasta não for informada, usa 'jr_arquivos' como padrão
        $defaultMaxSize = 5 * 1024 * 1024 * 1024;
        // Define o tamanho máximo do arquivo como 5GB em bytes, se não for informado um tamanho
        $MaxFileSize = $MaxFileSize ? $MaxFileSize : $defaultMaxSize;
        // Define o tamanho máximo do arquivo como 5GB se não for informado um tamanho

        // Tipos de arquivo aceitáveis
        $FileAccept = [
            'application/pdf', // PDF
            'application/x-msexcel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // XLSX
            'application/vnd.ms-excel',
            'application/excel',
            'application/x-excel', // XLS
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
            'application/msword',
            'application/octet-stream', // DOC
            'application/zip',
            'application/x-zip-compressed',
            'application/x-gzip',
            'multipart/x-gzip', // ZIP
            'application/x-rar-compressed', // RAR
            'application/x-7z-compressed', // 7Z
            'text/plain' // TXT
        ];

        // Extensões de arquivo proibidas
        $forbiddenExtensions = ['.php', '.phtml', '.xhtml', '.html', '.sql', '.js', '.shell', '.jdk', '.json', '.htaccess', '.xml'];

        foreach ($forbiddenExtensions as $extension) { // Chama as extenções proibidas de $extension
            if (strpos($this->File['name'], $extension) !== false) { // Se a extensão do arquivo for proibida, retorna false 
                $this->Result = false;
                $this->Error = "Não aceitamos arquivos do tipo " . trim($extension, ".");
                // Mensagem de erro = "Não aceitamos arquivos do tipo " . trim($extension, ".") = nome da extensão
                // trim($extension, ".") remove o ponto da extensão
                return;
                //Bloqueia extensões perigosas, se o usuário tentar mandar um PHP, JS, SQL, HTML, etc., o upload é negado.
            }
        }

        if ($this->File['size'] > $MaxFileSize) { // Verifica se o tamanho do arquivo é maior que o tamanho máximo permitido 
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de " . ($MaxFileSize / (1024 * 1024 * 1024)) . "GB";

            // Se o tamanho do arquivo for maior que o tamanho máximo permitido, retorna false
            // Mensagem de erro = "Arquivo muito grande, tamanho máximo permitido de 5GB"
            return;
        }

        if (!in_array($this->File['type'], $FileAccept)) { // Verifica se o tipo de arquivo é diferente do tipo de arquivo aceito
            $this->Result = false; //Se for, retorna false
            $this->Error = "Só poderá enviar arquivos nos formatos PDF, ZIP, DOC, XLS, TXT.";
            return;
        }

        $this->CheckFolder($this->Folder); //Verifica e cria os diretórios(pastas) caso não existam com base em tipo de arquivo, ano e mês!
        $this->setFileName(); // Usa Formata::Name($this->Name) para gerar um nome de arquivo limpo.
        $this->MoveFile(); // Move o arquivo para a pasta de destino
    }


    /**
     * <b>Enviar Mídia:</b> Basta envelopar um $_FILES de uma mídia e caso queira um nome e um tamanho personalizado.
     * Caso não informe o tamanho será 40mb!
     * @param FILES $Media = Enviar envelope de $_FILES (ZIP, MP3 ou MP4)
     * @param STRING $Name = Nome do arquivo ( ou do artigo )
     * @param STRING $Folder = Pasta personalizada
     * @param STRING $MaxFileSize = Tamanho máximo do arquivo (40mb)
     */
    public function Media(array $Media, $Name = null, $Folder = null, $MaxFileSize = null)
    {
        $this->File = $Media; // Recebe os dados do arquivo de mídia
        $this->Name = $Name ? (string)$Name : substr($Media['name'], 0, strrpos($Media['name'], '.'));
        // Nome do arquivo(ou do artigo) formatado pela função setFileName através de Formata::Name
        // Se não for informado nenhum nome, usa o nome original do arquivo

        // Diretório padrão para a criação da pasta
        $this->Folder = $Folder ? (string)$Folder : 'media';
        // Se não for informado nenhum diretório(pasta), usa 'media' como padrão

        // 10GB em bytes
        $defaultMaxSize = 10 * 1024 * 1024 * 1024; 
        $MaxFileSize = $MaxFileSize ? (int)$MaxFileSize : $defaultMaxSize; //Define o tamanho máximo do arquivo permitido
        // Se não for informado nenhum tamanho, usa 10GB como padrão

        // Tipos de arquivo aceitáveis
        $FileAccept = [
            'audio/mp3',
            'audio/mpeg',
            'audio/ogg',
            'audio/*',
            'application/octet-stream',
            'video/mp4',
            'video/webm',
            'video/ogg'
        ];

        // Extensões de arquivo proibidas
        $forbiddenExtensions = ['.php', '.phtml', '.xhtml', '.html', '.sql', '.js', '.shell', '.jdk', '.json', '.htaccess', '.xml'];

        foreach ($forbiddenExtensions as $extension) {
            if (strpos($this->File['name'], $extension) !== false) {
                $this->Result = false;
                $this->Error = "Não aceitamos arquivos com extensão " . trim($extension, ".");
                return;
            }
        }

        if ($this->File['size'] > $MaxFileSize) {// Verifica se o tamanho do arquivo é maior que o tamanho máximo permitido
            $this->Result = false;// Se for, retorna false
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de " . ($MaxFileSize / (1024 * 1024)) . "MB";
            //Dá erro e Informa o usuário que o tamanho máximo permitido é de 10GB
            return;//Termina a execução
        }

        if (!in_array($this->File['type'], $FileAccept)) {// Verifica se o tipo de arquivo é aceito
            $this->Result = false;// Se não for, retorna false
            $this->Error = "Só pode enviar arquivos nos formatos MP3 ou MP4.";
            //Dá erro e Informa o usuário que o formato é inválido
            return;//Termina a execução
        }

        $this->CheckFolder($this->Folder); //Verifica e cria os diretórios(pastas) caso não existam com base em tipo de arquivo, ano e mês!
        $this->setFileName(); // Usa Formata::Name($this->Name) para gerar um nome de arquivo limpo.
        $this->MoveFile(); // Move o arquivo de vídeo para a pasta de destino
    }


    public function Gif(array $Gif, $Name = null, $Folder = null)
    {
        $this->File = $Gif;//Recebe os dados do arquivo GIF
        $this->Name = ((string) $Name ? $Name : pathinfo($Gif['name'], PATHINFO_FILENAME));//Define o nome do arquivo
        /* Se não for informado nenhum nome, usa o nome original do arquivo usando pathinfo($Gif['name'], PATHINFO_FILENAME)
         para obter o nome sem extensão
        */
        // Se não for informado nenhum diretório(pasta), usa 'gifs' como padrão
        $this->Folder = ((string) $Folder ? $Folder : 'gifs');

        if ($Gif['type'] !== "image/gif") {// Verifica se o tipo de arquivo é GIF
            $this->Result = false;// Se não for, retorna false
            $this->Error = "Formato inválido. Apenas GIFs são permitidos.";// Informa o usuário que o formato é inválido
            return;//Termina a execução
        }

        $this->CheckFolder($this->Folder); //Verifica e cria os diretórios(pastas) caso não existam com base em tipo de arquivo, ano e mês!
        $this->setFileName(); // Usa Formata::Name($this->Name) para gerar um nome de arquivo limpo.
        $this->MoveFile(); // Move o arquivo GIF para a pasta de destino
    }



    public function getResult()//Função que Retorna o resultado da operação
    {
        return $this->Result;// Retorno do resultado da operação
    }


    public function getError()//Função que Retorna o erro da operação
    {
        return $this->Error;// Retorno do erro da operação
    }

    /**
     * ***********MAYKONSILVEIRA.COM.BR*************
     * ********** PRIVATE METHODS *************
     * ************MAYKON***SILVEIRA************
     */


    //cria uma pasta organizada por ano/mês.
    private function CheckFolder($Folder)
    {
        list($y, $m) = explode('/', date('Y/m')); // Usa a data atual para criar pastas por ano e mês
        $this->CreateFolder("{$Folder}"); // Cria a pasta base
        $this->CreateFolder("{$Folder}/{$y}"); // Cria a pasta do ano
        $this->CreateFolder("{$Folder}/{$y}/{$m}/"); // Cria a pasta do mês
        $this->Send = "{$Folder}/{$y}/{$m}/"; // Define o caminho de envio 
    }

    //Verifica e cria o diretório base!
    private function CreateFolder($Folder)
    {       // Verifica se o diretório já existe
        if (!file_exists(self::$BaseDir . $Folder) && !is_dir(self::$BaseDir . $Folder)) : // Se não existir diretório e nem o caminho correspondente
            mkdir(self::$BaseDir . $Folder, 0755); // Cria o diretório(pasta) com permissões 0755

        endif;
    }

    //Verifica e monta o nome dos arquivos tratando a string!

    // Formata o nome do arquivo
    private function setFileName()
    {   //Usa Formata::Name($this->Name) para gerar um nome de arquivo limpo.
        $FileName = Formata::Name($this->Name) . strrchr($this->File['name'], '.');

        // Verifica se o arquivo já existe no diretório(pasta) de destino
        if (file_exists(self::$BaseDir . $this->Send . $FileName)) :
            $FileName = Formata::Name($this->Name) . '-' . time() . strrchr($this->File['name'], '.');
        //Se já existir um arquivo com o mesmo nome, acrescenta o time() para deixar único, se nao existir, usa o nome original
        // time() retorna o timestamp atual em segundos desde 1 de janeiro de 1970
        // Exemplo: 'imagem.jpg' vira 'imagem-1692345678.jpg'
        endif;// Termina a execução
        $this->Name = $FileName;// Define o nome do arquivo
    }


    //Realiza o upload de imagens redimensionando a mesma!
    public function UploadImage() //Valida tipo MIME dentro de UploadImage() - Valida se o tipo de imagem é permitido
    {
        //Redimensiona a imagem
        // Limite de tamanho de 5GB em bytes
        $maxSize = 5 * 1024 * 1024 * 1024;

        if ($this->File['size'] > $maxSize) {// Verifica se o tamanho do arquivo é maior que 5GB
            $this->Result = false;// Se sim, define o resultado como falso
            $this->Error = 'Arquivo muito grande, tamanho máximo permitido é 5GB!';// Mostra a mensagem de erro
            return;// Termina a execução
        }
        // Verifica se o formato da imagem é válido
        switch ($this->File['type']) {// Verifica o tipo MIME da imagem
            case 'image/jpg'://Caso seja for JPG
            case 'image/jpeg'://Caso seja for JPEG
            case 'image/pjpeg'://Caso seja for PJPEG
                $this->Image = imagecreatefromjpeg($this->File['tmp_name']);// Cria a imagem a partir do arquivo JPEG
                $outputFunction = 'imagejpeg';// Define a função de saída
                break;// Termina a execução

            case 'image/png': // Caso seja for PNG
            case 'image/x-png': // Caso seja for X-PNG
                $this->Image = imagecreatefrompng($this->File['tmp_name']); // Cria a imagem a partir do arquivo PNG
                $outputFunction = 'imagepng';// Define a função de saída
                break;// Termina a execução

            case 'image/gif': // Caso seja for GIF
                $this->Image = imagecreatefromgif($this->File['tmp_name']);// Cria a imagem a partir do arquivo GIF
                $outputFunction = 'imagegif';// Define a função de saída
                break;// Termina a execução

            default:// Caso seja um formato inválido
                $this->Image = false; // S a imagem é definida como falsa
                break;// Termina a execução

        }

        if (!$this->Image) {// Se o formato foi definido como inválido
            $this->Result = false;// Define o resultado como falso
            $this->Error = 'Tipo de arquivo inválido, envie imagens JPG, GIF ou PNG!';// Mostra a mensagem de erro
            return;
            // Se o formato for inválido, retorna false - A operação de upload falhou
        }

        $x = imagesx($this->Image);// Largura da imagem original
        $y = imagesy($this->Image);// Altura da imagem original
        $ImageX = ($this->Width < $x ? $this->Width : $x);// Largura da nova imagem
        $ImageH = ($ImageX * $y) / $x;// Altura da nova imagem

        $NewImage = imagecreatetruecolor($ImageX, $ImageH);// Cria uma nova imagem
        imagealphablending($NewImage, false);// Desativa a mesclagem de alpha
        imagesavealpha($NewImage, true);// Salva a transparência da imagem
        imagecopyresampled($NewImage, $this->Image, 0, 0, 0, 0, $ImageX, $ImageH, $x, $y);// Redimensiona a imagem
        //Usa imagecopyresampled pra garantir largura máxima ($this->Width, padrão 2000px).
        //Isso evita upload de imagens gigantes (mesmo que o arquivo original fosse 10.000px).

        if (!$NewImage) {// Se a nova imagem não foi criada
            $this->Result = false;// Define o resultado como falso
            $this->Error = 'Erro ao processar a imagem!';// Mostra a mensagem de erro
            return;
        }

        $outputFunction($NewImage, self::$BaseDir . $this->Send . $this->Name);// Salva a nova imagem no diretório(pasta) de destino
        $this->Result = $this->Send . $this->Name;// Armazena o caminho da nova imagem
        $this->Error = null;// Limpa a mensagem de erro

        imagedestroy($this->Image);// Destrói a imagem original
        imagedestroy($NewImage);// Destrói a nova imagem
    }

    //envia arquivos e midias
    private function MoveFile()
    {
        $destination = self::$BaseDir . $this->Send . $this->Name;// Define o caminho de destino para o arquivo

        if (move_uploaded_file($this->File['tmp_name'], $destination)) {// Se o arquivo for movido com sucesso
            $this->Result = $this->Send . $this->Name; //Retorna apenas o caminho relativo seguro
            //Se o arquivo for movido com sucesso, armazena o caminho relativo seguro em $this->Result
            //Ex: /uploads/2023/03/15/nome-arquivo.extensao
            //Isso significa que no banco vai ficar algo tipo:images/2025/08/camisa-barcelona-jogador-raiz-1692345678.png
            $this->Error = null;// Limpa a mensagem de erro
        } else {
            $this->Result = false;// Define o resultado como falso
            $this->Error = 'Erro ao mover o arquivo para o servidor. Favor tente mais tarde!';// Mostra a mensagem de erro
        }
    }
}
