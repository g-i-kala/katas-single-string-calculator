<?php

declare(strict_types=1);

namespace App;

use Exception;

class SimpleStringCalculator
{
    public function calculate(string $input): int
    {
        if ($input === '') {
            return 0;
        }

        // normalize input
        [$delimiter, $numbersPart] = $this->normalize($input);
        $pattern = '/' . preg_quote($delimiter, '/') . '|\R/';
        $inputArray = preg_split($pattern, $numbersPart);

        //throw on negative
        $this->throwOnNegative($inputArray);

        $inputArray = array_filter($inputArray, function ($v) {
            return (int) $v <= 1000;
        });
        return (int)array_sum($inputArray);

    }

    private function normalize(string $input): array
    {
        if (str_starts_with($input, '//')) {
            $parts = explode('\n', $input, 2);
            $delimiter = substr($parts[0], 2);
            return [$delimiter, (string)($parts[1] ?? '')];
        }

        return [',', (string)$input];
    }

    private function throwOnNegative(array $numbersPart): void
    {
        if (!empty(array_filter($numbersPart, function ($v) {
            return $v < 0;
        }))) {
            throw new Exception('We throw when negative number!');
        }
    }
}
