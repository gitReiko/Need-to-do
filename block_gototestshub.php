<?php

include_once 'classes/main.php';

use Blocks\GoToTestsHub as b;

class block_gototestshub extends block_base {

    public function init() 
    {
        $this->title = get_string('go_to_tests', 'block_gototestshub');
    }

    public function get_content() 
    {
        if ($this->content !== null) 
        {
          return $this->content;
        }
    
        $this->content         =  new stdClass;
        $this->content->text   = $this->get_block();
     
        return $this->content;
    }
    
    private function get_block() : string 
    {
        $main = new b\Main;
        return $main->get_page();
    }
    

}
