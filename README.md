# Anymarket PHP SDK

This is a PHP SDK for Anymarket Plataform

## How do I install it?

       clone repository https://github.com/tiaguinho/anymarket

## How do I use it?

The first thing to do is to instance a ```Anymarket``` class. You'll need to give the ```token```. To obtain the token you need to ask the support.

### Including the Lib
Include the lib in your project

```php
require 'anymarket.php';
```
Start the development!

### Create an instance of Anymarket class
Simple like this
```php
$anymarket = new Anymarket('token');
```
With this instance you can start working on Anymarket's APIs.

There are some design considerations worth to mention.

1. This SDK is just a thin layer on top of an http client to handle all the requests.

2. There is JSON parsing. this SDK will include [json](http://php.net/manual/en/book.json.php) for internal usage.

3. This SDK will include [curl](http://php.net/manual/en/book.curl.php) for internal usage.

4. To put your project in production, you need to pass the second parameter as false

```php
$anymarket = new Anymarket('a secret', 'sandbox [true or false]');
```

#### Making GET calls

```php
$result = $anymarket->get('/categories'); 
 #If you wish , you can get an associative array with param $assoc = true Example:
$result = $anymarket->get('/categories', [], true); 
```

#### Making POST calls

```php
 #this body will be converted into json for you
$body = ['foo' => 'bar', 'bar' => 'foo'];

$response = $anymarket->post('/categories', $body, $params);
```

#### Making PUT calls

```php
 #this body will be converted into json for you
$body = ['foo' => 'bar', 'bar' => 'foo'];

$response = $anymarket->put('/categories/123', $body);
```

#### Making DELETE calls
```php
$response = $anymarket->delete('/categories/123')
```