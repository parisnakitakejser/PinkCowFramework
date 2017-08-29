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

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @var string
	 */
	public static $host = '127.0.0.1';

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @var string
	 */
	public static $port = '27017';

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
	 * @access public
	 *
	 * @var string
	 */
	public static $username = '';

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @var string
	 */
	public static $password = '';

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
		#If in doubt use this : https://docs.mongodb.com/php-library/master/tutorial/ ^^
		try {
			if ( self::$_db == null ) {
				if(self::$username != '') {
					$m = new \MongoDB\Client('mongodb://'. self::$username .':'. self::$password .'@'. self::$host .':'. self::$port .'/admin');
				} else {
					$m = new \MongoDB\Client('mongodb://'. self::$host .':'. self::$port);
				}
				$currentDatabase = self::$database;
				self::$_db = $m->$currentDatabase;
			}

			return self::$_db;
		} catch (MongoConnectionException $e) {
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
	public static function setLimit( $limit ) {
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
	public static function find($collection = '', $query = array(), $fields = array() ) {
		$collection = self::$_db->$collection;

		$limit = 0;
		$sort = [];
		$skip = null;

		if ( self::$_limit > 0 )
			$limit = intval( self::$_limit );

		if ( count( self::$_sort ) > 0 )
			$sort = self::$_sort;

		if (self::$_skip) {
			$skip = self::$_skip;
		}

		$filters = [];
		$filters['limit'] = $limit;
		$filters['sort'] = $sort;
		$filters['skip'] = $skip;

		if(isset($fields) && count($fields) > 0){
			$filters['projection'] = $fields;
		}

		$obj = $collection->find( $query, $filters );

		self::$_limit = 0;
		self::$_sort = array();
		self::$_skip = null;

		return iterator_to_array( $obj );
	}

	public static function aggregate($collection, $ops = []) {
		$collection = self::$_db->$collection;

		$obj = $collection->aggregate($ops);

		return $obj;
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
		$collection = self::$_db->$collection;

		$obj = $collection->count($query, $fields);

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
		$collection = self::$_db->$collection;

		$limit = 1;

		$obj = $collection->findOne($query, [
			'projection' => $fields
		] );

		if(isset($fields) && count($fields) > 0){
			$obj = $collection->findOne($query, [
				'limit' => $limit,
				'projection' => $fields
			] );
		} else {
			$obj = $collection->findOne($query, [
				'limit' => $limit
			]);
		}

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
		$collection = self::$_db->$collection;

		if( isset($data[1]) ) {
			$collection->insertMany( $data );
		} else {
			$collection->insertOne( $data );
		}
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
		$collection = self::$_db->$collection;

		if( isset($data[1]) ) {
			$collection->updateMany( $fields,$data );
		} else {
			$collection->updateOne( $fields,$data );
		}
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
		$collection = self::$_db->$collection;
		$collection->deleteOne($fields);
	}
}
?>
