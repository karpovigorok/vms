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
use \App\User as User;
use \App\Libraries\ThemeHelper;

class AdminUsersController extends \AdminBaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function index()
	{
        $search_value = Input::get('s');
        
        if(!empty($search_value)):
            $users = User::where('username', 'LIKE', '%'.$search_value.'%')->orWhere('email', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
        else:
            $users = User::all();
        endif;

		$data = array(
			'users' => $users
			);
		return View::make('admin.users.index', $data);
	}

    public function create(){
        $data = array(
            'post_route' => URL::to('admin/user/store'),
            'admin_user' => Auth::user(),
            'button_text' => 'Create User',
            );
        return View::make('admin.users.create_edit', $data);
    }

    public function store(){
        $input = Input::all();
        if(Input::hasFile('avatar')){
            $input['avatar'] = ImageHandler::uploadImage(Input::file('avatar'), 'avatars');
        }
        else {
            $input['avatar'] = '';
        }
        $input['password'] = Hash::make('password');
        $user = User::create($input);
        return Redirect::to('admin/users')->with(array('note' => _i('Successfully Created New User'), 'note_type' => 'success') );
    }

	public function edit($id) {

        $settings = ThemeHelper::getSystemSettings();
    	$user = User::find($id);
    	$data = array(
    		'user' => $user,
    		'post_route' => URL::to('admin/user/update'),
    		'admin_user' => Auth::user(),
    		'button_text' => _i('Update User'),
            'default_avatar' => "/content/themes/" . $settings->theme . "/assets/images/avatar.png"
    		);

    	return View::make('admin.users.create_edit', $data);
    }

    public function update(){
    	$input = Input::all();
        $id = $input['id'];
        $user = User::find($id);

    	if(Input::hasFile('avatar')){
        	$input['avatar'] = ImageHandler::uploadImage(Input::file('avatar'), 'avatars');
        } else { $input['avatar'] = $user->avatar; }

        if(empty($input['active'])){
            $input['active'] = 0;
        }

        if($input['password'] == ''){
        	$input['password'] = $user->password;
        } else{ $input['password'] = Hash::make($input['password']); }

    	$user->update($input);
    	return Redirect::to('admin/user/edit/' . $id)->with(array('note' => _i('Successfully Updated User Settings'), 'note_type' => 'success') );
    }

    public function destroy($id)
    {

        User::destroy($id);
        return Redirect::to('admin/users')->with(array('note' => _i('Successfully Deleted User'), 'note_type' => 'success') );
    }

}