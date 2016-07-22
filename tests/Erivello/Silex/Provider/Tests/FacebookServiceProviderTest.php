<?php

namespace Erivello\Silex\Tests;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Erivello\Silex\Provider\FacebookServiceProvider;
use Facebook;

class FacebookServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $app = new Application();

        $app->register(new FacebookServiceProvider(), array(
            'facebook.apps' => array(
                'test' => array(
                    'facebook.app_id' => '12345',
                    'facebook.secret' => '67890',
                ),
                'foo' => array(
                    'facebook.app_id' => '54321',
                    'facebook.secret' => '09876',
                ),
            ),
        ));

        $app->get('/', function () use ($app) {
            $app['facebook_test'];
            $app['facebook_foo'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $this->assertTrue($app['facebook_test'] instanceof Facebook\Facebook);
        $this->assertEquals($app['facebook_test']->getApp()->getId(), '12345');
        $this->assertEquals($app['facebook_test']->getApp()->getSecret(), '67890');
        // $this->assertEquals($app['facebook_test']->getAccessToken(), '12345|67890');

        $this->assertTrue($app['facebook_foo'] instanceof Facebook\Facebook);
        $this->assertEquals($app['facebook_foo']->getApp()->getId(), '54321');
        $this->assertEquals($app['facebook_foo']->getApp()->getSecret(), '09876');
        // $this->assertEquals($app['facebook_foo']->getAccessToken(), '54321|09876');
    }
}
