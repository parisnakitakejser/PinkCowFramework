<?php
namespace PinkCow\Database;

class MongoDB
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @var string
	 */
	public static $_db = null;
	
	private static
		$_host = '127.0.0.1',
		$_port = '27017';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 * 
	 * @var string
	 */
	public static $database = '';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access private
	 * 
	 * @var int
	 */
	private static $_limit = 0;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access private
	 * 
	 * @var int
	 */
	private static $_skip = null;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access private
	 * 
	 * @var array
	 */
	private static $_sort = array();
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @return object
	 */
	public static function connect()
	{
		try 
		{
			if ( self::$_db == null ) 
			{
				$m = new \MongoClient('mongodb://'. self::$_host .':'. self::$_port );
				self::$_db = $m->selectDB( self::$database );
			}
			
			return self::$_db;
		}		
		catch (MongoConnectionException $e) 
		{
			print '<p>'. _('Couldn\'t connect to mongodb, is the "mongo" process running?') .'</p>';
			die();
		}
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @param int $limit
	 *
	 * @return int
	 */
	public static function setLimit( $limit )
	{
		self::$_limit = $limit;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 * 
	 * @param array $sort
	 *
	 * @return array
	 */
	public static function setSort( $sort = array() )
	{
		self::$_sort = $sort;
	}
	
	public static function setSkip($skip) {
		self::$_skip = $skip;
	}
	
	public static function setHost($value) {
		self::$_host = $value;
	}
	
	public static function setPort($value) {
		self::$_port = $value;
	}

	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @param string $collection
	 * @param array $query
	 * @param array $fields
	 *
	 * @return object
	 */
	public static function find($collection = '', $query = array(), $fields = array() )
	{
		$collection = new \MongoCollection(self::$_db, $collection);
		
		$obj = $collection->find( $query, $fields );
		
		if ( self::$_limit > 0 )
			$obj->limit( self::$_limit );
		
		if ( count( self::$_sort ) > 0 )
			$obj->sort( self::$_sort );
		
		if (self::$_skip) {
			$obj->skip(self::$_skip);
		}
		
		self::$_limit = 0;
		self::$_sort = array();
		self::$_skip = null;
		
		return iterator_to_array( $obj );
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @param string $collection
	 * @param array $query
	 * @param array $fields
	 *
	 * @return object
	 */
	public static function count($collection = '', $query = array(), $fields = array() ) {
		$collection = new \MongoCollection(self::$_db, $collection);
		
		$obj = $collection->count($query, $fields );
		
		return (int) $obj;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 *
	 * @param string $collection
	 * @param array $query
	 * @param array $fields
	 *
	 * @return object
	 */
	public static function findOne($collection='', $query = array(), $fields = array())
	{
		$collection = new \MongoCollection(self::$_db, $collection);
		$obj = $collection->findOne( $query, $fields = array() );
		
		return $obj;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 * 
	 * @param array $data
	 *
	 * @return void
	 */
	public static function insert( $collection, $data = array() )
	{
		$collection = new \MongoCollection(self::$_db, $collection);
		$collection->insert( $data );
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 *
	 * @param string $collection
	 * @param array $fields
	 * @param array $data
	 *
	 * @return void
	 */
	public static function update($collection, $fields=array(), $data=array())
	{
		$collection = new \MongoCollection(self::$_db, $collection);
		$collection->update( $fields,$data );
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 *
	 * @param string $collection
	 * @param array $fields
	 *
	 * @return void
	 */
	public static function remove($collection,$fields)
	{
		$collection = new \MongoCollection(self::$_db, $collection);
		$collection->remove($fields);
	}
}
?>