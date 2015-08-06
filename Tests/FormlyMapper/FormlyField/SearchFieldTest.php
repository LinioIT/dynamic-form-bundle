<?php

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\SearchField;

class SearchFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SearchField
     */
    protected $formlyField;

    public function testIsAddingSearchFields()
    {
        $fieldConfiguration = [
            'name' => 'search',
            'type' => 'search',
            'options' => [
                'required' => true,
                'label' => 'Search',
            ],
            'validation' => [
                'Symfony\Component\Validator\Constraints\NotBlank' => [
                    'message' => 'Search field is mandatory',
                ],
            ],
        ];

        $expected = [
            'key' => 'search',
            'type' => 'input',
            'templateOptions' => [
                'type' => 'search',
                'label' => 'Search',
                'required' => true,
            ],
            'validation' => [
                'messages' => 'Search field is mandatory',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->generateCommonConfiguration();
        $actual = $this->formlyField->getFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup()
    {
        $this->formlyField = new SearchField();
    }
}
