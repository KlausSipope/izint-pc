<?php declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\PropertyAccessTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class UserTest extends TestCase
{
    use PropertyAccessTrait;

    /**
     * @test
     *
     * @param array $data
     *
     * @dataProvider companyProvider
     *
     * @throws \ReflectionException
     */
    public function testCreateAProperInstance(array $data)
    {
        $instance = new User();
        $instance->setFirstName($data['firstName']);
        $instance->setLastName($data['lastName']);
        $instance->setDescription($data['description']);
        $instance->setSubscribed($data['subscribed']);
        $instance->setEmail($data['email']);
        $instance->setEmailCanonical($data['email']);
        $this->setProperty($instance, $data['id'], 'id');

        $this->assertEquals($data['firstName'], $instance->getFirstName());
        $this->assertEquals($data['lastName'], $instance->getLastName());
        $this->assertEquals($data['description'], $instance->getDescription());
        $this->assertEquals($data['subscribed'], $instance->isSubscribed());
        $this->assertEquals($data['id'], $instance->getId());
    }

    /**
     * @test
     *
     * @param array $data
     *
     * @dataProvider companyProvider
     *
     * @throws \ReflectionException
     */
    public function testToArray(array $data)
    {
        $instance = new User();
        $instance->setFirstName($data['firstName']);
        $instance->setLastName($data['lastName']);
        $instance->setDescription($data['description']);
        $instance->setSubscribed($data['subscribed']);
        $this->setProperty($instance, $data['id'], 'id');

        unset($data['email']);

        $this->assertEquals($data, $instance->toArray());
    }

    /**
     * @test
     *
     * @param array $data
     *
     * @dataProvider companyProvider
     */
    public function testToString(array $data)
    {
        $instance = new User();
        $instance->setEmail($data['email']);

        $this->assertEquals($data['email'], $instance->__toString());
    }

    /**
     * @see testCreateAProperInstance, testToArray, testToString
     *
     * @return array
     */
    public function companyProvider(): array
    {
        return [[[
            'id'          => 1,
            'email'       => 'test@test.com',
            'firstName'   => 'test',
            'lastName'    => 'test',
            'description' => 'test',
            'subscribed'  => false,
        ]]];
    }
}
