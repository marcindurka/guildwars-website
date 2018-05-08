<?php
class ContentModel extends Model{
    public function index(){
        $this->query('SELECT * FROM shares ORDER BY create_date DESC');
        $rows = $this->resultSet();
        //print_r($rows);
        return $rows;
    }
    public function news(){
        return;
    }
    public function recruitment(){
        return;
    }
    public function history(){
        return;
    }
    public function recomended(){
        return;
    }
    public function contact(){
        
        return;
    }
    
    
}