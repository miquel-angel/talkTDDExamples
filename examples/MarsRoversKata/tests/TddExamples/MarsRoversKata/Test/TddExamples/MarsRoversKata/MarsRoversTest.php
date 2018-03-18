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
        $map = [];

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

    private function assertMarsRoversHasNotColisioned($status)
    {
        $this->assertTrue($status, 'If the mars rovers doesn\'t find any obstacle, should return true');
    }
}
