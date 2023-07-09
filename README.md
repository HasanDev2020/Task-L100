# Installation Laravel 9
## Requirements
- php 8.*
- composer
- mysql 5.7
- xaamp or wamp or laragon
- git

## Installation
- Clone this repository
- Run `composer install`
- Copy `.env.example` to `.env`
- Run `php artisan key:generate`
- Run Command `php artisan app:convert-files-structr-to-tamatem-structure-command`
- Go to public folder you will find folder name `files` this folder contain all files that you want to convert it to tamatem structure

## If you want to return the files structure to the original
* "NOTE: this command must be run after you run the command above: app:convert-files-structr-to-tamatem-structure-command"
- Run Command `php artisan app:convert-files-structr-to-original-structure-command`

## If you want to convert the files structure to tamatem structure again
- Run Command `php artisan app:convert-files-structr-to-tamatem-structure-command`

