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

use \Redirect as Redirect;
use App\Models\PostCategory;

class AdminPostCategoriesController extends \AdminBaseController {


    public function index(){
        $data = array(
            'admin_user' => Auth::user(),
            'post_categories' => json_decode(PostCategory::orderBy('order', 'ASC')->get()->toJson()),
            );

        return View::make('admin.posts.categories.index', $data);
    }

    public function store(){
        $input = Input::all();
        $last_category = PostCategory::orderBy('order', 'DESC')->first();

        if(isset($last_category->order)){
            $new_category_order = intval($last_category->order) + 1;
        } else {
            $new_category_order = 1;
        }
        $input['order'] = $new_category_order;
        $post_category = PostCategory::create($input);
        if(isset($post_category->id)){
            return Redirect::to('admin/posts/categories')->with(array('note' => _i('Successfully Added Your New Video Category'), 'note_type' => 'success') );
        }
    }

    public function update(){
        $input = Input::all();
        $category = PostCategory::find($input['id'])->update($input);
        if(isset($category)){
            return Redirect::to('admin/posts/categories')->with(array('note' => _i('Successfully Updated Category'), 'note_type' => 'success') );
        }
    }

    public function destroy($id){
        PostCategory::destroy($id);
        $child_cats = PostCategory::where('parent_id', '=', $id)->get();
        foreach($child_cats as $cats){
            $cats->parent_id = NULL;
            $cats->save();
        }
        return Redirect::to('admin/posts/categories')->with(array('note' => _i('Successfully Deleted Category'), 'note_type' => 'success') );
    }

    public function edit($id){
        return View::make('admin.posts.categories.edit', array('category' => PostCategory::find($id)));
    }

    public function order(){
        $category_order = json_decode(Input::get('order'));
        $post_categories = PostCategory::all();
        $order = 1;
        
        foreach($category_order as $category_level_1):
            
            $level1 = PostCategory::find($category_level_1->id);
            if($level1->id){
                $level1->order = $order;
                $level1->parent_id = NULL;
                $level1->save();
                $order += 1;
            }
            
            if(isset($category_level_1->children)):
            
                $children_level_1 = $category_level_1->children;

                foreach($children_level_1 as $category_level_2):

                    $level2 = PostCategory::find($category_level_2->id);
                    if($level2->id){
                        $level2->order = $order;
                        $level2->parent_id = $level1->id;
                        $level2->save();
                        $order += 1;
                    }

                    if(isset($category_level_2->children)):

                        $children_level_2 = $category_level_2->children;


                        foreach($children_level_2 as $category_level_3):

                            $level3 = PostCategory::find($category_level_3->id);
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
