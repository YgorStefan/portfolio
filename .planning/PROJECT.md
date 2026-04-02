# Portfólio Pessoal — Ygor Stefankowski da Silva

## What This Is

Site de portfólio pessoal para Ygor Stefankowski da Silva, desenvolvedor full stack. Single-page application construída com Laravel 12, PHP, JavaScript e Tailwind CSS v4, com dark theme e acento azul elétrico, exibindo apresentação pessoal, habilidades, projetos e formulário de contato funcional com envio de email via Brevo SMTP. **Em produção em ygorstefan.com.**

## Core Value

Causar uma primeira impressão profissional e memorável a recrutadores e clientes, comunicando competência técnica full stack de forma visual e direta.

## Current State (v1.0 — shipped 2026-04-02)

- Site ao vivo em ygorstefan.com
- Formulário de contato funcionando via Brevo SMTP → ygor.stefan@gmail.com
- OG tags gerando rich preview no WhatsApp e LinkedIn
- 41/41 requirements v1 entregues

## Requirements

### Validated (v1.0)

- ✓ Projeto Laravel 12 com PHP 8.2, Vite e Tailwind CSS v4 — v1.0
- ✓ Pipeline Vite compilando com output em `public/build/` — v1.0
- ✓ Configuração de deploy para Hostinger documentada — v1.0
- ✓ Layout Blade base com header, main e footer — v1.0
- ✓ Navegação com smooth scroll e menu hamburger mobile — v1.0
- ✓ Botão "voltar ao topo" com transição suave — v1.0
- ✓ Design responsivo mobile, tablet e desktop — v1.0
- ✓ Seção Hero com nome, cargo, foto e CTA — v1.0
- ✓ Seção Sobre com bio, foto e download do CV — v1.0
- ✓ Carrossel Swiper.js de skills com Devicon — v1.0
- ✓ Grid de projetos carregado de `data/projects.json` com hover overlay — v1.0
- ✓ Formulário de contato com validação server-side e rate limiting — v1.0
- ✓ Email de contato via Laravel Mail (Brevo SMTP) — v1.0
- ✓ Links sociais: GitHub, LinkedIn, WhatsApp, E-mail — v1.0
- ✓ Dark theme com acento azul elétrico — v1.0
- ✓ Animações AOS em todas as seções — v1.0
- ✓ OG meta tags para preview no WhatsApp/LinkedIn — v1.0
- ✓ `.env` protegido (403/404), APP_DEBUG=false em produção — v1.0

### Active (v2.0)

- [ ] Modo claro/escuro toggle
- [ ] Página de erro 404 customizada
- [ ] Analytics sem cookies (Fathom ou Plausible)

### Out of Scope

- Banco de dados — JSON é suficiente, sem overhead em shared hosting
- Autenticação / área restrita — sem painel admin em v1
- Sistema de filas (queues) — shared hosting sem worker daemon
- Vue.js / React / Livewire — Alpine.js é suficiente para portfólio
- Blog ou sistema de posts — fora do escopo de v1
- Multi-idioma — apenas português em v1

## Context

- **Produção**: ygorstefan.com (Hostinger shared hosting)
- **Deploy**: upload manual via hPanel File Manager / FTP
- **SMTP**: Brevo, sender ygor.stefan@gmail.com, destino ygor.stefan@gmail.com
- **Stack**: Laravel 12 + PHP 8.2 + Tailwind CSS v4 + Alpine.js + Swiper.js + AOS
- **Projetos**: `data/projects.json` — editado manualmente, imagens em `public/images/projects/`

## Constraints

- **Tech Stack**: Laravel + PHP + JavaScript + Tailwind CSS — escolha do usuário
- **Sem banco de dados**: projetos gerenciados via JSON
- **Deploy**: Hostinger shared hosting com suporte PHP/Laravel
- **PHP**: ^8.2 (ceiling do Hostinger confirmado)

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Projetos via JSON em vez de DB | Simplicidade, sem overhead de banco em shared hosting | ✓ Funciona bem |
| Laravel em vez de site estático | Formulário de contato funcional + showcase da stack | ✓ Entregue |
| Tailwind CSS v4 | Utilidade-first, padrão moderno, CSS-first sem config.js | ✓ Funcionou |
| Alpine.js para interatividade | Complementa Tailwind sem overhead de Vue/React | ✓ Suficiente |
| Swiper CSS importado em app.js (não app.css) | Evita problemas de cascade ordering do Tailwind v4 | ✓ Correto |
| AOS.init() e Swiper() em DOMContentLoaded | Module scope falha silenciosamente em Vite builds | ✓ Correto |
| MAIL_FROM_ADDRESS = ygor.stefan@gmail.com | contato@ygorstefan.com não existe; Gmail verificado no Brevo | ✓ Funcionando |
| Fallback SVG inline no onerror das imagens | Elimina 404s no DevTools sem arquivo externo | ✓ Aplicado |
| Config cache deletado via File Manager | Sem SSH, php artisan config:clear indisponível | ✓ Documentado |
| Validação OG via WhatsApp em vez do Facebook Debugger | Hostinger bloqueia bot do Facebook (403) | ✓ Equivalente |

---
*Last updated: 2026-04-02 after v1.0 milestone*
