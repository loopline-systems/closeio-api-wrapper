closeio-api-wrapper
===================

PHP Wrapper to use the Close.io API

[![License](https://img.shields.io/packagist/l/loopline-systems/closeio-api-wrapper.svg)](http://opensource.org/licenses/MIT)
[![Build Status](http://img.shields.io/travis/loopline-systems/closeio-api-wrapper.svg)](https://travis-ci.org/loopline-systems/closeio-api-wrapper)
[![Coverage Status](https://img.shields.io/coveralls/loopline-systems/closeio-api-wrapper.svg)](https://coveralls.io/r/loopline-systems/closeio-api-wrapper)

[![Packagist](http://img.shields.io/packagist/v/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dt/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dm/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dd/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)


Installation and Configuration
------------
* Require via composer<br />
  "loopline-systems/closeio-api-wrapper": "dev-master"
* Copy the config/config.sample.yml into config/config.yml and add your API Key.<br />
   ! Probably a good idea to use testing credentials first.<br />
! You can use different endpoints if you want to.<br />
  Just create another config file like so "config.anothername.yml" and instanciate the CloseIoApiWrapper
  using the anothername as the first argument

```php
$closeIoApiWrapper = new CloseIoApiWrapper();

$anotherCloseIoApiWrapper = new CloseIoApiWrapper('anothername');
```


Usage
------------
```php
$closeIoApiWrapper = new CloseIoApiWrapper();
$leadsApi = $closeIoApiWrapper->getLeadApi();

// create lead
$lead = new Lead();
$lead->setName('Dynamic Test');
$lead->setDescription('Dynamic lead test description');
$lead->setUrl('www.dynamic-lead-test.com');

// address
$address = new Address();
$address->setCountry('DE');
$address->setCity('Berlin');
$address->setAddress1('Main Street');
$address->setAddress2('Mitte');

// contacts
$contact = new Contact();
$contact->setName('Dynamic Testcontact');
$contact->setTitle('Dynamic Contact Test Title');

// emails
$email = new Email();
$email->setEmail('testcontactemail@dynamic-lead-test.com');
$email->setType('work');
$contact->addEmail($email);

// phones
$phone = new Phone();
$phone->setPhone('01244349656');
$phone->setType('mobile');
$contact->addPhone($phone);

$lead->addAddress($address);
$lead->addContact($contact);

$response = $leadsApi->addLead($lead);
```

Info
------------
Right now just a few request are implemented, because the main need was to create leads.
Feel free to add requests and create pull requests or go on forking the repo.

Requirements
------------

PHP 5.4.0 or above

Authors
-------

Michael Devery - <michaeldevery@gmail.com><br />
Marco Roßdeutscher - <marco.rossdeutscher@gmail.com><br />

See also the list of [contributors](https://github.com/composer/composer/contributors) who participated in this project.

License
-------

The Close.io API Wrapper is licensed under the MIT License - see the LICENSE file for details<br />
*!We are not affiliated with Close.io itself.*
