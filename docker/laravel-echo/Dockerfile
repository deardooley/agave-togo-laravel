FROM node:alpine

RUN apk add --update --no-cache bash \
	&& apk add --update --no-cache -t .build-deps python make g++ gcc \
	&& npm i -g laravel-echo-server \
	&& apk del .build-deps

ADD ./laravel-echo-server.json /app/laravel-echo-server.json

WORKDIR /app

ENTRYPOINT ["laravel-echo-server"]
CMD ["start"]