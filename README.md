# Overview
A simple application to perform basic crud for a user and his transactions


# Endpoints
## REST API


| ENDPOINT  | HTTP METHOD | USEAGE | RETURNS
| ------------- | ------------- | ------------- | ------------- |  
| /api/v1/users/store  | post  | accept email, name, password
| /api/v1/users/index | Get | returns response with the all users details
| /api/v1/users/show/{id} | Get | returns response with the a user detail
| /api/v1/users/update/{id} | Put| updates the fields of users
| /api/v1/users/destroy/{id} | Delete| deletes all the fields of users
| /api/v1/transactions/store | post | accept user_id, amount,status to create a transaction response




# How To Use
git clone https://github.com/samcesa45/bill-payment-api.git to clone the project to your local machine
composer install to install all dependencies
php artisan serve to run the project locally and php artisan test to run test
