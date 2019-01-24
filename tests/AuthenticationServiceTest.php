<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:45
 */

namespace Tests;

use App\AuthenticationService;
use App\IProfileDao;
use App\ITokenDao;
use Mockery;
use PHPUnit\Framework\TestCase;

class AuthenticationServiceTest extends TestCase
{
    private $profile;
    private $token;

    protected function setUp()
    {
        parent::setUp();
        $this->profile = Mockery::mock(IProfileDao::class);
        $this->token = Mockery::mock(ITokenDao::class);
    }

    public function test_isValid()
    {
        $this->givenProfile('joey', '91');
        $this->givenToken('000000');

        $this->shouldBeValid('joey', '91000000');
    }

    protected function givenToken($token): void
    {
        $this->token->shouldReceive('getRandom')
            ->andReturn($token);
    }

    protected function shouldBeValid($account, $password): void
    {
        $target = new AuthenticationService($this->profile, $this->token);
        $actual = $target->isValid($account, $password);
        //always failed
        $this->assertTrue($actual);
    }

    protected function givenProfile($account, $password): void
    {
        $this->profile->shouldReceive('getPassword')
            ->with($account)
            ->andReturn($password);
    }
}
