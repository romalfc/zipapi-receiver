Sender API Installation:
1) git clone https://github.com/romalfc/zipapi-sender
2) In root folder make .env file from .env.example and set DB_VALUES:
	DB_CONNECTION=mysql
	DB_DATABASE=zipapi
	DB_USERNAME=username
	DB_PASSWORD=password
3) Download all required packages: composer update
4) Run migration: php artisan migrate
Now you can go to the index page of application, but for full working you need to install Receiver API,
that's is awfully similar. 

Receiver API Installation:
1) git clone https://github.com/romalfc/zipapi-receiver
2) In root folder make .env file from .env.example and set DB_VALUES:
	DB_CONNECTION=mysql
	DB_DATABASE=zipapi
	DB_USERNAME=username
	DB_PASSWORD=password
3) Download all required packages: composer update
4) Run migration: php artisan migrate

Also you need to insert in users table one row with username and password.
That's all now you can run and test ZIPAPI application.