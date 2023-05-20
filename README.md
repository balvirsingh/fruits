## Running the project.

To run the project, follow the steps below:

I have setup this project with docker.

```
With Docker -
If do you want to install with docker then first please install the docker and docker compose on your system and follow the steps mentioned below. Here are the links -

https://docs.docker.com/engine/install/
https://docs.docker.com/compose/install/
```

```
Without Docker -
If do you want to install without docker then the following are the requirements -
Apache2
PHP 8.2
MySql 8.0
```

For non-docker project, commands are the same (skip first command)

Replace the ./docker-php with php

1. In 1st terminal tab: Run the containers

```
docker-compose up
```

2. In 2nd terminal tab: Composer install

```
./docker-php composer install
```

3. After complete the above command: Command to create database, make migration dir if not exist and run database migrations

```
./docker-php bin/console doctrine:database:create

mkdir -p migrations
./docker-php bin/console make:migration
./docker-php bin/console doctrine:migrations:migrate
```

4. In terminal, run commmand to import data (used local json file from root folder)

```
./docker-php bin/console fruits:fetch
```

5. In browser open the application URL

```
http://localhost:5000/fruit/list
```

5. In browser database app can be opened, via phpmyadmin:

```
localhost:5001
```

if its not working then run the following commands one by one:-

```
1) docker stop $(docker ps -a -q)
2) docker rm $(docker ps -a -q)
3) docker-compose up
```

## File Ownership

Please after using composer for install/require run the following command in your project folder to regain ownership of all the files (instead of root).

```
sudo chown -R $(id -u ${USER}):$(id -g ${USER}) .
```
