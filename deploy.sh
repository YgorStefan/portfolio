#!/bin/bash
# =============================================================
# Script de Deploy - Portfólio Ygor Stefan
# Execute este script no servidor via SSH após um git pull
# Uso: bash ~/portfolio/deploy.sh
# =============================================================

set -e  # Para o script se qualquer comando falhar

PORTFOLIO_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PORTFOLIO_DIR"

echo "🚀 Iniciando deploy em: $PORTFOLIO_DIR"
echo "-------------------------------------------"

# 1. Baixar atualizações do GitHub
echo "📥 Baixando atualizações do GitHub..."
git pull origin main

# 2. Instalar/atualizar dependências PHP
echo "📦 Instalando dependências PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

# 3. Criar banco SQLite se não existir
if [ ! -f "database/database.sqlite" ]; then
    echo "🗄️  Criando banco de dados SQLite..."
    touch database/database.sqlite
fi

# 4. Rodar migrations
echo "🗃️  Rodando migrations..."
php artisan migrate --force

# 5. Criar o arquivo .env se não existir
if [ ! -f ".env" ]; then
    echo "⚠️  ATENÇÃO: Arquivo .env não encontrado!"
    echo "   Crie o .env manualmente antes de continuar."
    exit 1
fi

# 6. Gerar APP_KEY se estiver em branco
APP_KEY=$(grep "^APP_KEY=" .env | cut -d '=' -f2)
if [ -z "$APP_KEY" ]; then
    echo "🔑 Gerando APP_KEY..."
    php artisan key:generate
fi

# 7. Ajustar permissões
echo "🔒 Ajustando permissões..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# 8. Criar symlink do storage
echo "🔗 Criando symlink do storage..."
php artisan storage:link --force 2>/dev/null || true

# 9. Limpar caches antigos
echo "🧹 Limpando caches antigos..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 10. Reconstruir caches para produção
echo "⚡ Otimizando para produção..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "-------------------------------------------"
echo "✅ Deploy concluído com sucesso!"
echo "🌐 Acesse seu site no domínio configurado."
