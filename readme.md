#**Mi Mercado**

Demo: http://mimercado.herokuapp.com/

When you use Mercado Libre's free publishing service to get your items
displayed online to be sold, you are not entitled to a "personal shop" as paid publishings have access.


This project was created as a workaround for the lack of "personal shop" in mercado libre 
for the occacional users who would like to have a easy way to share all the products that they are selling. 
https://developers.mercadolibre.com/en_us/search-products-seller


**Features**
1. Products get cached using redis for performance improvement.
2. Lists articles, including those that have been 'paused' in Mercado Libre.
3. Check github's issues to see upcoming features.

**HOW TO RUN**

1. Composer install
2. Create an app as a developer in MeLi: http://applications.mercadolibre.com/
3. Get appId and secret from meli
6. add appId and secret key the .env file
7. get Redis working (apt-get install redis and make sure redis-server is running)
8. Install mysql and add the required credentials into the .env file
9. php artisan migrate:fresh (drops tables if they exist and recreates the database)
10. npm install
11. npm run watch ( css & js transpiler)

**HOW TO USE**

1. Go to http://localhost:8000
2. Login to Mercado libre
3. You'll be shown a URL, that is the URL that you should be sharing with your friends!

**Heroku Config**
1. create an app in heroku
2. Take note of redis's ip, port and credentials
3. Add that info alongside appId,secret and userId using heroku config:set





