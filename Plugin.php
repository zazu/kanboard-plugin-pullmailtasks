<?php

namespace Kanboard\Plugin\Pullmailtasks;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

/**
 * Pull Mail Tasks Plugin
 *
  * @author   Ralf Blumenthal
 */
class Plugin extends Base
{
    public function initialize()
    {

        $this->on('session.bootstrap', function($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
        });

    }

    public function getPluginDescription()
    {
        return 'Pull Email-Tasks from IMAP Account';
    }

    public function getPluginAuthor()
    {
        return 'Ralf Blumenthal';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/zazu/kanboard-plugin-pullmailtask';
    }
}
