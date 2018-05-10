# PHP Graphql

Microservices with Graphql.

### Docker tools

* Docker version 1
* Docker compose

### PHP Dependency

* `slim/slim` - Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
* `illuminate/database` - The Illuminate Database component is a full database toolkit for PHP, providing an expressive query builder, ActiveRecord style ORM, and schema builder.
* `webonyx/graphql-php` - This is a PHP implementation of the GraphQL specification based on the reference implementation in JavaScript.
* `vlucas/phpdotenv` - Loads enviroment variables from `.env` to `getenv()`.

### Is require to used `.env` file, you can follow this "Example" below:

```
APP_NAME=NameApp
APP_DEBUG=true

CACHE_VIEWS=true

DB_TYPE=mysql
DB_DRIVER=pdo_mysql
DB_HOST=mysql
# DB_HOST=127.0.0.1
DB_DATABASE=name_db
DB_USERNAME=user
DB_PASSWORD=password
DB_PORT=3306
```

### Test query example

```
Query GraphQL
  Postman:
    Verb - POST
      Query:
        Body raw - {"query": "query { echo(message: \"Hi Worlds, GraphQL!\") }"}
        Response - {"data":{"echo":"You said: Hi Worlds, GraphQL!"}}
      Mutation:
        Body raw - {"query": "mutation { sum(x: 2, y: 2) }"}
        Response - {"data":{"sum":4}}

Query:
  {"query": "query { user(id: 2) { name, email, friends { name } } }" }
  {"query": "query { allUsers { id, name, email, countFriends } }" }

Mutation:
  Correct - {"query": "mutation { changeUserEmail(id: 2, email: \"pereci@gmail.com\" ) { id name email } }" }
  Incorrent - {"query": "mutation { changeUserEmail(id: 2, email: \" \" ) }" }

  Correct - {"query" : "mutation ($newUser: InputUser) { addUser(user: $newUser) { id, name, email} }", "variables" : { "newUser" : { "name" : "Secosito", "email" : "secosito@gmail.com" } } }
```
# php-graphql
https://github.com/XAHTEP26/graphql-php-tutorial/blob/master/get-data-from-mysql/graphql.php
https://habr.com/post/328122/
https://habr.com/post/329238/
https://habr.com/post/329408/
https://github.com/webonyx/graphql-php
http://webonyx.github.io/graphql-php/
https://philsturgeon.uk/
https://www.youtube.com/watch?v=jRuSicPIeUY&t=605s
https://zendframework.github.io/zend-diactoros/usage/


{"query": "mutation { addUser(name: \"Secosito\" email: \"secosito@gmail.com\" password: \"password\" ) { id name email password } }" }