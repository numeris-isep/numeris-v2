FROM node:11.15.0 as builder
WORKDIR /opt/numeris
ENV PATH /opt/numeris/node_modules/.bin:$PATH
COPY package*.json /opt/numeris/
RUN yarn install
RUN yarn add -g @angular/cli@7.3.9
COPY . .
RUN yarn run build-prod
ENTRYPOINT [ "ng", "serve", "--configuration", "production", "--port", "80" ]
