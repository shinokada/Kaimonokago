<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File: models/Nested_sets_model.php
 *
 * An implementation of Joe Celko's Nested Sets as a Code Igniter model.
 * Ideally, this would be an abstract class since it should be extended
 * by another class to provide specific functionality (ie a Categories class
 * or a Site_structure class). However, PHP4.x doesn't have support for
 * asbtract classes so I've done it this way for now. 
 *
 * @package     Nested_sets
 * @author      Thunder <ravenvelvet@gmail.com>
 * @copyright   Copyright (c) 2007, Thunder
 */

 
/**
 * @package Nested_sets
 * @author  Thunder <ravenvelvet@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2007 Thunder
 */
class Nested_sets_model extends Model {
   
    var $table_name;
    var $left_column_name;
    var $right_column_name;
    var $primary_key_column_name; 
    
    /**
	 * Constructor
	 *
     * @access	public
	 */
	function Nested_sets_model()
	{		
        // Call the parent constructor
		parent::Model();
    }

	// -------------------------------------------------------------------------
    //  OBJECT INITIALISATION METHODS
    //
    //  For setting instance properties
    //
    // -------------------------------------------------------------------------
    
    /**
     *  On initialising the instance, this method should be called to set the
     *  database table name that we're dealing and also to identify the names
     *  of the left and right value columns used to form the tree structure.
     *  Typically, this would be done automatically by the model class that 
     *  extends this "base" class (eg. a Categories class would set the table_name
     *  to "categories", a Site_structure class would set the table_name to
     *  "pages" etc)
     *
     *  @param string $table_name The name of the db table to use
     *  @param string $left_column_name The name of the field representing the left identifier
     *  @param string $right_column_name The name of the field representing the right identifier
     *  @return void
     *
     */
    function setControlParams($table_name,$left_column_name = "lft",$right_column_name = "rgt") 
    {
        $this->table_name = $table_name;
        $this->left_column_name = $left_column_name;
        $this->right_column_name = $right_column_name;
        return "";
    }
    
    /**
     * Used to identify the primary key of the table in use. Commonly, this will
     * be an auto_incrementing ID column (eg CategoryId)
     *
     * @param string $primary_key_name
     * @return void
     */
    function setPrimaryKeyColumn($primary_key_name)
    {
        $this->primary_key_column_name = $primary_key_name;
    }


	// -------------------------------------------------------------------------
    //  NODE MANIPULATION FUNCTIONS
    //
    //  Methods to add/remove nodes in your tree
    //
    // -------------------------------------------------------------------------


    /**
     * Adds the first entry to the table
     * @param     $extrafields  An array of field->value pairs for the database record
     * @return    $node an array of left and right values
     */
     
    function initialiseRoot($extrafields = array())
    {
        
        $node = array(  $this->left_column_name  => 1,  
                        $this->right_column_name => 2
                     );
                     
        $this->_setNewNode($node, $extrafields);
        
        return $node;
    }
    /**
     * inserts a new node as the first child of the supplied parent node
     * @param array $parentNode The node array of the parent to use
     * @param array $extrafields An associative array of fieldname=>value for the other fields in the recordset
     * @return array $childNode An associative array representing the new node
     */
    function insertNewChild($parentNode, $extrafields = array())
    {
        $childNode[$this->left_column_name]      =   $parentNode[$this->left_column_name]+1;
        $childNode[$this->right_column_name]     =   $parentNode[$this->left_column_name]+2;
        
        $this->_modifyNode($childNode[$this->left_column_name], 2);
        $this->_setNewNode($childNode, $extrafields);
        
        $childNode = array_merge($childNode, $extrafields);
        return $childNode;
    }
    
    /**
     * Same as insertNewChild except the new node is added as the last child
     * @param array $parentNode The node array of the parent to use
     * @param array $extrafields An associative array of fieldname=>value for the other fields in the recordset
     * @return array $childNode An associative array representing the new node
     */
    function appendNewChild($parentNode, $extrafields = array()) 
    {
        $childNode[$this->left_column_name]      =   $parentNode[$this->right_column_name];
        $childNode[$this->right_column_name]     =   $parentNode[$this->right_column_name]+1;
        
        $this->_modifyNode($childNode[$this->left_column_name], 2);
        $this->_setNewNode($childNode, $extrafields);
        
        $childNode = array_merge($childNode, $extrafields);
        return $childNode;
    }
    /**
     * Adds a new node to the left of the supplied focusNode
     * @param array $focusNode The node to use as the position marker
     * @param array $extrafields An associative array of node attributes
     * @return array $siblingNode The new node
     */
    function insertSibling($focusNode, $extrafields)
    {
        $siblingNode[$this->left_column_name]    =   $focusNode[$this->left_column_name];
        $siblingNode[$this->right_column_name]   =   $focusNode[$this->left_column_name]+1;
        
        $this->_modifyNode($siblingNode[$this->left_column_name], 2);
        $this->_setNewNode($siblingNode, $extrafields);
        
        $siblingNode = array_merge($siblingNode, $extrafields);
        return $siblingNode;
    }
    
    /**
     * Adds a new node to the right of the supplied focusNode
     * @param array $focusNode The node to use as the position marker
     * @param array $extrafields An associative array of node attributes
     * @return array $siblingNode The New Node
     */
    function appendSibling($focusNode, $extrafields)
    {
        $siblingNode[$this->left_column_name]    =   $focusNode[$this->right_column_name]+1;
        $siblingNode[$this->right_column_name]   =   $focusNode[$this->right_column_name]+2;
        
        $this->_modifyNode($siblingNode[$this->left_column_name], 2);
        $this->_setNewNode($siblingNode, $extrafields);
        
        return $siblingNode;
    }

    
    /**
     * Empties the table currently in use - use with extreme caution!
     */
    function deleteTree()
    {
        $sql = "DELETE FROM " . $this->table_name;
        $res = $this->db->query($sql);
        
        return;
    }

    /**
     * Deletes the given node (and any children) from the tree table
     * @param array $node The node to remove from the tree
     * @return array $newnode The node that replaced the deleted node 
     */
    function deleteNode($node)
    {
        $leftanchor         =       $node[$this->left_column_name];
        $table              =       $this->table_name;
        $leftcol            =       $this->left_column_name;
        $rightcol           =       $this->right_column_name;
        $leftval            =       $node[$this->left_column_name];
        $rightval           =       $node[$this->right_column_name];
        
        $sql = "DELETE FROM     $table
                WHERE           $leftcol    >= $leftval 
                AND             $rightcol   <= $rightval";
                
        $this->db->query($sql);
        
        $this->_modifyNode($node[$this->right_column_name]+1, $node[$this->left_column_name] -$node[$this->right_column_name] - 1);
        
        return $this->getNodeWhere("$leftcol < $leftanchor ORDER BY $leftcol DESC");
    }
    
	// -------------------------------------------------------------------------
    //  MODIFY/REORGANISE TREE
    //
    //  Methods to move nodes around the tree. Method names should be 
    //  relatively self-explanatory! Hopefully ;)
    //
    // -------------------------------------------------------------------------

    /**
     * Moves the given node to make it the next sibling of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsNextSibling($node, $target)
    {
        return $this->_moveSubtree($node, $target[$this->right_column_name]+1);
    }

    /** 
     * Moves the given node to make it the prior sibling of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsPrevSibling($node, $target)
    {
        return $this->_moveSubtree($node, $target[$this->left_column_name]);
    }

    /** 
     * Moves the given node to make it the first child of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */    
    function setNodeAsFirstChild($node, $target)
    {
        return $this->_moveSubtree($node, $target[$this->left_column_name]+1);
    }

    /** 
     * Moves the given node to make it the last child of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsLastChild($node, $target)
    {
        return $this->_moveSubtree($node, $target[$this->right_column_name]);
    }
    
    // -------------------------------------------------------------------------
    //  QUERY METHODS
    //
    //  Selecting nodes from the tree
    //
    // -------------------------------------------------------------------------
    
    /**
     * Selects the first node to match the given where clause argument
     * @param string $whereArg Any valid SQL to follow the WHERE keyword in an SQL statement
     * @return array $resultNode The node returned from the query 
     */
    function getNodeWhere($whereArg = "1=1")
    {
        $resultNode[$this->left_column_name]     =       $resultNode[$this->right_column_name]    =       0;
        $leftcol                =       $this->left_column_name;
        $rightcol               =       $this->right_column_name;
        $table                  =       $this->table_name;
        
        $sql = "SELECT      *
                FROM        $table
                WHERE       $whereArg";
                
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0) 
        {
            $result = $query->result_array();
            $resultNode = array_shift($result); // assumes CI standard $row[0] = first row
        }
        
        return $resultNode;
    }
    
    /**
     * Returns the node identified by the given left value
     * @param integer $leftval The left value to use to select the node
     * @return array $resultNode The node returned
     */
    function getNodeWhereLeft($leftval)
    { 
        return $this->getNodeWhere($this->left_column_name . " = " . $leftval);
    }
    
    /**
     * Returns the node identified by the given right value
     * @param integer $rightval The right value to use to select the node
     * @return array $resultNode The node returned
     */
    function getNodeWhereRight($rightval)
    { 
        return $this->getNodeWhere($this->right_column_name . " = " . $rightval);
    }

    /**
     * Returns the root node
     * @return array $resultNode The node returned
     */
    function getRoot()
    {   
        return $this->getNodeWhere($this->left_column_name . " = 1 ");
    }
    
    /**
     * Returns the node with the appropriate primary key field value.
     * Typically, this will be an auto_incrementing primary key column 
     * such as categoryid
     * @param mixed $primarykey The value to look up in the primary key index
     * @return array $resultNode The node returned
     */
    function getNodeFromId($primarykey) 
    {
        // Test if we've set the primary key column name property
        if(empty($this->primary_key_column_name)) return false;
        
        return $this->getNodeWhere($this->primary_key_column_name . "='$primarykey'");
    }

    /**
     * Returns the first child node of the given parentNode
     * @param array $parentNode The parent node to use
     * @return array $resultNode The first child of the parent node supplied
     */
    function getFirstChild($parentNode)
    { 
        return $this->getNodeWhere($this->left_column_name . " = " . ($parentNode[$this->left_column_name]+1));
    }
    
    /**
     * Returns the last child node of the given parentNode
     * @param array $parentNode The parent node to use
     * @return array $resultNode the last child of the parent node supplied
     */
    function getLastChild($parentNode)
    { 
        return $this->getNodeWhere($this->right_column_name . " = " . ($parentNode[$this->right_column_name]-1));
    }
    
    /**
     * Returns the node that is the immediately prior sibling of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode The node returned
     */
    function getPrevSibling($currNode)
    { 
      return $this->getNodeWhere($this->right_column_name . " = " . ($currNode[$this->left_column_name]-1));
    }
    
    /**
     * Returns the node that is the next sibling of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode The node returned
     */
    function getNextSibling($currNode)
    { 
        return $this->getNodeWhere($this->left_column_name . " = " . ($currNode[$this->right_column_name]+1));
    }
    
    /**
     * Returns the node that represents the parent of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode the node returned
     */
    function getAncestor($currNode)
    { 
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        
        $whereArg = "           $leftcol    < " . $currNode[$leftcol] . 
                    " AND       $rightcol   > " . $currNode[$rightcol] . 
                    " ORDER BY  $rightcol ASC";
        return $this->getNodeWhere($whereArg);
    }


    // -------------------------------------------------------------------------
    //  NODE TEST METHODS
    //
    //  Boolean tests for nodes
    //
    // -------------------------------------------------------------------------
    
    
    /**
     * Returns true or false 
     * (in reality, it checks to see if the given left and
     * right values _appear_ to be valid not necessarily that they _are_ valid)
     * @param array $node The node to test
     * @return boolean 
     */
    function checkIsValidNode($node)
    { 
        return ($node[$this->left_column_name] < $node[$this->right_column_name]);
    }
    
    /**
     * Tests whether the given node has an ancestor 
     * (effectively the opposite of isRoot yes|no)
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasAncestor($node)
    { 
        return $this->checkIsValidNode($this->getAncestor($node));
    }
    
    /**
     * Tests whether the given node has a prior sibling or not
     * @param array $node
     * @return boolean
     */
    function checkNodeHasPrevSibling($node)
    { 
        return $this->checkIsValidNode($this->getPrevSibling($node));
    }
    
    /**
     * Test to see if node has siblings after itself
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasNextSibling($node)
    { 
        return $this->CheckIsValidNode($this->getNextSibling($node));
    }
    
    /**
     * Test to see if node has children
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasChildren($node)
    { 
        return (($node[$this->right_column_name] - $node[$this->left_column_name]) > 1);
    }

    /**
     * Test to see if the given node is also the root node
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeIsRoot($node)
    {
        return ($node[$this->left_column_name] == 1);
    }
    
    /**
     * Test to see if the given node is a leaf node (ie has no children)
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeIsLeaf($node)
    { 
        return (($node[$this->right_column_name] - $node[$this->left_column_name]) == 1);
    }
    
    /**
     * Test to see if the first given node is a child of the second given node
     * @param array $testNode the node to test for child status
     * @param array $controlNode the node to use as the parent or ancestor
     * @return boolean
     */
    function checkNodeIsChild($testNode, $controlNode)
    { 
        return (        ($testNode[$this->left_column_name]  >   $controlNode[$this->left_column_name]) 
                    and ($testNode[$this->right_column_name] <   $controlNode[$this->right_column_name])
               );
    }
    
    /**
     * Test to determine whether testNode is infact also controlNode (is A === B)
     * @param array $testNode The node to test
     * @param array $controlNode The node prototype to use for the comparison
     * @return boolean
     */
    function checkNodeIsEqual($testNode, $controlNode)
    { 
        return (($testNode[$this->left_column_name]==$controlNode[$this->left_column_name]) and ($testNode[$this->right_column_name]==$controlNode[$this->right_column_name]));
    }

    /**
     * Combination method of IsChild and IsEqual
     * @param array $testNode The node to test
     * @param array $controlNode The node prototype to use for the comparison
     * @return boolean
     */
    function checkNodeIsChildOrEqual($testNode, $controlNode)
    { 
        return (($testNode[$this->left_column_name]>=$controlNode[$this->left_column_name]) and ($testNode[$this->right_column_name]<=$controlNode[$this->right_column_name]));
    }


    // -------------------------------------------------------------------------
    //  TREE QUERY METHODS
    //
    //  Query the tree itself
    //
    // -------------------------------------------------------------------------

    /**
     * Returns the number of descendents that a node has
     * @param array $node The node to query
     * @return integer The number of descendents
     */
    function getNumberOfChildren($node)
    { 
        return (($node[$this->right_column_name] - $node[$this->left_column_name] - 1) / 2);
    }

    /**
     * Returns the tree level for the given node (assuming root node is at level 0)
     * @param array $node The node to query
     * @return integer The level of the supplied node
     */
    function getNodeLevel($node)
    {
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        $table          =       $this->table_name;
        $leftval        = (int) $node[$this->left_column_name];
        $rightval       = (int) $node[$this->right_column_name];
        
        $sql = "SELECT      COUNT(*) AS level 
                FROM        $table  
                WHERE       $leftcol < $leftval 
                AND         $rightcol > $rightval
                ";
                
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $result = $query->row();
            return $result->level;
        } else {
            return 0;
        }
    }

    /**
     * Returns an array of the tree starting from the supplied node
     * @param array $node The node to use as the starting point (typically root)
     * @return array $tree_handle The tree represented as an array to assist with
     *                            the other tree traversal operations
     */
    function getTreePreorder($node)
    {
        $table      =       $this->table_name;
        $leftcol    =       $this->left_column_name;
        $rightcol   =       $this->right_column_name;
        $leftval    = (int) $node[$leftcol];
        $rightval   = (int) $node[$rightcol];
        
        $sql = "SELECT      *
                FROM        $table
                WHERE       $leftcol >= $leftval
                AND         $rightcol <= $rightval
                ORDER BY    $leftcol ASC";
        
        $query = $this->db->query($sql);
        
        $treeArray = array();
        
        if($query->num_rows() > 0) {
            foreach($query->result_array() AS $result) {
                $treeArray[] = $result;
            }
        }
        
        $retArray = array(  "result_array"  =>      $treeArray,
                            "prev_left"     =>      $node[$leftcol],
                            "prev_right"    =>      $node[$rightcol],
                            "level"         =>      -2);
        
        return $retArray;
    }
    
    /**
     * Returns the next element from the tree and updates the tree_handle with the 
     * new positions
     * @param array $tree_handle Passed by reference to allow for modifications
     * @return array The next node in the tree
     */
    function getTreeNext(&$tree_handle)
    {
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        
        if(!empty($tree_handle['result_array'])) {
            if($row = array_shift($tree_handle['result_array'])) {
                
                $tree_handle['level']+= $tree_handle['prev_left'] - $row[$leftcol] + 2;
                // store current node
                $tree_handle['prev_left']  = $row[$leftcol];
                $tree_handle['prev_right'] = $row[$rightcol];
                $tree_handle['row'] = $row;

                return array(   $leftcol  =>  $row[$leftcol],
                                $rightcol =>  $row[$rightcol]
                            );
            } 
        }
        
        return FALSE;
    }

    /**
     * Returns the given attribute (database field) for the current node in $tree_handle
     * @param array $tree_handle The tree as an array
     * @param string $attribute A string containing the fieldname to retrieve
     * @return string The value requested
     */
    function getTreeAttribute($tree_handle,$attribute) 
    {
        return $tree_handle['row'][$attribute];
    }
    
    /**
     * Returns the current node of the tree contained in $tree_handle
     * @param array $tree_handle The tree as an array
     * @return array The left and right values of the current node
     */
    function getTreeCurrent($tree_handle) 
    {
        return array(   $this->left_column_name  =>      $tree_handle['prev_left'],
                        $this->right_column_name =>      $tree_handle['prev_right']
                    );
    }
    /**
     * Returns the current level from the tree
     * @param array $tree_handle The tree as an array
     * @return integer The integer value of the current level
     */
    function getTreeLevel($tree_handle) 
    {
        return $tree_handle['level'];
    }

    
    // -------------------------------------------------------------------------
    //   NODE FIELD QUERIES
    //
    // -------------------------------------------------------------------------
    
    /**
     * Queries the database for the value of the given field 
     * @param array $node The node to be queried
     * @param string $fieldname The name of the field to query
     * @return string $retval The value of the field for the node looked up
     */
    function getNodeAttribute($node, $fieldname)
    {
        $table          =       $this->table_name;
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        $leftval        = (int) $node[$this->left_column_name];
        
        $sql = "SELECT      *
                FROM        $table
                WHERE       $leftcol = $leftval";
        
        $query = $this->db->query($sql);
        
        
        if($query->num_rows() > 0) {
            $res = $query->result();
            return $res->$fieldname;
        } else {
            return "";
        }
    }
    
    /**
     * Renders the fields for each node starting at the given node
     * @param array $node The node to start with
     * @param array $fields The fields to display for each node
     * @return string Sample HTML render of tree
     */
    function getSubTreeAsHTML($node, $fields = array()) 
    {
        $tree_handle = $this->getTreePreorder($node);
        $retVal = "";
        
        while($this->getTreeNext($tree_handle)) 
        {
            // print indentation
            $retVal .= (str_repeat("&nbsp;", $this->getTreeLevel($tree_handle)*4));
	
            // print requested fields
            $field = reset($fields);
            while($field){
                $retVal .= $tree_handle['row'][$field] . "\n";
                $field = next($fields);
            }
            $retVal .= "<br />\n";
            
        }
        
        return $retVal;
    }


    /**
     * Renders the entire tree as per getSubTreeAsHTML starting from root
     * @param array $fields An array of the fields to display
     */
    function getTreeAsHTML($fields=array())
    { 
        return $this->getSubTreeAsHTML($this->getRoot(), $fields);
    }

    // -------------------------------------------------------------------------
    //  INTERNALS
    //
    //  Private, internal methods 
    //
    // -------------------------------------------------------------------------
    
    /**
     *  _setNewNode
     * 
     *  Inserts a new node into the tree
     *
     *  @param array $node An array containing the left and right values to use
     *  @param array $extrafields An associative array of field names to values for \
     *                          additional columns in tree table (eg CategoryName etc)
     *
     *  @return boolean True/False dependent upon the success of the operation
     *  @access private
     */
    function _setNewNode($node, $extrafields)
    {
        $table      =       $this->table_name;
        $leftcol    =       $this->left_column_name;
        $rightcol   =       $this->right_column_name;
        $leftval    = (int) $node[$this->left_column_name];
        $rightval   = (int) $node[$this->right_column_name];
        
        // Handle 'othercols'
        $extraFieldsArg = $extraValuesArg = "";
        
        if(is_array($extrafields) && !empty($extrafields)) {
            $fields = array();
            $values = array();
            
            foreach($extrafields AS $field=>$value) {
                $fields[] = $field;
                $values[] = $value;
            }
            $extraFieldsArg = ",`" . join("`,`",$fields) . "`";
            $extraValuesArg = ",'" . join("','",$values) . "'";
        }
        
        $sql = "INSERT INTO $table ( 
                    `$leftcol`,
                    `$rightcol`
                     $extraFieldsArg)
                 VALUES (
                    '$leftval',
                    '$rightval'
                    $extraValuesArg
                 )";
                    
         if($this->db->query($sql)) {
             return true;
         } else {
             log_message('error', "Node addition failed for $left_value - $right_value");
         }
         
         return false;
    }
    
    
    /** 
     * The method that performs moving/renumbering operations 
     * @param array $node The node to move
     * @param array $targetValue Position integer to use as the target
     * @return array $newpos The new left and right values of the node moved
     * @access private
     */
    function _moveSubtree($node, $targetValue)
    { 
        $sizeOfTree = $node[$this->right_column_name] - $node[$this->left_column_name] + 1;
        $this->_modifyNode($targetValue, $sizeOfTree);
        
        
        if($node[$this->left_column_name] >= $targetValue)
        {
            $node[$this->left_column_name] += $sizeOfTree;
            $node[$this->right_column_name] += $sizeOfTree;
        }
  
        $newpos = $this->_modifyNodeRange($node[$this->left_column_name], $node[$this->right_column_name], $targetValue - $node[$this->left_column_name]);
  
        $this->_modifyNode($node[$this->right_column_name]+1, - $sizeOfTree);
        
        if($node[$this->left_column_name] <= $targetValue)
        { 
            $newpos[$this->left_column_name] -= $sizeOfTree;
            $newpos[$this->right_column_name] -= $sizeOfTree;
        }
  
        return $newpos;
    }

    /**
     * _modifyNode
     *
     * Adds $changeVal to all left and right values that are greater than or
     * equal to $node_int
     * 
     * @param  $node_int The value to start the shift from
     * @param  $changeVal unsigned integer value for change
     * @access private
     */
   function _modifyNode($node_int, $changeVal)
    {
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        $table          =       $this->table_name;
        
        $sql =  "UPDATE     $table " .
                "SET        $leftcol = $leftcol + $changeVal ".
                "WHERE      $leftcol >= $node_int";
        
        $this->db->query($sql);
        
        $sql =  "UPDATE     $table " .
                "SET        $rightcol = $rightcol + $changeVal ".
                "WHERE      $rightcol >= $node_int";
        
        $this->db->query($sql);
        
        return true;
    } // END: _modifyNode
    
    /**
     * _modifyNodeRange
     *
     * @param $lowerbound integer value of lowerbound of range to move
     * @param $upperbound integer value of upperbound of range to move
     * @param $changeVal unsigned integer of change amount
     * @access private
     */
     
    function _modifyNodeRange($lowerbound, $upperbound, $changeVal)
    {
        $leftcol        =       $this->left_column_name;
        $rightcol       =       $this->right_column_name;
        $table          =       $this->table_name;
        
        $sql = "UPDATE      $table 
                SET         $leftcol    =   $leftcol    +   $changeVal 
                WHERE       $leftcol    >=  $lowerbound  
                AND         $leftcol    <=  $upperbound";
        
        $this->db->query($sql);
        
        $sql = "UPDATE      $table
                SET         $rightcol   =   $rightcol   +   $changeVal
                WHERE       $rightcol   >=  $lowerbound
                AND         $rightcol   <=  $upperbound";
        
        $this->db->query($sql);
        
        $retArray = array(
                            $this->left_column_name  =>  $lowerbound+$changeVal, 
                            $this->right_column_name =>  $upperbound+$changeVal
                          ); 
        return $retArray;
    } // END: Method _modifyNodeRange

} // END: Class Nested_sets

?>
