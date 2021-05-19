# php-apache-phpmyadmin-mariadb-setup

### This setup gives you the essential tools and services to develop a php application. In other terms it is a docker alternative to XAMPP
#### The setup gives you possibility to change your code on your localhost machine and all the changes will automaticvally be seen in the docker container
#### In the websites-conf is the configuration file to make apache serve your website in a proper way

1. make sure to remove .gitignore from empty folders first otherwise you will face problems with volumes.
2. run docker-compose up
3. Then go into the container using docker exec -it yiitraining-php-apache bash
4. enable rewrite using a2enmod rewrite
5. restart apache2 service using service apache2 reload.
6. uncomment the comented part in apacheconf/sites-available/bigCompaEmployees RewriteEngine on
7. enable your websites using a2ensite bigCompaEmployees.testingapp
8. restart apache using service apache2 reload
9. website is accessible now navigate to http://bigcompaemployees.testingapp:8085/ and phpmyadmin is accessible on http://localhost:8086/ username is root and password is example

### N.B: your local host will not know that bigcompaemployees.testingapp maps to 127.0.0.1 so you need to change the hosts file in your host on mac do :
1. cd /etc
2. sudo vim hosts
3. add at the end 127.0.0.1 bigcompaemployees.testingapp
