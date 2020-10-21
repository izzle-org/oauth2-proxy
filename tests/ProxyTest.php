<?php

use Illuminate\Support\Str;

class ProxyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanRedirectToAuth()
    {
        $this->get(route('proxy.redirect', []));
        $this->assertResponseStatus(422);

        $this->get(route('proxy.redirect', ['redirect_uri' => 'http://localhost']));
        $this->assertResponseStatus(422);

        $params = [
            'redirect_uri' => 'http://localhost',
            'state' => Str::random(40),
            'scope' => 'profile phone'
        ];

        $this->get(route('proxy.redirect', $params));
        $this->assertResponseStatus(302);
    }
}
