## Learn PHP Restful API

This repository intended for beginner who want's to learn RESTFUL API using PHP

## Requiresments

You need the following extension:

- PDO
- PDO_SQLITE3
- PHP 8.0 and Up.
- Composer

## Installation

Simply run `composer install` to install the required dependencies.

> Optional: `npm install` to install client dependencies. Please note that the Client features is still WIP and currently only support Auth and Features.

## Serving Up

To serve this project, please make sure the initial directory are set to base.

With Built-in PHP:

Simly perform `php -S localhost:8080` at base directory.

Accessing index.php would be like this: `localhost:8080/src/index.php`.

## Refreshing Database

To refresh a database for CRUD stuff you can perform:
`php fill.php drop` and then `php fill.php`.

> `Fill.php` located in `src/CRUD/Database/fill.php`

To refresh a database for Features Database stuff:

Include `RESET_USER: true` into your header. This header can be hit into one of these url endpoint: 

- `/features/expires`
- `/features/ratelimit`
- `/features/timeout`

## Usage

We advised you to use Postman/Insomnia with this settings:

`BASE_URL: http://localhost:8080/src/index.php?url=`

and then in your request URL.

`${BASE_URL}/${url}`

With JavaScript Client:

> Required to run: `npm install` or `yarn install` or `pnpm install`.

`node filename.js`

## Route Documentation

Fill this route into `${url}` in your Postman/Insomnia.

| Route | Method | Usage | Cresidentials |
|---|---|---|---|
| `/auth/basic` | GET | Authentication Basic | Username: root, Password: root123 |
| `/auth/digest` | GET | Authentication Digest | Username: root, Password: root123 |
| `/auth/jwt` | GET | Authentiction JWT | bearer: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpZCI6MSwibmFtZSI6InVzZXIiLCJyb2xlIjoidXNlciJ9.J_N0u8ZlleSoG0Iy2ZKkD3qYvGdqPwpS3fBdv_NoEyWoUy8_BEPO0y9T7j0T7lT_L5qvbdEVWXNCiAjaOclRzg |
| `/auth/query?api_key={key}` | GET | Authentication Using Query Parameter | key: root123 |
| `/features/JWT/timeout` | GET | Activate Token after 1 minute. JWT Approach. | Require execute file: `php Token.php timeout` located in `src/Features/JWT/Token.php` |
| `/features/JWT/expires` | GET | Token expiring after 2 minutes. JWT Approach. | Require execute file: `php Token.php expires` located in `src/Features/JWT/Token.php` |
| `/features/expires` | GET | Token expiring after 2 minutes. Manual Approach | bearer: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoiLCJ1c2VybmFtZSI6InJvb3QifQ.-kcpKXGMhnXoqOcFLTu-NKuHYSrXP7kYDzuOfr3z_rg |
| `/features/timeout` | GET | Activate Token after 2 minutes. Manual Approach. | bearer: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoxeiIsInVzZXJuYW1lIjoicm9vdCJ9.drKo0_XU4Teg1bluOX56ctp_GaXL9n6lqRQrvuXU2yY |
| `/features/ratelimit` | GET | Ratelimit token for 3 times for some minutes. | bearer: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IkZ6dUxrc21PbWQiLCJ1c2VybmFtZSI6InJvb3QiLCJyYXRlbGltaXQiOiIzIn0.iLDG-90snWqz7NCP8CsSOkUm5UEX4y176ZeyFL5TAeA |
| `/CRUD/home` | GET | Fetch a data into CRUD. | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/get/{id}` | GET | Fetch a single data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/search/{search}` | GET | Search a data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/paginate?page={page}&row={row}` | GET | Fetch a data with Pagination | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/create` | POST | Create a data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/update/{id}` | PUT | Update a data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/delete/{id}` | DELETE | Delete a data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/upload` | GET | Fetch uploaded data | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |
| `/CRUD/upload` | POST | Upload a file using `form-multipart` | Require execute file: `php Token.php` located in `src/CRUD/Tools/Token.php` |

## End of the word.

Have fun exploring and learning Restful API for PHP!