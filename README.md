# Demo application for demostrate PHP, RabbitMQ and wkhtmltopdf

- PHP - [http://www.php.net](http://www.php.net)
- RabbitMQ - [http://www.rabbitmq.com/](http://www.rabbitmq.com/)
- wkhtmltopdf - [http://code.google.com/p/wkhtmltopdf/](http://code.google.com/p/wkhtmltopdf/)


##  Demo

Basic PHP application for creating PDF file from some url website by command line utility wkhtmltopdf. I can demostrate using RabbitMQ on this example.


## Install

For installing on Mac OS X i used [homebrew](http://mxcl.github.com/homebrew/).

	brew install rabbitmq
	brew install wkhtmltopdf

For notify using [growlnotify](http://growl.info/extras.php)
	
## Design

Here is basic design of applicatin

- user make SET of URLs
- URLs are proceed by wkhtmlpdf
- user are notify about jobs done and file are ready to download

![design](https://github.com/abtris/php-rabbitmq-wkhtmltox-demo/raw/master/docs/design.png)

## Using

- start RabbitMQ server
- start consumer script (scripts/consumer.php)
- start application and proceed url

## Tools

- [RabbitMQ managment tool](http://localhost:55672/mgmt/)

## Benchmark

Try test only with AB test tool

  	ab -n 300 -c 20 http://rabbit.dev/index/perform
	
	