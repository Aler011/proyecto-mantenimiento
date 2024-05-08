FROM php:8.2-apache

# Actualizar paquetes existentes e instalar el cliente de MySQL y otras utilidades
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y iputils-ping default-mysql-client && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copiar los archivos de la aplicación
ADD ./application_v1 /var/www/html

# Configurar el virtual host
COPY ./application_v1/my-site.conf /etc/apache2/sites-available/my-site.conf

# Configurar variables de entorno accesibles desde Apache
RUN echo 'SetEnv MYSQL_DB_CONNECTION ${MYSQL_DB_CONNECTION}' >> /etc/apache2/conf-enabled/environment.conf && \
    echo 'SetEnv MYSQL_DB_NAME ${MYSQL_DB_NAME}' >> /etc/apache2/conf-enabled/environment.conf && \
    echo 'SetEnv MYSQL_USER ${MYSQL_USER}' >> /etc/apache2/conf-enabled/environment.conf && \
    echo 'SetEnv MYSQL_PASSWORD ${MYSQL_PASSWORD}' >> /etc/apache2/conf-enabled/environment.conf && \
    echo 'SetEnv SITE_URL ${SITE_URL}' >> /etc/apache2/conf-enabled/environment.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite headers && \
    a2dissite 000-default && \
    a2ensite my-site && \
    service apache2 restart

# Exponer los puertos para HTTP y HTTPS
EXPOSE 80
EXPOSE 443
