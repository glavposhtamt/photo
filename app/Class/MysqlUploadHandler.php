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
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
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
            $query->execute();
            $file->id = $this->db->insert_id;
            $ref1 = 'http://'. $_SERVER['HTTP_HOST'] . '/admin/news/add';
            $ref2 = 'http://'. $_SERVER['HTTP_HOST'] . '/admin/work/add';
            if( $ref1 === $_SERVER['HTTP_REFERER'] || $ref2 === $_SERVER['HTTP_REFERER']){
                setcookie("file[$file->id]", $file->name);
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
    
    private function remove_image_water($file_name){
        $file_path = null;
        $arr = explode('.', $file_name);
        array_pop($arr);
        $water = implode('.', $arr);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . 'files/water/' . $water . '.jpg';
        if(is_file($file_path)){
            unlink($file_path);
        }
        
    }

}

