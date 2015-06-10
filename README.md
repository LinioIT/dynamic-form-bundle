Dynamic Form Bundle
============

[![Latest Stable Version](https://poser.pugx.org/linio/dynamic-form-bundle/v/stable.svg)](https://packagist.org/packages/linio/dynamic-form-bundle)
[![License](https://poser.pugx.org/linio/dynamic-form-bundle/license.svg)](https://packagist.org/packages/linio/dynamic-form-bundle)
[![Build Status](https://travis-ci.org/LinioIT/dynamic-form-bundle.svg?branch=master)](https://travis-ci.org/LinioIT/dynamic-form-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/dynamic-form-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/dynamic-form-bundle/?branch=master)

> Generates symfony forms based on YAML configuration files

Getting Started
-------
This plugin requires Symfony `2.6.*`

The recommended way to install Linio Dynamic Form Bundle is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "linio/dynamic-form-bundle": "~1.0"
    }
}
```

Tests
-----


To rxun the test suite, you need install the dependencies via composer, then
run PHPUnit.

    $ composer install
    $ phpunit

Usage
-----
Add the bundle on `registerBundles()` at `AppKernel.php`

```php
new Linio\DynamicFormBundle\DynamicFormBundle();
```
The service `dynamic_form.factory` will be available.

Create your form on the Configuration File. The YAML structure for the Form should follow the next structure:

```
+---dynamic_form
|   \--- Form Name
|       \---Field Name
|           \---Field Options
|           \---Field Transformer
|           \---Field Validators
```
The method `createform()` takes the form configuration named `new_user` from `app/config/config.yml`. 

```php
use Linio\DynamicFormBundle\DynamicFormAware;

class TestController
{
	use DynamicFormAware;
	
	public function testAction()
	{
		$form = $this->getDynamicFormFactory()->createForm('new_user');
		return $this->render(
		  'WebBundle:Default:dynamicForms.html.twig',
		  ['form' => $form->createView(),]
		);
	}
}
```
The method `getJsonConfiguration()` takes the configuration from `app/config/config.yml`. and returns a JSON with the Form Configuration.


###Example
Here's an example of a form named `new_user` with a single field called `first_name`:

```yaml
dynamic_form:
    new_user:
        first_name:
            enabled: true
            type: text
            options:
                type: password
                required: true
            transformers:
            validators:
```
###Options
Field options are the same as symfony, refer to the documentation


###Transformers

When using transformers write both the class where it is defined and the calls you need.

```yaml
dynamic_form:
    new_user:
        first_name:
            enabled: true
            type: text
            transformer:
              class: 'Linio\Frontend\CustomerBundle\Form\DataTransformer\BornDateTransformer'
              calls:
                  - [setUserFormat, ['d/m/Y']]
                  - [setInputFormat, ['Y-m-d']]
```

###Validators

When using validators call each validator constraint and its parameters like shown down below.

```yaml
dynamic_form:
    new_user:
        first_name:
            enabled: true
            type: text
            validation:
              'Symfony\Component\Validator\Constraints\True':
                  message: 'The token is invalid.'
              'Symfony\Component\Validator\Constraints\Length':
                  min: 2
                  max: 50
```

## Release History

 * 2015-05-21   v1.0   First Version
