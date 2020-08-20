<?php
namespace Tests;
use Mockery;
use Mockery\LegacyMockInterface;
use PHPUnit\Framework\TestCase;
use Project\Components\Session;
use Project\Exceptions\UserLoginException;
use Project\Models\UserModel;
use Project\Repositories\UserRepository;
use Project\Services\UserService;
use Project\Structures\UserLoginItem;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    /**
     * @var LegacyMockInterface|Mockery\MockInterface|Session
     */
    private $mockSession;
    /**
     * @var LegacyMockInterface|Mockery\MockInterface|UserRepository
     */
    private $mockRepository;
    public function setUp(): void
    {
        parent::setUp();
        $this->mockSession = Mockery::mock(Session::class);
        $this->mockRepository = Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->mockRepository, $this->mockSession);
    }
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    public function testSignOut()
    {
        $this->mockSession->shouldReceive('destroy')->once();
        $this->userService->signOut();
        self::expectNotToPerformAssertions();
    }
    public function testSignIn_withMissingEmail_fail()
    {
        $loginItem = new UserLoginItem();
        $loginItem->email = '';
        $loginItem->password = 'password';

        self::expectException(UserLoginException::class);
        //self::expectExceptionMessage('Email or password missing');
        $this->userService->signIn($loginItem);
    }

    public function testSignIn_withUnknownUser_fail()
    {
        $loginItem = new UserLoginItem();
        $loginItem->email = 'test@test.com';
        $loginItem->password = 'password';

        $this->mockRepository->shouldReceive('getUserByEmail')->andReturnNull()->once();
        self::expectException(UserLoginException::class);
       // self::expectExceptionMessage('Email or password is invalid');
        $this->userService->signIn($loginItem);
    }

    public function testSignIn_withWrongPassword_fail()
    {
        $loginItem = new UserLoginItem();
        $loginItem->email = 'test@test.com';
        $loginItem->password = 'password';

        $user = new UserModel();
        $user->password =  password_hash('wrong-password', PASSWORD_DEFAULT);

        $this->mockRepository->shouldReceive('getUserByEmail')->andReturn($user)->once();
        self::expectException(UserLoginException::class);
       // self::expectExceptionMessage('Email or password is invalid');
        $this->userService->signIn($loginItem);
    }

    public function testSignIn_withValidEmailAndPassword_succeed()
    {
        $loginItem = new UserLoginItem();
        $loginItem->email = 'test@test.com';
        $loginItem->password = 'whateveer';

        $user = new UserModel();
        $user->password =  password_hash($loginItem->password, PASSWORD_DEFAULT);

        $this->mockRepository->shouldReceive('getUserByEmail')->andReturn($user)->once();

        $this->mockSession->shouldReceive('regenerate')->once();
        $this->mockSession->shouldReceive('set')->once();

        $result = $this->userService->signIn($loginItem);
        // self::expectExceptionMessage('Email or password is invalid');
        self::assertEquals($result, $user);
    }
}