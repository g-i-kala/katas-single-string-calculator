<?php

declare(strict_types=1);

namespace Tests;

use App\SimpleStringCalculator;
use PHPUnit\Framework\TestCase;

class SimpleStringCalculatorTest extends TestCase
{
    public function test_when_empty_string(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(0, $ssc->calculate(''));
    }

    public function test_when_single_number(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(1, $ssc->calculate('1'));
    }

    public function test_when_two_numbers_comma(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(23, $ssc->calculate('1, 22'));
    }

    public function test_when_more_numbers_comma(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(70, $ssc->calculate('1, 22, 3, 44'));
    }

    public function test_when_more_numbers_newlines(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(101, $ssc->calculate('//\u2029\n1 \u2029 22 \u2029 33 \u2029 45'));
    }

    public function test_when_more_numbers_custom(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(101, $ssc->calculate('//kupa!\n1 kupa! 22 kupa! 33 kupa! 45'));
    }

    public function test_when_negative_numbers(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->expectException('Exception');
        $ssc->calculate('-1, 2, 4');
    }

    public function test_ignore_numbers_above_1000(): void
    {
        $ssc = new SimpleStringCalculator();
        $this->assertSame(101, $ssc->calculate('1, 22, 33, 45, 1001'));
    }
}
