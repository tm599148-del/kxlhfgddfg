#!/bin/bash

echo "========================================"
echo "Railway Deployment Script"
echo "========================================"
echo ""

echo "Step 1: Checking Railway CLI..."
if ! command -v railway &> /dev/null; then
    echo "Railway CLI not found. Installing..."
    npm install -g @railway/cli
fi

railway --version

echo ""
echo "Step 2: Please login to Railway (browser will open)..."
railway login

echo ""
echo "Step 3: Initializing Railway project..."
railway init

echo ""
echo "Step 4: Deploying to Railway..."
railway up

echo ""
echo "========================================"
echo "Deployment Complete!"
echo "========================================"
echo ""
echo "To get your URL, run: railway domain"
echo ""

