<?
class dbClass {
    
    /*
    * Following functions to deal with thinktank resource 
    *
    *  search_thinktanks($target)
    *  $target is a thinktank_id or thinktank name 
    *  
    *
    */
        

    //Connect to DB
    function __construct($db_location, $db_user_name, $db_password, $db_name) { 
        
        $this->db = MYSQL_CONNECT ($db_location, $db_user_name,  $db_password) or DIE ("Unable to connect to Database Server");
        MYSQL_SELECT_DB ($db_name, $this->db) or DIE ("Could not select database");
    }
    
    //Basic query    
    function query($sql) {
        $result = MYSQL_QUERY ($sql, $this->db) or DIE ("Invalid query: " . MYSQL_ERROR());
        return $result;
    }
    
    //Return array 
    function fetch($sql) {
        $data = array();
        $result = $this->query($sql);
        WHILE($row = MYSQL_FETCH_ASSOC($result)) {
           $data[] = $row;
        }
        return $data;
     }
     
    function get_sites() { 
        $sql = "SELECT * FROM manual_sites GROUP BY site "; 
        $sites = $this->fetch($sql);
        return($sites); 
    } 
    
    function get_non_default_sites() { 
        $sql = "SELECT * FROM manual_sites WHERE scraper != '' GROUP BY site "; 
        $sites = $this->fetch($sql);
        return($sites);
    }    
    
    function save_update($site, $title, $description, $link, $date) {
        $md5 = md5($description);
        $query = "SELECT * FROM manual_updates WHERE link = '$link' OR md5='$md5'";
        $result = $this->fetch($query); 

        if (empty($result)) { 
            $output =  "<p style='color:red'>SAVING</p>";
            
            $title          = addslashes($title);
            $description    = addslashes($description);
            $link           = addslashes($link);
            $date           = addslashes($date);           
            $short_url      = getBitly($link);
             
            $query = "INSERT INTO manual_updates (site, title, description, link, pubdate, md5, short_url) 
            VALUES ('$site', '$title', '$description', '$link', '$date', '$md5', '$short_url')";
            
            $this->query($query); 
        } 

        else { 
           $output =  "<p style='color:green'>Already in</p><br/>"; 
        }
        return $output; 
     }
}

?>