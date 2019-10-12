# Basic CRM Application

Basic CRM Application developed with Laravel PHP Framework.

## Prerequisites

##### Assumed following things are already installed in your server.
##### Shell scripts are based on Linux (Centos-7) so they can be slightly different for other operating systems.
- Apache (alternatively you can use Nginx)
- PHP
- MySQL
- Nodejs (for installation of javascript packages if you are going to make developments)
- Composer (for installation of php packages)
- git (for repository version control)
- nano (for file editing)
- zip (for composer to extract downloads)

## Installation

- Clone github repo
```shell script
git clone https://github.com/simsek97/Basic-CRM-with-Laravel.git
````
 
- Optionally you can change the name of the folder. I will change it to be **crm** with the following command

````shell script
mv Basic-CRM-with-Laravel crm
````

- Go to the created folder which will be Basic-CRM-with-Laravel

```shell script
cd crm
````

- First we need to make some configurations. Directories within the storage and the bootstrap/cache directories should be writable by Apache (or Nginx if you use it).
So we need to run the following command to make these directories writable.
````shell script
sudo chmod -R o+rw storage
sudo chmod -R o+rw bootstrap/cache
````
 
- Install js packages by npm _(This step is not necessary to run the application as it is already built for production. But if you are planning to make developments you need to install node modules.)_
````shell script
npm install
````

- Install php packages by composer
````shell script
composer install
````

- Create .env file (As github repository does not include .env file, we need to create it by copying .env.example)
````shell script
cp .env.example .env
````

- Generate application key (This is important for security. If the application key is not set, sessions and other encrypted data will not be secure!)
````shell script
php artisan key:generate
````

- Open .env file and edit necessary config

````shell script
nano .env
````

- Below changes will be nice but you can make changes as you wish. 
Especially you need to set MySQL connection settings and emailing setting 
if you would like to send email through the application 
Add appropriate values for xxx
```text
APP_NAME='Simple CRM'
APP_ENV=prod
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=basic_crm
DB_USERNAME=root
DB_PASSWORD=xxx

MAIL_DRIVER=smtp
MAIL_HOST=xxx
MAIL_PORT=2525
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
```

- As Laravel has a very unique storage filesystem, we need to add symbolic links in order to make storage files viewable for public. Run the following command to make it happen.
````shell script
php artisan storage:link
````

    This command is basically creating a symbolic link from public/storage to storage/app/public so that you can add it manually by the following command alternatively but I would recommend using artisan command.
    
    ln -s root_folder/storage/app/public root_folder/public/storage

- Create MySQL database. You should do this manually based on your favourite client. I am using Sequel Pro and I created a database called basic_crm as I defined in the .env file
 ![Create Database 1](https://crm.smartclass.tech/img/db1.png)
 ![Create Database 2](https://crm.smartclass.tech/img/db2.png)

- Now it is time to migrate our database tables. Use Laravel migrate command.
````shell script
php artisan migrate
````

- After migration you should be able to see the tables in your database as below
![Create Database 3](https://crm.smartclass.tech/img/db3.png)

- Now let's add some mock data. Before creating mock data, as a best practise we need to run the following command to regenerate Composer's autoloader.
````shell script
composer dump-autoload
```` 

- As a best practise, you might want to run the following commands in production for performance.
````shell script
composer install --optimize-autoloader --no-dev
php artisan config:cache
````


There are already factory and seed files in the repository so that the only thing we need to do is to run the following command in order to generate mock data
````shell script
php artisan db:seed
````

- This command will create 10 companies and 10 employees for each company as well as 2 users.
If you want to add more company and employee data, you can run the following command as running the previous command again will generate error due to duplication of users. 
```shell script
php artisan db:seed --class=CompanySeeder
```

- As mentioned above, seed command creates 2 users as below.
    * CRM Administrator, **admin@site.com** (password is password)
    * CRM Manager, **manager@site.com** (password is password)

- Now you can go to your url and login to the system by using the credentials above.

## Additional Features

- CRM provides Restful API endpoints for companies and employees. Every user has an API token by default. 
Using API tokens, one can get to use APIs with several ways as below by using Guzzle HTTP library.

    * Query String
    ````shell script
    $response = $client->request('GET', '/api/companies?api_token='.$token);
    ```` 
  
    * Request Payload
    ````shell script
    $response = $client->request('POST', '/api/companies', [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'form_params' => [
            'api_token' => $token,
        ],
    ]);
    ```` 

    * Bearer Token
    ````shell script
    $response = $client->request('POST', '/api/companies', [
        'headers' => [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ],
    ]);
    ```` 

