---
phase: 04-polish-and-deploy
plan: "02"
subsystem: infra
tags: [deploy, smtp, brevo, og-tags, production, hostinger, mail]

# Dependency graph
requires:
  - phase: 04-polish-and-deploy
    plan: "01"
    provides: OG meta tags no layout Blade
  - phase: 03-contact-form-backend
    provides: ContactController com formulário funcional
provides:
  - Site em produção com todos os 5 itens do checklist aprovados
affects: [milestone-complete]

# Tech tracking
tech-stack:
  added: [Brevo SMTP]
  patterns: [Log::error no catch do ContactController para diagnóstico de falhas de envio]

key-files:
  created: []
  modified:
    - app/Http/Controllers/ContactController.php
    - resources/views/pages/home.blade.php

key-decisions:
  - "MAIL_FROM_ADDRESS deve ser um sender verificado no Brevo — usar ygor.stefan@gmail.com (verificado) em vez de contato@ygorstefan.com (não existente)"
  - "Fallback de imagem de projeto via data URI SVG inline no onerror — elimina 404s no DevTools sem depender de arquivo externo"
  - "Config cache da Hostinger (bootstrap/cache/config.php) precisa ser deletado manualmente após atualizar .env — sem SSH não há php artisan config:clear"
  - "Facebook OG Debugger retorna 403 na Hostinger (bot bloqueado) — validação via WhatsApp é alternativa válida e suficiente"

patterns-established:
  - "Log::error no catch de Mail::send — padrão para diagnóstico de falhas SMTP em produção"

requirements-completed: [SEO-01, SEO-02]

# Metrics
duration: ~60min
completed: 2026-04-02
---

# Phase 4 Plan 02: Verificação do Checklist de Produção — Summary

**Site ygorstefan.com validado em produção: .env protegido, debug desligado, assets funcionando, email entregue via Brevo SMTP, e OG tags gerando preview correto no WhatsApp**

## Performance

- **Duration:** ~60 min (verificação manual + troubleshooting SMTP)
- **Started:** 2026-04-02
- **Completed:** 2026-04-02
- **Tasks:** 2
- **Files modified:** 2

## Accomplishments
- Todos os 5 itens do checklist de produção aprovados pelo usuário
- SMTP Brevo configurado e funcionando — emails chegando na inbox do proprietário
- Fallback SVG inline para imagens de projetos ausentes — elimina 404s no DevTools
- OG tags gerando rich preview correto no WhatsApp com foto, título e descrição

## Task Commits

Correções aplicadas durante a verificação:

1. **Fallback SVG para imagens de projetos** — `home.blade.php` atualizado com data URI no onerror
2. **Log::error no ContactController** — diagnóstico de falha SMTP adicionado
3. **Configuração SMTP Brevo** — realizada no .env do servidor (não commitada — credenciais)

## Files Created/Modified
- `app/Http/Controllers/ContactController.php` — Log::error adicionado no catch para diagnóstico SMTP
- `resources/views/pages/home.blade.php` — onerror atualizado de `display='none'` para fallback SVG inline

## Decisions Made
- `MAIL_FROM_ADDRESS` trocado para `ygor.stefan@gmail.com` — único sender verificado no Brevo disponível
- Fallback via data URI evita request HTTP adicional e funciona sem deploy de arquivo de imagem
- Validação das OG tags feita via WhatsApp em vez do Facebook Debugger (403 bloqueado pela Hostinger)

## Deviations from Plan

### Auto-fixed Issues

**1. SMTP sem Log — diagnóstico impossível**
- **Found during:** Tarefa 2 (verificação do formulário)
- **Issue:** catch no ContactController engolia exceção sem logar — log.laravel mostrava apenas erro antigo de storage:link
- **Fix:** Adicionado `Log::error('ContactForm mail failed: ' . $e->getMessage())` no catch
- **Files modified:** app/Http/Controllers/ContactController.php

**2. 404s das imagens de projetos no DevTools**
- **Found during:** Tarefa 2 (verificação de assets)
- **Issue:** `public/images/projects/` vazia — 4 imagens com 404 (portfolio.jpg, sistema-gestao.jpg, api-restful.jpg, dashboard.jpg)
- **Fix:** onerror atualizado para carregar SVG placeholder via data URI em vez de esconder a imagem
- **Files modified:** resources/views/pages/home.blade.php

---

**Total deviations:** 2 auto-fixed
**Impact on plan:** Correções necessárias para produção. Sem scope creep.

## Issues Encountered
- **SMTP falhando silenciosamente:** catch sem Log tornava impossível diagnosticar — resolvido adicionando Log::error
- **Config cache:** atualização do .env não surtia efeito por causa do bootstrap/cache/config.php — deletado via File Manager
- **Sender não verificado no Brevo:** `contato@ygorstefan.com` não existe — trocado para Gmail verificado
- **Facebook Debugger 403:** bot do Facebook bloqueado pela Hostinger sem WAF configurado — validação migrada para WhatsApp

## User Setup Required
- Imagens reais dos projetos devem ser colocadas em `public/images/projects/` com os nomes: `portfolio.jpg`, `sistema-gestao.jpg`, `api-restful.jpg`, `dashboard.jpg` (proporção 16:9 recomendada)
- SMTP key do Brevo compartilhada no chat — **revogar e gerar nova key no painel Brevo**, atualizar no .env do servidor

## Next Phase Readiness
- Fase 4 completa — milestone v1.0 concluído
- Site em produção em ygorstefan.com com todas as funcionalidades funcionando
- Próximo passo: `/gsd:complete-milestone` para arquivar v1.0

---
*Phase: 04-polish-and-deploy*
*Completed: 2026-04-02*
