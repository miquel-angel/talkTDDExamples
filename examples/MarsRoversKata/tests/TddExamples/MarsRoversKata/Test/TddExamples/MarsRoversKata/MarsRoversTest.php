<?php
namespace Test\TddExamples\MarsRoversKata;

use PHPUnit\Framework\TestCase;
use TddExamples\MarsRoversKata\MarsRovers;

class MarsRoversTest extends TestCase
{
    /**
     * @test
     */
    public function whenWeNotPassAnyCommandShouldBeInInitialPosition()
    {
        // Arrange
        $originalPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'N'
        ];
        $expectedPosition = $originalPosition;
        $map = [];
        $marsRovers = new MarsRovers($originalPosition, $map);

        // Act
        $status = $marsRovers->move('');

        // Assert
        $this->assertSame($expectedPosition, $marsRovers->getCurrentPosition());
        $this->assertTrue($status, 'If the mars rovers doesn\'t find any obstacle, should return true');
    }

    /**
     * @test
     */
    public function whenWeJustTurnRightShouldHasEastDirection()
    {
        // Arrange
        $originalPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'N'
        ];
        $expectedPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'E'
        ];
        $map = [];
        $marsRovers = new MarsRovers($originalPosition, $map);
        $commands = 'R';

        // Act
        $status = $marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $marsRovers->getCurrentPosition());
        $this->assertTrue($status, 'If the mars rovers doesn\'t find any obstacle, should return true');
    }

    /**
     * @test
     */
    public function whenWeJustTurnLeftShouldHasWestDirection()
    {
        // Arrange
        $originalPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'N'
        ];
        $expectedPosition = [
            'x' => 0,
            'y' => 0,
            'direction' => 'W'
        ];
        $map = [];
        $marsRovers = new MarsRovers($originalPosition, $map);
        $commands = 'L';

        // Act
        $status = $marsRovers->move($commands);

        // Assert
        $this->assertSame($expectedPosition, $marsRovers->getCurrentPosition());
        $this->assertTrue($status, 'If the mars rovers doesn\'t find any obstacle, should return true');
    }
}
