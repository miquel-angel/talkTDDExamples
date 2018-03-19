<?php
namespace Test\TddExamples\MarsRoversKata;

use PHPUnit\Framework\TestCase;
use TddExamples\MarsRoversKata\MarsRovers;

class MarsRoversTest extends TestCase
{
    /**
     * @var MarsRovers
     */
    private $marsRovers;

    protected function setUp()
    {
        $originalPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'N'
        ];
        $map = [
            ['.', '.', '.', '.'],
            ['.', '.', '.', '*'],
            ['.', '.', '.', '*'],
        ];

        $this->marsRovers = new MarsRovers($originalPosition, $map);
    }

    protected function tearDown()
    {
        $this->marsRovers = null;
    }

    /**
     * @test
     */
    public function whenWeNotPassAnyCommandShouldBeInInitialPosition()
    {
        // Arrange
        $expectedPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'N'
        ];

        // Act
        $status = $this->marsRovers->move('');

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasNotColisioned($status);
    }

    /**
     * @test
     */
    public function whenWeJustTurnRightShouldHasEastDirection()
    {
        // Arrange
        $expectedPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'E'
        ];
        $commands = 'R';

        // Act
        $status = $this->marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasNotColisioned($status);
    }

    /**
     * @test
     */
    public function whenWeJustTurnLeftShouldHasWestDirection()
    {
        // Arrange
        $expectedPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'W'
        ];
        $commands = 'L';

        // Act
        $status = $this->marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasNotColisioned($status);
    }

    /**
     * @test
     */
    public function whenWeMoveOnePositionToSudShouldIncreasedByOneX()
    {
        // Arrange
        $expectedPosition = [
            'x' => 1,
            'y' => 0,
            'direction' => 'N'
        ];
        $commands = 'B';

        // Act
        $status = $this->marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasNotColisioned($status);
    }

    public function whenWeMoveManyCommandsCorrectlyProvider()
    {
        return [
            'When we move one backward and turn left' => [
                'commands' => 'bl',
                'expectedPosition' => [
                    'x' => 1,
                    'y' => 0,
                    'direction' => 'W'
                ]
            ],
            'When we move to right and left we still facing north' => [
                'commands' => 'rl',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we move to 4 right we still facing north' => [
                'commands' => 'rrrr',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we move to 4 left we still facing north' => [
                'commands' => 'llll',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we turn right and move one we should update position correctly' => [
                'commands' => 'RF',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 1,
                    'direction' => 'E'
                ]
            ],
            'When we advance one back and one frond we should not move our position' => [
                'commands' => 'bf',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we move one front, we loop the world' => [
                'commands' => 'f',
                'expectedPosition' => [
                    'x' => 2,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we move three back, we loop the world' => [
                'commands' => 'bbb',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'N'
                ]
            ],
            'When we turn left and move one we loop the world' => [
                'commands' => 'lf',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 3,
                    'direction' => 'W'
                ]
            ],
            'When we turn right and move four we loop the world' => [
                'commands' => 'rffff',
                'expectedPosition' => [
                    'x' => 0,
                    'y' => 0,
                    'direction' => 'E'
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider whenWeMoveManyCommandsCorrectlyProvider
     */
    public function whenWeMoveManyCommandsCorrectly($commands, $expectedPosition)
    {
        // Act
        $status = $this->marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasNotColisioned($status);
    }

    /**
     * @test
     */
    public function whenWeFindAnObstacleInThePathShouldStopMovingAndReturnFalse()
    {
        // Arrange
        $expectedPosition = [
            'x' => 1,
            'y' => 2,
            'direction' => 'E'
        ];
        $commands = 'RRfLffffff';

        // Act
        $status = $this->marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $this->marsRovers->getCurrentPosition());
        $this->assertMarsRoversHasColisioned($status);
    }

    private function assertMarsRoversHasNotColisioned($status)
    {
        $this->assertTrue($status, 'If the mars rovers doesn\'t find any obstacle, should return true');
    }

    private function assertMarsRoversHasColisioned($status)
    {
        $this->assertFalse($status, 'If the mars rovers find any obstacle, should return false');
    }
}
