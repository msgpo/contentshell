<div id="headbar">
    <b>RACHEL <?php echo $lang['admin'] ?></b>
    <ul id="nav">
        <li><a href="admin.php"<?php if (isset($nav_admin)) { echo ' class="active"'; } ?>><?php echo $lang['modules'] ?></a></li>
        <li><a href="stats.php"<?php if (isset($nav_stats)) { echo ' class="active"'; } ?>><?php echo $lang['stats'] ?></a></li>
        <li><a href="version.php"<?php if (isset($nav_version)) { echo ' class="active"'; } ?>><?php echo $lang['version'] ?></a></li>
        <li><a href="update.php"<?php if (isset($nav_update)) { echo ' class="active"'; } ?>><?php echo $lang['update'] ?></a></li>
        <li><a href="login.php?logout=1"><?php echo $lang['logout'] ?></a></li>
    </ul>
    <div id="ip">
        <?php
            function showip () {
                global $lang;
                #-------------------------------------------
                # this is done as a function to enforce scope on $output
                #-------------------------------------------
                # some notes to prevent future regression:
                # the PHP suggested gethostbyname(gethostname())
                # brings back the unhelpful 127.0.0.1 on RPi systems,
                # as well as slowing down some Windows installations
                # with a DNS lookup. $_SERVER["SERVER_ADDR"] will just
                # display what's in the user's address bar, so also
                # not useful - using ifconfig/ipconfig is the way to go,
                # but requires system-specific tweaking
                #-------------------------------------------
                if (preg_match("/^win/i", PHP_OS)) {
                    # under windows it's ipconfig
                    # (though we're making windows static-only now)
                    $output = shell_exec("ipconfig");
                    preg_match("/IPv4 Address.+?: (.+)/", $output, $match);
                    if (isset($match[1])) { echo "<b>$lang[server_address]</b>: $match[1]\n"; }
                } else if (preg_match("/^darwin/i", PHP_OS)) {
                    # OSX is unix, but it's a little different
                    exec("/sbin/ifconfig", $output);
                    preg_match("/en0.+?inet (.+?) /", join("", $output), $match);
                    if (isset($match[1])) { echo "<b>$lang[server_address]</b>: $match[1]\n"; }
                } else {
                    # most likely linux based - so ifconfig should work
                    exec("/sbin/ifconfig", $output);
                    preg_match("/eth0.+?inet addr:(.+?) /", join("", $output), $match);
                    if (isset($match[1])) { echo "<b>LAN</b>: $match[1]\n"; }
                    preg_match("/wlan0.+?inet addr:(.+?) /", join("", $output), $match);
                    if (isset($match[1])) { echo "<br><b>WIFI</b>: $match[1]\n"; }
                }
            }
            showip();
        ?>
    </div>
</div>
