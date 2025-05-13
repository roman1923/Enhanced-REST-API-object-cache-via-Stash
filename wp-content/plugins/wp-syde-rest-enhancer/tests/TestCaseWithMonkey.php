<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Tests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

abstract class TestCaseWithMonkey extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
