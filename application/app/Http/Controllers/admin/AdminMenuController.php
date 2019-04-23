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
use \Redirect as Redirect;

class AdminMenuController extends \AdminBaseController {

    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
    {
        $menu = json_decode(Menu::orderBy('order', 'ASC')->get()->toJson());
        $user = Auth::user();

        $data = array(
            'menu' => $menu,
            'user' => $user,
            'admin_user' => Auth::user()
            );

        return View::make('admin.menu.index', $data);
    }

    public function store(){
        $input = Input::all();
        $last_menu_item = Menu::orderBy('order', 'DESC')->first();

        if(isset($last_menu_item->order)){
            $new_menu_order = intval($last_menu_item->order) + 1;
        } else {
            $new_menu_order = 1;
        }
        $input['order'] = $new_menu_order;
        $menu= Menu::create($input);
        if(isset($menu->id)){
            return Redirect::to('admin/menu')->with(array('note' => _i('Successfully Added New Menu Item'), 'note_type' => 'success') );
        }
    }

    public function edit($id){
        return View::make('admin.menu.edit', array('menu' => Menu::find($id)));
    }


    public function destroy($id){
        Menu::destroy($id);
        $child_menu_items = Menu::where('parent_id', '=', $id)->get();
        foreach($child_menu_items as $menu_items){
            $menu_items->parent_id = NULL;
            $menu_items->save();
        }
        return Redirect::to('admin/menu')->with(array('note' => _i('Successfully Deleted Menu Item'), 'note_type' => 'success') );
    }

    public function update(){
        $input = Input::all();
        $menu = Menu::find($input['id'])->update($input);
        if(isset($menu)){
            return Redirect::to('admin/menu')->with(array('note' => _i('Successfully Updated Category'), 'note_type' => 'success') );
        }
    }

    public function order(){
        $menu_item_order = json_decode(Input::get('order'));
        $post_categories = Menu::all();
        $order = 1;
        
        foreach($menu_item_order as $menu_level_1):
            
            $level1 = Menu::find($menu_level_1->id);
            if($level1->id){
                $level1->order = $order;
                $level1->parent_id = NULL;
                $level1->save();
                $order += 1;
            }
            
            if(isset($menu_level_1->children)):
            
                $children_level_1 = $menu_level_1->children;

                foreach($children_level_1 as $menu_level_2):

                    $level2 = Menu::find($menu_level_2->id);
                    if($level2->id){
                        $level2->order = $order;
                        $level2->parent_id = $level1->id;
                        $level2->save();
                        $order += 1;
                    }

                    if(isset($menu_level_2->children)):

                        $children_level_2 = $menu_level_2->children;


                        foreach($children_level_2 as $menu_level_3):

                            $level3 = Menu::find($menu_level_3->id);
                            if($level3->id){
                                $level3->order = $order;
                                $level3->parent_id = $level2->id;
                                $level3->save();
                                $order += 1;
                            }

                        endforeach;

                    endif;

                endforeach;

            endif;


        endforeach;

        return 1;
    }


}