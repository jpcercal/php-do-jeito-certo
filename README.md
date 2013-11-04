PHP do Jeito Certo
===

Foi realizado na instituição de ensino SOCIESC um minicurso intitulado como "PHP do Jeito Certo", no qual eu (João Paulo Cercal) fui palestrante junto com (Adan Felipe Medeiros).

O minicurso ocorreu nos dias 19, 20, 21 e 22 de outubro na data onde foi praticada a Semana Acadêmica.

Gerenciando as dependências do Projeto
----------------------------------

### Instalando/Atualizando (*vendors* ou *bibliotecas de terceiros*)

Assumimos que você já possua o *composer* e o *bower* instalados no seu sistema operacional.

Entre no diretório raiz do projeto e execute:

    php composer.phar install

Agora, vamos realizar a instalação dos recursos web, sendo assim, digite o seguinte comando:

    bower install

### Cache e Log

Precisamos agora criar o diretório de logs e cache, para isso entre no diretório raíz do projeto pelo terminal e execute os seguintes comandos:

    mkdir cache
    mkdir logs

Em seguida crie o arquivo de log, com o seguinte comando:

    touch logs/app.log

### Permissão

Vamos dar permissão total (777) para os seguintes diretórios, afim de permitir o uso de cache e logs da aplicação. Sendo assim, rode o seguinte comando no terminal:

    chmod -Rf 777 cache/
    chmod -Rf 777 logs/

### Instalando o banco de dados

Abra o seu gerenciador de banco de dados e execute o script SQL que está na pasta docs, este script irá: criar a base de dados nomeada como "php_do_jeito_certo", criar as tabelas "sexo" e "agenda", inserir dois sexos na tabela "sexo": "masculino" e "feminino".

Abaixo listamos o path onde encontra-se o script de criação da base de dados:

    docs/database/php_do_jeito_certo.sql

### Executando o Projeto

No Terminal, entre no diretório raiz do projeto e execute o seguinte comando:

    php -S localhost:80 -t web/

O comando acima, irá iniciar o servidor web, após a inicialização do server local, vá no navegador e acesse a seguinte URL:

    http://localhost

----------------------------------
Aproveite e faça bom uso deste projeto!

[@CekurteSistemas](http://sistemas.cekurte.com "@CekurteSistemas")