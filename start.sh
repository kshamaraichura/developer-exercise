#!/bin/bash

echo Composer is installing required dependencies
composer install

echo Starting Symbiote::CMS
php ./bin/console server:run

