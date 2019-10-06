<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Event\Test;

use PHPUnit\Event\Run\AfterRun;
use PHPUnit\Event\Run\AfterRunType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PHPUnit\Event\Test\AfterRun
 */
final class AfterRunTest extends TestCase
{
    public function testTypeIsAfterTest(): void
    {
        $event = new AfterRun();

        $this->assertTrue($event->type()->is(new AfterRunType()));
    }
}
