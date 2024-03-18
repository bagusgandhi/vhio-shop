# Vhio Shop + Payment with Midtrans Core API

## Getting Started

## Installation
To setup this project, follow these steps:
```bash
# php version v8.1.20
# nodejs version 20.10.0
# npm version 10.2.3

# clone the repository
$ git clone https://github.com/bagusgandhi/vhio-shop.git

# navigate to repository
$ cd ./vhio-shop

# install dependency
$ composer install

$ npm install

# build asset
$ npm run build

```

## Set environment
copy .env.example to .env file

```bash
...

DB_CONNECTION=mysql
DB_HOST= # your host
DB_PORT= # mysql port | 3306
DB_DATABASE= # your db name
DB_USERNAME= # your db user
DB_PASSWORD= # your db password

# midtrans
MIDTRANS_SERVERKEY= # your midtran server key
MIDTRANS_URL= # midtrans sandbox url | https://api.sandbox.midtrans.com/v2/charge

...
```
To get server key login to your midtrans accountt hen access this url

https://dashboard.sandbox.midtrans.com/settings/config_info

## Running the Migration and Seedr

Use the following command to run the migration and sededer:

```bash

$ php artisan migrate

$ php artisan db:seed --class=UsersTableSeeder

$ php artisan db:seed --class=ProductTableSeeder

```

## Running the App

Use the following command to run the website:

```bash

$ php artisan serve

```

you can fill the credential demo for login with this:

email: <b>vhioshop@mail.co</b><br/>
password: <b>password</b>