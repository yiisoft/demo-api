FROM yiisoftware/yii-php:8.0-fpm

WORKDIR /app

RUN echo "Installing packages" && \
    composer i --prefer-dist && \
    echo "Installation has been completed"
