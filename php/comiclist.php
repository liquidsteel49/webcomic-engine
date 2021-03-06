<?php
    
    require("./php/variables.php");
  
    // Class for a single page of a comic.
    class Comic {
        var $title, $alt, $hover, $url, $page, $totalPages;
        function __construct($title, $hover, $url, $page, $totalPages) {		
            $this->title = $title;
            $this->alt = "Comic " . title . " page " . $page; // Sets alt text to "Comic <comic title> page <page number>"
            $this->hover = $hover; // Sets title-text
            $this->url = IMAGE_DIRECTORY . $url;
            $this->page = $page; // Number of this comic page
            $this->totalPages = $totalPages; // Total number of pages in this comic's storyline
        }
        
        public function __get($property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }
    }
    
    // Read comic data from file. Each line of the file is a different storyline (not page).
    $comicData = trim(file_get_contents(COMIC_LIST_FILE));
    $comics = explode("\n", $comicData);
    $comicList = array();
    foreach ($comics as $story) {
        $data = array_map("trim", explode("::", $story));
        $hovers = array_map("trim", explode(",,", $data[1]));
        $url = explode(".", $data[2]);
        for ($i = 0; $i < $data[3]; $i++) {
            $comicList[] = new Comic($data[0], $hovers[$i], $url[0] . "_" . str_pad(($i + 1), 3, '0', STR_PAD_LEFT) . "." . $url[1], $i + 1, $data[3]);
        }
    }
    
    define("N_COMICS", count($comicList)); // Total number of comic pages
    define("CURR_N", $_GET["comic"] == 0 ? N_COMICS : $_GET["comic"]); // Current comic number

?>
