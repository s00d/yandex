<?php

namespace Arhitector\Yandex\Tests;

use Arhitector\Yandex\Disk;
use Arhitector\Yandex\Disk\Resource\Closed;
use PHPUnit\Framework\TestCase;

class DiskTest extends TestCase
{
    public function testConstructWithoutNetwork(): void
    {
        $disk = new Disk('dummy-token');

        $this->assertInstanceOf(Disk::class, $disk);
        $this->assertSame('https://cloud-api.yandex.net/v1/disk/', (string) $disk->getUri());
    }

    public function testGetResourceReturnsClosedResource(): void
    {
        $disk = new Disk('dummy-token');
        $resource = $disk->getResource('disk:/test.txt');

        $this->assertInstanceOf(Closed::class, $resource);
    }

    public function testFilterTraitSetters(): void
    {
        $disk = new Disk('dummy-token');
        $collection = $disk->getResources();

        $collection->setLimit(10)->setOffset(5);

        $params = $collection->getParameters(['limit', 'offset']);

        $this->assertSame(10, $params['limit']);
        $this->assertSame(5, $params['offset']);
    }

    public function testOpenedSaveSignatureAcceptsNullables(): void
    {
        $disk = new Disk('dummy-token');
        $opened = $disk->getPublishResource('https://yadi.sk/d/example');

        $this->assertTrue(method_exists($opened, 'save'));
    }
}
