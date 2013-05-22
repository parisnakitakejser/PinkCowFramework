<?php
namespace PinkCow\Database;

class MySQL
{
	private $_table = '';
	private $_bindparam = array();
	private $_where = array();
	private $_sql = "";
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @return void
	 */
	public function setTable($name)
	{
		$this->_table = $name;
		
		return $this;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $field
	 * @param string $value
	 * @param string $type
	 * @return void
	 */
	public function bind($field, $value, $type)
	{
		array_push($this->_bindparam, array(
			$field, 
			$value, 
			$type 
			)
		);
		return $this;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @param stirng $fieldX
	 * @param stirng $equal
	 * @param stirng $fieldY
	 * @return void
	 */
	public function where($fieldX, $equal ,$fieldY)
	{
		array_push($this->_where, array(
			$fieldX, 
			$equal, 
			$fieldY 
			)
		);
		
		return $this;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @return void
	 */
	private function _buildInsertSQL()
	{
		$fields = array();
		$values = array();
		
		if ( count( $this->_bindparam ) > 0 )
		{
			foreach( $this->_bindparam AS $key => $val )
			{
				array_push($fields,$val[0]);
				array_push($values,':'. $val[0]);
			}
		}
		
		$this->_sql = "INSERT INTO ". $this->_table ."(". implode(',', $fields) .")
		VALUES(". implode(',', $values) .")
		";
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $method
	 * @return void
	 */
	public function commit($method = '')
	{
		if ( $method == 'insert' )
			$this->_buildInsertSQL();
		
		$query = \PinkCow\Database::prepare( $this->_sql );
		\PinkCow\Database::exec( $query, $this->_bindparam);
		
		return $this;
	}
}
?>