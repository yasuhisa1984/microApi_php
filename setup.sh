#!/bin/bash

# ServerNameの警告を抑制
echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf

# mod_rewriteを有効化
sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /etc/httpd/conf/httpd.conf

# .htaccessが有効になるようにディレクトリ設定を追加
echo '<Directory "/var/www/html">
    AllowOverride All
    Require all granted
</Directory>' >> /etc/httpd/conf/httpd.conf
