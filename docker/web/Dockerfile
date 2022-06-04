FROM nginx

COPY ./conf/default.conf /etc/nginx/conf.d/
COPY ./scripts/app.sh /usr/local/bin/app

ENTRYPOINT ["app"]