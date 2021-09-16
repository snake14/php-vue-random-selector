# php-random-selector
A basic PHP page that can aid in making decisions by randomly selecting from a list of options. This came about because my wife and I are both indecisive. Being able to enter a list of dinner options and then have one randomly picked at the press of a button comes in handy sometimes.

## Setup
* Clone this repository to your local machine.
* Install the composer libraries `composer install`.
* Depending on how you deploy this project to your HTTP server, you may need to redirect all public traffic to public/index.php so that routing works correctly. This can be done using something like an .htaccess (Apache) or web.config (IIS) file.
* To run the application locally, using the built-in php HTTP server, use the following terminal command `composer start`.
* To run the unit tests, use the following terminal command `composer test`.