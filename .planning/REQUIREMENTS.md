# Requirements: Portfólio Pessoal — Ygor Stefankowski da Silva

**Defined:** 2026-03-24
**Core Value:** Causar uma primeira impressão profissional e memorável a recrutadores e clientes, comunicando competência técnica full stack de forma visual e direta.

## v1 Requirements

### Infraestrutura

- [x] **INFRA-01**: Projeto Laravel 12 criado com PHP 8.2, Vite e Tailwind CSS v4
- [x] **INFRA-02**: Pipeline Vite compilando corretamente (`npm run build`) com output em `public/build/`
- [x] **INFRA-03**: Configuração de deploy documentada para Hostinger (document root → `public/`)
- [x] **INFRA-04**: `.env.example` com todas as variáveis necessárias documentadas

### Layout e Navegação

- [x] **LAYOUT-01**: Layout Blade base (`layouts/app.blade.php`) com header, main e footer
- [x] **LAYOUT-02**: Navegação com links de âncora suave para cada seção
- [x] **LAYOUT-03**: Menu hamburger funcional em mobile (Alpine.js)
- [x] **LAYOUT-04**: Botão "voltar ao topo" com transição suave
- [x] **LAYOUT-05**: Design responsivo em mobile, tablet e desktop

### Seção Hero

- [ ] **HERO-01**: Exibe nome completo (Ygor Stefankowski da Silva) e cargo (Desenvolvedor Full Stack)
- [ ] **HERO-02**: Exibe foto de perfil ou imagem de fundo com overlay
- [ ] **HERO-03**: Botão de chamada de ação (CTA) para seção de contato ou download de CV
- [ ] **HERO-04**: Animação de entrada nos elementos do hero

### Seção Sobre

- [ ] **ABOUT-01**: Exibe texto pessoal com trajetória e objetivo profissional
- [ ] **ABOUT-02**: Exibe foto de perfil na seção sobre
- [ ] **ABOUT-03**: Botão de download do CV em PDF
- [ ] **ABOUT-04**: Animação de entrada com AOS ao rolar

### Seção Skills

- [ ] **SKILL-01**: Carrossel de tecnologias usando Swiper.js
- [ ] **SKILL-02**: Cada card exibe ícone/logo e nome da tecnologia
- [ ] **SKILL-03**: Skills carregadas a partir de dado configurável (array no controller ou JSON)
- [ ] **SKILL-04**: Paginação e/ou navegação do Swiper funcional

### Seção Projetos

- [ ] **PROJ-01**: Projetos carregados dinamicamente de `data/projects.json`
- [ ] **PROJ-02**: Grid responsivo de cards de projeto (3 colunas desktop, 2 tablet, 1 mobile)
- [ ] **PROJ-03**: Cada card exibe imagem, título, descrição e tags de tecnologia
- [ ] **PROJ-04**: Hover overlay com links para demo e repositório
- [ ] **PROJ-05**: Schema do `projects.json` documentado (título, descrição, imagem, url, repo, tags)

### Seção Contato

- [ ] **CONTACT-01**: Formulário com campos: nome, e-mail, assunto e mensagem
- [ ] **CONTACT-02**: Validação server-side com feedback de erro inline
- [ ] **CONTACT-03**: Envio via Laravel Mail (SMTP) com mensagem chegando ao e-mail do proprietário
- [ ] **CONTACT-04**: Feedback visual de sucesso/erro após envio
- [ ] **CONTACT-05**: Rate limiting no endpoint de contato (máximo 5 envios/minuto por IP)
- [ ] **CONTACT-06**: Links sociais visíveis na seção: GitHub, LinkedIn, WhatsApp, E-mail

### Visual e Animações

- [ ] **VIS-01**: Dark theme com acento azul elétrico consistente em todos os elementos interativos
- [ ] **VIS-02**: Animações de entrada ao scroll com AOS em todas as seções
- [ ] **VIS-03**: Transições hover suaves em botões, links e cards de projeto
- [x] **VIS-04**: Google Fonts carregando corretamente em produção

### SEO e Compartilhamento

- [ ] **SEO-01**: Meta tags OG (og:title, og:description, og:image) para preview no WhatsApp/LinkedIn
- [ ] **SEO-02**: Meta description e título da página configurados

### Assets

- [ ] **ASSET-01**: Foto de perfil do usuário presente em `public/images/`
- [ ] **ASSET-02**: CV em PDF presente em `public/files/curriculo.pdf`
- [ ] **ASSET-03**: Imagens dos projetos otimizadas presentes em `public/images/projects/`

## v2 Requirements

### Melhorias futuras

- **V2-01**: Modo claro/escuro toggle — deixado para v2 (dark é a identidade visual da v1)
- **V2-02**: Blog ou sistema de posts
- **V2-03**: Painel admin para gerenciar projetos sem editar JSON
- **V2-04**: Internacionalização PT/EN
- **V2-05**: Página de erro 404 customizada
- **V2-06**: Analytics (Fathom ou Plausible, sem cookies)

## Out of Scope

| Feature | Reason |
|---------|--------|
| Banco de dados | Desnecessário para portfólio; JSON é suficiente e mais simples no shared hosting |
| Autenticação / área restrita | Sem painel admin em v1 |
| Sistema de filas (queues) | Shared hosting sem worker daemon; envio SMTP síncrono |
| Vue.js / React / Livewire | Over-engineering para portfólio; Alpine.js é suficiente |
| Dark/light mode toggle | Compromete a identidade visual do dark theme; adiado |
| Testes automatizados | Fora do escopo de v1; portfólio simples sem lógica de negócio complexa |

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| INFRA-01 | Phase 1 | Complete |
| INFRA-02 | Phase 1 | Complete |
| INFRA-03 | Phase 1 | Complete |
| INFRA-04 | Phase 1 | Complete |
| LAYOUT-01 | Phase 1 | Complete |
| LAYOUT-02 | Phase 1 | Complete |
| LAYOUT-03 | Phase 1 | Complete |
| LAYOUT-04 | Phase 1 | Complete |
| LAYOUT-05 | Phase 1 | Complete |
| HERO-01 | Phase 2 | Pending |
| HERO-02 | Phase 2 | Pending |
| HERO-03 | Phase 2 | Pending |
| HERO-04 | Phase 2 | Pending |
| ABOUT-01 | Phase 2 | Pending |
| ABOUT-02 | Phase 2 | Pending |
| ABOUT-03 | Phase 2 | Pending |
| ABOUT-04 | Phase 2 | Pending |
| SKILL-01 | Phase 2 | Pending |
| SKILL-02 | Phase 2 | Pending |
| SKILL-03 | Phase 2 | Pending |
| SKILL-04 | Phase 2 | Pending |
| PROJ-01 | Phase 2 | Pending |
| PROJ-02 | Phase 2 | Pending |
| PROJ-03 | Phase 2 | Pending |
| PROJ-04 | Phase 2 | Pending |
| PROJ-05 | Phase 2 | Pending |
| CONTACT-01 | Phase 3 | Pending |
| CONTACT-02 | Phase 3 | Pending |
| CONTACT-03 | Phase 3 | Pending |
| CONTACT-04 | Phase 3 | Pending |
| CONTACT-05 | Phase 3 | Pending |
| CONTACT-06 | Phase 3 | Pending |
| VIS-01 | Phase 2 | Pending |
| VIS-02 | Phase 2 | Pending |
| VIS-03 | Phase 2 | Pending |
| VIS-04 | Phase 1 | Complete |
| SEO-01 | Phase 4 | Pending |
| SEO-02 | Phase 4 | Pending |
| ASSET-01 | Phase 2 | Pending |
| ASSET-02 | Phase 2 | Pending |
| ASSET-03 | Phase 2 | Pending |

**Coverage:**
- v1 requirements: 41 total
- Mapped to phases: 41
- Unmapped: 0 ✓

---
*Requirements defined: 2026-03-24*
*Last updated: 2026-03-24 after initial definition*
