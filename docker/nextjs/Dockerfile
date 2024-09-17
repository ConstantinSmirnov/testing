FROM node:18

WORKDIR /var/www

COPY ./frontend/package*.json ./

RUN npm install

COPY ./frontend ./

RUN npm run build

ENV PORT=3000

EXPOSE 3000

CMD [ "npm", "start" ]
