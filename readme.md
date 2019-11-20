#**Mi Mercado**

Demo: http://mimercado.herokuapp.com/

When you use Mercado Libre's free publishing service to get your items
displayed online to be sold, you are not entitled to a "personal shop" as paid publishings have access.


This project was created as a workaround for the lack of "personal shop" in mercado libre 
for the occacional users who would like to have a easy way to share all the products that they are selling. 



https://developers.mercadolibre.com/en_us/search-products-seller


**Features**


. Products get cached using redis for performance improvements

. Lists articles, including those that have been 'paused' in Mercado Libre

**TODO**
1. Unit tests
2. Nicer looks.
3. Multitenancy: It should be able to support listing the articles of multiple users at the same time
4. Admin portal
5. Hiding certain articles from visitors sight 

**HOW TO**

1. Composer install
2. Create an app as a developer in MeLi: http://applications.mercadolibre.com/
3. Get appId and secret from meli
4. Let the app access your data from https://developers.mercadolibre.com/en_us/authentication-and-authorization#token
5. get your userId from  https://api.mercadolibre.com/sites/MLA/search?nickname=MELI_USER
6. add appId, secret key and userId to the .env file
7. get Redis working.
8. npm install
9. npm run watch ( css y js transpiler)


**Heroku Config**
1. create a in heroku
2. Take note of redis's ip, port and credentials
3. Add that info alongside appId,secret and userId using heroku config:set





