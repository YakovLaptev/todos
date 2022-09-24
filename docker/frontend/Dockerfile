FROM node:16.17

# Install dependencies
RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

# Add user for vue application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Change current user
USER node

CMD ["sh", "-c", "npm install && npm run serve"]
