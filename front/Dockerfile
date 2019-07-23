FROM node:11.15.0

RUN mkdir -p /home/numeris

ENV PATH /home/numeris/node_modules/.bin:$PATH

COPY package*.json /home/numeris/

# npm install
WORKDIR /home/numeris
RUN npm install
RUN npm install -g @angular/cli@7.3.9

COPY . /home/numeris

RUN npm rebuild node-sass

WORKDIR /home/numeris
