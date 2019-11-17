# Hotel file converter

[Repository available on Gitlab: gitlab.com/rafaelcaviquioli/hotel-file-converter](https://gitlab.com/rafaelcaviquioli/hotel-file-converter)

#### Goals

This is a tool that converts data from hotels. Currently, it allows convert XML and JSON sources to CSV outputs. But the tool architecture was designed to be extensible, you can implement new strategies to sources (parsers) and outputs (converters). The application will choose the appropriate strategy implementation to convert each file extension.

#### How it works

- 1. The user run command to convert file through command line interface setting the source and  intended output file.
- 2. Verify the source file and define appropriated strategy to parse data according its extensions.
- 3. Parse hotels data from source file to `HotelModel`.
- 4. Verify the intended output file and define appropriated strategy to convert data according its extensions.
- 5. Convert `HotelModel` to output file.

#### Requirements

- Docker
- Docker composer

#### Build PHP Docker image

```bash
$ docker-compose build
```

#### Install composer dependencies

```bash
$ docker-compose run --rm php-fpm composer install
```

#### Run unit tests

```bash
$ docker-compose run --rm php-fpm php bin/phpunit
```

#### Convert hotels from json file

`Caution: `

```bash
$ docker-compose run --rm \
    php-fpm php bin/console \
    app:convert-hotels-file \
    ./playground/sourceFiles/hotels.json \
    ./playground/outputFiled/convertedHotelsFromJson.csv
```

#### Convert hotels from xml file

```bash
$ docker-compose run --rm \
    php-fpm php bin/console \
    app:convert-hotels-file \
    ./playground/sourceFiles/hotels.xml \
    ./playground/outputFiled/convertedHotelsFromXml.csv
```