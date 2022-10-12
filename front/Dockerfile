FROM node:11.15.0 as builder
WORKDIR /opt/numeris
ENV PATH /opt/numeris/node_modules/.bin:$PATH
COPY package*.json /opt/numeris/
RUN npm ci
RUN npm install -g @angular/cli@7.3.9
COPY . .
RUN npm rebuild node-sass
RUN npm run build-prod
ENTRYPOINT [ "ng", "s", "--host", "0.0.0.0" ]
