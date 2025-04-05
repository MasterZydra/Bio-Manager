FROM serversideup/php:8.4-fpm-apache

WORKDIR /var/www/html

USER root

COPY . .

RUN apt update ; \
    apt upgrade -y ; \
    # Rename env.example so that .env exists
    mv .env.example .env; \
    # Fix permissions
    chown -R www-data:www-data /var/www/html ; \
    # Add bioman-automations to startup
    mkdir /etc/s6-overlay/scripts ; \
    mv ./bioman-automations /etc/s6-overlay/scripts/bioman-automations ; \
    sed -i 's/\r$//' /etc/s6-overlay/scripts/bioman-automations ; \
    # chown root:root /etc/s6-overlay/scripts/bioman-automations ; \
    chmod ugo+x /etc/s6-overlay/scripts/bioman-automations ; \
    mkdir /etc/s6-overlay/s6-rc.d/bioman-automations ; \
    echo "/etc/s6-overlay/scripts/bioman-automations" > /etc/s6-overlay/s6-rc.d/bioman-automations/up ; \
    echo "oneshot" > /etc/s6-overlay/s6-rc.d/bioman-automations/type ; \
    touch /etc/s6-overlay/s6-rc.d/bioman-automations/dependencies ; \
    touch /etc/s6-overlay/s6-rc.d/user/contents.d/bioman-automations

USER www-data

EXPOSE 8080
