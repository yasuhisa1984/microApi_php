#!/bin/bash
echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf
sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /etc/httpd/conf/httpd.conf
echo '<Directory "/var/www/html">
    AllowOverride All
    Require all granted
</Directory>' >> /etc/httpd/conf/httpd.conf
