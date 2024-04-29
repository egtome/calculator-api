## Instructions

Built in Laravel, you need PHP 8 to run it
- Create a database in you local environment named calculator_api
- Create a local virtual host, that’s the one that calculator_web will consume
- In the root directory, place .env file (I attached it in the email)
- Once you pulled the project, run these commands:
- composer install
- php artisan migrate:fresh
- php artisan db:seed

That’s it, now, you can interact with the API via Postman or the web client
The seeders created 3 users for you:

1. user1@test.com
2. user2@test.com
3. user3@test.com (this user has EMPTY balance, for testing purposes)

User passwords provided in the email I sent

Consume API:
I created and exported ALL the endpoints to use with Postman for you, please check the
attached file in the email “calculator-api.postman_collection.json”

Run API tests:
I wrote a total of 33 tests, to run them:
From the console, step in root directory and run: vendor/bin/phpunit tests/Feature
