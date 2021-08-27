# The "Payman": powered by Symfony

This project has the same core (built with Domain-Driven Design in mind) as https://github.com/vtos/payman.
The difference is now it uses Symfony for the infrastructure layer.

The purpose of this repository is to practice Domain-Driven Design methodology, hexagonal architecture
(Ports and Adapters), probably some microservices with front-ends (Vue.js) and add a PHP framework to the mix.

## Dockering
To run the app development environment on PHP's built-in server run ```docker-compose -f docker-compose.dev.yml up```
in the app's root directory. 
