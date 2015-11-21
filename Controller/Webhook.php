<?php
//http://localhost/kanboard/?controller=Webhook&action=pullmail&plugin=Pullmailtasks
namespace Kanboard\Plugin\Pullmailtasks\Controller;

use Kanboard\Controller\Base;
use Kanboard\Plugin\Pullmailtasks\EmailHandler;

/**
 * Webhook Controller
 *
 */
class Webhook extends Base
{
    /**
     * Handle webhooks
     *
     * @access public
     */
    public function pullmail()
    {
//        $this->checkWebhookToken();

        $handler = new EmailHandler($this->container);
        $res =  $handler->pullEmail();
		echo  "{$res[0]} PARSED  {$res[1]} IGNORED";
    }
}
