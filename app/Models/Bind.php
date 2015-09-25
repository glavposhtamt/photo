<?php

class Bind extends ActiveRecord\Model {
    
    public static $table_name = 'bind';
    
    public static function num_rows()
    {
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
        
}

