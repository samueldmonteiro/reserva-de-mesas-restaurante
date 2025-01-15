FROM node:22.0

ARG UID
ARG GID

# Modifica o GID do grupo 'node' para o valor passado
RUN groupmod -g ${GID} node || groupadd -g ${GID} node

# Modifica o UID do usuário 'node' para o valor passado
RUN usermod -u ${UID} -g ${GID} node

# Ajusta as permissões do diretório de trabalho
RUN chown -R node:node /home/node

WORKDIR /app

# Ajusta as permissões do diretório de trabalho para o usuário 'node'
RUN chown -R node:node /app

COPY . .

USER node

EXPOSE 5173
