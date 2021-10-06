<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

use Linio\DynamicFormBundle\Exception\InvalidConfigurationException;
use Linio\DynamicFormBundle\Exception\NumberFormatException;
use Linio\DynamicFormBundle\FormlyMapper\FormlyField\BirthdayField;
use PHPUnit\Framework\TestCase;

class BirthdayFieldTest extends TestCase
{
    /**
     * @var DateField
     */
    protected $formlyField;

    public function basicDataProvider(): array
    {
        $config = [
            'name' => 'borndate',
            'type' => 'birthday',
            'options' => [
                'required' => true,
                'label' => 'Borndate',
            ],
        ];

        $expected = [
            'key' => 'borndate',
            'type' => 'input',
            'templateOptions' => [
                'required' => true,
                'label' => 'Borndate',
                'type' => 'birthday',
            ],
        ];

        return [
            [$config, $expected],
        ];
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingBirthdayFields(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['validation'] = [
            'Symfony\Component\Validator\Constraints\Regex' => [
                'pattern' => '^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$',
                'message' => 'The birthday field must follow the pattern "yyyy-MM-dd"',
            ],
        ];

        $expected['templateOptions']['pattern'] = '^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$';
        $expected['validation'] = [
            'messages' => [
                'regex' => 'The birthday field must follow the pattern "yyyy-MM-dd"',
            ],
        ];

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingGivenYears(array $fieldConfiguration, array $expected): void
    {
        $years = [2000, 2001, 2002, 2003, 2004, 2005];

        $fieldConfiguration['options']['years'] = $years;

        $expected['templateOptions']['years'] = $years;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testItDoesNotAllowNonNumericalValuesForGivenYears(array $fieldConfiguration, array $expected): void
    {
        $this->expectException(NumberFormatException::class);

        $badYears = ['2000 ', 2001, '20O2', 2003, 2004, 2005];
        $fieldConfiguration['options']['years'] = $badYears;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->getFormlyFieldConfiguration();
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testItDoesNotAllowNonNumericalValuesForAllowedAges(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['minAgeAllowed'] = '18a';
        $fieldConfiguration['options']['maxAgeAllowed'] = 120;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingYearsRangeInDefaultOrder(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 18;
        $maxAgeAllowed = 120;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;

        $expected['templateOptions']['years'] = range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testItDoesNotAllowNegativeValuesForAllowedAges(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['minAgeAllowed'] = -2;
        $fieldConfiguration['options']['maxAgeAllowed'] = 120;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function isAllowingtoLeaveWithoutRestrictionForAllowedAges(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 0;
        $maxAgeAllowed = 0;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;

        $expected['templateOptions']['years'] = range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsBlockingWhenMinAgeAllowedValueIsLargerThanMaxAgeAllowed(array $fieldConfiguration, array $expected): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $fieldConfiguration['options']['minAgeAllowed'] = 120;
        $fieldConfiguration['options']['maxAgeAllowed'] = 18;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $this->formlyField->getFormlyFieldConfiguration();
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingAgeRangeInOrderAsc(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 18;
        $maxAgeAllowed = 120;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;
        $fieldConfiguration['options']['order'] = 'asc';

        $expected['templateOptions']['years'] = range(date('Y') - $maxAgeAllowed, date('Y') - $minAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingAgeRangeOrderDesc(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 18;
        $maxAgeAllowed = 120;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;
        $fieldConfiguration['options']['order'] = 'desc';

        $expected['templateOptions']['years'] = range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsShowingYearsRangeSortedByDefaultWhenAnInvalidOrderIsAssigned(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 18;
        $maxAgeAllowed = 120;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;
        $fieldConfiguration['options']['order'] = 'dasc';

        $expected['templateOptions']['years'] = range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsOmittingOrderParameterWhenAllowedAgeParametersAreNotAssigned(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['order'] = 'asc';

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsHavingAllowedAgesMorePriorityOverYearsGivenForTheResponse(array $fieldConfiguration, array $expected): void
    {
        $minAgeAllowed = 18;
        $maxAgeAllowed = 120;
        $years = [2000, 2001, 2002, 2003, 2004, 2005];

        $fieldConfiguration['options']['years'] = $years;

        $fieldConfiguration['options']['minAgeAllowed'] = $minAgeAllowed;
        $fieldConfiguration['options']['maxAgeAllowed'] = $maxAgeAllowed;

        $expected['templateOptions']['years'] = range(date('Y') - $minAgeAllowed, date('Y') - $maxAgeAllowed);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new BirthdayField();
    }
}
