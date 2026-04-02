# Project Retrospective

*A living document updated after each milestone. Lessons feed forward into future planning.*

## Milestone: v1.0 — MVP

**Shipped:** 2026-04-02
**Phases:** 4 | **Plans:** 14 | **Sessions:** múltiplas

### What Was Built
- Laravel 12 + Tailwind CSS v4 + Alpine.js + Vite asset pipeline em produção
- 5 seções de portfólio: Hero, Sobre, Skills (Swiper), Projetos (JSON), Contato
- Formulário de contato funcional com validação, rate limiting e email via Brevo SMTP
- OG meta tags gerando rich preview no WhatsApp e LinkedIn
- Site ao vivo em ygorstefan.com com checklist de produção completo

### What Worked
- Tailwind CSS v4 CSS-first sem config.js foi mais simples do que esperado
- Swiper + AOS integração tranquila uma vez resolvido o DOMContentLoaded
- Brevo configuração rápida — conta gratuita funciona bem para volume de portfólio
- Checklist de produção como plano separado (04-02) foi boa decisão — forçou verificação sistemática

### What Was Inefficient
- `catch` sem `Log::error` no ContactController tornou diagnóstico SMTP desnecessariamente difícil — deveria ser padrão desde o início
- Config cache da Hostinger não documentado antecipadamente — causou confusão ao atualizar `.env`
- `MAIL_FROM_ADDRESS` com domínio inexistente (`contato@ygorstefan.com`) deveria ter sido identificado antes do deploy

### Patterns Established
- Swiper CSS importado em `app.js` (não `app.css`) para evitar problemas de cascade do Tailwind v4
- `AOS.init()` e `new Swiper()` sempre dentro de `DOMContentLoaded` em projetos Vite
- `Log::error` no `catch` de `Mail::send` — obrigatório para diagnóstico em produção
- Fallback via data URI SVG no `onerror` de imagens — elimina 404s sem arquivo externo
- Deletar `bootstrap/cache/config.php` via File Manager quando sem SSH para forçar config reload

### Key Lessons
1. **SMTP sempre testar em produção desde cedo** — log mailer local mascara problemas reais de autenticação e sender verification
2. **Sender de email precisa ser verificado no provedor SMTP** — domínios sem MX ou emails inexistentes são rejeitados silenciosamente
3. **Config cache em shared hosting** — qualquer mudança de `.env` pode não ter efeito sem limpar o cache
4. **Facebook OG Debugger não é confiável para validar previews** — WhatsApp é alternativa válida e mais representativa do uso real

---
*v1.0 shipped: 2026-04-02*
