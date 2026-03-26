# 🚀 Portfólio Profissional - Ygor Stefan

Bem-vindo ao repositório do meu portfólio pessoal. Este projeto é uma vitrine moderna, performática e elegante do meu trabalho, habilidades e trajetória profissional.

## ✨ Características

-   🎨 **Design Moderno:** Interface limpa e responsiva, focada na experiência do usuário.
-   ⚡ **Performance:** Construído com o poder do **Laravel** e a agilidade do **Vite**.
-   🧩 **Componentes Interativos:** Utiliza **Alpine.js** para reatividade leve e intuitiva.
-   🎬 **Animações Fluidas:** Efeitos visuais suaves com **AOS (Animate On Scroll)**.
-   📱 **Totalmente Responsivo:** Adaptado para todos os dispositivos, do desktop ao mobile.
-   📬 **Formulário de Contato:** Sistema funcional para mensagens diretas com proteção de limite de envios (*throttling*).

## 🛠️ Tecnologias Utilizadas

### Backend
-   **[Laravel 11+](https://laravel.com):** O framework PHP para artesãos da web.
-   **MySQL:** Banco de dados confiável para armazenamento de dados e contatos.

### Frontend
-   **[Tailwind CSS v4](https://tailwindcss.com):** Estilização utilitária de última geração.
-   **[Alpine.js](https://alpinejs.dev):** Framework JavaScript leve para comportamentos interativos.
-   **[Vite](https://vite.dev):** Ferramenta de build extremamente rápida.
-   **[Swiper](https://swiperjs.com):** Para carrosséis e sliders modernos.
-   **[AOS](https://michalsnik.github.io/aos/):** Biblioteca para animações ao rolar a página.

## 🚀 Como Executar Localmente

Siga os passos abaixo para rodar o projeto em sua máquina:

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/YgorStefan/portifolio.git
    cd portifolio
    ```

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Instale as dependências do Frontend:**
    ```bash
    npm install
    ```

4.  **Configure o ambiente:**
    -   Copie o arquivo `.env.example` para `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Gere a chave da aplicação:
        ```bash
        php artisan key:generate
        ```
    -   Configure suas credenciais de banco de dados no arquivo `.env`.

5.  **Execute as migrações:**
    ```bash
    php artisan migrate
    ```

6.  **Inicie o servidor de desenvolvimento:**
    ```bash
    php artisan serve
    ```

7.  **Inicie o Vite (compilação de assets):**
    ```bash
    npm run dev
    ```

Acesse o projeto em: `http://localhost:8000`

## 📄 Licença

Este projeto está sob a licença [MIT](LICENSE). Sinta-se à vontade para usá-lo como inspiração!

---

Desenvolvido com ❤️ por [Ygor Stefan](https://github.com/YgorStefan)
