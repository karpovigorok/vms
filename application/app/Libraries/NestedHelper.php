<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php

class NestedHelper{

	public static function get_children_from_id($list, $id){
		$new_array = array();
		foreach($list as $item):
			if($item->parent_id == $id):
				array_push($new_array, $item);
			endif;
		endforeach;

		return $new_array;
	}

	public static function get_children_from_id_and_remove_from_list(&$list, $id){
		$new_array = array();
		foreach($list as $key => $item):
			if($item->parent_id == $id):
				unset($list[$key]);
				array_push($new_array, $item);
			endif;
		endforeach;

		return $new_array;
	}

	public static function pop_element_off_nest_from_id(&$list, $id){
		foreach($list as $key => $item):
			if($item->id == $id):
				unset($list[$key]);
			endif;
		endforeach;

	}

}