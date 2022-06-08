#!/bin/bash

ssh-keygen -t rsa -P "" -b 4096 -m PEM -f jwtRS256.key
ssh-keygen -e -m PEM -f jwtRS256.key > jwtRS256.key.pub

mv jwtRS256.key ./keys/
mv jwtRS256.key.pub ./keys/