const PROXY_CONFIG = {
    "/api": {
      "target": "http://localhost:8080",
      "changeOrigin": true,
      "secure": false,
      "cookieDomainRewrite": "localhost",
      "logLevel": "debug",
    }
  }
  
  module.exports = PROXY_CONFIG;