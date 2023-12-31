<?php

namespace Common\Tests\Adapter\Zip;

use PhpOffice\Common\Adapter\Zip\PclZipAdapter;
use PhpOffice\Common\Tests\TestHelperZip;

class PclZipAdapterTest extends \PHPUnit_Framework_TestCase
{
    protected $zipTest;

    public function setUp()
    {
        parent::setUp();

        $pathResources = PHPOFFICE_COMMON_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
        $this->zipTest = tempnam($pathResources, 'PhpOfficeCommon');
        copy($pathResources.'Sample_01_Simple.pptx', $this->zipTest);
    }

    public function tearDown()
    {
        parent::tearDown();

        unlink($this->zipTest);
    }

    public function testOpen()
    {
        $object = new PclZipAdapter();
        $this->assertInstanceOf('PhpOffice\\Common\\Adapter\\Zip\\ZipInterface', $object->open($this->zipTest));
    }

    public function testClose()
    {
        $object = new PclZipAdapter();
        $object->open($this->zipTest);
        $this->assertInstanceOf('PhpOffice\\Common\\Adapter\\Zip\\ZipInterface', $object->close());
    }

    public function testAddFromString()
    {
        $expectedPath = 'file.test';
        $expectedContent = 'Content';

        $object = new PclZipAdapter();
        $object->open($this->zipTest);
        $object->addFromString($expectedPath, $expectedContent);
        $object->close();

        $this->assertTrue(TestHelperZip::assertFileExists($this->zipTest, $expectedPath));
        $this->assertTrue(TestHelperZip::assertFileContent($this->zipTest, $expectedPath, $expectedContent));
    }
}
