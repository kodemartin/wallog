FROM php:7.2-apache

ARG BLOG_NAME=wallog
COPY . ${BLOG_NAME}/

# Setup config.php
RUN sed "s/\$folder = .\+;$/\$folder = \"${BLOG_NAME}\/\";/" \
        ${BLOG_NAME}/config.php.sample  > ${BLOG_NAME}/config.php

# Aliasing requests on /posts/<filename>.md
ARG regex=(/${BLOG_NAME}/posts/.+)
ARG alias=/var/www/html/${BLOG_NAME}/index.php

RUN sed -i "/DocumentRoot \/var\/www\/html/ a\
     \        AliasMatch $regex $alias" /etc/apache2/sites-available/000-default.conf
