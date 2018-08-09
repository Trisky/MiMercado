#**Mi Mercado**

Este proyecto tiene como objetivo la creación de un store individual para un perfil de mercado libre.

En la actualidad no existe una forma de ofrecer un listado de todos tus productos a menos que sea un store verificado, este proyecto plantea la posibilidad de tener tu propio listado de productos utilizando el listado privado de artículos:

https://developers.mercadolibre.com/en_us/search-products-seller


**Features**

. Cache con redis para que Meli no te banee la app.

. Listado de productos, incluso si estan pausados.

**TODO**

. Una vista como la gente. 

**HOW TO**
1. Composer install 
2. Creamos una app como developer de meli: http://applications.mercadolibre.com/
3. Obtenemos el app id y secret key
4. Vamos a https://developers.mercadolibre.com/en_us/authentication-and-authorization#token ,para permitirle a la app acceder a nuestros datos
5. vamos a https://api.mercadolibre.com/sites/MLA/search?nickname=TU_NICKNAME_DE_MELI para obtener tu user id.
6. Ponemos appId, secret key y user id en el archivo .env
7. Configurar Redis.




