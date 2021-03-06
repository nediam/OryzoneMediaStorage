<?php
namespace Oryzone\MediaStorage\Test\Exception;

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Oryzone\MediaStorage\Exception\VariantProcessingException;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-06 at 10:32:11.
 */
class VariantProcessingExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VariantProcessingException
     */
    protected $exception;

    protected $media;

    protected $variant;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->media = $this->getMock('\Oryzone\MediaStorage\Model\MediaInterface');
        $this->variant = $this->getMock('\Oryzone\MediaStorage\Variant\VariantInterface');
        $this->exception = new VariantProcessingException('message', $this->media, $this->variant);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testGetMedia()
    {
        $this->assertEquals($this->media, $this->exception->getMedia());
    }

    public function testGetVariant()
    {
        $this->assertEquals($this->variant, $this->exception->getVariant());
    }
}
