# Projeto Busca CEP

Este é um sistema web completo para buscar e salvar informações de endereços a partir de um CEP. A aplicação possui um sistema de autenticação de usuários e permite que cada usuário salve seus próprios "cards" de endereços.

O projeto foi construído com uma arquitetura moderna, utilizando PHP para o backend, MongoDB Atlas como banco de dados na nuvem, e HTML/CSS/JavaScript para o frontend.

## 📜 Índice

- [✨ Features](#-features)
- [🛠️ Tecnologias Utilizadas](#️-tecnologias-utilizadas)
- [🚀 Configuração do Ambiente](#-configuração-do-ambiente)
- [⚙️ Instalação do Projeto](#️-instalação-do-projeto)
- [🧪 Testando a API com Insomnia](#-testando-a-api-com-insomnia)
- [📁 Estrutura de Pastas](#-estrutura-de-pastas)

## ✨ Features

- **Autenticação:** Sistema completo de registro e login de usuários com senhas criptografadas.
- **Busca de Endereço:** Integração com a API [ViaCEP](https://viacep.com.br/) para buscar dados de endereços.
- **Persistência de Dados:** Os usuários podem salvar os endereços encontrados em sua conta pessoal.
- **Interface Reativa:** Os endereços são exibidos como cards em um dashboard pessoal, com a interface sendo atualizada dinamicamente (sem recarregar a página).
- **Backend Seguro:** Utiliza um banco de dados NoSQL na nuvem (MongoDB Atlas) e uma estrutura de pastas que separa a lógica de negócio dos arquivos públicos.

## 🛠️ Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (ES6+, com `async/await` e `fetch API`)
- **Backend:** PHP 8+
- **Banco de Dados:** MongoDB (hospedado no MongoDB Atlas)
- **Gerenciador de Dependências PHP:** [Composer](https://getcomposer.org/)
- **Servidor de Desenvolvimento:** Extensão [PHP Server](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver) para VS Code (ou qualquer servidor web como Apache/Nginx).

## 🚀 Configuração do Ambiente

Antes de instalar o projeto, sua máquina precisa ter algumas ferramentas essenciais configuradas.

### 1. PHP
O projeto foi desenvolvido com PHP. A forma mais fácil de instalá-lo no Windows é através do **XAMPP**, mesmo que não usemos o Apache ou MySQL dele.
- Baixe e instale o XAMPP em [apachefriends.org](https://www.apachefriends.org/index.html).
- **Importante:** Precisamos habilitar a extensão do MongoDB no PHP.
  - Encontre o arquivo `php.ini` usado pela sua linha de comando (geralmente em `C:\xampp\php\php.ini`).
  - Abra o arquivo e descomente (remova o `;` do início) da seguinte linha:
    ```ini
    ;extension=mongodb
    ```
  - Deve ficar:
    ```ini
    extension=mongodb
    ```
  - Salve o arquivo.

### 2. Composer
O Composer é usado para instalar o driver do MongoDB para o PHP.
- Siga o guia de instalação em [getcomposer.org](https://getcomposer.org/doc/00-intro.md).
- Após a instalação, abra um novo terminal e rode `composer --version` para confirmar que foi instalado corretamente.

### 3. MongoDB Atlas
Este projeto usa um banco de dados na nuvem.
- Crie uma conta gratuita no [MongoDB Atlas](https://www.mongodb.com/cloud/atlas/register).
- Crie um novo Cluster (o plano gratuito `M0` é suficiente).
- Na seção **"Database Access"**, crie um novo usuário para o banco de dados e guarde bem o nome de usuário e a senha.
- Na seção **"Network Access"**, adicione o IP `0.0.0.0/0` (Allow Access From Anywhere) para permitir que sua máquina se conecte ao cluster durante o desenvolvimento.
- Na visão geral do seu cluster, clique em "Connect", selecione "Drivers", e copie a sua **Connection String**. Ela será algo como `mongodb+srv://<username>:<password>@cluster0.xxxx.mongodb.net/`.

## ⚙️ Instalação do Projeto

Com o ambiente configurado, siga estes passos para rodar o projeto:

1.  **Clone o Repositório:**
    ```bash
    git clone https://github.com/seu-usuario/projeto_cep.git
    cd projeto_cep
    ```

2.  **Instale as Dependências do PHP:**
    O Git ignora a pasta `vendor/` por segurança e para manter o repositório leve. O Composer irá recriá-la com as bibliotecas necessárias.
    ```bash
    composer install
    ```

3.  **Configure as Variáveis de Ambiente:**
    O arquivo `src/conexao.php` contém a chave de acesso ao banco de dados.
    - Abra `src/conexao.php`.
    - Encontre a linha da variável `$uri`.
    - Substitua a string de conexão pela sua, preenchendo seu `<username>` e `<password>` do MongoDB Atlas. Especifique também o nome do banco de dados (ex: `projeto_cep`).

    ```php
    // Exemplo:
    $uri = "mongodb+srv://meu_usuario:minha_senha_segura@cluster0.xxxx.mongodb.net/projeto_cep?retryWrites=true&w=majority";
    ```

4.  **Inicie o Servidor de Desenvolvimento:**
    Este projeto está configurado para ser servido a partir da pasta `/public`.
    - Abra a pasta `projeto_cep` no VS Code.
    - Clique com o botão direito no arquivo `public/index.html`.
    - Selecione a opção **"PHP Server: Serve project"**.
    - Seu navegador abrirá automaticamente no endereço `http://localhost:[porta]`.

Agora a aplicação deve estar totalmente funcional no seu navegador!

## 🧪 Testando a API com Insomnia

Você pode testar todos os endpoints da API usando uma ferramenta como o [Insomnia](https://insomnia.rest/).

1.  **Crie um Ambiente:** Configure uma variável `base_url` com o endereço do seu servidor (ex: `http://localhost:3000`).

2.  **Endpoints:**
    - `POST {{ base_url }}/src/registrar.php`
      - **Body (Form URL Encoded):** `nome`, `email`, `senha`.
      - **Descrição:** Registra um novo usuário.
    - `POST {{ base_url }}/src/login.php`
      - **Body (Form URL Encoded):** `email`, `senha`.
      - **Descrição:** Autentica um usuário. O Insomnia salvará o cookie de sessão (`PHPSESSID`) automaticamente.
    - `GET {{ base_url }}/src/buscar_enderecos.php`
      - **Descrição:** Retorna um array JSON com os endereços salvos pelo usuário autenticado. Requer o cookie de sessão.
    - `POST {{ base_url }}/src/salvar_endereco.php`
      - **Body (JSON):**
        ```json
        {
            "cep": "01001-000",
            "logradouro": "Praça da Sé",
            "bairro": "Sé",
            "cidade": "São Paulo",
            "uf": "SP"
        }
        ```
      - **Descrição:** Salva um novo endereço para o usuário autenticado. Requer o cookie de sessão.

## 📁 Estrutura de Pastas
