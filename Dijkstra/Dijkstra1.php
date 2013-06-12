<?php 

function dijkstra( array $g, $start, $end = null )
{
    $d = array();
    $p = array();
    $q = array( 0 => $start );//aa.. q are "a"
	
	print_r($q);
    
    foreach( $q as $v )
    { //a nu este nodul de plecare? ba a q = 0 aici. are doar un element. ce naiba tot vrea ? no idea cu q ala, eu nu m
	echo $v;
	echo " ".$q[$v];
        $d[$v] = $q[$v]; //deci, $d[start] ia $start.. adica a . ceva nu e bine
		
        if( $v == $end )
            break;
        
        foreach( $g[$v] as $w )
        {
            $vw = $d[$v] + $g[$v][$w];
            
            if( $vw < $q[$w] )
            {
                $q[$w] = $vw;
                $p[$w] = $v;
            }
        }
        
        return array( $d, $p );
    }
}




	$x['a'] = array("b",4);
	$x['b'] = array("e",12);

	$g[] = array("a", "b", 4);
	$g[]=array("a", "d", 1);

	$g[]=array("b", "a", 74);
	$g[]=array("b", "c", 2);
	$g[]=array("b", "e", 12);

	$g[]=array("c", "b", 12);
	$g[]=array("c", "j", 12);
	$g[]=array("c", "f", 74);

	$g[]=array("d", "g", 22);
	$g[]=array("d", "e", 32);

	$g[]=array("e", "h", 33);
	$g[]=array("e", "d", 66);
	$g[]=array("e", "f", 76);

	$g[]=array("f", "j", 21);
	$g[]=array("f", "i", 11);

	$g[]=array("g", "c", 12);
	$g[]=array("g", "h", 10);

	$g[]=array("h", "g", 2);
	$g[]=array("h", "i", 72);

	$g[]=array("i", "j", 7);
	$g[]=array("i", "f", 31);
	$g[]=array("i", "h", 18);

	$g[]=array("j", "f", 8);
	
	$graph = array( 
	's' => array('u'=>10, 'x'=>5),
	'u' => array('x'=>2, 'v'=>1),
	'x' => array('u'=>3, 'v'=>9, 'y'=>2),
	'v' => array('y'=>4),
	'y' => array('s'=>7, 'v'=>6),
	);
	
	echo '<pre>';
	echo dijkstra($graph, 's','v');
	echo '</pre>';
?>