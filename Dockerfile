FROM php:8.2-apache

# 安裝 libcurl 的開發檔
RUN apt-get update && apt-get install -y libcurl4-openssl-dev

# 啟用 Apache rewrite 模組與安裝 curl 擴充
RUN a2enmod rewrite
RUN docker-php-ext-install curl

# 複製專案到 Web 根目錄
COPY public/ /var/www/html/
