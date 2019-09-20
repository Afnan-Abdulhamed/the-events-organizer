# Events Management System

## Author
Afnan Abdelhameed


### Getting Started
These instructions will get you a copy of the project up and running on your local machine.
    

### Prerequisites
* node v8.11.2
* Composer 1.5.6
* Apache for the PHP
* MySql
 

### Installing
* Clone the code
```
git clone https://github.com/Afnan-Abdulhamed/the-events-organizer.git
```


* While in the project root directory, run composer install to bring all the project libraries and dependencies
```
composer install
```

* copy .env.example to .env 

* Create a database and change the credentials in .env with the details below:
```
DB_NAME="events-organizer"    
DB_USER="root"    
DB_PASSWORD=""   
DB_HOST=localhost   
```

* While in the project root directory, install all JS work using node   
Note: this step needed for assets building (with laramix) during development phase, If you do not need to add any new assets skip this step 
```
npm install
npm i node-sass
npm install cross-env --save-dev
npm run rebuild
npm run production
```
* login to the dashboard and follow wordpress installation steps 
```
 http://environmenturl/web/wp/wp-admin
```

* from dashboard > apperance > themes please active the events-theme  

* from dashboard > plugins please active the events organizer plugin  

* update permalinks from dashboard > settings > permalink please active the events organizer plugin

## Built With
* [Wordpress](https://wordpress.com) - The CMS used
* [bedrock](https://roots.io/bedrock/) - Better WordPress project structure  
* [Laramix](https://github.com/kofan/laramix) - For assets


## Login user
Depending what you're URL is locally, you should be able to login as follows:

**URL:**  http://environmenturl/wp/wp-admin   


## Event Plugin
for all details about the events plugin please check the plugin readme file
