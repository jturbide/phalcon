<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Integration\Storage\Adapter\Redis;

use Phalcon\Support\Exception as HelperException;
use Phalcon\Storage\Adapter\Redis;
use Phalcon\Storage\Exception as StorageException;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Support\HelperFactory;
use Phalcon\Tests\Fixtures\Traits\RedisTrait;
use UnitTester;

use function getOptionsRedis;

class IncrementCest
{
    use RedisTrait;

    /**
     * Tests Phalcon\Storage\Adapter\Redis :: increment()
     *
     * @param UnitTester $I
     *
     * @throws HelperException
     * @throws StorageException
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function storageAdapterRedisIncrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Redis - increment()');

        $I->skipTest('Check this');

        $helper     = new HelperFactory();
        $serializer = new SerializerFactory();
        $adapter    = new Redis($helper, $serializer, getOptionsRedis());

        $key    = 'cache-data';
        $actual = $adapter->set($key, 1);
        $I->assertTrue($actual);

        $expected = 2;
        $actual   = $adapter->increment($key);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        $expected = 10;
        $actual   = $adapter->increment($key, 8);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        /**
         * unknown key
         */
        $key    = 'unknown';
        $actual = $adapter->increment($key);
        $I->assertFalse($actual);
    }
}
