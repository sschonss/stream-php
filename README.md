# PHP - Streams

## Introdução

Se você já trabalhou com arquivos em PHP, provavelmente já usou funções como `fopen`, `fwrite`, `fread`, `fclose`, entre outras. Streams são uma abstração mais poderosa e flexível para trabalhar com arquivos e outros recursos de I/O.

Streams são uma forma de abstrair a manipulação de dados de entrada e saída, permitindo que você leia e escreva dados de e para diferentes fontes, como arquivos, strings, conexões de rede, etc.

Por exemplo, você pode usar streams para ler dados de um arquivo, processá-los e escrevê-los em outro arquivo, sem ter que se preocupar com a origem ou destino dos dados.

Ou então, você pode usar streams para ler dados de uma conexão de rede, processá-los e escrevê-los em um banco de dados. E assim por diante.

## Exemplo básico

```php
$stream = fopen('data.txt', 'r');

while (!feof($stream)) {
    $line = fgets($stream);
    echo $line;
}

fclose($stream);
```

Neste exemplo, abrimos um arquivo chamado `data.txt` em modo de leitura (`'r'`). Em seguida, lemos o conteúdo do arquivo linha por linha até o final do arquivo (`feof($stream)`). Por fim, fechamos o arquivo com `fclose($stream)`.

Mas o que é um stream? Um stream é um recurso que representa uma fonte ou destino de dados. No exemplo acima, `$stream` é um stream que representa o arquivo `data.txt`.

Vamos ver um exemplo mais avançado.

## Exemplo avançado

```php
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['key' => 'value']),
    ],
]);

$stream = fopen('http://example.com/data.csv', 'r', false, $context);

while (!feof($stream)) {
    $line = fgetcsv($stream);
    print_r($line);
}

fclose($stream);
```

Neste exemplo, criamos um contexto de stream com `stream_context_create`, que é um array associativo com opções de configuração para o stream. No caso, estamos configurando um stream HTTP com o método `POST`, o cabeçalho `Content-Type: application/json` e o corpo da requisição em formato JSON.

Em seguida, abrimos um stream para a URL `http://example.com/data.csv` em modo de leitura (`'r'`) com o contexto de stream que acabamos de criar.

Depois, lemos o conteúdo do stream linha por linha com `fgetcsv`, que lê uma linha do stream e a converte em um array de valores separados por vírgula.

Por fim, fechamos o stream com `fclose`.

## Mas por que usar streams?

O PHP surgiu em uma época em que a manipulação de arquivos era a principal forma de interagir com o sistema de arquivos e outros recursos de I/O. Por isso, as funções de manipulação de arquivos do PHP são baseadas em operações de baixo nível, como abrir, ler, escrever e fechar arquivos, os famosos `fopen`, `fread`, `fwrite` e `fclose`.

Com o tempo, a necessidade de interagir com outros tipos de recursos de I/O, como conexões de rede, bancos de dados, etc., tornou-se cada vez mais comum. E foi aí que os streams entraram em cena.

Streams são essencialmente uma camada de abstração sobre diferentes tipos de recursos de I/O, permitindo que você leia e escreva dados de e para esses recursos de forma consistente, independente da origem ou destino dos dados.

Quando eu falo de recursos de I/O, estou me referindo a qualquer coisa que você possa ler ou escrever dados, como arquivos, strings, janelas de console, conexões de rede, sockets, pipes, etc.

E quando eu falei de não se preocupar com a origem ou destino dos dados, eu quis dizer que você não precisa saber se está lendo de um arquivo, de uma conexão de rede, de um banco de dados, etc. Você simplesmente lê os dados do stream e os processa da forma que desejar. Isso é muito poderoso e flexível.

## E como eu uso streams?

Para usar streams em PHP, você precisa entender alguns conceitos básicos:

- **Resource**

- **Context**

- **Wrapper**

- **Stream functions**

- **Stream filters**

> **Nota**: Este é apenas um resumo básico sobre streams em PHP. Para saber mais, consulte a [documentação oficial](https://www.php.net/manual/en/book.stream.php).

## Resource

Vamos nos aprofundar um pouco mais no conceito de recurso (resource) em PHP.

Um stream é representado por um recurso (resource) em PHP. Um recurso é uma variável especial que contém uma referência interna para um recurso externo, como um arquivo, uma conexão de rede, etc. Você pode criar um recurso com a função `fopen` e fechá-lo com a função `fclose`.

Um `resource` em PHP é indentificador interno para recursos externos, e a função `get_resource_type` pode ser usada para obter o tipo de recurso.

```php
$stream = fopen('data.txt', 'r');
echo get_resource_type($stream);
fclose($stream);
```

No console, você verá algo como `stream`.

O `resource` sempre vai referenciar o arquivo aberto, .

## Context

Um contexto de stream é um array associativo com opções de configuração para o stream. Você pode criar um contexto de stream com a função `stream_context_create` e passá-lo como argumento para funções que abrem streams, como `fopen`, `file_get_contents`, etc.

Quando você abre um stream com um contexto de stream, as opções de configuração do contexto são aplicadas ao stream. Por exemplo, você pode configurar um stream HTTP com o método `POST`, o cabeçalho `Content-Type: application/json`, etc.

```php
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['key' => 'value']),
    ],
]);

$stream = fopen('http://example.com/data.csv', 'r', false, $context);
```

Ou então, você pode usar um contexto de stream para configurar um stream FTP com o nome de usuário e senha.

```php
$context = stream_context_create([
    'ftp' => [
        'username' => 'user',
        'password' => 'pass',
    ],
]);

$stream = fopen('ftp://example.com/data.csv', 'r', false, $context);
```

## Wrapper

Um wrapper é um esquema de URL que define como o PHP deve abrir um stream. Por exemplo, o wrapper `http` é usado para abrir streams HTTP, o wrapper `ftp` é usado para abrir streams FTP, etc.

Quando você abre um stream com `fopen`, o PHP usa o wrapper correspondente para abrir o stream. Por exemplo, se você abrir um stream `http://example.com/data.csv`, o PHP usará o wrapper `http` para abrir o stream.

Você também pode usar wrappers para abrir streams de outros tipos de recursos, como strings, variáveis de memória, etc.

```php
$stream = fopen('data:text/plain;base64,SGVsbG8gV29ybGQ=', 'r');
echo stream_get_contents($stream);
fclose($stream);
```

Neste exemplo, estamos abrindo um stream de uma string codificada em base64 com o wrapper `data`. O conteúdo da string é `Hello World`.

```php
$stream = fopen('php://memory', 'r+');
```

Neste exemplo, estamos abrindo um stream de uma variável de memória com o wrapper `php`. O stream é aberto em modo de leitura e escrita (`'r+'`).

```php
$stream = fopen('ogg://temp', 'r+');
```

OGG é um wrapper que permite a manipulação de arquivos de áudio no formato OGG, isso é um exemplo de um wrapper personalizado.

Você pode criar seus próprios wrappers personalizados para abrir streams de outros tipos de recursos, como bancos de dados, APIs, etc.

Veja a [documentação oficial](https://www.php.net/manual/en/wrappers.php) para mais informações sobre wrappers em PHP.

## Stream functions

O PHP fornece várias funções para trabalhar com streams, como `fopen`, `fclose`, `fread`, `fwrite`, `feof`, `fseek`, `ftell`, `fgetcsv`, `stream_get_contents`, etc.

Você pode usar essas funções para abrir, fechar, ler, escrever, posicionar, verificar o final, etc., de um stream.

Por exemplo, você pode usar `fopen` para abrir um stream, `fread` para ler dados do stream, `fwrite` para escrever dados no stream e `fclose` para fechar o stream.

```php
$stream = fopen('data.txt', 'r');

while (!feof($stream)) {
    $line = fgets($stream);
    echo $line;
}

fwrite($stream, 'Hello World');

fclose($stream);
```

Neste exemplo, estamos abrindo um arquivo chamado `data.txt` em modo de leitura (`'r'`). Em seguida, lemos o conteúdo do arquivo linha por linha até o final do arquivo com `fgets`. Depois, escrevemos a string `Hello World` no arquivo com `fwrite`. Por fim, fechamos o arquivo com `fclose`.

Você pode usar essas funções para trabalhar com streams de diferentes tipos de recursos, como o curl, sockets, pipes, etc.

```php

$url = 'http://example.com/data/page.html';

$data = curl_init($url);

curl_setopt($data, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($data);

curl_close($data);

$stream = fopen('php://memory', 'r+');

fwrite($stream, $response);

rewind($stream);

echo stream_get_contents($stream);

fclose($stream);
```

Neste exemplo, estamos fazendo uma requisição HTTP com o curl para a URL `http://example.com/data/page.html`. Em seguida, abrimos um stream de uma variável de memória com o wrapper `php` em modo de leitura e escrita (`'r+'`). Depois, escrevemos a resposta da requisição no stream com `fwrite`. Por fim, exibimos o conteúdo do stream com `stream_get_contents` e fechamos o stream com `fclose`.

## Stream filters

Aqui chegamos a um dos recursos mais poderosos e flexíveis dos streams em PHP: os filtros de stream.

Imagine o seguinte cenário: você está lendo dados de um arquivo e precisa processar esses dados antes de exibi-los na tela. Com os filtros de stream, você pode criar um filtro que processa os dados conforme necessário e aplicá-lo ao stream de leitura, sem precisar modificar o código que lê os dados.

Por exemplo, você pode usar um filtro de stream para converter os dados de um arquivo de texto para letras maiúsculas antes de exibi-los na tela.

```php

$stream = fopen('data.txt', 'r');

stream_filter_append($stream, 'string.toupper');

echo stream_get_contents($stream);

fclose($stream);
```

Neste exemplo, estamos abrindo um arquivo chamado `data.txt` em modo de leitura (`'r'`). Em seguida, aplicamos o filtro `string.toupper` ao stream com `stream_filter_append`, que converte os dados para letras maiúsculas. Por fim, exibimos o conteúdo do stream com `stream_get_contents` e fechamos o arquivo com `fclose`.

Essa conversão é feita automaticamente pelo filtro de stream, ocorre durante a leitura dos dados e não afeta o arquivo original.

Você pode criar seus próprios filtros de stream para processar os dados de acordo com suas necessidades.

Veja a [documentação oficial](https://www.php.net/manual/en/filters.php) para mais informações sobre filtros de stream em PHP.

Mas eu preparei um exemplo para você entender melhor como funciona um filtro de stream.

No primeiro exemplo, vamos criar um filtro de stream que filtrará somente para linhas que contém a palavra "PHP".

```php
<?php

class FilterPHP extends php_user_filter
{
    public $stream;
    public string $filter;

    public function onCreate(): bool
    {
        $this->stream = fopen('php://temp', 'w+');
        return $this->stream !== false;
    }

    public function filter($in, $out, &$consumed, $closing): int
    {
        $this->filter = 'PHP';
        $out_data = '';
        while ($bucket = stream_bucket_make_writeable($in)) {
            $line = explode("\n", $bucket->data);
            foreach ($line as $l) {
                if (str_contains($l, $this->filter)) {
                    $out_data .= $l . "\n";
                }
            }
        }

        $bucket_out = stream_bucket_new($this->stream, $out_data);
        stream_bucket_append($out, $bucket_out);

        return PSFS_PASS_ON;
    }
}

```

Vamos entender o que está acontecendo no código acima passo a passo.

1. Criamos uma classe chamada `FilterPHP` que estende a classe `php_user_filter`. Esta classe é usada para criar um filtro de stream personalizado.

Se você já trabalhou com classes em PHP, deve estar estranhando o fato de extender uma classe com um nome tão estranho. Isso acontece porque a classe `php_user_filter` é uma classe interna do PHP que não segue as convenções de nomenclatura de classes em PHP que foram estabelecidas pela comunidade ao longo dos anos.

2. A classe `FilterPHP` possui duas propriedades: `$stream` e `$filter`. A propriedade `$stream` é usada para armazenar um stream temporário onde os dados filtrados serão escritos. A propriedade `$filter` é usada para armazenar o filtro que será aplicado aos dados.

3. O método `onCreate` é chamado quando o filtro é criado. Neste método, abrimos um stream temporário com `fopen('php://temp', 'w+')` e armazenamos o recurso do stream na propriedade `$stream`. Se o stream não puder ser aberto, retornamos `false`.

O método `onCreate` é um método obrigatório que deve ser implementado em todos os filtros de stream personalizados, funcionando como um construtor para o filtro.

Mas o que é `php://temp`? `php://temp` é um wrapper que permite a criação de streams temporários em PHP. Os streams temporários são armazenados na memória ou em um arquivo temporário, dependendo do tamanho dos dados.

4. O método `filter` é chamado para filtrar os dados do stream. Neste método, lemos os dados de entrada das seguintes variáveis:

- `$in`: stream de entrada, onde os dados originais são lidos. Este stream é somente leitura, vem de `input` e é passado para o filtro.
- `$out`: stream de saída, onde os dados filtrados são escritos. Este stream é somente escrita, vem de `output` e é passado para o filtro.
- `&$consumed`: quantidade de dados consumidos pelo filtro. Este valor é atualizado pelo filtro e passado de volta para o PHP.
- `$closing`: indica se o stream está sendo fechado. Se for `true`, o filtro deve liberar todos os recursos alocados.

> **Nota**: O `&` na frente de uma variável em PHP indica que a variável é passada por referência, ou seja, o valor da variável pode ser alterado dentro da função e refletido fora dela.

5. No método `filter`, lemos os dados de entrada do stream com `stream_bucket_make_writeable` e os armazenamos na variável `$out_data`. Em seguida, dividimos os dados em linhas com `explode("\n", $bucket->data)` e verificamos se cada linha contém a palavra "PHP" com `str_contains($l, $this->filter)`.

6. Se a linha contiver a palavra "PHP", a linha é adicionada à variável `$out_data`. Em seguida, criamos um novo bucket de saída com `stream_bucket_new` e o adicionamos ao stream de saída com `stream_bucket_append`.

7. Por fim, retornamos `PSFS_PASS_ON` para indicar que o filtro deve continuar a passar os dados para o próximo filtro ou para o stream de saída.

Agora que criamos o filtro de stream, vamos aplicá-lo a um stream de entrada.

```php
<?php

require_once './FilterPHP.php';

$json = 'https://raw.githubusercontent.com/sschonss/stream-php/main/data.json';

$fileContents = file_get_contents($json);

if ($fileContents === false) {
    die('Failed to fetch data from the endpoint.');
}

stream_filter_register('filterphp', 'FilterPHP') or die("Failed to register filter.");

$tempStream = fopen('php://temp', 'r+');
fwrite($tempStream, $fileContents);
rewind($tempStream);

$out_fp = fopen('php://stdout', 'w') or die("Failed to open output stream.");
stream_filter_append($tempStream, 'filterphp');

while ($data = fread($tempStream, 1024)) {
    $data = str_replace('"name": ', '', $data);
    $data = str_replace('"description": ', '', $data);
    echo $data;
}

fclose($tempStream);
fclose($out_fp);

```

Neste exemplo, estamos lendo um arquivo JSON de uma URL com `file_get_contents` e armazenando o conteúdo do arquivo em uma variável chamada `$fileContents`.

Em seguida, registramos o filtro de stream `FilterPHP` com `stream_filter_register`. O primeiro argumento é o nome do filtro, que será usado para aplicar o filtro ao stream de entrada. O segundo argumento é o nome da classe do filtro.

É importante registrar o filtro de stream antes de aplicá-lo ao stream de entrada, para que o PHP saiba como lidar com o filtro.

Depois, abrimos um stream temporário com `fopen('php://temp', 'r+')` e escrevemos o conteúdo do arquivo no stream com `fwrite`. Em seguida, rebobinamos o stream com `rewind`.

> **Nota**: O `rewind` é uma função que move o ponteiro interno do stream para o início do stream. Isso é necessário porque o ponteiro interno do stream é movido para o final do stream após a escrita.

> > **Nota**: Ponteiro em PHP é como se fosse um cursor que aponta para a posição atual do stream.

Depois, abrimos um stream de saída com `fopen('php://stdout', 'w')` e aplicamos o filtro de stream `FilterPHP` ao stream temporário com `stream_filter_append`.

Por fim, lemos os dados do stream temporário com `fread` e exibimos os dados na tela com `echo`. Antes de exibir os dados, removemos as aspas duplas das chaves `name` e `description` com `str_replace`.

Por fim, fechamos o stream temporário e o stream de saída com `fclose`.

O retorno do código acima será algo como:

```json
php-filter_1  |       "PHP",
php-filter_1  |        "PHP (Hypertext Preprocessor) é uma linguagem de script amplamente utilizada para desenvolvimento web e pode ser embutida em HTML."
php-filter_1  |        "Composer é um gerenciador de dependências para PHP, permitindo que você declare as bibliotecas que seu projeto depende e as instale."
php-filter_1  |        "Laravel é um framework web PHP, conhecido por sua sintaxe elegante e ferramentas robustas para desenvolvimento rápido de aplicativos."
php-filter_1  |        "Symfony é um conjunto de componentes PHP reutilizáveis e um framework web para criar aplicações e sites."
php-filter_1  |        "CodeIgniter é um framework PHP poderoso e simples de usar, construído para desenvolvedores que precisam de um toolkit elegante para criar aplicativos web completos."
php-filter_1  |       "CakePHP",
php-filter_1  |        "CakePHP é um framework PHP rápido de desenvolvimento que proporciona uma estrutura extensível para desenvolvedores criar aplicativos web."
php-filter_1  |        "Zend Framework é uma coleção de pacotes PHP profissionais com mais de 570 milhões de instalações."
```

Caso você queira testar o código acima, você pode clonar o repositório [stream-php](https://github.com/sschonss/stream-php) e executar o comando `docker-compose up` para subir o container com o PHP e testar o código.

## Conclusão

Streams são uma abstração poderosa e flexível para trabalhar com arquivos e outros recursos de I/O em PHP. Com streams, você pode ler e escrever dados de e para diferentes fontes, como arquivos, strings, conexões de rede, etc., de forma consistente e independente da origem ou destino dos dados.

Além disso, você pode usar contextos de stream para configurar streams com opções específicas, wrappers para abrir streams de diferentes tipos de recursos, funções de stream para trabalhar com streams de forma eficiente e filtros de stream para processar os dados conforme necessário.

Espero que este guia tenha sido útil para você entender melhor como trabalhar com streams em PHP. Se tiver alguma dúvida, sugestão ou correção, fique à vontade para entrar em contato.

Até a próxima!
