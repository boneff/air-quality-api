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

#### Testing
In the PHP-FPM container run the following:
```
vendor/bin/phpunit
```
#### Built with
* [Docker](https://www.docker.com/) 
* [Composer](https://getcomposer.org)


#### Authors

* **Iliyan Bonev** 

