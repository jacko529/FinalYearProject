FROM node:latest

# Create app directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

COPY front-end/package.json /usr/src/app/

RUN npm install

CMD [ "npm", "start" ]