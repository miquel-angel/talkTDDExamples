<?php
declare(strict_types=1);

namespace TddExamples\MarsRoversKata;

class MarsRovers
{
    private $originalPosition;

    public function __construct($originalPosition, $map)
    {
        $this->originalPosition = $originalPosition;
    }

    public function move(string $commands): bool
    {
        if ($commands === 'R') {
            $this->originalPosition['direction'] = 'E';
        } elseif ($commands === 'L') {
            $this->originalPosition['direction'] = 'W';
        }

        return true;
    }

    public function getCurrentPosition(): array
    {
        return $this->originalPosition;
    }
}