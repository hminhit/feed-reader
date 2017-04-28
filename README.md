# PHP Developer assignment

## Task

Your task is to create a PHP application that is a feeds reader. The app can read feed from multiple feeds and store them to database. Sample feeds http://www.feedforall.com/sample-feeds.htm.

## Requirements
- The application must be developed by using a php framework and follow coding standard of that framework.
- As a developer, I want to run a command which help me to setup database easily with one run.
- As a developer, I want to run a command which accepts the feed urls (separated by comma) as argument to grab items from given urls. Duplicate items are accepted.
- As a developer, I want to see output of the command not only in shell but also in pre-defined log file. The log file should be defined as a parameter of the application.
- As a user, I want to see the list of items which were grabbed by running the command line. I also should see the pagination if there are more than one page. The page size is up to you.
- As a user, I want to filter items by category name on list of items.
- As a user, I want to create new item manually
- As a user, I want to update/delete an item

## How to do
1. Fork this repository
2. Start coding
3. Use gitflow to manage branches on your repository
4. Open a pull request to this repository after done

## How to setup environment
1. Run command cd to `env` folder.
2. Run command `vagrant up` to start vagrant.

## How to access docker
1. Run command `varant ssh` to access docker.

## How to create schema db
1. Run command cd to `env` folder.
2. Access into docker by command `vagrant ssh`.
3. Run command `docker exec -it feeds-reader-php-fpm php bin/console doctrine:schema:update --force` to create schema db.

## How to grab items from given urls
1. Run command cd to `env` folder.
2. Access into docker by command `vagrant ssh`.
3. Run command `docker exec -it feeds-reader-php-fpm php bin/console feed_reader:retrieve_feed_from_multi_url url1,url2,.....` without log
- For example: `docker exec -it feeds-reader-php-fpm php bin/console feed_reader:retrieve_feed_from_multi_url http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml`
4. Run command `docker exec -it feeds-reader-php-fpm php bin/console feed_reader:retrieve_feed_from_multi_url http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml -vvv` with log
- For example: `docker exec -it feeds-reader-php-fpm php bin/console feed_reader:retrieve_feed_from_multi_url http://www.feedforall.com/sample.xml,http://www.feedforall.com/sample-feed.xml -vvv`

## How to run test case
1. Run command cd to `env` folder.
2. Access into docker by command `vagrant ssh`.
3. Run command `docker exec -it feeds-reader-php-fpm phpunit tests --testdox`

## How to run web app on web browser
http://192.168.50.6/feeds-reader/

# Reference
1. Relating to the requirements:
- https://validator.w3.org/feed/docs/rss2.html
2. Using Domain Driven Design Architecture to do the application, this is some reference to relating to this Architecture:
- https://en.wikipedia.org/wiki/Domain-driven_design
- https://www.infoq.com/articles/ddd-in-practice
- https://martinfowler.com/bliki/CQRS.html
- https://github.com/dddinphp