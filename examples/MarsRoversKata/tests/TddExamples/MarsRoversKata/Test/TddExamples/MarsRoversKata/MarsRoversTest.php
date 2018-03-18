<?php
namespace Test\TddExamples\MarsRoversKata;

use PHPUnit\Framework\TestCase;

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
}
