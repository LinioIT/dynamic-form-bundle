Dynamic Form Bundle
============

[![Latest Stable Version](https://poser.pugx.org/linio/dynamic-form-bundle/v/stable.svg)](https://packagist.org/packages/linio/dynamic-form-bundle)
[![License](https://poser.pugx.org/linio/dynamic-form-bundle/license.svg)](https://packagist.org/packages/linio/dynamic-form-bundle)
[![Build Status](https://travis-ci.org/LinioIT/dynamic-form-bundle.svg?branch=master)](https://travis-ci.org/LinioIT/dynamic-form-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/dynamic-form-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/dynamic-form-bundle/?branch=master)
![Backend Coverage](.github/badges/coverage.svg)

> Generates symfony forms based on YAML configuration files

Getting Started
-------
This plugin supports Symfony `^2.8|^3.0|^4.0|^5.0`. Even tough we encorage you to use the latest version because of the Symfony maintained branches itself.

The recommended way to install Linio Dynamic Form Bundle is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "linio/dynamic-form-bundle": "~2.0"
    }
}
```

Tests
-----


To run the test suite, you need install the dependencies via composer, then
run PHPUnit.

    $ composer install
    $ vendor/bin/phpunit

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


### Example
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
### Options
Field options are the same as symfony, refer to the documentation

#### Birthday Type

Supports `Symfony >= 4.4`.

In addition to the own options that the field brings by default ([see documentation](https://symfony.com/doc/current/reference/forms/types/birthday.html)), we added 3 new attributes to make its behavior more flexible.

##### minAgeAllowed and maxAgeAllowed:

These options work together and it is an improvement to the `years` option because it is too strict to only receive an array with the allowed years (and that in our case we should leave static in our Yaml file). With them we can determine (taking the current date) the minimum and maximum number of ages to generate the years that will be displayed in the form. These options only accept whole numbers greater than or equal to zero.

For example, if we want to have a field of type `birthday` but we only want children who have between **5** and **10** years of life to be registered, we would have something like the following:

```yaml
dynamic_form:
    new_user:
        birthday:
            enabled: true
            type: birthday
            options:
                minAgeAllowed: 5
                maxAgeAllowed: 10
```

The above would generate this array of `years` => `[2016, 2015, 2014, 2013, 2012, 2011]` taking into account `2021` as the current year.

##### Order:

This option is used together with `minAgeAllowed` and `maxAgeAllowed` and is for the cases where we want to show our drop-down list of years in one order or another. The accepted values are **`asc`** and **`desc`**, the latter by default.

### Transformers

When using transformers write both the class where it is defined and the calls you need.

```yaml
dynamic_form:
    new_user:
        birthday:
            enabled: true
            type: text
            transformer:
              class: 'Linio\Frontend\CustomerBundle\Form\DataTransformer\BirthdayTransformer'
              calls:
                  - [setUserFormat, ['d/m/Y']]
                  - [setInputFormat, ['Y-m-d']]
```

### Validators

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

