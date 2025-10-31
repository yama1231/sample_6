FROM php:8.1-fpm-bullseye

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

RUN apt-get update && \
    apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install intl pdo_mysql zip bcmath

COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /data

# Cronのインストール
RUN apt-get update && apt-get install -y cron && rm -rf /var/lib/apt/lists/*
# crontabファイルをコピー
COPY docker/crontab /etc/cron.d/laravel-cron
# 適切な権限を設定
RUN chmod 0644 /etc/cron.d/laravel-cron
# crontabを登録
RUN crontab /etc/cron.d/laravel-cron
# ログファイル作成
RUN touch /var/log/cron.log
# entrypointスクリプトをコピー
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]