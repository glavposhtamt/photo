<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Watermark
 *
 * @author sergey
 */
class Watermark extends ActiveRecord\Model {
    public static $table_name = 'watermark';
    
    public static function num_rows()
    {
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
    public static function get_row_id(){
        $obj = self::find('all', array('select' => 'id'));
        return (int)$obj[0]->id;
    }

}
