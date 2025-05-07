#!/bin/bash
# Deployment script for Render.com

# Make sure we're in the right directory
echo "Starting deployment to Render..."

# Check if render-cli is installed
if ! command -v render &> /dev/null
then
    echo "render-cli not found, installing..."
    npm install -g @renderinc/cli
fi

# Authenticate with Render (will prompt for token)
echo "Authenticating with Render..."
render auth

# Deploy the service
echo "Deploying to Render... (Make sure you have created the service in Render dashboard first)"
render deploy --data='{
  "service": "rosels-trading",
  "clearCache": true
}'

echo "Deployment completed! Visit your service on Render dashboard to monitor progress."
echo "Your app should be available at https://rosels-trading.onrender.com once deployment is complete."