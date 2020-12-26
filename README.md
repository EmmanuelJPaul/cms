## Installation

### Laravel 
 This project requires Laravel to be pre-installed on the executing system. To install laravel:
- Install [composer](https://getcomposer.org/)
- Install Laravel globally, execute in the terminal ``` composer global require laravel/installer ```


### Project Enviroment
- Extract the cloned repository in the dersired directory
- Create a Mysql Database called <b>`cms`</b>
- Open a terminal in the root folder of the project
- To migrate the Tables to the Database execute ``` php artisan migrate ```
- Setup the default user by Seeding the database, to do so execute ``` php artisan db:seed ```

Hurray all done!

## Launch Application
To spin up a server, open up a terminal in the project's root folder and execute ``` php artisan serve ``` in the terminal.
