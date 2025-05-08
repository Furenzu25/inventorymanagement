#!/bin/bash
# Deployment script for Render.com

# Make sure we're in the right directory
echo "Starting deployment preparation..."

# Run Laravel optimizations locally before deploying
echo "Running Laravel optimizations..."
php artisan optimize
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# Set APP_DEBUG to false for production
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env

# Check if git is initialized
if [ ! -d ".git" ]; then
    echo "Git repository not initialized. Initializing..."
    git init
    git add .
    git commit -m "Initial commit for deployment"
fi

# Prompt for GitHub repository URL if not already set
if ! git remote -v | grep -q origin; then
    echo "No remote repository set."
    read -p "Enter your GitHub repository URL: " repo_url
    git remote add origin $repo_url
    echo "Remote repository added."
fi

# Push code to GitHub
echo "Pushing code to GitHub..."
git add .
git commit -m "Prepare for deployment to Render.com"
git push -u origin main || git push -u origin master

# Deploy to Render
echo "Deploying to Render..."
echo "1. Visit https://dashboard.render.com/new/web-service"
echo "2. Connect your GitHub repository"
echo "3. Use Docker environment"
echo "4. Select the Free plan"
echo "5. Click 'Create Web Service'"

echo "Deployment preparation completed!"
echo "Your app will be available at https://your-service-name.onrender.com once you complete the steps above."