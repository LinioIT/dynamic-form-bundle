<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\FormlyMapper\FormlyField\SearchField;

class SearchFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SearchField
     */
    protected $formlyField;

    public function testIsAddingSearchFields(): void
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
                'messages' => [
                    'blank' => 'Search field is mandatory',
                ],
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new SearchField();
    }
}
