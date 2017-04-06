## Sender API Installation:
1) git clone https://github.com/romalfc/zipapi-sender
2) In root folder make .env file from .env.example and set DB values:
	DB_CONNECTION=mysql
	DB_DATABASE=zipapi
	DB_USERNAME=username
	DB_PASSWORD=password
3) Download all required packages: 
```
composer update
```
4) Run migration: 
```
php artisan migrate:install
```
```
php artisan migrate
```
Now you can go to the index page of application, but for full working you need to install Receiver API,
that's is awfully similar. 

## Receiver API Installation:
1) git clone https://github.com/romalfc/zipapi-receiver
2) In root folder make .env file from .env.example and set DB values:
	DB_CONNECTION=mysql
	DB_DATABASE=zipapi
	DB_USERNAME=username
	DB_PASSWORD=password
3) Download all required packages: 
```
composer update
```

Also you need to create one user (with password >= 8 symb.) in users table.
That's all now you can run and test ZIPAPI application.
