## Installation

### Laravel 
 This project requires Laravel to be pre-install on the executing system. To install laravel:
- Install [composer](https://getcomposer.org/)
- Install Laravel globally, execute in the terminal ``` composer global require laravel/installer ```


### Project Enviroment
- Extract the cloned repository in the dersired directory
- Open a terminal in the root folder of the project 
- To migrate the Database execute ``` php artisan migrate ```
- Setup the default user by Seeding the database, to do so execute ``` php artisan db:seed ```

Hurray all done!

## Launch Server
To spin up a server, open up a terminal in the project's root folder and execute ``` php artisan serve ``` in the terminal.
