FROM node:11.15.0 as builder
WORKDIR /home/numeris
ENV PATH /home/numeris/node_modules/.bin:$PATH
COPY package*.json /home/numeris/
RUN npm install
RUN npm install -g @angular/cli@7.3.9
COPY . .
RUN npm rebuild node-sass
RUN npm run build-prod
ENTRYPOINT [ "ng", "s", "--host", "0.0.0.0" ]

FROM nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf
RUN rm -rf /usr/share/nginx/html/*
COPY --from=builder dist /usr/share/nginx/html
EXPOSE 80
ENTRYPOINT ["nginx", "-g", "daemon off;"]
