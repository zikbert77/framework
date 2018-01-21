<?php

require_once(ROOT . '/components/Db.php');

class News {
    
    public static function getNewsItemById($id){
        $id = intval($id);
        
        if($id){
            
            $db = Db::getConnection();
            
            $result = $db->query('SELECT * FROM news WHERE id=' . $id) or die('Query Error');
            
            $newsItem = $result->fetch_array();
            
            return $newsItem;
        }
    }
    
    public static function getNewsList(){
        
        $db = Db::getConnection();
        
        $newsList = array();
        
        $result = $db->query('SELECT * FROM news ORDER BY date DESC LIMIT 10') or die('Query Error');
        
        $i=0;
        while($row = $result->fetch_array()){
            $newsList[$i]['id'] = $row['id'];
            $newsList[$i]['title'] = $row['title'];
            $newsList[$i]['date'] = $row['date'];
            $newsList[$i]['short_content'] = $row['short_content'];
            $newsList[$i]['content'] = $row['content'];
            $newsList[$i]['author_name'] = $row['author_name'];
            $newsList[$i]['preview'] = $row['preview'];
            $newsList[$i]['type'] = $row['type'];
            $i++;
        }
        
        return $newsList;
    }
}

?>