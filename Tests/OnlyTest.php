<?php
/**
 * PHP Unit Test Case
 */
namespace Pentagonal\PhPass\Tests;

use Pentagonal\PhPass\PasswordHash;

/**
 * Class OnlyTest
 * @package Pentagonal\PhPass\Tests
 */
class OnlyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Constant
     */
    const HASH_PREFIX = '$2a$';
    const HASH_PORTABLE_PREFIX = '$P$';
    const STORED_PLAIN_VALID = 'string';
    const STORED_PLAIN_INVALID = 'invalid';
    const STORED_HASH = '$2a$08$mNxdFMzB2GeCrotHAgviA.3OjkRMtm2b6c5i/Byx6JJqJwB6liJEG';
    const STORED_PORTABLE = '$P$B9ONMngc6ZoLbAyfpsTnxP1gxs7atD1';

    public function testCorrectHashWithCreate()
    {
        $passwordHash  = new PasswordHash(8, false);
        $hashedString  = $passwordHash->HashPassword(self::STORED_PLAIN_VALID);
        /**
         * Asserting true
         */
        $this->assertTrue(
            $passwordHash->checkPassword(self::STORED_PLAIN_VALID, $hashedString)
        );
    }

    public function testCorrectHashWithStored()
    {
        $hash  = new PasswordHash(8, false);
        /**
         * Asserting true
         */
        $this->assertTrue(
            $hash->checkPassword(self::STORED_PLAIN_VALID, self::STORED_HASH)
        );
    }

    public function testIncorrectHashWithCreate()
    {
        $passwordHash  = new PasswordHash(8, false);
        $hashedString  = $passwordHash->HashPassword(self::STORED_PLAIN_VALID);
        /**
         * Asserting false
         */
        $this->assertFalse(
            $passwordHash->checkPassword(self::STORED_PLAIN_INVALID, $hashedString)
        );
    }

    public function testIncorrectHashWithStored()
    {
        $passwordHash  = new PasswordHash(8, false);
        /**
         * Asserting false
         */
        $this->assertFalse(
            $passwordHash->checkPassword(self::STORED_PLAIN_INVALID, self::STORED_HASH)
        );
    }

    public function testCorrectPortableHashWithCreate()
    {
        $passwordHash  = new PasswordHash(8, true);
        $hashedString  = $passwordHash->HashPassword(self::STORED_PLAIN_VALID);
        /**
         * Asserting true
         */
        $this->assertTrue(
            $passwordHash->checkPassword(self::STORED_PLAIN_VALID, $hashedString)
        );
    }

    public function testCorrectPortableHashWithStored()
    {
        $passwordHash  = new PasswordHash(8, true);
        /**
         * Asserting true
         */
        $this->assertTrue(
            $passwordHash->checkPassword(self::STORED_PLAIN_VALID, self::STORED_PORTABLE)
        );
    }

    public function testIncorrectPortableHashWithCreate()
    {
        $passwordHash  = new PasswordHash(8, true);
        $hashedString  = $passwordHash->HashPassword(self::STORED_PLAIN_VALID);
        /**
         * Asserting false
         */
        $this->assertFalse(
            $passwordHash->checkPassword(self::STORED_PLAIN_INVALID, $hashedString)
        );
    }

    public function testIncorrectPortableHashWithStored()
    {
        $passwordHash  = new PasswordHash(8, true);
        /**
         * Asserting false
         */
        $this->assertFalse(
            $passwordHash->checkPassword(self::STORED_PLAIN_INVALID, self::STORED_PORTABLE)
        );
    }

    public function testContainsAndStartHash()
    {
        $passwordHash  = new PasswordHash(8, false);
        $portablePasswordHash  = new PasswordHash(8, true);

        $hash = $passwordHash->HashPassword(self::STORED_PLAIN_VALID);
        $hashPortable = $portablePasswordHash->HashPassword(self::STORED_PLAIN_VALID);

        $this->assertContains(self::HASH_PREFIX, $hash);
        $this->assertContains(self::HASH_PORTABLE_PREFIX, $hashPortable);
        $this->assertStringStartsWith(self::HASH_PREFIX, $hash);
        $this->assertStringStartsWith(self::HASH_PORTABLE_PREFIX, $hashPortable);
    }
}
