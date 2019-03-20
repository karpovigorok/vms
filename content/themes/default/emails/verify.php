<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2><?php echo _i('Verify Your Email Address');?></h2>

        <div>
            <?php echo _i('Thanks for creating an account with %s.
            Please follow the link below to verify your email address', $website_name);?>
            <?php echo URL::to('verify/' . $activation_code) ?>.<br/>
        </div>
    </body>
</html>