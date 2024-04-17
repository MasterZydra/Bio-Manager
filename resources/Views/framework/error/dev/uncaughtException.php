<?php
/** @var Exception $exception */

use Framework\Facades\Http;
?>
<?= component('framework.error.header') ?>

Uncaught Exception in <code><?= $exception->getFile() ?>:<?= $exception->getLine() ?></code><br><br>

<h1>Message</h1>
<pre style="overflow: auto;"><?= $exception->getMessage() ?></pre>

<?php // Show potential solutions
if ((str_starts_with($exception->getMessage(), 'Table \'') && str_ends_with($exception->getMessage(), '\' doesn\'t exist')) ||
    (str_starts_with($exception->getMessage(), 'Unable to prepare statement: ') && str_contains($exception->getMessage(), ', no such table:'))
) { ?>
    <h1>Potential solution</h1>
    <p>You can try to run the <strong><code>migrate</code></strong> command.</p>

    <form action="<?= Http::requestUri() ?>" method="<?= Http::requestMethod() ?>">
        <input name="runCommand" type="hidden" value="migrate">
        <button>Run <strong><code>migrate</code></strong></button>
    </form><br>
<?php } ?>

<h1>Trace</h1>
<pre style="overflow: auto;"><?= trim($exception->getTraceAsString()) ?></pre>

<?= component('framework.error.footer') ?>
