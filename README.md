reporter
===

Report (error) messages to given emailaddress using given subject and message. This reporter will automatically add relevant environment variables so you don't have to think about that every time.

## Install
Install using [Composer](https://getcomposer.org/).

## Usage
```php
// Include the composer autoloader once and the Reporter is available to you!

denvers\Reporter::report("denver@dsinternet.nl", "Something to remember", "User did something we need to investigate", array("variable1", "key" => "variable2"));
```

## Example report
![image](https://dl.dropboxusercontent.com/u/6723035/Screenshot%202014-03-22%2012.05.08.png)