<?php declare(strict_types=1);

namespace App\Tests\Service\Mailer;

use App\Exception\MissingMandatoryFieldException;
use App\Service\Mailer\ContactMailer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class ContactMailerTest extends TestCase
{
    /**
     * @var \Swift_Mailer|MockObject
     */
    private $mailer;

    /**
     * @var ContactMailer
     */
    private $instance;

    protected function setUp()
    {
        $this->mailer = $this->createMock(\Swift_Mailer::class);
        $this->instance = new ContactMailer($this->mailer, 'test@test.com', '', '');

        parent::setUp();
    }

    /**
     * @test
     *
     * @throws MissingMandatoryFieldException
     */
    public function testSendingAnEmailWithMissingMandatoryField()
    {
        $this->expectException(MissingMandatoryFieldException::class);
        $this->expectExceptionMessage('The given data has a mandatory field missing: firstName');

        $this->instance->send(['email' => 'test@test.com']);
    }

    /**
     * @test
     *
     * @throws MissingMandatoryFieldException
     */
    public function testSendingAnEmailSuccessfully()
    {
        $this->mailer->expects($this->once())->method('send')->willReturn(1);

        $result = $this->instance->send([
            'email'     => 'test@test.com',
            'lastName'  => 'test',
            'firstName' => 'test',
            'message'   => 'test',
        ]);

        $this->assertEquals(1, $result);
    }
}
