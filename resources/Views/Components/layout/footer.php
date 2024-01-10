<?php use Framework\Authentication\Auth; ?>
</main>

<footer>
    <a href="imprint"><?= __('Imprint') ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if (Auth::isLoggedIn()) {
        ?><a href="about">Systeminformationen</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php
    } ?>
    &copy; <?= date("Y") ?> David Hein
</footer>

</body>

</html>
