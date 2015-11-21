<h3><img src="<?= $this->url->dir() ?>plugins/Pullmailtasks/mailgun-icon.png"/>&nbsp;PullMailTasks</h3>
<div class="listing">
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('webhook', 'receiver', array('plugin' => 'mailgun', 'token' => $values['webhook_token']), false, '', true) ?>"/><br/>
    <p class="form-help"><a href="https://github.com/zazu/kanboard-plugin-pullmailtasks" target="_blank"><?= t('Help on Pull Mail Tasks Plugin') ?></a></p>
</div>
