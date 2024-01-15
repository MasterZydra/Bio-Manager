<?= component('framework.error.header') ?>

Uncaught error no. <?= $errno ?> in <code><?= $errfile ?>:<?= $errline ?></code><br><br>

<h1>Message</h1>
<pre style="overflow: auto;"><?= htmlspecialchars($errstr) ?></pre>

<?php if ($errcontext !== null) { ?>
    <h1>Context</h1>
    <pre style="overflow: auto;"><?= implode(PHP_EOL, $errcontext) ?></pre>
<?php } ?>

<?= component('framework.error.footer') ?>
