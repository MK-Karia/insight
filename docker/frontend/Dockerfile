FROM node:18-alpine

WORKDIR /frontend

# Copy package.json and package-lock.json (if available)
COPY package.json ./
COPY package-lock.json* ./

# # Install dependencies
# RUN npm install

# Copy the rest of the application code
COPY . .

# Create a script to handle the volume mount scenario
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'if [ ! -d "node_modules" ] || [ ! -f "node_modules/.bin/react-scripts" ]; then' >> /start.sh && \
    echo '  echo "Installing dependencies..."' >> /start.sh && \
    echo '  npm install' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo 'npm start' >> /start.sh && \
    chmod +x /start.sh

# Expose port 3000
EXPOSE 3000

# Start the React development server
CMD ["/start.sh"]
