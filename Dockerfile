#Base Image by NottDev (17/12/18)
FROM php:7.2-apache

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

#install mysqli module
RUN docker-php-ext-install mysqli

#install vim
RUN apt-get update && apt-get install -y \
    vim 

#Enable module rewrite
RUN a2enmod rewrite

RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN a2enconf fqdn

#Restart apache2
RUN service apache2 restart