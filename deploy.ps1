Write-Host "========================================"
Write-Host "Railway Deployment - Research360 Bot"
Write-Host "========================================"
Write-Host ""

Write-Host "Checking Railway CLI..."
railway --version
if ($LASTEXITCODE -ne 0) {
    Write-Host "Installing Railway CLI..."
    npm install -g @railway/cli
}

Write-Host ""
Write-Host "Step 1: Login to Railway"
Write-Host "Browser will open - please login there"
Write-Host ""
railway login

if ($LASTEXITCODE -ne 0) {
    Write-Host "Login failed. Please try again."
    pause
    exit 1
}

Write-Host ""
Write-Host "Login successful!"
Write-Host ""

Write-Host "Step 2: Initializing Railway project..."
railway init

if ($LASTEXITCODE -ne 0) {
    Write-Host "Init failed."
    pause
    exit 1
}

Write-Host ""
Write-Host "Step 3: Deploying to Railway..."
railway up

if ($LASTEXITCODE -ne 0) {
    Write-Host "Deployment failed."
    pause
    exit 1
}

Write-Host ""
Write-Host "========================================"
Write-Host "Deployment Complete!"
Write-Host "========================================"
Write-Host ""

Write-Host "Getting your deployment URL..."
railway domain

Write-Host ""
Write-Host "Your app is now live!"
Write-Host ""
pause
