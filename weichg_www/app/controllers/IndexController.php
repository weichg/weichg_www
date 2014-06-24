<?php

class IndexController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	
    }
    
    public function regionAction()
    {
    	$id = $this->request->get("id", 'int', 0);
    	
        $this->db->query("set names 'utf8'");
                
    	$regions = $this->db->fetchAll("SELECT * FROM weic_region WHERE parent_id=$id");
    	$ret = "<ul>";
    	foreach ($regions as $z) {
    		if ($z['grade'] == 3) {
    			if (!empty($z['shop_url'])) {
    				$ret .= "<li class=\"zc\"><a href=\"http://{$z['shop_url']}\">{$z['region_name']}</a></li>";
    			} else {
    				$ret .= "<li>{$z['region_name']}</li>";
    			}
    			    
    		} else {
    			$ret .= "<li><a href=\"#\" onClick=\"getRegionList({$z['region_id']})\">{$z['region_name']}</a></li>";
    		}
    	}
    	$ret .= "</ul>";
    	echo $ret;
    }

}