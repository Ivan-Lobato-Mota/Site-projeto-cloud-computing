FROM php:8.3-apache

# O site é PHP puro: não precisa de extensão de banco, composer nem node.
# Só precisamos de duas coisas do Apache: docroot em public/ e porta 8080.

# 1) Docroot -> /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g'      /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 2) Apache escutando em 8080 (casa com o WEBSITES_PORT=8080 do roteiro)
RUN sed -ri -e 's!^Listen 80$!Listen 8080!' /etc/apache2/ports.conf \
 && sed -ri -e 's!<VirtualHost \*:80>!<VirtualHost *:8080>!' /etc/apache2/sites-available/000-default.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 3) Configuração de PHP de produção (sem exibir erros na tela)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# 4) Código
WORKDIR /var/www/html
COPY . /var/www/html/

# 5) O contador de visitas escreve em data/counter.txt
RUN mkdir -p /var/www/html/data \
 && chown -R www-data:www-data /var/www/html/data

EXPOSE 8080
