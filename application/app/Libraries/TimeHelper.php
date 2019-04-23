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

class TimeHelper{

	public static function convert_seconds_to_HMS($seconds){
		if($seconds != 0){
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds / 60) % 60);
			$seconds = $seconds % 60;

			if($hours != 0){
				return $hours.':'.$minutes.':'.sprintf( '%02d', $seconds );
			} else {
				return $minutes.':'.sprintf( '%02d', $seconds );
			}
		}
	}

    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);


        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => _n('year', 'years', $diff->y),
            'm' => _n('month', 'months', $diff->m),
            'w' => _n('week', 'weeks', $diff->w),
            'd' => _n('day', 'days', $diff->d),
            'h' => _n('hour', 'hours', $diff->h),
            'i' => _n('minute', 'minutes', $diff->i),
            's' => _n('second', 'seconds', $diff->s),
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ' . _i('ago') : _i('just now');
    }

}