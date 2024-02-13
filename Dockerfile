FROM serversideup/php:8.2-fpm-apache-v2.2.1

WORKDIR /var/www/html

COPY . .

    # Rename env.example so that .env exists
RUN cp .env.example .env; \
    # Fix permissions
    chown -R webuser:webgroup /var/www/html ; \
    # Add bioman-automations to startup
    mv ./bioman-automations /etc/s6-overlay/scripts ; \
    sed -i 's/\r$//' /etc/s6-overlay/scripts/bioman-automations ; \
    chown root:root /etc/s6-overlay/scripts/bioman-automations ; \
    chmod ugo+x /etc/s6-overlay/scripts/bioman-automations ; \
    mkdir /etc/s6-overlay/s6-rc.d/bioman-automations ; \
    echo "/etc/s6-overlay/scripts/bioman-automations" > /etc/s6-overlay/s6-rc.d/bioman-automations/up ; \
    echo "oneshot" > /etc/s6-overlay/s6-rc.d/bioman-automations/type ; \
    echo "runas-user" > /etc/s6-overlay/s6-rc.d/bioman-automations/dependencies ; \
    touch /etc/s6-overlay/s6-rc.d/user/contents.d/bioman-automations

EXPOSE 80
