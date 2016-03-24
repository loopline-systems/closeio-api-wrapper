closeio-api-wrapper
===================

PHP Wrapper to use the Close.io API 

[![License](https://img.shields.io/packagist/l/loopline-systems/closeio-api-wrapper.svg)](http://opensource.org/licenses/MIT)
[![Build Status](http://img.shields.io/travis/loopline-systems/closeio-api-wrapper.svg)](https://travis-ci.org/loopline-systems/closeio-api-wrapper)
[![Coverage Status](https://img.shields.io/coveralls/loopline-systems/closeio-api-wrapper.svg)](https://coveralls.io/r/loopline-systems/closeio-api-wrapper?branch=master)
[![Code Climate](https://codeclimate.com/github/loopline-systems/closeio-api-wrapper/badges/gpa.svg)](https://codeclimate.com/github/loopline-systems/closeio-api-wrapper)

[![Packagist](http://img.shields.io/packagist/v/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dt/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dm/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)
[![Packagist](http://img.shields.io/packagist/dd/loopline-systems/closeio-api-wrapper.svg)](https://packagist.org/packages/loopline-systems/closeio-api-wrapper)


Installation and Configuration
------------
Require via [Composer](https://github.com/composer/composer)<br />
```bash
{
    "require": {
        "loopline-systems/closeio-api-wrapper": "0.1.0"
    }
}
```

Usage
------------
```php
// you can optionally pass in close.io api endpoint as init argument (it defaults to 'https://app.close.io/api/v1')
$closeIoConfig = new CloseIoConfig();
$closeIoConfig->setApiKey('yourApiKey');

$closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);
$leadsApi = $closeIoApiWrapper->getLeadApi();

// create lead
$lead = new Lead();
$lead->setName('Test Company');
$lead->setDescription('Company description');
$lead->setUrl('www.test-company.com');

// address
$address = new Address();
$address->setCountry('DE');
$address->setCity('Berlin');
$address->setAddress1('Main Street');
$address->setAddress2('Mitte');

// contacts
$contact = new Contact();
$contact->setName('Testy Testersson');
$contact->setTitle('Chief Tester');

// emails
$email = new Email();
$email->setEmail('testy-testersson@test-company.com');
$email->setType(Email::EMAIL_TYPE_OFFICE);
$contact->addEmail($email);

// phones
$phone = new Phone();
$phone->setPhone('+491234567890');
$phone->setType(Phone::PHONE_TYPE_MOBILE);
$contact->addPhone($phone);

$lead->addAddress($address);
$lead->addContact($contact);

$response = $leadsApi->addLead($lead);
```

Adding Opportunities
----------------------
```php
$opportunity = new Opportunity();
$opportunity->setValue(500);
$opportunity->setNote('My note on this opportunity');
$opportunity->setConfidence(85);
$opportunity->setValuePeriod(Opportunity::OPPORTUNITY_FREQUENCY_MONTHLY);

// you can use the leadApi to get ID for leads
$opportunity->setLeadId(<lead-id>);

$opportunityApi = $this->apiWrapper->getOpportunityApi();
$result = $opportunityApi->addOpportunity($opportunity);
```

Updating custom fields
----------------------
```php
$customField = new CustomField();
$customField->setId('Custom field id')
$customField->addChoice('Value for choices list');

$customFieldApi = $this->apiWrapper->getCustomFieldApi();
$result = $customFieldApi->updateCustomField($customField);
```

Info
------------
Right now just a few request are implemented, because the main need was to create leads.
Feel free to add requests and create pull requests or go on forking the repo.

We use https://github.com/btford/adj-noun for our release names, so don`t worry they have no special meaning :)

Requirements
------------

PHP 5.4.0 or above

Authors
-------

Michael Devery - <michaeldevery@gmail.com><br />
Marco Roßdeutscher - <marco.rossdeutscher@gmail.com><br />

See also the list of [contributors](https://github.com/loopline-systems/closeio-api-wrapper/contributors) who participated in this project.

License
-------

The Close.io API Wrapper is licensed under the MIT License - see the LICENSE file for details<br />
*! We are not affiliated with Close.io itself.*
