FROM arm64v8/amazonlinux

# パッケージリストを更新し、必要なパッケージをインストール
RUN yum update -y && \
    yum install -y httpd php php-cli php-fpm php-json php-mysqlnd zip unzip && \
    yum clean all

# PHP-FPMの設定を変更し、ソケット用のディレクトリを作成
RUN sed -i 's|listen = 127.0.0.1:9000|listen = /run/php-fpm/www.sock|' /etc/php-fpm.d/www.conf && \
    mkdir -p /run/php-fpm && \
    chmod 755 /run/php-fpm

# ServerNameを設定して警告を抑制
RUN echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf

# Apacheのmod_rewriteを有効化
RUN sed -i 's/^#LoadModule rewrite_module/LoadModule rewrite_module/' /etc/httpd/conf/httpd.conf


# Apache設定ファイルにAllowOverrideとRequireを追加
RUN echo '<Directory "/var/www/html">' >> /etc/httpd/conf/httpd.conf && \
    echo '    AllowOverride All' >> /etc/httpd/conf/httpd.conf && \
    echo '    Require all granted' >> /etc/httpd/conf/httpd.conf && \
    echo '</Directory>' >> /etc/httpd/conf/httpd.conf

# 作業ディレクトリを設定
WORKDIR /var/www/html

# ソースコードをコピー
COPY ./src /var/www/html

# PHP-FPMとApacheを起動する
CMD php-fpm && httpd -D FOREGROUND

# ポート80を公開
EXPOSE 80
