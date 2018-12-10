ARG SYMFONY_ENV

FROM cleverage/eav-manager:php7.2 AS base-prod

ENV SYMFONY_ENV ${SYMFONY_ENV}

FROM cleverage/eav-manager:php7.2-dev AS base-dev
ENV SYMFONY_ENV ${SYMFONY_ENV}

FROM base-${SYMFONY_ENV} AS base

COPY --chown=docker:docker . /app

### He you can add specific stuff like php module missing
### RUN apk add -U php-foo@php php-bar@php
### Please to note that you can add a module without specify the php version
### you must suffix the module to install with @php

### STAGE-BUILD
#==============
FROM base AS build-dev
RUN composer install --no-scripts --no-ansi --no-interaction --no-progress --optimize-autoloader

FROM build-dev AS build-prod
RUN composer install --no-scripts --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader

FROM build-${SYMFONY_ENV} AS release

