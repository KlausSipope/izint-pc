<?php declare(strict_types=1);

namespace App\Tests\Service\Mailer;

use App\Entity\Company;
use App\Tests\PropertyAccessTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class CompanyTest extends TestCase
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
        $instance = new Company();
        $instance->setName($data['name']);
        $this->setProperty($instance, $data['id'], 'id');

        $this->assertEquals($data['name'], $instance->getName());
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
        $instance = new Company();
        $instance->setName($data['name']);
        $this->setProperty($instance, $data['id'], 'id');

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
        $instance = new Company();
        $instance->setName($data['name']);

        $this->assertEquals($data['name'], $instance->__toString());
    }

    /**
     * @see testCreateAProperInstance, testToArray, testToString
     *
     * @return array
     */
    public function companyProvider(): array
    {
        return [[['id' => 1, 'name' => 'test']]];
    }
}
