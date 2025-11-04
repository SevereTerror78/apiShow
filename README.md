# Laravel REST API

We do _not_ use default `SPA Authentication` https://laravel.com/docs/11.x/sanctum#spa-authentication

## Endpoints

| URL          | HTTP method | Auth | JSON Response     |
| ------------ | ----------- | ---- | ----------------- |
| /users/login | POST        |      | user's token      |>>✓
| /users       | GET         | Y    | all users         |>>✓
| /films       | GET         |      | all films         |>>✓
| /films       | POST        | Y    | new film added    |>>✓
| /films       | PATCH       | Y    | edited film       |>>✓
| /films       | DELETE      | Y    | id                |>>✓
| /series      | GET         |      | all series        |>>✓
| /series      | POST        | Y    | new serie added   |>>✓
| /series      | PATCH       | Y    | edited serie      |>>✓
| /series      | DELETE      | Y    | id                |>>✓
| /actors      | GET         |      | all actors        |>>✓
| /actors      | POST        | Y    | new actor added   |>>✓
| /actors      | PATCH       | Y    | edited actor      |>>✓
| /actors      | DELETE      | Y    | id                |>>✓
| /directors   | GET         |      | all directors     |>>✓
| /directors   | POST        | Y    | new director added|>>✓
| /directors   | PATCH       | Y    | edited director   |>>✓
| /directors   | DELETE      | Y    | id                |>>✓

