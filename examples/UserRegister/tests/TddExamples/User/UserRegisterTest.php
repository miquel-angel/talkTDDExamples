<?php

namespace Test\TddExamples\User;

use TddExamples\User\InMemoryUserRepository;
use TddExamples\User\UserRegister;
use PHPUnit\Framework\TestCase;

class UserRegisterTest extends TestCase
{
    /**
     * @test
     */
    public function whenAlreadyExistTheUserShouldThrowExceptionInMemoryTestDouble()
    {
        // Arrange
        $inMemoryUserRepository = new InMemoryUserRepository();
        $inMemoryUserRepository->saveUser('miquel','password');
        $userRegister = new UserRegister($inMemoryUserRepository);

        // Assert
        $this->expectException('TddExamples\User\UserAlreadyExistException');
        $this->expectExceptionMessage('User with this name already exist in the system');

        // Act
        $userRegister->registerNewUser('miquel', 'ohterPass');
    }

    /**
     * @test
     */
    public function whenTheUserNotExistShouldSaveCorrectlyInMemoryTestDouble()
    {
        // Arrange
        $inMemoryUserRepository = new InMemoryUserRepository();
        $inMemoryUserRepository->saveUser('miquel','password');
        $userRegister = new UserRegister($inMemoryUserRepository);

        // Act
        $this->assertFalse($inMemoryUserRepository->existUser('newUsermiquel'));
        $result = $userRegister->registerNewUser('newUsermiquel', 'newPass');

        // Assert
        $this->assertTrue($result);
        $this->assertTrue($inMemoryUserRepository->existUser('newUsermiquel'));
    }

    /**
     * @test
     */
    public function whenAlreadyExistTheUserShouldThrowExceptionMockTestDouble()
    {
        // Arrange
        $userRepositoryMock = $this->getMockBuilder('TddExamples\User\UserRepository')
            ->getMock();
        $userRepositoryMock->expects($this->once())
            ->method('existUser')
            ->willReturn(true);
        $userRepositoryMock->expects($this->never())
            ->method('saveUser');
        $userRegister = new UserRegister($userRepositoryMock);


        // Assert
        $this->expectException('TddExamples\User\UserAlreadyExistException');
        $this->expectExceptionMessage('User with this name already exist in the system');

        // Act
        $userRegister->registerNewUser('miquel', 'pass');
    }

    /**
     * @test
     */
    public function whenOccursSomeErrorInSaveUserShouldReturnExceptionMockTestDouble()
    {
        // Arrange
        $userRepositoryMock = $this->getMockBuilder('TddExamples\User\UserRepository')
            ->getMock();
        $userRepositoryMock->expects($this->once())
            ->method('existUser')
            ->willReturn(false);
        $userRepositoryMock->expects($this->once())
            ->method('saveUser')
            ->willReturn(false);
        $userRegister = new UserRegister($userRepositoryMock);


        // Assert
        $this->expectException('\Exception');
        $this->expectExceptionMessage('Error when trying to save the new user in DB.');

        // Act
        $userRegister->registerNewUser('miquel', 'pass');
    }

    /**
     * @test
     */
    public function whenTheUserNotExistShouldSaveCorrectlyMockTestDouble()
    {
        // Arrange
        $userRepositoryMock = $this->getMockBuilder('TddExamples\User\UserRepository')
            ->getMock();
        $userRepositoryMock->expects($this->once())
            ->method('existUser')
            ->willReturn(false);
        $userRepositoryMock->expects($this->once())
            ->method('saveUser')
            ->willReturn(true);

        $userRegister = new UserRegister($userRepositoryMock);

        // Act
        $result = $userRegister->registerNewUser('newUsermiquel', 'newPass');

        // Assert
        $this->assertTrue($result);
    }
}
