/** @type {import('next').NextConfig} */
const nextConfig = {
    images: {
        remotePatterns: [
            {
                protocol: 'http',
                hostname: 'localhost',
                port: '8000',
                pathname: '/photos/**'
            },
            {
                protocol: 'http',
                hostname: 'api',
                port: '8000',
                pathname: '/photos/**'
            },
        ],
    },
    experimental: {
        serverActions: true,
    },
}

module.exports = nextConfig
