<?php
 
// incidence list
$incidenceList = array(
    1 => array(
        'vertex' => 1, // vertex number
        'visited' => false, // `visited` flag
        'letter' => 'A', // vertex value
        'neighbours' => array(2, 4) // neighbours
    ),
    2 => array(
        'vertex' => 2,
        'visited' => false,
        'letter' => 'B',
        'neighbours' => array(1,3,5)
    ),
    3 => array(
        'vertex' => 3,
        'visited' => false,
        'letter' => 'C',
        'neighbours' => array(2, 10, 6)
    ),
    4 => array(
        'vertex' => 4,
        'visited' => false,
        'letter' => 'D',
        'neighbours' => array(7, 5)
    ),
    5 => array(
        'vertex' => 5,
        'visited' => false,
        'letter' => 'E',
        'neighbours' => array(8, 6, 4)
    ),
    6 => array(
        'vertex' => 6,
        'visited' => false,
        'letter' => 'F',
        'neighbours' => array(10, 9)
    ),
    7 => array(
        'vertex' => 7,
        'visited' => false,
        'letter' => 'G',
        'neighbours' => array(3, 8)
    ),
    8 => array(
        'vertex' => 8,
        'visited' => false,
        'letter' => 'H',
        'neighbours' => array(7, 9)
    ),
    9 => array(
        'vertex' => 9,
        'visited' => false,
        'letter' => 'I',
        'neighbours' => array(10, 6, 8)
    ),
    10 => array(
        'vertex' => 10,
        'visited' => false,
        'letter' => 'J',
        'neighbours' => array(6)
    ),
);
 
/**
 * Depth-first search of the graph
 * 
 * @param type $vertex Currently checked graph's vertex
 * @param type $list Incidence list of graph vertexes
 * @return Incidence list of graph vertexes
 */
function depthFirstSearch($vertex, $list)
{
    if (!$vertex['visited']) {
        echo $vertex['letter']; // output on screen
        // mark vertex as visited
        $list[$vertex['vertex']]['visited'] = true;
        foreach ($vertex['neighbours'] as $neighbour) {
            // Watch neighbours, which were not visited yet
            if (!$list[$neighbour]['visited']) {
                // going through neighbour-vertexes
                $list = depthFirstSearch(
                    $list[$neighbour], 
                    $list
                );
            }
        }
    }
     
    return $list;
}
 
function breadthFirstSearch($list)
{
    $queue = array();
    array_unshift($queue, $list[1]);
    $list[1]['visited'] = true;
     
    while (sizeof($queue)) {
        $vertex = array_pop($queue);
        echo $vertex['letter']; // output on screen
        foreach ($vertex['neighbours'] as $neighbour) {
            // Watch neighbours, which were not visited yet
            if (!$list[$neighbour]['visited']) {
                // mark vertex as visited
                $list[$neighbour]['visited'] = true;
                array_unshift($queue, $list[$neighbour]);
            }
        }
    }
}
 
 
// go through graph starting from 1st vertex
depthFirstSearch($incidenceList[1], $incidenceList);
echo "\n";
breadthFirstSearch($incidenceList);
 
// Here is an example of breadth-first search (queue content step by step)
// Event       Queue
// Visit   A    A
// Visit   N    NA
// Remove  A    N
// Visit   R    RN
// Remove  N    R
// Visit   I    IR
// Visit   K    KIR
// Remove  R    KI
// Visit   L    LKI
// Remove  I    LK
// Remove  K    L
// Visit   V    VL
// Remove  L    V
// Visit   N    NV
// Remove  V    N
// Visit   A    AN
// Remove  N    
// Remove  A    
 
// P.S. Of course this is just a simple implementation of graph and methods to traverse the graph. 
// You can use matrixes to represent graph, optimize the code etc. 
// But at least i hope it will help you to understand the basics. Cheers!