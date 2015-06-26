<?php

class UserController extends \BaseController {
        public $userModel;
        
        public function __construct() {
            $this->userModel = new UserModel();
        }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('register');
	}
        
        public function showLoginForm() {
            return View::make('login');
        }
        public function login() {
            $data = Input::all();
            print_r($data);
            $errors = $this->userModel->loginUser($data);
            if(count($errors['errors']) > 0) {

                return Redirect::to('user/login')->withErrors($errors['errors'])->withInput();
            }
//            else {
//                return Redirect::to('/project');
//            }

        }
        
	public function store()
	{
                $data = Input::all();
                $errors = $this->userModel->createUser($data);
                if(count($errors['errors']) > 0) {
                    echo 'vliza';
                    return Redirect::to('user/create')->withErrors($errors['errors'])->withInput();
                }
                else {
                    return Redirect::to('/user/login');
                }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showEditForm()
	{
		return View::make('editProfile');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		echo 'Edited profile';
        $data = Input::all();
        $errors = $this->userModel->editUser($data);
        if(count($errors['errors']) > 0) {
            return Redirect::to('/user/edit')->withErrors($errors['errors']);
        } else {
            return Redirect::to('/project');
        }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function logout()
	{
		Session::flush();
        return Redirect::to('/user/login');
	}
}
