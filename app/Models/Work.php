<?php

class Work extends ActiveRecord\Model {
    
    public static $table_name = 'work';
    
    public static function num_rows()
    {
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
    public static function remove($inst){
        $obj = self::find('all', array('conditions' => array('institution' => $inst)));
        for($i = 0; $i < count($obj); $i++){
            $obj[$i]->delete();
        }
    }
    
}