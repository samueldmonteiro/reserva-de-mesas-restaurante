FROM php:8.4.1-fpm

ARG USER
ARG UID

# Define o diretório de trabalho padrão
WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Criação de usuário não-root com características similares ao host
RUN if [ "$USER" != "root" ]; then echo "Creating $USER" && \
    useradd -G www-data,root -u $UID -d /home/$USER $USER && \
    mkdir -p /home/$USER/.compose && \
    chown -R $USER:$USER /home/$USER;fi;

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    wget \
    procps \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    net-tools \
    iputils-ping \
    ncat \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala o Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Ajusta permissões da pasta de armazenamento e cache para o Symfony funcionar corretamente
RUN chown -R $USER:$USER /var/www/html/var \
    && chmod -R 775 /var/www/html/var

USER $USER

# Expondo a porta padrão usada pelo Symfony
EXPOSE 8000
