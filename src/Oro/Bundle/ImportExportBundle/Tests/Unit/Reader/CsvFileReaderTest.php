<?php

namespace Oro\Bundle\ImportExportBundle\Tests\Unit\Reader;

use Oro\Bundle\ImportExportBundle\Reader\CsvFileReader;

class CsvFileReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CsvFileReader
     */
    protected $reader;

    protected function setUp()
    {
        $this->reader = new CsvFileReader();
    }

    /**
     * @expectedException \Oro\Bundle\ImportExportBundle\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Configuration of CSV reader must contain "filePath".
     */
    public function testSetStepExecutionNoFileException()
    {
        $this->reader->setStepExecution($this->getMockStepExecution(array()));
    }

    /**
     * @expectedException \Oro\Bundle\ImportExportBundle\Exception\InvalidArgumentException
     * @expectedExceptionMessage File "unknown_file.csv" does not exists.
     */
    public function testUnknownFileException()
    {
        $this->reader->setStepExecution($this->getMockStepExecution(array('filePath' => 'unknown_file.csv')));
    }

    public function testSetStepExecution()
    {
        $options = array(
            'filePath' => __DIR__ . '/fixtures/import_correct.csv',
            'delimiter' => ',',
            'enclosure' => "'''",
            'escape' => ';',
            'firstLineIsHeader' => false,
            'header' => array('one', 'two')
        );

        $this->assertAttributeEquals(';', 'delimiter', $this->reader);
        $this->assertAttributeEquals('"', 'enclosure', $this->reader);
        $this->assertAttributeEquals('\\', 'escape', $this->reader);
        $this->assertAttributeEquals(true, 'firstLineIsHeader', $this->reader);
        $this->assertAttributeEmpty('header', $this->reader);

        $this->reader->setStepExecution($this->getMockStepExecution($options));

        $this->assertAttributeEquals($options['delimiter'], 'delimiter', $this->reader);
        $this->assertAttributeEquals($options['enclosure'], 'enclosure', $this->reader);
        $this->assertAttributeEquals($options['escape'], 'escape', $this->reader);
        $this->assertAttributeEquals($options['firstLineIsHeader'], 'firstLineIsHeader', $this->reader);
        $this->assertAttributeEquals($options['header'], 'header', $this->reader);
    }

    public function testRead()
    {
        $stepExecution = $this->getMockStepExecution(array('filePath' => __DIR__ . '/fixtures/import_correct.csv'));
        $this->reader->setStepExecution($stepExecution);
        $stepExecution->expects($this->atLeastOnce())
            ->method('incrementReadCount');
        $stepExecution->expects($this->never())
            ->method('addReaderWarning');
        $data = array();
        while (($dataRow = $this->reader->read($stepExecution)) !== null) {
            $data[] = $dataRow;
        }
        $expectedData = array(
            array(
                'field_one' => '1',
                'field_two' => '2',
                'field_three' => '3',
            ),
            array(
                'field_one' => 'test1',
                'field_two' => 'test2',
                'field_three' => 'test3',
            ),
            array(
                'field_one' => 'after_new1',
                'field_two' => 'after_new2',
                'field_three' => 'after_new3',
            )
        );
        $this->assertEquals($expectedData, $data);
    }

    public function testReadError()
    {
        $stepExecution = $this->getMockStepExecution(array('filePath' => __DIR__ . '/fixtures/import_incorrect.csv'));
        $stepExecution->expects($this->once())
            ->method('addReaderWarning')
            ->with($this->reader, 'Expecting to get 3 columns, actually got 2');
        $this->reader->setStepExecution($stepExecution);
        $this->reader->read($stepExecution);
    }

    /**
     * @param array $jobInstanceRawConfiguration
     * @return \PHPUnit_Framework_MockObject_MockObject+
     */
    protected function getMockStepExecution(array $jobInstanceRawConfiguration)
    {
        $jobInstance = $this->getMockBuilder('Oro\Bundle\BatchBundle\Entity\JobInstance')
            ->disableOriginalConstructor()
            ->getMock();

        $jobInstance->expects($this->once())->method('getRawConfiguration')
            ->will($this->returnValue($jobInstanceRawConfiguration));

        $jobExecution = $this->getMockBuilder('Oro\Bundle\BatchBundle\Entity\JobExecution')
            ->disableOriginalConstructor()
            ->getMock();

        $jobExecution->expects($this->once())->method('getJobInstance')
            ->will($this->returnValue($jobInstance));

        $stepExecution = $this->getMockBuilder('Oro\Bundle\BatchBundle\Entity\StepExecution')
            ->disableOriginalConstructor()
            ->getMock();
        $stepExecution->expects($this->once())->method('getJobExecution')
            ->will($this->returnValue($jobExecution));

        return $stepExecution;
    }
}
