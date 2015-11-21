Pullmail plugin for Kanboard (Based on Mailgun Plugin)
============================

Use your IMAP Mail account to create tasks directly by email

- Create tasks from incoming emails

Author
------

- Ralf Blumenthal
- License MIT

Installation
------------

- Create a folder **plugins/Pullmailtasks**
- Copy all files under this directory

Use your IMAP Mail account to create tasks
-------------------------------------------

Define those constants in your `config.php` file :

```php
// xxx
define('PMT_DOMAIN', 'imap.goneo.de:993/imap/ssl');
define('PMT_MSGBOX', 'INBOX');
define('PMT_USER', '');
define('PMT_PASWORD', '');


### Kanboard configuration

1. Be sure that your users have an email address in their profiles
2. Assign a project identifier to the desired projects: **Project settings > Edit**
3. Try to send an email to your project: kanboard+myprojectid:taskname@mydomain.tld

The sender email address must be same as the user profile in Kanboard and the user must be member of the project.
