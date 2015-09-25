<?php

class Post extends ActiveRecord\Model {
    
    public static $table_name = 'post';

    public function before_create() {
        $this->date = date('Y-m-d H:i:s', strtotime('now'));
    }
    
    public function before_update() {
        $this->date = date('Y-m-d H:i:s', strtotime('now'));
    }
}

