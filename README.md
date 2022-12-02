# phpwebtest

1) Download the project phpwebtest
2) Go to the project directory and run composer install to install the dependencies 
3)     composer install

3) Change the database credentials in the file:   
	change database url credentials name and password of  product_db database
	env file : DATABASE_URL - make changes here.

	      Run the command to create database:
		- php bin/console doctrine:database:create

	      Create schema:
		- php bin/console doctrine:schema:create

4)     Install chromedriver: 
5)      brew install chromedriver geckodriver

5)    	Start symfony server 
6)    	-symfony serve or php bin/console server:run

6)	  -To fetch the scrape data from webpage. 
 		- https://127.0.0.1:8000/product

        -To view the scrape data output from database table 
		- https://127.0.0.1:8000/fetch_all_product/ 


/** run the PHPUnit test case **/

    - bin/phpunit tests/ProductScrapeDataTest.php
