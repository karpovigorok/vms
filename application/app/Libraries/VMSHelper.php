<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php
namespace App\Libraries;
class VMSHelper {

    /**
     * convert multy array to coma separated string
     */

    public static function convert_multi_array($array) {
        return implode(", ",array_map(function($a) {return implode(", ",$a);},$array));
    }
}
