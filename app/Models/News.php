<?php

class News extends ActiveRecord\Model {
    
    public static $table_name = 'news';

    public function before_create() {
        $this->date = date('Y-m-d H:i:s', strtotime('now'));
    }
    
    public static function num_rows()
    {
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
}

