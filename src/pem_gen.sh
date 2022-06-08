#!/bin/bash

ssh-keygen -t rsa -b 4096 -m PEM -f jwtRS256.key
openssl rsa -in jwtRS256.key -pubout -outform PEM -out jwtRS256.key.pub

chown -R www-data:www-data jwtRS256.key
chown -R www-data:www-data jwtRS256.key.pub