# Equimundo web app

The Equimundo web application running on Laravel 5.

## Requirements

Below are the required tools which need to be installed before you can install and use the web app. Go to each tool's website and follow their install instructions.

- Latest [Vagrant](https://www.vagrantup.com/) version
- Latest [VirtualBox](https://www.virtualbox.org/) version

## Installation

1. Run `composer install`
2. Run `vendor/bin/homestead make`
3. Inside the homestead.yaml file, create 2 databases, one called equimundo and the other equimundo_testing
4. Run `vagrant up`
5. Run `vagrant ssh` and cd into the directory
6 Run `php artisan migrate`
7 Run `php artisan db:seed`
8. Add the corresponding ip from your homestead.yaml file in the /etc/hosts file and name it appropiately
9. Go to that url

## Frontend Development

Run these tools outside the Vagrant box in the root of the project. **Never run these tools with `sudo`.**

1. `npm install`
2. `bower install`
3. `gulp`
