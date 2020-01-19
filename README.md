### Air quality API call from CMD

This simple command line tool enables you to get air quality data for a given sensor ID
from [OpenData Stuttgart API](https://github.com/opendata-stuttgart/meta/wiki/EN-APIs)
1. [Query sensor by type, coordinates, country](https://data.sensor.community/airrohr/v1/filter/type=SDS011&country=BG&area=42.658,23.277,0.5)
 get all sensors in an area - find the sensor ID
2. [Get data for las 5 mins by sensor ID](https://data.sensor.community/airrohr/v1/sensor/6043/)

The sensor ID can be passed from command line, as an argument or put in config file.

#### Prerequisites
* [Docker](https://www.docker.com/) installed on your machine.

This project uses public images from [DockerHub](https://hub.docker.com/)

#### Run the command locally
```
docker-compose up
```
```
docker run -it -v $(pwd):/application  airqualityapi_php-cli:latest php index.php
```

### Jenkins integration 
If Jenkins is set up with the ability to run Docker in it (if we deploy Jenkins as a Docker image - there are some extra steps), this command line script could be ran just like we run it locally. \
Further reading on running Docker inside a Dockerized Jenkins [Nestybox](https://blog.nestybox.com/2019/09/29/jenkins.html)

If there are issues with running Docker in Jenkins - the repo contains a Jenkinsfile which builds the project and runs it without Docker.
There should be PHP and Composer already installed on Jenkins.

Such a custom image of Jenkins can be found [here](https://hub.docker.com/repository/docker/boneff/jenkins-docker-php).

#### Testing
In the PHP-CLI container run the following:
```
docker run -it -v $(pwd):/application  airqualityapi_php-cli:latest vendor/bin/phpunit
```
#### Built with
* [Docker](https://www.docker.com/) 
* [Composer](https://getcomposer.org)


#### Authors

* **Iliyan Bonev** 

