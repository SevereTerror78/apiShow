# Laravel REST API

We do _not_ use default `SPA Authentication` https://laravel.com/docs/11.x/sanctum#spa-authentication

## Endpoints

| URL                              | HTTP method | Auth | JSON Response     |
| -------------------------------- | ----------- | ---- | ----------------- |
| /users/login                     | POST        |      | user's token      |>>✓
| /users                           | GET         | Y    | all users         |>>✓
| /films                           | GET         |      | all films         |>>✓
| /films                           | POST        | Y    | new film added    |>>✓
| /films                           | PATCH       | Y    | edited film       |>>✓
| /films                           | DELETE      | Y    | id                |>>✓
| /series                          | GET         |      | all series        |>>✓
| /series                          | POST        | Y    | new serie added   |>>✓
| /series                          | PATCH       | Y    | edited serie      |>>✓
| /series                          | DELETE      | Y    | id                |>>✓
| /actors                          | GET         |      | all actors        |>>✓
| /actors                          | POST        | Y    | new actor added   |>>✓
| /actors                          | PATCH       | Y    | edited actor      |>>✓
| /actors                          | DELETE      | Y    | id                |>>✓
| /directors                       | GET         |      | all directors     |>>✓
| /directors                       | POST        | Y    | new director added|>>✓
| /directors                       | PATCH       | Y    | edited director   |>>✓
| /directors                       | DELETE      | Y    | id                |>>✓

| /directors/director/films        | GET         |      | all directors     |>>✓
| /actors/actor/films              | GET         |      | all directors     |>>✓
| /films/film/directors            | GET         |      | all directors     |>>✓
| /films/film/directors            | POST        | Y    | new director added|>>✓
| /films/film/directors/director   | PATCH       | Y    | edited director   |>>✓
| /films/film/directors            | DELETE      | Y    | id                |-> csak egy készítője lehet a filmnek ezért, ha azt törlöm nem kell az id
| /films/film/actors               | GET         |      | all directors     |
| /films/film/actors               | POST        | Y    | new director added|
| /films/film/actors/actor         | PATCH       | Y    | edited director   |
| /films/film/actors/actor         | DELETE      | Y    | id                |



//nem kell ||
           \/

!| /directors/director/films| POST        | Y    | new director added|
!| /directors/director/films| PATCH       | Y    | edited director   |
!| /directors/director/films| DELETE      | Y    | id                |

!| /actors/actor/films   | POST        | Y    | new director added|
!| /actors/actor/films   | PATCH       | Y    | edited director   |
!| /actors/actor/films   | DELETE      | Y    | id                |

| /actors/series   | GET         |      | all directors     |
| /actors/series   | POST        | Y    | new director added|
| /actors/series   | PATCH       | Y    | edited director   |
| /actors/series   | DELETE      | Y    | id                |

| /series/actors   | GET         |      | all directors     |
| /series/actors   | POST        | Y    | new director added|
| /series/actors   | PATCH       | Y    | edited director   |
| /series/actors   | DELETE      | Y    | id                |

| /directors/series| GET         |      | all directors     |
| /directors/series| POST        | Y    | new director added|
| /directors/series| PATCH       | Y    | edited director   |
| /directors/series| DELETE      | Y    | id                |
