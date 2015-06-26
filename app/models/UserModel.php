<?php
class UserModel {
    const emailRegex = 'required|regex:/[A-z-_.0-9]+@[A-z-_0-9]+.[A-z]{1,5}$/';
    const usernameRegex = 'required|regex:/[A-z0-9_]{4,10}$/';
    const passwordRule = 'required|min:6|max:100';
    const repeatPassword = 'required|same:user-password';
    
    public function createUser($data) {
        $rule = array('user-name' => self::usernameRegex,
                  'user-email' => self::emailRegex,
                  'user-password' => self::passwordRule,
                  'user-repeat-password' => self::repeatPassword
            );
        $validator = Validator::make(
            $data, 
            array('user-name' => self::usernameRegex,
                  'user-email' => self::emailRegex,
                  'user-password' => self::passwordRule,
                  'user-repeat-password' => self::repeatPassword
            )
        );
        if($validator->fails()) {
//
            return array('errors' => $validator);
        }
        else {
            $query = DB::select('SELECT * FROM users WHERE user_name=?', array($data['user-name']));
            if(count($query) === 0) {
                DB::insert('INSERT INTO users(user_name, user_email, user_password) VALUES(?, ?, ?)', array($data['user-name'], $data['user-email'], Hash::make($data['user-password'])));
                echo 'User Created';
                return array('errors' => []);
            }
            else {
                return array('errors' => array('User exist'));
            }

        }
        
        
    }
    public function loginUser($data) {
        $rule = array(
            'user-name' => self::usernameRegex,
            'user-password' => self::passwordRule
        );
        $validator = Validator::make($data, $rule);
        if(!$validator->fails()) {
            $inputPass = Hash::make($data['user-password']);
            $result = DB::select('SELECT * FROM users WHERE user_name=?', array($data['user-name']));
            if (count($result) > 0) {
                $passwordDb = $result[0]->user_password;
                if (Hash::check($data['user-password'], $passwordDb)) {
                    Session::put('isLogin', 1);
                    Session::put('userId', $result[0]->user_id);
                    return array('errors' => []);
                }
            }
            return array('errors' => array('Invalid  Username or password'));
        }

        else {
            return array('errors' => $validator);
        }
    }
    public function editUser($data) {
        var_dump($data);
        $validator = Validator::make(
            $data,
            array(
                'user-email' => self::emailRegex,
                'user-password' => self::passwordRule,
                'old-user-password' => self::passwordRule,
                'user-repeat-password' => self::repeatPassword
            )
        );
        if($validator->fails()) {
            return array('errors' =>$validator);
        }
        else {
            $userId = Session::get('userId');
            $result = DB::select('SELECT * FROM users WHERE user_id=?', array($userId));
            var_dump($result);
            $passwordDb = $result[0]->user_password;

            if(Hash::check($data['old-user-password'], $passwordDb)) {
                DB::update('UPDATE users SET user_password=?, user_email=? WHERE user_id=?', array(Hash::make($data['user-password']), $data['user-email'], $userId));
                return array('errors' => []);
            }
            else {
                return array('errors' => ['invalid old password']);
            }
        }


    }
}
