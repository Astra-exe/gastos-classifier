FROM node:18-alpine AS base

# Install dependencies only when needed
FROM base AS deps
# Check https://github.com/nodejs/docker-node/tree/b4117f9333da4138b03a546ec926ef50a31506c3#nodealpine to understand why libc6-compat might be needed.
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

FROM base AS dev

WORKDIR /app
COPY --from=deps /app/node_modules ./node_modules
COPY . .

# This will do the trick, use the corresponding env file for each environment.
#COPY .env.development.sample .env.production
#RUN npm run build


# # Rebuild the source code only when needed
FROM base AS builder
WORKDIR /app
# Copy node_modules from deps stage
COPY --from=deps /app/node_modules ./node_modules
# Copy source code
COPY . .

# Optionally disable telemetry if needed
ENV NEXT_TELEMETRY_DISABLED 1
# Build the Next.js app
RUN npm run build

# Production image, copy all the files and run next
FROM base AS runner
WORKDIR /app

# Create a non-root user to run the app for security
RUN addgroup --system --gid 1001 nodejs
RUN adduser --system --uid 1001 nextjs


# Copy necessary files from the builder stage
COPY --from=builder /app/public ./public
COPY --from=builder --chown=nextjs:nodejs /app/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /app/.next/static ./.next/static


# Switch to non-root user for security
USER nextjs

# Expose the default port (Next.js runs on port 3000 by default)
EXPOSE 3000

# Run the Next.js app in production
CMD ["node", "server.js"]