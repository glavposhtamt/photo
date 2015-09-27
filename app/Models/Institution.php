<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Iinstitution
 *
 * @author sergey
 */
class Institution extends ActiveRecord\Model{
    
    public static $table_name = 'institution';
    
    public static function num_rows()
    {
        $obj = self::find('all', array('select' => 'count(*) AS num_rows'));
        return (int)$obj[0]->num_rows;
    }
    
    public static function get_unique_sityes(){
        $obj = self::all(array('select' => 'DISTINCT sity'));
        return $obj;
    }
}
