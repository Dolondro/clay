<?php
/**
 * Silktide Nibbler. Copyright 2013-2014 Silktide Ltd. All Rights Reserved.
 */
namespace Downsider\Clay\Test;
use Downsider\Clay\Exception\ModelException;
use Downsider\Clay\Test\Implementation\DataTypeHandlingTraitImplementation;

/**
 *
 */
class DataTypeHandlingTraitTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider handleDateProvider
     *
     * @param $data
     * @param $date
     * @param bool $catchException
     * @throws ModelException
     */
    public function testHandleDate($data, $date, $catchException = false)
    {
        $dataTypeTrait = new DataTypeHandlingTraitImplementation();

        try {
            $dataTypeTrait->setDate($data);
            if ($catchException) {
                $this->fail("Should not be able to set a date with the value '$date'");
            }
        } catch (ModelException $e) {
            if (!$catchException) {
                throw $e;
            }
        }

        if (!$catchException) {
            $this->assertAttributeInstanceOf("\\DateTime", "date", $dataTypeTrait);
            $this->assertEquals($date, $dataTypeTrait->getDate());
        }

    }

    public function testChangeDateFormat()
    {
        $dataTypeTrait = new DataTypeHandlingTraitImplementation();

        $date = new \DateTime("2015-01-26");
        $newFormat = "d-m-Y";

        $dataTypeTrait->setDateFormat($newFormat);
        $dataTypeTrait->setDate($date);
        $this->assertEquals("26-01-2015", $dataTypeTrait->getDate());
    }

    public function handleDateProvider()
    {
        return [
            [ // with a string
                "2015-01-26",
                "2015-01-26"
            ],
            [ // with a datetime object
                new \DateTime("2015-01-26"),
                "2015-01-26"
            ],
            [ // with an invalid value (throws exception)
                20150126,
                null,
                true
            ]
        ];
    }

}
 