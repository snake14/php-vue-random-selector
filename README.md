# php-vue-random-selector
This was copied from my [php-random-selector](https://github.com/snake14/php-random-selector) project and adapted to use some Vue.js. The php-random-selector project is a basic PHP page that can aid in making decisions by randomly selecting from a list of options. This came about because my wife and I are both indecisive. Being able to enter a list of dinner options and then have one randomly picked at the press of a button comes in handy sometimes.

## Requirements
* You must have a MySQL database setup. The database can be named whatever you want, but it needs to have two tables:
  * `lists` table with 2 columns: `id` (int Auto Increment) and `name` (varchar).
  * `list_items` table with 3 columns: `id` (int Auto Increment), `list_id` (int), and `name` (varchar).
* The database connection information is to be saved in the src/config/config.php file. There is a sample file in that same directory.

## Setup
* Clone this repository to your local machine.
* Install the composer libraries `composer install`.
* Depending on how you deploy this project to your HTTP server, you may need to redirect all public traffic to public/index.php so that routing works correctly. This can be done using something like an .htaccess (Apache) or web.config (IIS) file.
* To run the application locally, using the built-in php HTTP server, use the following terminal command `composer start`.
* To run the unit tests, use the following terminal command `composer test`.