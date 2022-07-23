##Requirements
##PHP and Webserver
1. PHP Version: 8.1
2. Webserver: As long php is configured correctly, it makes no difference what webserver is used.
##DB
This application is set to use sqlite. The database file is <span style="color: green">database</span> folder as: database.sqlite. Using other db systems requires php extensions and reconfiguring <span style="color: green">.env</span> file.
##Composer
Composer installation process can be found in [documentation](https://getcomposer.org/download/)
##GIT
To clone this project from github; installing git application is a must.
##Notes
This project can easily be dockerized via [Laravel Sail](https://laravel.com/docs/9.x/sail) Package. If it's necessary, please don't hesitate to contact me.
***
##Initial setup
##Installing required packages
After cloning; `composer update` command must be run to install required packages.
##Adding users
Please run `php artisan db:seed` to add 10 users. User emails can be checked with DB browse application of your choice. The password for every seeded user is: 1234
##Adding other data
For every model there is a seeder file in <span style="color: green">database/seeders</span> folder. To fill database with fake data please run `php artisan db:seed  --class=SEEDER_CLASS_NAME`
***
##Tests
####Running Tests
Please run `php artisan test` to check test results.
***
##Project Components
####app
Entire app logic organized in these sub folders:
1. HTTP/Controller: Web controllers are in root of this folder. API controller are in <span style="color: green">api\v1</span> sub folder.
2. libs: Custom classes and Media interface can be found in this folder 
3. Models: This folder contains classes that are application's dynamic data structure, independent of the user interface.
####database/migrations
Database structure migrations can be found here.  
####public folder
1. All the libraries that are used for design can be found in this folder.
2. Uploaded medias are saved in <span style="color: green">storage/app/public</span> folder. In order to make files available for visitors; running `php artisan storage:link` command is a must.
####Lang
This folder is customizing static texts of views and some dynamic texts like validation errors. Although this app is in english language; <span style="color: green">en.json</span> was added to avoid repetition and making changes easier.
####Views
Views are separated in below folders
1. Components: This folder contains views to avoid repetition. The `layouts` sub-folder contains a file for importing libraries (like bootstrap), main menu and contents section. Other components are form elements (like input) and messaging sections (like bootstrap alerts).
2. Other Views: <span style="color: green">index</span> view in root contains a form for user login. Other view in admin folder, are for using application after login.
***
##Future Improvements
1. Configuring Laravel [Sanctum](https://laravel.com/docs/9.x/sanctum) to make accessing api secure via tokens.
2. Refactoring tests to make a use of coverage test introduced in Laravel 9.
3. Unfortunately since Amazon aws service is not available in Iran, Docker implementation of [minio](https://hub.docker.com/r/minio/minio/) can be an improvement for media saving.
