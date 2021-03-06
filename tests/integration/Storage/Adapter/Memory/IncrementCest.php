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

namespace Phalcon\Tests\Integration\Storage\Adapter\Memory;

use Phalcon\Support\Exception as HelperException;
use Phalcon\Storage\Adapter\Memory;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Support\HelperFactory;
use UnitTester;

class IncrementCest
{
    /**
     * Tests Phalcon\Storage\Adapter\Memory :: increment()
     *
     * @param UnitTester $I
     *
     * @throws HelperException
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function storageAdapterMemoryIncrement(UnitTester $I)
    {
        $I->wantToTest('Storage\Adapter\Memory - increment()');

        $helper     = new HelperFactory();
        $serializer = new SerializerFactory();
        $adapter    = new Memory($helper, $serializer);

        $key    = 'cache-data';
        $result = $adapter->set($key, 1);
        $I->assertTrue($result);

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
    }
}
