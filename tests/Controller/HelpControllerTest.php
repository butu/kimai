<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller;

/**
 * @coversDefaultClass \App\Controller\HelpController
 * @group integration
 */
class HelpControllerTest extends ControllerBaseTest
{
    public function testIsSecure()
    {
        $this->assertUrlIsSecured('/help/');
    }

    public function testReadmePage()
    {
        $client = $this->getClientForAuthenticatedUser();
        $this->request($client, '/help/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('<h1 id="kimai-documentation">Kimai documentation</h1>', $client->getResponse()->getContent());
        $this->assertContains('<a href="configurations">', $client->getResponse()->getContent());
        $this->assertContains('<a href="developers">', $client->getResponse()->getContent());
        $this->assertContains('<a href="users">', $client->getResponse()->getContent());
    }

    public function testUsersPage()
    {
        $client = $this->getClientForAuthenticatedUser();
        $this->request($client, '/help/users');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('<a href="/en/help/">Back</a>', $client->getResponse()->getContent());
    }

    public function testMissingPage()
    {
        $client = $this->getClientForAuthenticatedUser();
        $this->request($client, '/help/foo');
        $this->assertFalse($client->getResponse()->isSuccessful());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testValidateRouteDoesNotAllowSpecialChars()
    {
        $client = $this->getClientForAuthenticatedUser();
        $this->request($client, '/help/.users');
        $this->assertRouteNotFound($client);
    }
}
