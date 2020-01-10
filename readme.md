
## Demo of statistics dashboard with Laravel and ChartJS

[![ScreenShot](https://raw.github.com/chrisplusk/laravel-stats-demo/screenshots/Untitled4.png)](https://youtu.be/2Jc_v1tOXIE)


### SETUP

git clone  
composer update  
composer install  

if composer post-install hook didn't do this for you:  
  * copy env.example to .env  
  * php artisan key:generate  

update .env file:  
  * DB_DATABASE=laravel_stats_demo
  * DB_USERNAME=laravel-stats-demo
  * DB_PASSWORD=VpQJ6zFxbq"y2FeP
  * (set up mailer)

mysql:  
  * CREATE DATABASE laravel_stats_demo;  
  * USE laravel_stats_demo;  
  * GRANT ALL PRIVILEGES ON laravel_stats_demo.* TO 'laravel-stats-demo'@'localhost' IDENTIFIED BY 'VpQJ6zFxbq"y2FeP';

php artisan migrate  
php artisan db:seed  


browse to the project  

register user (set admin to 2 in database for superadmin) and/or login (default users: admin/admin, guest/guest)  

click ‘seed’ the first time to seed the statistics database or when you want new additional data to be generated  


Play around with the filter settings (click ‘filter’ button to expand, then ‘Apply’) or ‘users’ view (toolbar)  
