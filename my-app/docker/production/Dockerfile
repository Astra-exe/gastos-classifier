# Build Stage
FROM node:18-alpine AS base

# Install dependencies only when needed
FROM base AS deps
RUN apk add --no-cache libc6-compat
WORKDIR /app

# Install dependencies based on the preferred package manager
COPY package.json yarn.lock* package-lock.json* pnpm-lock.yaml* ./
RUN \
  if [ -f yarn.lock ]; then yarn --frozen-lockfile; \
  elif [ -f package-lock.json ]; then npm ci; \
  elif [ -f pnpm-lock.yaml ]; then yarn global add pnpm && pnpm i --frozen-lockfile; \
  else echo "Lockfile not found." && exit 1; \
  fi

# Build Stage
FROM base AS build
WORKDIR /app
COPY --from=deps /app/node_modules ./node_modules
COPY . .

# Build the Next.js application
RUN npm run build

# Production Stage
FROM node:18-alpine AS production
RUN apk add --no-cache libc6-compat
WORKDIR /app

# Copy only the necessary files from the build stage
COPY --from=build /app/package.json /app/yarn.lock* /app/package-lock.json* /app/pnpm-lock.yaml* ./
COPY --from=build /app/.next/ ./.next/
COPY --from=build /app/public/ ./public/
COPY --from=build /app/node_modules ./node_modules/

# Expose the default port (Next.js runs on port 3000 by default)
EXPOSE 3000

# Run the Next.js app in production mode
CMD ["npm", "run", "start"]