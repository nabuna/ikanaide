<div class="profile-wrapper">
    <div class="profile_left-column">
        <img src="<?=$userInfo['pfp']?>" alt="<?=$userInfo['username']?>">

            <?php

            if (isset($_COOKIE["session"], $_COOKIE["username"])) {
                if ($_COOKIE['session'] === 'Yes' && $_COOKIE['username'] === $userInfo['username']) {
                    ?>
                     <section class="profile_left-column_buttons">
                        <form action="" method="post">
                            <button type="button" id="user-post_button" class="list-submit submit-button__colorful box">Make a post</button>
                            <input class="list-submit box submit-button__colorful" type="submit" value="Edit profile">
                        </form>
                     </section>
                    <?php
                }
            }

            ?>


        <section class="profile_user-info box-wrapper">
            <div class="box-title">
                <h3><?=$userInfo['username']?></h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <li><span class="ul_first-column">anime</span><span><?=count($animelist)?></span></li>
                    <li><span class="ul_first-column">manga</span><span><?=count($mangalist)?></span></li>
                    <li><span class="ul_first-column">reviews</span><span>0</span></li>
                    <li><span class="ul_first-column">posts</span><span>0</span></li>
                </ul>
            </div>
        </section>

        <section class="profile_user-following box-wrapper">
            <div class="box-title">
                <h3>Social</h3>
            </div>
            <div class="box-body">
                <ul class="two-column-list">
                    <li><span class="ul_first-column">following</span><span>0</span></li>
                    <li><span class="ul_first-column">followers</span><span>0</span></li>
                </ul>
            </div>
        </section>
        <?php

        // Comprobación de los campos que contienen un link. Si existe al menos uno, se creará la sección con los links que han sido asignados por el usuario.
        if (!empty($userInfo['twitter']) || !empty($userInfo['github']) || !empty($userInfo['discord']) || !empty($userInfo['website'])) {
            ?>
            <section class="profile_user-links two-column-list box-wrapper">
                <div class="box-title">
                    <h3>Links</h3>
                </div>
                <div class="box-body">
                    <ul class="two-column-list">
                        <?php

                        $possibleLinks = ['twitter', 'github', 'discord', 'website'];
                        foreach ($possibleLinks as $link) {
                            if (!empty($userInfo[$link])) {
                                ?><li><span class="ul_first-column"><?=$link?></span><span><?=$userInfo[$link]?></span></li><?php
                            }
                        }

                        ?>

                    </ul>
                </div>
            </section>
            <?php
        }

        // Comprobación de los campos que contienen información sobre fechas. Si existe al menos uno, se creará la sección con las fechas  que han sido asignadas por el usuario.
        if (!empty($userInfo['country']) || !empty($userInfo['born']) || !empty($userInfo['joined_at'])) {
            ?>
            <section class="profile_user-data two-column-list box-wrapper">
                <div class="box-title">
                    <h3>Information</h3>
                </div>
                <div class="box-body">
                    <ul class="two-column-list">
                        <?php

                        if (!empty($userInfo['country'])) {
                            ?><li><span class="ul_first-column">from</span><span><?=$userInfo['country']?></span></li><?php
                        }
                        if (!empty($userInfo['born'])) {
                            ?><li><span class="ul_first-column">born</span><span><?=lcfirst(dateFormat(substr($userInfo['born'], 0, 10)))?></span></li><?php
                        }
                        if (!empty($userInfo['joined_at'])) {
                            ?><li><span class="ul_first-column">joined</span><span><?=lcfirst(dateFormat(substr($userInfo['joined_at'], 0, 10)))?></span></li><?php
                        }

                        ?>

                    </ul>
                </div>
            </section>
            <?php
        }

        ?>

    </div>
    <div class="profile_right-column">
        <?php
        if (isset($userInfo['header'])) {
            ?><img src="<?=$userInfo['header']?>" alt="<?=$userInfo['username']?>"><?php
        }

        ?>

        <nav class="profile_user-nav box-wrapper box-title">
            <ul class="profile_user-nav_ul">
                <?php

                // Este bloque de código muestra un menú de navegación que dinamiza la clase .current en torno a la URI actual.
                // He añadido dos condiciones específicas para 'overview' ya que pretendo mostrar esa pestaña por defecto en la URI '/profile' y no '/profile/overview' (lo cual se generaría sin estas dos condiciones).
                $nav = ['overview', 'animelist', 'mangalist', 'reviews', 'favorites'];
                for ($i=0; $i < count($nav); $i++) {

                    if ($nav[$i] === 'overview' && $page === '/'.$username) {
                        print "<a href='/".$username."'><li class='current'>$nav[$i]</li></a>";
                    } else if ($page === '/'.$username.'/'.$nav[$i]) {
                        print "<a href='/".$username."/".$nav[$i]."'><li class='current'>$nav[$i]</li></a>";
                    } else if ($nav[$i] === 'overview' && $page !== '/'.$username) {
                        print "<a href='/".$username."'><li>$nav[$i]</li></a>";
                    } else {
                        print "<a href='/".$username."/" . $nav[$i] . "'><li>$nav[$i]</li></a>";
                    }

                }
                
                ?>
            </ul>
        </nav>
        <?php

        switch($uri) {
            case '/'.$username:
                require('resources/views/user/_overviewprofile.view.php');
                break;
            case '/'.$username.'/animelist':
            case '/'.$username.'/mangalist':
                require('resources/views/user/_listsprofile.view.php');
                break;
            case '/'.$username.'/reviews':
                require('resources/views/user/_reviewsprofile.view.php');
                break;
            case '/'.$username.'/favorites':
                require('resources/views/user/_favoritesprofile.view.php');
                break;
        }
        
        ?>
    </div>
</div>

<section id="user_post-wrapper">
    <div class="box-wrapper">
        <div class="box-title"><h3>Make a post</h3></div>
        <div class="box-body">
            <form action="/post" method="post">
                <label for="post-content">This post will appear in your profile and your followers time line.</label>
                <textarea name="post-content" id="post-content" autocomplete="off" required></textarea>
                <hr id="user_post_fields-separator">
                    <div class="user_post_fields-buttons">
                        <button type="button" id="user-post_cancel" class="submit-button__colorful box">Cancel</button>
                        <input class="submit-button__colorful box" type="submit" name='post' value="Post">
                    </div>
            </form>
        </div>
    </div>
</section>

<script !src="">
    let modal = document.getElementById('user_post-wrapper');
    let btn = document.getElementById('user-post_button');
    let cancelBtn = document.getElementById('user-post_cancel');

    btn.addEventListener('click', function() {
        modal.style.display = "block";
    })

    cancelBtn.addEventListener('click', function() {
        modal.style.display = "none";
    })

</script>