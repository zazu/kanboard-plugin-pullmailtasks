Pullmail plugin for Kanboard
============================
(Based on Mailgun Plugin)

Use your IMAP Mail account to create tasks directly by email

- Create tasks from incoming emails sent to a mailbox

Basically only makes sense for personal installations since one specific mailbox is used.

Incoming Mails for Kanboard are identified using the mails subject: kanboard+projectid:taskname
Mails are deleted after task creation.


Developed using Kanboard Version: 1.0.20
http://kanboard.net/

Author
------

- Ralf Blumenthal
- License MIT

Installation
------------

- Create a folder **plugins/Pullmailtasks**
- Copy all files under this directory
- php-imap extension required
- Setup a cron job calling the URL to pull mail task (http://name.tld/kanboard/?controller=Webhook&action=pullmail&plugin=Pullmailtasks)

Plugin Setup
-------------------------------------------

Define those constants in your `config.php` file :

```php
// System name, port and flags
define('PMT_DOMAIN', 'imap.goneo.de:993/imap/ssl');
// Mailbox name
define('PMT_MSGBOX', 'INBOX');
// Username and password
define('PMT_USER', '');
define('PMT_PASWORD', '');
```

### Kanboard configuration

1. Be sure that your users have an email address in their profiles
2. Assign a project identifier to the desired projects: **Project settings > Edit**
3. Send an email to your project using the mail subject: kanboard+myprojectid:taskname
4. Pull mail by calling http://name.tld/kanboard/?controller=Webhook&action=pullmail&plugin=Pullmailtasks

The mailbox email address must be same as the user profile in Kanboard and the user must be member of the project.
