<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\TestRunner\TestResult;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
abstract readonly class Subscriber
{
    private readonly Collector $collector;

    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    protected function collector(): Collector
    {
        return $this->collector;
    }
}
