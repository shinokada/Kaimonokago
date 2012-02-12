<h2>Welcome to BackendPro</h2>

<p>Since your reading this it means BackendPro is setup and ready for you to
start to develop using it.</p>

<p>I won't go into a lot here but my best advise to start off with is just have a
play with the system before you think about writing code using it. Of course if you
want the full documentation on BackendPro just get it <a href="<?php print base_url()?>user_guide/index.html">here</a>.</p>

<p><b>My only real advice is be very carefull with member accounts and access control
permissions untill you understand them fully. Performing certain actions could lock you
out of your system.</b></p>

<p>So head over to the <?php print anchor('auth/login','login page')?> and get started. Currently you are
<?php
    if(is_user())
        print "<font color='green'><b>logged in</b></font>";
    else
        print "<font color='red'><b>logged out</b></font>";
?>.</p>