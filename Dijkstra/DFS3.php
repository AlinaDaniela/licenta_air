<?php class treeNode { 
    private $_nodeValue = ""; 
     
    private $_children = array(); 
     
    /** 
     * Constructor, accepts data in an associative array where the keys are the values for the nodes and the values are an array of children.   
     *  
     * This is an n-ary tree and may have any number of children per node.  A binary tree is more specialized. 
     * 
     * @param mixed $thisNode 
     * @param array $children 
     */ 
    public function __construct( $thisNode, $children ) { 
        $this->_nodeValue = $thisNode; 
        if ( is_array($children) ) { 
            //generate children 
            foreach ( $children AS $value => $grandChildren ) { 
                $this->_children[] = new treeNode($value, $grandChildren); 
            } 
        } 
    } 
     
    /** 
     * Searches the tree depth-first and returns the node that matches the argument. 
     *  
     * The search comparison is determined by the data type of the search.  If it's numeric, == will be used.  If it's a string, stristr !== false will be used. 
     * 
     * @param mixed $searchTerm 
     * @return treeNode or false on fail 
     */ 
    public function depthFirst ( $searchTerm ) { 
        //search children: 
        foreach ( $this->_children AS $child ) { 
            $check = $child->depthFirst( $searchTerm ); 
            if ( $check !== false ) { 
                //not false, record was found, return: 
                return $check; 
            } 
        } 
        //got to here without returning anything, check yourself: 
        if ( is_string($searchTerm) ) { 
            if ( stristr($this->_nodeValue, $searchTerm) !== false ) { 
                return $this; 
            } 
        } else { 
             //anything else, check == 
             if ( $this->_nodeValue == $searchTerm ) { 
                return $this; 
            } 
        } 
         
        //got to here without a match, return false: 
        return false; 
    } 
     
    /** 
     * Searches the tree width-first and returns the node that matches the argument.  Almost identical to depth-first but the order is different. 
     *  
     * Same deal as depthFirst with search comparison. 
     * 
     * @param mixed $searchTerm 
     * @return treeNode or false on fail 
     */ 
    public function widthFirst ( $searchTerm ) { 
         //check yourself first: 
        if ( is_string($searchTerm) ) { 
            if ( stristr($this->_nodeValue, $searchTerm) !== false ) { 
                return $this; 
            } 
        } else { 
             //anything else, check == 
             if ( $this->_nodeValue == $searchTerm ) { 
                return $this; 
            } 
        } 
         
        //search children: 
        foreach ( $this->_children AS $child ) { 
            $check = $child->widthFirst( $searchTerm ); 
            if ( $check !== false ) { 
                //not false, record was found, return: 
                return $check; 
            } 
        } 
        
        //got to here without a match, return false: 
        return false; 
    } 
     
    /** 
     * returns the current node's nodeValue 
     * 
     * @return mixed 
     */ 
    public function getValue() { 
        return $this->_nodeValue; 
    } 
} 


//build our "tree" as an array.  Our caveat is that there can be only one root node, like a highlander. 
//For our example we'll just make a balanced binary tree from 1 to 15 
$tree =  
array( 
    8 => array( 
        4 => array( 
            2 => array( 
                1 => array(), 
                3 => array() 
            ), 
            6 => array( 
                5 => array(), 
                7 => array(), 
            ) 
        ), 
        12 => array( 
            10 => array( 
                9 => array(), 
                11 => array() 
            ), 
            14 => array( 
                13 => array(), 
                15 => array(), 
            ) 
        ) 
    ) 
); 

//now create the tree, remembering we have to feed the first node manually: 
$tree = new treeNode(8, $tree[8]); 

//call the depth-first search on the binary tree: 
echo "search results for '7':\n"; 
echo $tree->depthFirst(7)->getValue(); 
echo "\n"; 


//Now build yourself an n-ary tree of search words, organized by the number of letters in the word, with nothing in the root, and each node's children representing words that start with that combination of letters: 
//clearly this is an example, I had to leave SOMETHING for you to do Panda ;-) 
$tree =  
array( 
    "" => array( 
        "a" => array( 
            "as" => array( 
                "ask" => array( 
                    "asked" => array()), 
                "asp" => array() 
            ), 
            "at" => array( 
                "ate" => array(), 
                "atm" => array(), 
            ) 
        ), 
        "I" => array( 
            "in" => array( 
                "ink" => array(), 
                "inn" => array() 
            ), 
            "is" => array(), 
            "it" => array( 
                "its" => array(), 
            ) 
        ) 
    ) 
); 
$tree = new treeNode("", $tree[""]); 

//now do a depth-first search for "as".  Since this will search depth and search on word beginnings, the result will be "asked" 
echo "Search results for 'as', depth-first:\n"; 
echo $tree->depthFirst("as")->getValue(); 
echo "\n"; 

//test widht-first 
echo "Search results for 'as', width-first:\n"; 
echo $tree->widthFirst("as")->getValue(); 
echo "\n";
?>