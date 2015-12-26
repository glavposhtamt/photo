<?php

class User extends ActiveRecord\Model {
    
    public static $table_name = 'user';
    
    public static function check_pass($user, $pass){
        
        $obj = self::find_by_user($user, array('select' => 'pass'));
        return $obj ? password_verify($pass, $obj->pass) : false;
    }
    
    public static function num_rows(){
        
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
    public static function create_default_user(){
        if(self::num_rows() === 0){
            $user = new self;
            $user->user = 'admin';
            $user->pass = password_hash('admin', PASSWORD_DEFAULT);
            $user->save();
        }
    }
    
    public static function change_password($user, $pass){
        $obj = self::find_by_user($user, array('select' => 'id, pass'));
        $obj->pass = password_hash($pass, PASSWORD_DEFAULT);
        $obj->save();
    }
    
    public static function get_user_id($user_name){
        $u = self::find_by_user($user_name);
        return $u->id;
    }
}