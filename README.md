#The Events Organizer

## Author
Afnan Abdelhameed


### Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
    

### Prerequisites
* node v8.11.2
* Composer 1.5.6
* Apache for the PHP
* MySql
 

### Installing
* Clone the code from git@gitlab.brightcreations.com
```
git clone 
```


* While in the project root directory, run composer install to bring all the project libraries and dependencies (you must be connected to the internet for this)

```
composer install
```

* Create a database and user in .env with the details below:

DB_NAME="events-organizer"

DB_USER="root"

DB_PASSWORD=""

DB_HOST=localhost


* While in the project root directory, install all JS work using node
```
npm install
npm i node-sass
npm install cross-env --save-dev
npm run rebuild
npm run production
```


## Built With
* [Wordpress](https://wordpress.com) - The CMS used
* [bedrock](https://roots.io/bedrock/) - Better WordPress project structure


## Login user
Depending what you're URL is locally, you should be able to login as follows:

**URL:**  http://environmenturl/wp/wp-admin   
**User:**  admin   
**Password:** admin1234


## Event Plugin
for all details about the events plugin please check the plugin readme file