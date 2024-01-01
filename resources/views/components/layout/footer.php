<?php use Framework\Authentication\Auth; ?>
</main>

<footer>
    <a href="imprint">Impressum</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if (Auth::isLoggedIn()) {
        ?><a href="about">Systeminformationen</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php
    } ?>
    &copy; David Hein
</footer>

</body>

</html>
