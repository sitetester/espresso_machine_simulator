# Espresso Machine Simulator

## Project Description
In software company X, engineers work best when consuming one cup of espresso an hour. 
The office espresso machine has a first come-first serve queue that applies to everyone, except for certain "super busy"
engineers who are prioritized before non-super-busy ones. Among competing super-busies the first-come-first-serve 
principle applies again.

Please implement a simulator for this espresso machine. Input parameters are number of engineers, the chance that an
engineer becomes busy in some unit of time and for how long they stay super-busy.

## Project Setup & Execution
The task is a PHP v7+ CLI application. To setup, 

- run `composer install` at root of the project (it will install ALL needed dependencies)
- to run unit tests, simply run `phpunit` at root of the project
- to run the CLI application with some sample input data, run 
`php bin/console app:espresso_machine_simulator 1:11-12 2:10-11 3 4:15-17 5:9-10 6 7 8:9-12`
