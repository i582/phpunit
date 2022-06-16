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

use function count;
use PHPUnit\Event\Test\BeforeFirstTestMethodErrored;
use PHPUnit\Event\Test\ConsideredRisky;
use PHPUnit\Event\Test\Errored;
use PHPUnit\Event\Test\Failed;
use PHPUnit\Event\Test\MarkedIncomplete;
use PHPUnit\Event\Test\PassedWithWarning;
use PHPUnit\Event\Test\Skipped;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class TestResult
{
    private int $numberOfTests;
    private int $numberOfTestsRun;
    private int $numberOfAssertions;

    /**
     * @psalm-var list<BeforeFirstTestMethodErrored|Errored>
     */
    private array $testErroredEvents;

    /**
     * @psalm-var list<Failed>
     */
    private array $testFailedEvents;

    /**
     * @psalm-var array<string,list<PassedWithWarning>>
     */
    private array $testPassedWithWarningEvents;

    /**
     * @psalm-var list<MarkedIncomplete>
     */
    private array $testMarkedIncompleteEvents;

    /**
     * @psalm-var list<Skipped>
     */
    private array $testSkippedEvents;

    /**
     * @psalm-var array<string,list<ConsideredRisky>>
     */
    private array $testConsideredRiskyEvents;

    /**
     * @psalm-param list<BeforeFirstTestMethodErrored|Errored> $testErroredEvents
     * @psalm-param list<Failed> $testFailedEvents
     * @psalm-param array<string,list<PassedWithWarning>> $testPassedWithWarningEvents
     * @psalm-param array<string,list<ConsideredRisky>> $testConsideredRiskyEvents
     * @psalm-param list<Skipped> $testSkippedEvents
     * @psalm-param list<MarkedIncomplete> $testMarkedIncompleteEvents
     */
    public function __construct(int $numberOfTests, int $numberOfTestsRun, int $numberOfAssertions, array $testErroredEvents, array $testFailedEvents, array $testPassedWithWarningEvents, array $testConsideredRiskyEvents, array $testSkippedEvents, array $testMarkedIncompleteEvents)
    {
        $this->numberOfTests               = $numberOfTests;
        $this->numberOfTestsRun            = $numberOfTestsRun;
        $this->numberOfAssertions          = $numberOfAssertions;
        $this->testErroredEvents           = $testErroredEvents;
        $this->testFailedEvents            = $testFailedEvents;
        $this->testPassedWithWarningEvents = $testPassedWithWarningEvents;
        $this->testConsideredRiskyEvents   = $testConsideredRiskyEvents;
        $this->testSkippedEvents           = $testSkippedEvents;
        $this->testMarkedIncompleteEvents  = $testMarkedIncompleteEvents;
    }

    public function numberOfTests(): int
    {
        return $this->numberOfTests;
    }

    public function numberOfTestsRun(): int
    {
        return $this->numberOfTestsRun;
    }

    public function numberOfAssertions(): int
    {
        return $this->numberOfAssertions;
    }

    public function numberOfTestErroredEvents(): int
    {
        return count($this->testErroredEvents);
    }

    public function hasTestErroredEvents(): bool
    {
        return $this->numberOfTestErroredEvents() > 0;
    }

    public function numberOfTestFailedEvents(): int
    {
        return count($this->testFailedEvents);
    }

    public function hasTestFailedEvents(): bool
    {
        return $this->numberOfTestFailedEvents() > 0;
    }

    public function numberOfTestPassedWithWarningEvents(): int
    {
        return count($this->testPassedWithWarningEvents);
    }

    public function hasTestPassedWithWarningEvents(): bool
    {
        return $this->numberOfTestPassedWithWarningEvents() > 0;
    }

    public function numberOfTestConsideredRiskyEvents(): int
    {
        return count($this->testConsideredRiskyEvents);
    }

    public function hasTestConsideredRiskyEvents(): bool
    {
        return $this->numberOfTestConsideredRiskyEvents() > 0;
    }

    public function numberOfTestSkippedEvents(): int
    {
        return count($this->testSkippedEvents);
    }

    public function hasTestSkippedEvents(): bool
    {
        return $this->numberOfTestSkippedEvents() > 0;
    }

    public function numberTestMarkedIncompleteEvents(): int
    {
        return count($this->testMarkedIncompleteEvents);
    }

    public function hasTestMarkedIncompleteEvents(): bool
    {
        return $this->numberTestMarkedIncompleteEvents() > 0;
    }

    public function wasSuccessful(): bool
    {
        return $this->wasSuccessfulIgnoringWarnings() && !$this->hasTestPassedWithWarningEvents();
    }

    public function wasSuccessfulIgnoringWarnings(): bool
    {
        return !$this->hasTestErroredEvents() && !$this->hasTestFailedEvents();
    }

    public function wasSuccessfulAndNoTestIsRiskyOrSkippedOrIncomplete(): bool
    {
        return $this->wasSuccessful() && !$this->hasTestConsideredRiskyEvents() && !$this->hasTestMarkedIncompleteEvents() && !$this->hasTestSkippedEvents();
    }
}