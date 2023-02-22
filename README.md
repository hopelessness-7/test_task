
## About test task

Completed the first 4 points. I also covered the code with tests.

## Project Description

This project is divided into two parts. Client and server. Communication is done using the rest API. The project allows you to create elements, save them to the database, update and delete them. These actions happen on the fly, that is, without reloading the page. In addition, user authorization passes through the artisan command. Namely "php artisan login: login password". After that, a token will appear in the console, which will allow you to send requests from the client to the server. The token is valid for five minutes. Next, you need to get a new one.
If a pop-up window appears with an error when working on the client, then your token is not valid or an error was made during copying. I understand that this is not the most convenient way of working, usually authorization goes on the client and allows you to save the token, and not register it all the time.
Tests have also been added. To run them, you need to open the file "tests/Feature/TaskTest.php". After that, specify a new token at the very beginning and write "./vendor/bin/phpunit" in the console.
If there are any problems with the deployment or operation of the project, I am ready to answer all questions and show the work. I use telegram for communication.

## Technology stack

- PHP 8.1
- Composer 2.2.5
- MySQL
- bootstrap 5.0
- JS

The development was carried out using a local XAMPP server.

## Project installation

In order to install the project, you must:

- Check that php is global and you can run the command "php -v" (checking the version and making sure php is available)
- Make sure that composer is installed and "composer --version" is available and corresponds to version 2.2.*
- Use the git clone command to install the project on your computer
- Once the project is installed you need to open it using any ide
- After opening the project in the IDE, you need to open the console and write "composer update"
- You need to create a .env file (command in the console "cp .env.example .env")
- Setting up the .env file. Specify your database, login and password from it (fields DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD)
- Next, in the console, write "php artisan key:generate"
- Next, we write in the console first "php artisan migrate --seed", and after "php artisan serv"

This completes the installation of the project, you can use!!!

## Report

An error occurred due to loss of internet. And the whole project flew to the git at once. But the description of the development is presented below, also how much time was spent.

| Task                                  | Grade         | Spent     | Comment                                                 |
| --------------------------------------| ------------- |-----------|---------------------------------------------------------|
| Loading a project and its add-in      | 5 min         | 5 min     | not comment                                             |
| Add authorization via artisan command | 10 min        | 15 min    | Command not register                                    |
| Construction backend                  | 1 hours       | 45-50 min | not comment                                             |
| Construction frontend                 | 3 hours       | 4 hours   | Difficulty in receiving requests and outputting them    |
| Testing                               | 1 hours       | 1 hours   | not comment                                             |
| Upload to git                         | 15 min        | 25 min    | data flew away with one commit                          |


Total task completion time - 6.5 hours
