<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 07:43
 */

namespace App {

    class AuthenticationService
    {
        private $profileDao;
        private $tokenDao;

        public function __construct(IProfileDao $profile = null, ITokenDao $token = null)
        {
            $this->tokenDao = $token ?? new RsaTokenDao();
            $this->profileDao = $profile ?? new ProfileDao();
        }

        public function isValid($account, $password)
        {
            // 根據 account 取得自訂密碼
            $passwordFromDao = $this->profileDao->getPassword($account);
            // 根據 account 取得 RSA token 目前的亂數
            $randomCode = $this->tokenDao->getRandom($account);

            var_dump($randomCode);

            // 驗證傳入的 password 是否等於自訂密碼 + RSA token亂數
            $validPassword = $passwordFromDao . $randomCode;
            $isValid = $password === $validPassword;

            if ($isValid) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    class ProfileDao implements IProfileDao
    {
        public function getPassword($account)
        {
            return Context::getPassword($account);
        }
    }

    class RsaTokenDao implements ITokenDao
    {
        public function getRandom($account)
        {
            return sprintf('%06d', mt_rand(0, 999999));
        }
    }

    class Context
    {
        public static $profiles = [
            'joey' => '91',
            'mei' => '99',
        ];

        public static function getPassword($key)
        {
            return static::$profiles[$key];
        }
    }
}
