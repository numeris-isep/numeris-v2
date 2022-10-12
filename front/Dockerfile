FROM node:11.15.0 as builder
WORKDIR /opt/numeris
ENV PATH /opt/numeris/node_modules/.bin:$PATH
COPY package*.json /opt/numeris/
RUN npm ci
RUN npm install -g @angular/cli@7.3.9
COPY . .
RUN npm rebuild node-sass
RUN npm run build-prod
ENTRYPOINT [ "ng", "s", "--host", "0.0.0.0", "--port", "80" ]

FROM nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN rm -rf /usr/share/nginx/html/*
COPY --from=builder /opt/numeris/dist /usr/share/nginx/html
EXPOSE 80
ENTRYPOINT ["nginx", "-g", "daemon off;"]
