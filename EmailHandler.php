<?php

namespace Kanboard\Plugin\Pullmailtasks;

use Kanboard\Core\Base;
use Kanboard\Core\Tool;
use Kanboard\Core\Mail\ClientInterface;

defined('PMT_DOMAIN') or define('PMT_DOMAIN', '');
defined('PMT_MSGBOX') or define('PMT_MSGBOX', '');
defined('PMT_USER') or define('PMT_USER', '');
defined('PMT_PASWORD') or define('PMT_PASWORD', '');

/**
 * Pull Mail Tasks
 *
  * @author   Ralf Blumenthal
  * @author   Frédéric Guillot
 */
class EmailHandler extends Base
{
	/* Fetch Mail*/
	public function pullEmail()
	{
		$res = array(0,0);
		$domain = '{' .PMT_DOMAIN. '}';
		$msgbox = PMT_MSGBOX;
		$user = PMT_USER;
		$password = PMT_PASWORD;

		$mbox = imap_open("{$domain}{$msgbox}", $user, $password)
			 or die("can't connect: " . imap_last_error());

		$mails = imap_search($mbox, 'SUBJECT "kanboard+"' );
		if ( ! empty($mails) ) {
			foreach( $mails as $num) {
				$header = imap_headerinfo( $mbox, $num );
//				echo "<pre>";var_dump($header);echo "</pre>";
				$body = imap_qprint(imap_body($mbox, $num));

                $subject = $header->subject; //kanboard+PROJECTID:subject

                list($target, $subject) = explode(':', $header->subject);
                list(, $identifier) = explode('+', $target);

                if ( ! empty($identifier) && ! empty($subject) ) {
                    $task = array(
                        'sender'=>$header->to[0]->mailbox.'@'.$header->to[0]->host,  // The sender email address must be same as the user profile in Kanboard and the user must be member of the project.
                        'subject'=>$subject,
                        'recipient'=>"kanboard+{$identifier}@pullmailtask.de",
                        'stripped-html'=>'',
                        'stripped-text'=>$body,
                    );
                    $r = $this->receiveEmail($task);
                    $res[$r?0:1]++;
                    if ( $r )
                        imap_delete($mbox,$num);
                }
			}
		}
        if ( $res[0]>0 )
		  imap_expunge ($mbox);
		imap_close($mbox);
		return $res;
	}


    /**
     * Parse incoming email
     *
     * @access public
     * @param  array   $payload   Incoming email
     * @author   Frédéric Guillot
     * @return boolean
     */
    public function receiveEmail(array $payload)
    {
        if (empty($payload['sender']) || empty($payload['subject']) || empty($payload['recipient'])) {
            return false;
        }

        // The user must exists in Kanboard
        $user = $this->user->getByEmail($payload['sender']);
        if (empty($user)) {
            $this->logger->debug('PullMailTasks: ignored => user not found');
            return false;
        }

        // The project must have a short name
        $project = $this->project->getByIdentifier(Tool::getMailboxHash($payload['recipient']));

        if (empty($project)) {
            $this->logger->debug('PullMailTasks: ignored => project not found');
            return false;
        }

        // The user must be member of the project
        if (! $this->projectPermission->isMember($project['id'], $user['id'])) {
            $this->logger->debug('PullMailTasks: ignored => user is not member of the project');
            return false;
        }

        // Get the Markdown contents
        if (! empty($payload['stripped-html'])) {
            $description = $this->htmlConverter->convert($payload['stripped-html']);
        }
        else if (! empty($payload['stripped-text'])) {
            $description = $payload['stripped-text'];
        }
        else {
            $description = '';
        }

        // Finally, we create the task
        return (bool) $this->taskCreation->create(array(
            'project_id' => $project['id'],
            'title' => $payload['subject'],
            'description' => $description,
            'creator_id' => $user['id'],
        ));
    }
}

