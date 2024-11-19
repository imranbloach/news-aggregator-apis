News Aggregator API
This is a Laravel-based News Aggregator API that fetches articles from multiple news sources, allows user authentication, and provides a personalized news feed based on user preferences. The application is Dockerized to simplify setup and deployment.


////////////Features//////////////////


User authentication using Laravel Sanctum.
1- Password reset functionality.
2- Personalized news feed based on user preferences.
3- Fetches news articles from NewsAPI, The Guardian, and New York Times.
4- Dockerized environment for easy setup.
5- Use best practices to meet the requirements 
6- Test cases

//////////////////Prerequisites/////////////////

Docker and Docker Compose must be installed on your system.

//////////////////Getting Started////////////////

1. Clone the Repository
git clone https://github.com/yourusername/news-aggregator-api.git
cd news-aggregator-api
2. Set Up Environment Variables
Create a .env file in the root directory of the project or copy from the provided:

cp .env.example .env
Then, update the .env file with the following essential variables:

///////////////.env file complete/////////////////
APP_NAME="News Aggregator"
APP_ENV=local
APP_KEY=base64:K5cMjLK9dONLk+w+xHr9vef+uT6EGebOIbFc7lKCb6U=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_aggregator_apis
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=redis
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=1616fb5d499627
MAIL_PASSWORD=731fd583d41dc4
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="dev.imran.pk@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

L5_SWAGGER_CONST_HOST=http://localhost:8000

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379


NEWS_API_KEY=35fc9f966315458db65a8e28afe05173
GUARDIAN_API_KEY=811b4738-f664-44d5-bb2b-97e040eb2bdd
NYT_API_KEY=JgQNFEMnrAqGaTKCDdv01m9qnNgxFAQh
NYT_API_SECRET=V76uWO1cEi5lig0I


////////////////////////////////////////////


/////////////////Build and Start the Docker Containers////////////
Run the following command to build and start the application using Docker:
--------------------------------
3. docker-compose up --build -d
--------------------------------
This command will:
Build the Docker images for the Laravel application and MySQL database.
Start the containers in detached mode.
4. Run Migrations
Run the migrations to set up the database schema:

docker-compose exec app php artisan migrate
5. Access the Application
The application will be accessible at http://localhost:8000.
The API documentation (Swagger) can be accessed at http://localhost:8000/api/documentation

6. Running Tests
Run the tests to verify the functionality:
----------------------------------------
docker-compose exec app php artisan test
-----------------------------------------

/////////////////////API Endpoints////////////////////
----------Authentication------------
Register: POST /api/register
Login: POST /api/login
Logout: POST /api/logout
Forgot Password: POST /api/forgot-password
Reset Password: POST /api/reset-password

/////////////////Preferences//////////////////////////
Set User Preferences: POST /api/save-preferences
Get User Preferences: GET /api/get-preferences
Get Personalized News: GET /api/preferences/news

////////////////////Rate Limiting/////////////////////

Rate limiting has been configured for API requests.

/////////////////Shutdown/////////////////////
To stop the application, run:
---------------------------
docker-compose down
---------------------------
//////////////////Troubleshooting//////////////////////////
If you encounter any issues, try rebuilding the containers:
----------------------------------
docker-compose up --build -d
----------------------------------

I hope these instructions are enough to run the assignment code

/////////////////////////////////////////////////////////////////
///           HOPE FOR POSITIVE RESPONSE                      ///
/////////////////////////////////////////////////////////////////