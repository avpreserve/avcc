<div>Hi <b><?php echo $user->getName(); ?></b>,</div>
<br/>

Your AVCC account has been created by <?php echo $admin; ?> (<?php echo $admin_email; ?>). <br />

Your Account Info:
<br />
<b>Username: </b><?php echo $user->getUsername(); ?><br />
<b>Password: </b><?php echo $password; ?><br />

Login now <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a>
<br/><br/>
<div>AVCC-team</div>