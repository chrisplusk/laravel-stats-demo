
## Demo of statistics dashboard with Laravel and ChartJS

[![ScreenShot](https://raw.github.com/chrisplusk/laravel-stats-demo/screenshots/Untitled4.png)](https://youtu.be/2Jc_v1tOXIE)


SETUP

git clone 
composer install
--if needed for fresh install: php artisan key:generate
--set up mailer in .env file

mysql
  CREATE DATABASE laravel_stats_demo;
  USE laravel_stats_demo;
  GRANT ALL PRIVILEGES ON laravel_stats_demo.* TO 'laravel-stats-demo'@'localhost' IDENTIFIED BY 'VpQJ6zFxbq"y2FeP';

--update .env file:
  DB_DATABASE=laravel_stats_demo
  DB_USERNAME=laravel-stats-demo
  DB_PASSWORD=VpQJ6zFxbq"y2FeP

php artisan migrate
php artisan db:seed

browse to the project

register user (set admin to 2 in database for superadmin)
or login (default users: admin/admin, guest/guest)
click ‘seed’ the first time to seed the statistics database or when you want new additional data to be generated

Play around with the filter settings or ‘users’ view (toolbar)
