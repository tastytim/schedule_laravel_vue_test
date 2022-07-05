## TEST TASK
My Appointments

## Tecnologie

Frameworks : Laravel , Vue

## Installato

npm install
composer dball
composer install
artisan require vue-ui
vue-loader
npm i jspdf --save  (PER FILE PDF) https://rawgit.com/MrRio/jsPDF/master/docs/index.html
jspdf-autotable (create tables pdf) https://github.com/simonbengtsson/jsPDF-AutoTable
npm install dayjs (DateTime) https://day.js.org/docs/en/installation/node-js




## Email
<!-- CREATE MAIL CLASS -->
php artisan make:mail NameEmail (IF YOU WANT PASS DATA PASS IT TO CONSTRUCTOR AND DEFINE PUBLIC VARIABLE)
<!-- CREATE CONTROLLER -->
php artisan make:controller NameMailController
<!-- CREATE QUEUE TABLE IN DATABASE FOR STORING WORKS (REMEMBER MIGRATE) -->
php artisan queue:table
<!-- CREATE JOB -->
php artisan make:job NameJob  

##
## 
## 
## 

Finally, don't forget to instruct your application to use the database driver by updating the QUEUE_CONNECTION variable in your application's .env file:

QUEUE_CONNECTION=database


https://laravel.com/docs/9.x/queues#connections-vs-queues
