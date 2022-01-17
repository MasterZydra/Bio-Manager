echo ""
echo "Setting Apache up for development environment"
echo "---------------------------------------------"
echo "Logfile: /var/log/SetupApacheForDevEnv.log"
echo ""

# Configuration
# -------------

add_user_to_wwwdata=true
set_folder_permissions=true
generate_certificate=true
configure_apache_site=true

if $add_user_to_wwwdata ; then
    echo "Add user to wwwdata group ..."
    echo "----------------------------------" >> /var/log/SetupApacheForDevEnv.log
    echo "Add user to wwwdata group ..." >> /var/log/SetupApacheForDevEnv.log

    echo "> sudo adduser $SUDO_USER www-data" >> /var/log/SetupApacheForDevEnv.log
    sudo adduser $SUDO_USER www-data >> /var/log/SetupApacheForDevEnv 2>&1
fi

if $set_folder_permissions ; then
    echo "Set folder permissions ..."
    echo "----------------------------------" >> /var/log/SetupApacheForDevEnv.log
    echo "Set folder permissions ..." >> /var/log/SetupApacheForDevEnv.log
    
    echo "> Set permissions in html direcory" >> /var/log/SetupApacheForDevEnv.log
    sudo chown -R www-data:www-data /var/www/html
    sudo chmod -R g+rw /var/www/html
fi

if $generate_certificate ; then
    echo "Generate SSL certificate ..."
    echo "----------------------------------" >> /var/log/SetupApacheForDevEnv.log
    echo "Generate SSL certificate ..." >> /var/log/SetupApacheForDevEnv.log

    echo "> sudo a2enmod ssl" >> /var/log/SetupApacheForDevEnv.log
    sudo a2enmod ssl >> /var/log/SetupApacheForDevEnv.log

    echo "> Generate certificate" >> /var/log/SetupApacheForDevEnv.log
    (echo "DE"; echo "Germany"; echo "Frankfurt"; echo "Dev AG"; echo "Dev AG"; echo "local.biomanager.com"; echo "admin@local.biomanager.com") | sudo openssl req -x509 -nodes -days 1000 -newkey rsa:2048 -keyout /etc/ssl/private/local.biomanager.com.key -out /etc/ssl/certs/local.biomanager.com.crt
fi

if $configure_apache_site ; then
    echo "Configure Apache site ..."
    echo "----------------------------------" >> /var/log/SetupApacheForDevEnv.log
    echo "Configure Apache site ..." >> /var/log/SetupApacheForDevEnv.log

    echo "> sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/local.biomanager.com.conf" >> /var/log/SetupApacheForDevEnv.log
    sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log
            
    echo "> Add port forwarding to 443" >> /var/log/SetupApacheForDevEnv.log
    sudo sed -i 's/^<VirtualHost \*:80>/<VirtualHost *:80>\n\tServerName local.biomanager.com\n\tRedirect permanent \/ https:\/\/local.biomanager.com\/\n<\/VirtualHost>\n\n<VirtualHost *:443>/' /etc/apache2/sites-available/local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log

    echo "> Change DocumentRoot" >> /var/log/SetupApacheForDevEnv.log
    sudo sed -i 's/^\tDocumentRoot .*$/\tDocumentRoot \/var\/www\/html\/Bio-Manager/' /etc/apache2/sites-available/local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log

    echo "> Add certificate settings" >> /var/log/SetupApacheForDevEnv.log
    sudo sed -i 's/^<\/VirtualHost>$/\n\tSSLEngine on\n\tSSLCertificateFile \/etc\/ssl\/certs\/local.biomanager.com.crt\n\tSSLCertificateKeyFile \/etc\/ssl\/private\/local.biomanager.com.key\n<\/VirtualHost>/' /etc/apache2/sites-available/local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log

    echo "> sudo sed -i 's/^\t#ServerName www\.example\.com$/\tServerName wika.com\n\tServerAlias local.biomanager.com/' /etc/apache2/sites-available/local.biomanager.com.conf" >> /var/log/SetupApacheForDevEnv.log
    sudo sed -i 's/^\t#ServerName www\.example\.com$/\tServerName wika.com\n\tServerAlias local.biomanager.com/' /etc/apache2/sites-available/local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log

    echo "> Enable distributed .htaccess configuration" >> /var/log/SetupApacheForDevEnv.log
    sudo sed -i 's/^<\/VirtualHost>$/\n\t<Directory "\/var\/www\/html">\n\t\tAllowOverride All\n\t<\/Directory>\n<\/VirtualHost>/' /etc/apache2/sites-available/local.biomanager.com.conf

    echo "> sudo a2ensite local.biomanager.com.conf" >> /var/log/SetupApacheForDevEnv.log
    sudo a2ensite local.biomanager.com.conf >> /var/log/SetupApacheForDevEnv.log

    echo "> Add URL to hosts" >> /var/log/SetupApacheForDevEnv.log
    sudo echo "127.0.0.1 local.biomanager.com" >> /etc/hosts

    echo "> systemctl restart apache2" >> /var/log/SetupApacheForDevEnv.log
    sudo systemctl restart apache2 >> /var/log/SetupApacheForDevEnv.log

    echo "Apache Config-Test:"
    sudo apachectl configtest

    echo "> Enable the Apache rewrite module" >> /var/log/SetupApacheForDevEnv.log
    sudo a2enmod rewrite >> /var/log/SetupApacheForDevEnv.log

    echo "> systemctl restart apache2" >> /var/log/SetupApacheForDevEnv.log
    sudo systemctl restart apache2 >> /var/log/SetupApacheForDevEnv.log
fi
