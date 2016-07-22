<?php

/*
 * This file is part of FacebookServiceProvider.
 *
 * (c) Edoardo Rivello <edoardo.rivello@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Erivello\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Facebook;

/**
 * Facebook Provider.
 *
 * @author Edoardo Rivello <edoardo.rivello@gmail.com>
 */
class FacebookServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app->before(function () use ($app) {
            foreach ($app['facebook.apps'] as $label => $facebookApp) {
                $app['facebook_'.$label] = $app->share(function () use ($facebookApp) {
                    return new Facebook\Facebook(array(
                        'app_id' => $facebookApp['facebook.app_id'],
                        'app_secret' => $facebookApp['facebook.secret'],
                        'default_graph_version' => 'v2.6',
                    ));
                });
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }
}
