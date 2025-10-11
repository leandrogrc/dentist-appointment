FROM webdevops/php-nginx:8.2

WORKDIR /app

# Copiar aplicação
COPY . .

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instalar dependências do Laravel
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Configurar permissões
RUN chown -R application:application /app \
    && chmod -R 775 storage bootstrap/cache

# A imagem base já configura o nginx automaticamente
# baseado na variável WEB_DOCUMENT_ROOT
