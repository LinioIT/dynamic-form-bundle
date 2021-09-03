<?php

declare(strict_types=1);

namespace Linio\DynamicFormBundle\Tests\FormlyMapper\FormlyField;

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
                'label' => 'Borndate'
            ],
        ];

        $expected = [
            'key' => 'borndate',
            'type' => 'input',
            'templateOptions' => [
                'required' => true,
                'label' => 'Borndate',
                'type' => 'birthday'
            ],
        ];

        return [
            [$config, $expected]
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
    public function testIsAddingSpecificYears(array $fieldConfiguration, array $expected): void
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
    public function testWithNotNumberSpecificYears(array $fieldConfiguration, array $expected): void
    {
        $goodYears = [2000, 2001, 2002, 2003, 2004, 2005];
        $badYears = ['2000', 2001, '2002', 2003, 2004, 2005];

        $fieldConfiguration['options']['years'] = $badYears;

        $expected['templateOptions']['years'] = $goodYears;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingYearsRangeInOrderByDefault(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithBadYearsRangeForWord(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['minYear'] = '18a';
        $fieldConfiguration['options']['maxYear'] = 120;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithBadYearsRangeForNegativeNumber(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['minYear'] = -2;
        $fieldConfiguration['options']['maxYear'] = 120;

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithRangeZero(array $fieldConfiguration, array $expected): void
    {
        $minYear = 0;
        $maxYear = 0;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithMinYearBiggerThanMaxYear(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;

        $fieldConfiguration['options']['minYear'] = $maxYear;
        $fieldConfiguration['options']['maxYear'] = $minYear;

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingYearsRangeInOrderAsc(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;
        $fieldConfiguration['options']['order'] = 'asc';

        $expected['templateOptions']['years'] = range(date('Y')-$maxYear, date('Y')-$minYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingYearsRangeOrderDesc(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;
        $fieldConfiguration['options']['order'] = 'desc';

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testIsAddingYearsRangeWithBadOrderWord(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;
        $fieldConfiguration['options']['order'] = 'dasc';

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithOrderButWithoutRange(array $fieldConfiguration, array $expected): void
    {
        $fieldConfiguration['options']['order'] = 'asc';

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testWithYearsRangeAndSpecificYearsArray(array $fieldConfiguration, array $expected): void
    {
        $minYear = 18;
        $maxYear = 120;
        $years = [2000, 2001, 2002, 2003, 2004, 2005];

        $fieldConfiguration['options']['years'] = $years;

        $fieldConfiguration['options']['minYear'] = $minYear;
        $fieldConfiguration['options']['maxYear'] = $maxYear;

        $expected['templateOptions']['years'] = range(date('Y')-$minYear, date('Y')-$maxYear);

        $this->formlyField->setFieldConfiguration($fieldConfiguration);
        $actual = $this->formlyField->getFormlyFieldConfiguration();

        $this->assertEquals($expected, $actual);
    }

    public function setup(): void
    {
        $this->formlyField = new BirthdayField();
    }
}
