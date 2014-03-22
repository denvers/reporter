reporter
===

Report (error) messages to given emailaddress using given subject and message. This reporter will automatically add relevant environment variables so you don't have to think about that every time.

## Install
Install using [Composer](https://getcomposer.org/). *Reporter* is available as a package via [Packagist](https://packagist.org/packages/denvers/reporter), so just include *Reporter* in the `composer.json` file of your project, run `composer update` and you are ready to go!

## Usage
```php
// Include the composer autoloader once and the Reporter is available to you!

denvers\Reporter::report("your@emailaddress.com", "Something to remember", "User did something we need to investigate", array("variable1", "key" => "variable2"));
```

## Example report
![image](https://dl.dropboxusercontent.com/u/6723035/Screenshot%202014-03-22%2012.05.08.png)