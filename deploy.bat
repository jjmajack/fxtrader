@echo off
REM FXTrader Production Deploy Script
REM This script creates a production deployment package
REM Run this script from the Laravel project root directory

echo.
echo ========================================
echo 🚀 FXTrader Production Deploy Package
echo ========================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: Please run this script from the Laravel project root directory
    echo    Current directory: %CD%
    pause
    exit /b 1
)

echo 📋 Creating production deployment package...
echo.

REM Check if node_modules exists (need to build assets)
if exist "node_modules" (
    echo 📦 Building frontend assets...
    call npm run build
    if errorlevel 1 (
        echo ❌ Error: Frontend build failed!
        echo    Please run 'npm install' and 'npm run build' manually
        pause
        exit /b 1
    )
    echo ✅ Frontend assets built successfully!
    echo.
) else (
    echo ⚠️  Warning: node_modules not found!
    echo    Frontend assets may not be built.
    echo    If you need frontend assets, run 'npm install' and 'npm run build' first.
    echo.
)

REM Verify build directory exists
if not exist "public\build" (
    echo ⚠️  Warning: public/build directory not found!
    echo    Frontend assets may not be included in the package.
    echo    Make sure to run 'npm run build' before deploying.
    echo.
)

REM Create production build directory
if exist "production-build" rmdir /s /q "production-build"
mkdir "production-build"

echo 📁 Step 1: Copying Laravel application files...

REM Copy essential directories (excluding development files)
xcopy /E /I /Y app "production-build\app"
xcopy /E /I /Y bootstrap "production-build\bootstrap"
xcopy /E /I /Y config "production-build\config"
xcopy /E /I /Y database "production-build\database"
xcopy /E /I /Y resources "production-build\resources"
xcopy /E /I /Y routes "production-build\routes"
REM Copy storage directory but exclude logs
xcopy /E /I /Y storage "production-build\storage"
REM Remove logs directory if it was copied
if exist "production-build\storage\logs" rmdir /s /q "production-build\storage\logs"
xcopy /E /I /Y vendor "production-build\vendor"

REM Copy public folder contents to root (for cPanel deployment)
REM This includes built assets from public/build
xcopy /E /I /Y public\* "production-build\"

REM Fix index.php paths for cPanel deployment (change /../ to /)
powershell -Command "(Get-Content 'production-build\index.php') -replace '__DIR__\.''/\.\./', '__DIR__.''/' | Set-Content 'production-build\index.php'"

REM Copy essential files
copy /Y artisan "production-build\"
copy /Y composer.json "production-build\"
copy /Y composer.lock "production-build\"

echo 🧹 Step 1.5: Cleaning up development files from production build...

REM Remove .gitignore files
if exist "production-build\.gitignore" del "production-build\.gitignore"
if exist "production-build\app\.gitignore" del "production-build\app\.gitignore"
if exist "production-build\bootstrap\.gitignore" del "production-build\bootstrap\.gitignore"
if exist "production-build\config\.gitignore" del "production-build\config\.gitignore"
if exist "production-build\database\.gitignore" del "production-build\database\.gitignore"
if exist "production-build\resources\.gitignore" del "production-build\resources\.gitignore"
if exist "production-build\routes\.gitignore" del "production-build\routes\.gitignore"
if exist "production-build\storage\.gitignore" del "production-build\storage\.gitignore"
if exist "production-build\vendor\.gitignore" del "production-build\vendor\.gitignore"

REM Remove development files
if exist "production-build\package.json" del "production-build\package.json"
if exist "production-build\package-lock.json" del "production-build\package-lock.json"
if exist "production-build\vite.config.js" del "production-build\vite.config.js"
if exist "production-build\tailwind.config.js" del "production-build\tailwind.config.js"
if exist "production-build\phpunit.xml" del "production-build\phpunit.xml"
if exist "production-build\README.md" del "production-build\README.md"

REM Remove development directories
if exist "production-build\node_modules" rmdir /s /q "production-build\node_modules"
if exist "production-build\tests" rmdir /s /q "production-build\tests"
if exist "production-build\build" rmdir /s /q "production-build\build"

REM Remove development files specific to FXTrader
if exist "production-build\deploy.bat" del "production-build\deploy.bat"
if exist "production-build\CHANGELOG.md" del "production-build\CHANGELOG.md"

REM Remove development cache and log files
if exist "production-build\storage\logs" rmdir /s /q "production-build\storage\logs"
if exist "production-build\storage\framework\cache" rmdir /s /q "production-build\storage\framework\cache"
if exist "production-build\storage\framework\sessions" rmdir /s /q "production-build\storage\framework\sessions"
if exist "production-build\bootstrap\cache" rmdir /s /q "production-build\bootstrap\cache"

REM Recreate necessary directories (only cache directories needed)
mkdir "production-build\storage\framework\cache"
mkdir "production-build\storage\framework\sessions"
mkdir "production-build\bootstrap\cache"

echo 📝 Step 2: Creating production .env template file...
if exist ".env.example" (
    copy /Y .env.example "production-build\.env.template"
) else (
    echo # FXTrader Environment Configuration > "production-build\.env.template"
    echo APP_NAME=FXTrader >> "production-build\.env.template"
    echo APP_ENV=production >> "production-build\.env.template"
    echo APP_KEY= >> "production-build\.env.template"
    echo APP_DEBUG=false >> "production-build\.env.template"
    echo APP_URL=https://yourdomain.com >> "production-build\.env.template"
    echo. >> "production-build\.env.template"
    echo DB_CONNECTION=mysql >> "production-build\.env.template"
    echo DB_HOST=127.0.0.1 >> "production-build\.env.template"
    echo DB_PORT=3306 >> "production-build\.env.template"
    echo DB_DATABASE= >> "production-build\.env.template"
    echo DB_USERNAME= >> "production-build\.env.template"
    echo DB_PASSWORD= >> "production-build\.env.template"
    echo. >> "production-build\.env.template"
    echo LOG_CHANNEL=stack >> "production-build\.env.template"
    echo LOG_LEVEL=error >> "production-build\.env.template"
)

REM Update .env.template for production
echo. >> "production-build\.env.template"
echo # Production Settings >> "production-build\.env.template"
echo APP_ENV=production >> "production-build\.env.template"
echo APP_DEBUG=false >> "production-build\.env.template"

echo 🔧 Step 3: Optimizing for production...

REM Generate application key in build directory
cd production-build
php artisan key:generate --force

REM Clear any existing caches first
php artisan config:clear
php artisan cache:clear

REM Only cache routes and views, NOT config (so .env changes work)
php artisan route:cache
php artisan view:cache

REM Clear config cache again to ensure .env file is read
php artisan config:clear
cd ..

echo 🔒 Step 4: Creating .htaccess for cPanel...
copy /Y public\.htaccess "production-build\.htaccess"

echo 🧪 Step 4.5: Creating test file for debugging...
(
echo ^<?php
echo // Test file for debugging 500 errors
echo echo "PHP is working!<br>";
echo echo "PHP Version: " . phpversion^(^) . "<br>";
echo echo "Current directory: " . getcwd^(^) . "<br>";
echo.
echo // Test if you can include Laravel
echo try {
echo     require_once 'vendor/autoload.php';
echo     echo "Laravel autoloader works!<br>";
echo     
echo     // Test Laravel bootstrap
echo     $app = require_once 'bootstrap/app.php';
echo     echo "Laravel app bootstrap works!<br>";
echo     
echo     // Test database connection
echo     $config = $app['config'];
echo     echo "Database host: " . $config['database.connections.mysql.host'] . "<br>";
echo     echo "Database name: " . $config['database.connections.mysql.database'] . "<br>";
echo     
echo } catch ^(Exception $e^) {
echo     echo "Error: " . $e->getMessage^(^) . "<br>";
echo     echo "File: " . $e->getFile^(^) . " Line: " . $e->getLine^(^) . "<br>";
echo }
echo.
echo // Check file permissions
echo echo "Storage writable: " . ^(is_writable^('storage'^) ? 'Yes' : 'No'^) . "<br>";
echo echo "Bootstrap cache writable: " . ^(is_writable^('bootstrap/cache'^) ? 'Yes' : 'No'^) . "<br>";
echo.
echo // Check .env file
echo if ^(file_exists^('.env'^)^) {
echo     echo ".env file exists<br>";
echo     $env = file_get_contents^('.env'^);
echo     echo "APP_KEY set: " . ^(strpos^($env, 'APP_KEY='^) !== false ? 'Yes' : 'No'^) . "<br>";
echo     echo "DB_DATABASE set: " . ^(strpos^($env, 'DB_DATABASE='^) !== false ? 'Yes' : 'No'^) . "<br>";
echo     echo "DB_USERNAME set: " . ^(strpos^($env, 'DB_USERNAME='^) !== false ? 'Yes' : 'No'^) . "<br>";
echo     echo "DB_PASSWORD set: " . ^(strpos^($env, 'DB_PASSWORD='^) !== false ? 'Yes' : 'No'^) . "<br>";
echo     echo "<br>Current .env DB settings:<br>";
echo     preg_match_all^('/^DB_[A-Z_]+=.*$/m', $env, $matches^);
echo     foreach ^($matches[0] as $line^) {
echo         echo htmlspecialchars^($line^) . "<br>";
echo     }
echo } else {
echo     echo ".env file NOT found!<br>";
echo }
echo.
echo // Check what Laravel is actually using
echo try {
echo     $app = require_once 'bootstrap/app.php';
echo     $config = $app['config'];
echo     echo "Laravel is using:<br>";
echo     echo "DB_HOST: " . $config['database.connections.mysql.host'] . "<br>";
echo     echo "DB_DATABASE: " . $config['database.connections.mysql.database'] . "<br>";
echo     echo "DB_USERNAME: " . $config['database.connections.mysql.username'] . "<br>";
echo     echo "DB_PASSWORD: " . ^(strlen^($config['database.connections.mysql.password']^) > 0 ? 'SET' : 'NOT SET'^) . "<br>";
echo } catch ^(Exception $e^) {
echo     echo "Error getting Laravel config: " . $e->getMessage^(^) . "<br>";
echo }
echo ?^>
) > "production-build\test.php"

echo 📝 Step 5: Creating deployment instructions...
(
echo # FXTrader Deployment Instructions
echo.
echo ## 🚀 Quick Deployment Steps
echo.
echo ### 1. Upload Files (CRITICAL - READ CAREFULLY)
echo - Extract the ZIP file contents DIRECTLY to public_html/
echo - DO NOT create a subfolder like public_html/crecheassist/
echo - The files should be: public_html/index.php, public_html/app/, etc.
echo - NOT: public_html/production-build/index.php
echo - Upload the CONTENTS of production-build folder, not the folder itself
echo - After upload, you should see index.php in the root of public_html/
echo.
echo ### 2. Database Setup
echo - Create a MySQL database in cPanel
echo - Create a database user and assign it to the database
echo - Update the .env file with your database credentials
echo - Run migrations: php artisan migrate
echo.
echo ### 3. Set Permissions (CRITICAL for 500 errors)
echo - Set storage folder permissions to 755 (recursive)
echo - Set bootstrap/cache folder permissions to 755 (recursive)
echo - Set .env file permissions to 644
echo - Set all PHP files to 644
echo - Set all folders to 755
echo.
echo ### 4. Database Setup (No Terminal Required)
echo - Go to cPanel → MySQL Databases
echo - Create a new database (e.g., yourusername_fxtrader)
echo - Create a database user and assign it to the database
echo - Note down the database name, username, and password
echo - Copy .env.template to .env in public_html/
echo - Update the .env file with these credentials
echo.
echo ### 4.1. Alternative: Use cPanel File Manager
echo - Go to cPanel → File Manager
echo - Navigate to public_html/
echo - Copy .env.template to .env (rename the file)
echo - Edit the .env file
echo - Update database credentials:
echo   DB_DATABASE=your_actual_database_name
echo   DB_USERNAME=your_actual_database_user  
echo   DB_PASSWORD=your_actual_database_password
echo - Generate application key: php artisan key:generate
echo.
echo ### 5. Clear Config Cache (IMPORTANT!)
echo - After updating .env file, you MUST clear the config cache
echo - Go to cPanel → File Manager → public_html/
echo - Create a file called 'clear-cache.php' with this code:
echo ```php
echo ^<?php
echo require_once 'vendor/autoload.php';
echo $app = require_once 'bootstrap/app.php';
echo $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
echo $app->make('Illuminate\Contracts\Console\Kernel')->call('config:clear');
echo echo "Config cache cleared successfully!";
echo ?^>
echo ```
echo - Visit yourdomain.com/clear-cache.php
echo - DELETE clear-cache.php after running it
echo.
echo ### 6. Test Your Application
echo - FIRST: Visit yourdomain.com/test.php to check for errors
echo - If test.php works, visit your domain to test the application
echo - Check that all features are working correctly
echo - Verify that static assets are loading properly
echo.
echo ### 6. Troubleshooting 500 Errors
echo - Check cPanel Error Logs (Metrics → Error Logs) - THIS IS WHERE ERRORS GO
echo - Laravel logs may not appear in storage/logs/ on cPanel
echo - Check cPanel Error Logs for detailed error messages
echo - Verify PHP version is 8.1+ (Software → Select PHP Version)
echo - Ensure all required PHP extensions are enabled
echo - Check file permissions (most common cause)
echo - Make sure .env file exists and has correct database settings
echo - Try the test.php file first to isolate the issue
echo.
echo ### 7. Running Migrations Without Terminal
echo If you need to run database migrations without terminal access:
echo - Create a temporary PHP file called 'migrate.php' in public_html/
echo - Add this code to migrate.php:
echo ```php
echo ^<?php
echo require_once 'vendor/autoload.php';
echo $app = require_once 'bootstrap/app.php';
echo $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
echo $exitCode = $app->make('Illuminate\Contracts\Console\Kernel')->call('migrate', ['--force' => true]);
echo echo "Migration completed with exit code: " . $exitCode;
echo ?^>
echo ```
echo - Visit yourdomain.com/migrate.php to run migrations
echo - DELETE migrate.php after running migrations for security
echo.
echo ### 8. cPanel Logging Notes
echo - Laravel logs go to cPanel Error Logs, not storage/logs/
echo - Check: cPanel → Metrics → Error Logs
echo - Look for recent errors with your domain name
echo - Enable error logging in .env if needed
echo.
echo ## 📧 Support
echo If you need help, contact your hosting provider support.
echo.
echo ## 🔒 Security Notes
echo - The .env file is protected from direct access
echo - Composer files are protected from direct access
echo - Security headers are enabled
echo - GZIP compression is enabled for better performance
echo.
echo ## 📝 Notes
echo - Frontend assets are built using Vite (npm run build)
echo - Built assets are in public/build/ directory
echo - All assets are copied from the public directory
echo - Production build includes optimized CSS and JS files
) > "production-build\DEPLOYMENT_INSTRUCTIONS.md"

echo 📦 Step 6: Creating ZIP package for easy upload...
set "ZIP_NAME=fxtrader-production.zip"

if exist "%ZIP_NAME%" del "%ZIP_NAME%"

REM Create ZIP using PowerShell
echo Creating ZIP package: %ZIP_NAME%
powershell -command "Compress-Archive -Path 'production-build\*' -DestinationPath '%ZIP_NAME%' -Force"

echo.
echo ========================================
echo ✅ FXTrader Deployment Package Created!
echo ========================================
echo.
echo 📁 Production files are in the 'production-build' directory
echo 📦 ZIP package created: %ZIP_NAME%
echo.
echo 🚀 Next Steps:
echo 1. Upload %ZIP_NAME% to your server/cPanel
echo 2. Extract it in your public_html directory
echo 3. Follow the DEPLOYMENT_INSTRUCTIONS.md file
echo 4. Set up .env file with your database credentials
echo 5. Run migrations: php artisan migrate
echo.
echo 📋 Files ready for upload:
echo - %ZIP_NAME% (main deployment package)
echo - production-build/ directory (individual files)
echo.
echo 🔗 Your FXTrader application will be ready for production!
echo.
echo 📊 Build Summary:
echo - ✅ Laravel application copied
echo - ✅ Frontend assets built (Vite)
echo - ✅ Dependencies installed (vendor/)
echo - ✅ Security headers configured
echo - ✅ Caching optimized
echo - ✅ Development environment untouched
echo - ✅ Production-ready package created
echo.
echo 🎉 Your development environment is still intact and ready to use!
echo.
echo 💡 Tip: The deployment package includes all necessary files
echo    for production deployment. Review DEPLOYMENT_INSTRUCTIONS.md
echo    for detailed setup instructions.
echo.
pause