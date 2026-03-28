FROM node:lts-alpine

WORKDIR /app

COPY app/package.json ./

RUN npm install

CMD ["npm", "run", "dev", "--", "--host"]