FROM node:11.15.0 as builder
WORKDIR /opt/numeris
ENV PATH /opt/numeris/node_modules/.bin:$PATH
COPY package.json yarn.lock /opt/numeris/
RUN yarn install
# RUN yarn add -g @angular/cli@7.3.9
COPY . .
RUN yarn run build
ENTRYPOINT [ "ng", "serve", "--port", "80" ]
