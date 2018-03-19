<?php
declare(strict_types=1);

namespace TddExamples\MarsRoversKata;

class MarsRovers
{
    private $position;

    /**
     * Map to pass from direction numeric to string.
     *
     * @var array
     */
    private $directionNumericToString = [
        'N',
        'E',
        'S',
        'W'
    ];

    /**
     * For each direction the operation that we should do to update the position.
     *
     * @var array
     */
    private $directionToOperation = [
        [ // N --> decrease by 1 the "Y"
            'key'       => 'x',
            'update'    => -1
        ],
        [ // E --> increment by 1 the "X"
            'key'       => 'y',
            'update'    => 1
        ],
        [ // S --> increment by 1 the "Y"
            'key'       => 'x',
            'update'    => 1
        ],
        [ // W --> decrease by 1 the "X"
            'key'       => 'y',
            'update'    => -1
        ]
    ];

    private $limitsWorld = array(
        'x' => 0,
        'y' => 0
    );
    private $map;

    public function __construct($originalPosition, $map)
    {
        $this->map = $map;
        $this->position = $originalPosition;
        $this->position['direction'] = array_search($originalPosition['direction'], $this->directionNumericToString);
        $this->limitsWorld['x'] = count( $map );
        $this->limitsWorld['y'] = count( $map[0] );
    }

    public function move(string $commands): bool
    {
        $commands = strtolower($commands);
        $totalCommands = strlen($commands);
        for($i = 0; $i < $totalCommands; ++$i)
        {
            $command = $commands[$i];
            try {
                if ($command === 'r') {
                    $this->position['direction'] = $this->updateDirection($this->position['direction'], +1);
                } elseif ($command === 'l') {
                    $this->position['direction'] = $this->updateDirection($this->position['direction'], -1);
                } elseif($command === 'b') {
                    $newPosition = $this->updatePosition($this->position, -1);
                    $this->position = $newPosition;
                } elseif($command === 'f') {
                    $newPosition = $this->updatePosition($this->position, +1);
                    $this->position = $newPosition;
                }
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }

    public function getCurrentPosition(): array
    {
        return [
            'x' => $this->position['x'],
            'y' => $this->position['y'],
            'direction' => $this->directionNumericToString[$this->position['direction']]
        ];
    }

    private function updateDirection($currentDirection, $steps): int
    {
        $currentDirection = ($currentDirection + $steps)%4;

        if ($currentDirection < 0){
            $currentDirection += 4;
        }

        return $currentDirection;
    }

    private function updatePosition($currentPosition, $singMove): array
    {
        $operationAndKey = $this->directionToOperation[$currentPosition['direction']];
        $currentPosition[$operationAndKey['key']] += ( $operationAndKey['update'] * $singMove );

        $currentPosition = $this->correctOverWorld($currentPosition, $operationAndKey['key']);

        if ( $this->map[$currentPosition['x']][$currentPosition['y']] != '.' )
        {
            throw new \Exception();
        }


        return $currentPosition;

    }

    private function correctOverWorld($currentPosition, $keyUpdated): array
    {
        if ($currentPosition[$keyUpdated] < 0)
        {
            $currentPosition[$keyUpdated] = $this->limitsWorld[$keyUpdated] - 1;
        }
        $currentPosition[$keyUpdated] = $currentPosition[$keyUpdated] % $this->limitsWorld[$keyUpdated];

        return $currentPosition;
    }
}