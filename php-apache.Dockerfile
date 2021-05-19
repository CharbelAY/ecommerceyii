# Getting the php 7.4 image with apache2
FROM php:7.4-apache

#Creating the directory for our yii app.
#this will be used with volumes in development mode to apply changes directly between host and container
RUN mkdir /var/www/ecomerceapp && mkdir /var/www/ecomerceapp/public_html

#Installing pdo for mysql
RUN docker-php-ext-install pdo pdo_mysql

#Installing useful tools for debuggind, development and testing inside the container
# -y means that we are inputing yes automatically any time we are asked during the installation
RUN apt-get update -y && apt-get install -y openssl zip unzip git vim links

#Installing composer globally inside the container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Copying basic configs into app-config folder
RUN mkdir /app-config
COPY ./websites-conf /app-config

RUN mkdir /initialization
COPY ./initialization /initialization


#Setting to the right directory to create yii project
WORKDIR /var/www/ecomerceapp/public_html

#Installing basic yii project
RUN composer create-project --prefer-dist yiisoft/yii2-app-advanced ecomerceapp
