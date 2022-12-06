FROM node:11.15.0 as builder

LABEL source="https://github.com/numerisisep/numeris-v2"
LABEL maintainer="support@numeris-isep.fr"

WORKDIR /opt/numeris
ENV PATH /opt/numeris/node_modules/.bin:$PATH

COPY package.json yarn.lock ./
RUN yarn install
# RUN yarn add -g @angular/cli@7.3.9
COPY . .
RUN yarn run build-prod

EXPOSE 80
ENTRYPOINT [ "ng", "serve", "--configuration", "production", "--port", "80" ]
