<?php

class Answer extends ActiveRecord\Model {
    
    public static $table_name = 'answer';
    
    public static function num_rows(){
        
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
    public static function answer_by_id($user_id, $review_id){
        
        return self::find('all', array('conditions' => array('user_id' => $user_id, 'review_id' => $review_id)));
    }
            
}
