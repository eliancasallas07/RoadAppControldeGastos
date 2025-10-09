# Dockerfile para Ember (build y servir estático)
FROM node:20 AS build

WORKDIR /app
COPY . .

# Instala dependencias y genera el build de producción
RUN npm install && npm run build

# Imagen final para servir archivos estáticos
FROM nginx:alpine
COPY --from=build /app/dist /usr/share/nginx/html

# Copia configuración personalizada de Nginx si la necesitas (opcional)
# COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
