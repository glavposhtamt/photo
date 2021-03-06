<?php

require('UploadHandler.php');

class MysqlUploadHandler extends UploadHandler {
    
    public function listen() {
        $this->initialize();
    }

    protected function initialize() {
        $this->db = new mysqli(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );
        parent::initialize();
        $this->db->close();
    }

    protected function handle_form_data($file, $index) {
        $file->title = @$_REQUEST['title'][$index];
        $file->description = @$_REQUEST['description'][$index];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
        $index = null, $content_range = null) {
        if(preg_match('/[а-яА-Я]/', $name)){
            $name = Translit::object()->convert($name, 'ru,latin');
        }
        $imgInfo = pathinfo($name);
        $name = $imgInfo['filename'] . '_' . rand(0,100000) . '.' . $imgInfo['extension'];
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            //Проверка на наличие куки
            
            if(isset($_COOKIE['path']) && $_COOKIE['path'] !== ''){
                $url = $_COOKIE['path'] . $file->name;
                $sql = 'INSERT INTO `'.$this->options['db_table']
                    .'` (`name`, `size`, `type`, `title`, `description`, `url`)'
                    .' VALUES (?, ?, ?, ?, ?, ?)';
                $query = $this->db->prepare($sql);
                $query->bind_param(
                    'sissss',
                    $file->name,
                    $file->size,
                    $file->type,
                    $file->title,
                    $file->description,
                    $url
                );
            }else {
            
                $sql = 'INSERT INTO `'.$this->options['db_table']
                    .'` (`name`, `size`, `type`, `title`, `description`)'
                    .' VALUES (?, ?, ?, ?, ?)';
                $query = $this->db->prepare($sql);
                $query->bind_param(
                    'sisss',
                    $file->name,
                    $file->size,
                    $file->type,
                    $file->title,
                    $file->description
                );
            }
            $query->execute();
            $file->id = $this->db->insert_id;
            $news = 'http://'. $_SERVER['HTTP_HOST'] . '/admin/news/add';
            $work = 'http://'. $_SERVER['HTTP_HOST'] . '/admin/work/add';
            if( $work === $_SERVER['HTTP_REFERER'] || $news === $_SERVER['HTTP_REFERER']){
                setcookie("file[$file->id]", $file->name);
            }
            switch($_SERVER['HTTP_REFERER']){
				case $news:
					 $this->options['temp_callback'](array('file_id' => $file->id,
														   'file_name' => $file->name,
														   'type' => 'news'));
					 break;
					 
				case $work: 
					$this->options['temp_callback'](array('file_id' => $file->id,
														  'file_name' => $file->name,
														  'type' => 'work'));
					break;
					
				default: break;
			}

        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `id`, `type`, `title`, `description` FROM `'
                .$this->options['db_table'].'` WHERE `name`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type,
                $title,
                $description
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
                $file->title = $title;
                $file->description = $description;
            }
        }
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    .$this->options['db_table'].'` WHERE `name`=?';
                $sql2 = "DELETE FROM bind WHERE file_name = '$name'";
                $this->db->query($sql2);
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
                $this->remove_image_water($name);
            }
        } 
        return $this->generate_response($response, $print_response);
    }
    
    public function remove_image_water($file_name){
        $file_path = null;
        $arr = explode('.', $file_name);
        array_pop($arr);
        $water = implode('.', $arr);
        $file_path = WATER_PATH . '/' . $water . '.jpg';
        if(is_file($file_path)){
            unlink($file_path);
        }
        
    }

}

