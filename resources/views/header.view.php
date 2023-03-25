<header>
    <div class="inner-header">
        <a href="/"><p id="header-logo">ikanaide</p></a>
        <ul class="header-links">
            <?php
                $nav = ['home', 'anime', 'manga', 'rankings', 'community'];
                for ($i=0; $i < count($nav); $i++) {
                    // $page comes from /index.php (it stores the current URI).
                    if ($nav[$i] === substr($page, 1, strlen($page))) {
                        print "<a href='/".$nav[$i]."'><li class='current'>$nav[$i]</li></a>";
                    } else {
                        print "<a href='/".$nav[$i]."'><li>$nav[$i]</li></a>";
                    }
                }
            ?>
        </ul>
        <div class="header-user">
            <?php

            // La cookie 'session' es generada en User::login() o User::register().
            if (!isset($_COOKIE['session'])) {
                ?>
                <ul class="header-user-ul">
                    <a href="/login"><li>Sign in</li></a>
                    <a href="/register"><li>Sign up</li></a>
                </ul>
                <?php
            } else {
                if ($_COOKIE['session'] === "Yes") {
                    ?>
                    <ul class="header-user-ul">
                        <a href="/profile"><li><?=$_COOKIE['username']?></li></a>
                    </ul>
                    <?php
                }
            }

            ?>
        </div>
    </div>
</header>