<?php

class Graph
{
	var $graph_arr = array();
	var $solution_arr = array();
	
	function Graph()
	{
		//initialization of nodes, mythical for now
		$this->graph_arr = array();
		$n = new Node("A", array("B", "C"));
		array_push($this->graph_arr, $n);
		$n = new Node("B", array("A", "D"));
		array_push($this->graph_arr, $n);
		$n = new Node("C", array("A", "E", "F"));
		array_push($this->graph_arr, $n);		
		$n = new Node("D", array("B"));
		array_push($this->graph_arr, $n);
		$n = new Node("E", array("C"));
		array_push($this->graph_arr, $n);		
		$n = new Node("F", array("C"));
		array_push($this->graph_arr, $n);
	}
		
	function addNode($node)
	{
		global $debug;
		if ($node instanceof Node)
		{
			array_push($this->graph_arr, $node);
		}
		else
		{
			if ($debug)
				echo "<p>ERROR Graph.addNode(): parameter \$node is note an instance of Node.</p>";
		}
	}
	
	/** prints the entire graph, and all the edges **/
	function printGraph($graph_arr)
	{
		foreach ($graph_arr as $node)
		{
			echo $node->getNodeName();
			$adjacent_nodes = $node->getAdjacentNodes();
			foreach($adjacent_nodes as $a_node)
			{
				echo "<br /> -> " . $a_node;
			}
			echo "<br />";
		}
	}
	

	
	/**
	 * Recursive depth-first-search algorithm that looks for a path between $start_node_name and 
	 * $finish_node_name. It sets the path in the global array $solution_arr;
	 *
	 * @param string $start_node_name - the starting node
	 * @param string $finish_node_name - the ending node
	 * @return null if no path found, Node if path was found
	 */
	function dfs_recursive($start_node_name, $finish_node_name)
	{
		$start_node = $this->getNode($start_node_name);		//obtain the Node object from the node name
		if ($start_node == null || !($start_node instanceof Node))
		{
			if ($debug)
				echo "<p>ERROR Graph.dfs_recursive(): Start node $start_node_name is not a valid node.</p>";
			return null;
		}
		
		$start_node->setVisited();							//set starting node to visited
		/* set the starting node to be part of the solution, and if it is not, it is removed later 
		 */		
		array_push($this->solution_arr, $start_node);		
		
		$finish_node = $this->getNode($finish_node_name);	//obtain the Node object
		if ($finish_node == null || !($finish_node instanceof Node))
		{
			if ($debug)
				echo "<p>ERROR Graph.dfs_recursive(): Finish node $finish_node_name is not a valid node.</p>";
			return null;
		}
		
		if ($start_node_name == $finish_node_name)			//found the path! woohoo!
		{
			return $start_node;
		}
		
		$adjacent_nodes = $start_node->getAdjacentNodes();	//find $start_node's neighbors
		foreach($adjacent_nodes as $adjacent_node_name)
		{
			//neighbors are stored by name only to avoid circular references. Get the object
			$adjacent_node = $this->getNode($adjacent_node_name);
			if ($adjacent_node == null || !($adjacent_node instanceof Node))
			{
				if ($debug)
					echo "<p>WARN Graph.dfs_recursive(): Adjacent node $adjacent_node_name is not a valid node.</p>";
				continue;
			}
			//var_dump($adjacent_node);
			$is_node_visited = $adjacent_node->isVisited();
			if (!$is_node_visited)		//if this node was already visited, skip it. Otherwise, check the neighbor
			{
				//recursively check the neighbor
				$result_node = $this->dfs_recursive($adjacent_node_name, $finish_node_name);
				if ($result_node != null)
				{
					return $result_node;		//we found the path! return the result
				}
			}
		}
		//get rid of the latest "solution" node, since searching that path didn't yield a result
		array_pop($this->solution_arr);
		return null;		//no solution :( return null.
		
	}
	
	function getDfsSolution() { return $this->solution_arr; }

	//for debugging...
	function printDfsSolution()
	{
		if (is_array($this->solution_arr))
		{	
			echo "Solution Array: <br /><br />";
			foreach ($this->solution_arr as $node)
			{
				echo "->" . $node->getNodeName();
			}
			echo "<br />";
		}
	}
	
	function getNode($node_name)
	{
		foreach($this->graph_arr as $node)
		{
			if ($node->getNodeName() == $node_name)
			{
				return $node;
			}
		}
	}
	
	function getGraph() { return $this->graph_arr; }
}

class Node
{
	var $node_name;
	var $adjacent_nodes;
	var $is_visited;
	function Node($node_name, $adjacent_nodes)
	{
		$this->node_name = $node_name;
		$this->adjacent_nodes = $adjacent_nodes;
	}
	
	/** returns array of adjacent nodes **/
	function getAdjacentNodes()	{return $this->adjacent_nodes;}
	function getNodeName() {return $this->node_name;}	
	function isVisited() { return $this->is_visited; }
	function setVisited(){ $this->is_visited = true; }
}

$graph = new Graph();
echo "<p>";
$graph->printGraph($graph->getGraph());
echo "</p>----------------------------------</p><p>&nbsp;</p><p>";
$graph->dfs(@$_GET['s'], @$_GET['f']);
$graph->dfs_recursive(@$_GET['s'], @$_GET['f']);
$graph->printDfsSolution();

?>