# build stage
FROM node:14.16.0 as build-stage

RUN mkdir -p /front/
WORKDIR /front/

COPY . .
RUN npm install
RUN npm run build

# production stage
FROM nginx:latest as production-stage
COPY --from=build-stage /front/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]