FROM mysql:5.7

ENV MYSQL_DATABASE=laravel_local \
    MYSQL_USER=user \
    MYSQL_PASSWORD=123456 \
    MYSQL_ROOT_PASSWORD=123456 \
    TZ=Asia/Tokyo

COPY ./initdb.d/my.cnf /etc/mysql/conf.d/my.cnf

RUN chmod 644 /etc/mysql/conf.d/my.cnf && \
    apt-get -qq update && \
    apt-get -y install vim git unzip libzip-dev libicu-dev libonig-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
