# Deployment Guide for Your Laravel Project

This guide provides step-by-step instructions to deploy your Laravel application to Render.com for free.

## Prerequisites

1. A GitHub account (to host your code repository)
2. A Render.com account (for deployment)

## Step 1: Push Your Code to GitHub

If you haven't already done so, push your project to GitHub:

```bash
# Initialize git repository (if not already done)
git init

# Add all files to git
git add .

# Commit changes
git commit -m "Prepare for deployment"

# Add GitHub repository as remote (replace with your repository URL)
git remote add origin https://github.com/yourusername/yourrepository.git

# Push to GitHub
git push -u origin main
```

## Step 2: Deploy to Render.com

1. Sign up for a free account at [Render.com](https://render.com)
2. From the Render dashboard, click **New** and select **Web Service**
3. Connect your GitHub repository
4. Configure your service:
   - **Name**: rosels-trading (or your preferred name)
   - **Environment**: Docker
   - **Branch**: main (or your default branch)
   - **Plan**: Free

5. Click **Create Web Service**

Render will automatically:
- Build your Docker container
- Set up environment variables from your render.yaml file
- Run database migrations and seed your database
- Deploy your application

Your application will be available at `https://your-service-name.onrender.com` once deployment is complete (usually 5-10 minutes).

## Deployment Configuration

Your project is already configured with:

- SQLite database (perfect for small projects)
- Production environment settings
- Laravel optimization commands
- All required environment variables

## Updating Your Deployed Application

To update your deployed application:

1. Make changes to your code locally
2. Commit and push to GitHub:
```bash
git add .
git commit -m "Your update message"
git push
```
3. Render will automatically detect changes and redeploy

## Troubleshooting

If you encounter issues during deployment:

1. Check the Render logs in your dashboard
2. Ensure your .env settings match the render.yaml configuration
3. Verify all Laravel requirements are met in the Dockerfile

## Notes

- The free tier of Render has limitations (e.g., instances spin down after inactivity)
- Your SQLite database will be part of your deployment (no separate database service needed)
- Your project uses many Laravel optimization techniques to improve performance 

## Deployment Steps

1. Run the deployment script:
   ```
   bash deploy.sh
   ```
   This will:
   - Run all Laravel optimizations
   - Set up Git if needed
   - Push your code to GitHub
   - Guide you through the Render.com setup

2. Follow the on-screen instructions to complete the deployment on Render.com

Your Laravel application will be deployed with:
- SQLite database (free, included in your application)
- Optimized production settings
- All required environment variables

The application will be available at https://your-service-name.onrender.com after deployment completes (usually 5-10 minutes).

The DEPLOYMENT.md file I created contains additional details and troubleshooting information if you need it. 