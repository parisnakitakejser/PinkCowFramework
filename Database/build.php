<?php
namespace PinkCow;

class Database
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	private static $_DBType = 'mysql';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	private static $_DBHost = 'localhost';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	private static $_DBName = '';

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	private static $_DBUser = '';

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	private static $_DBPass = '';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	public static $count_query = 0;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	public static $count_select = 0;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	public static $count_execute = 0;

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	public static $_db = null;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @return object
	 */
	public static function connect()
	{
		try 
		{
			if ( self::$_db == null ) 
			{
				self::$_db = new \PDO(self::$_DBType .':host='. self::$_DBHost .';dbname='. self::$_DBName, self::$_DBUser, self::$_DBPass);
				self::$_db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
				self::$_db->setAttribute( \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY , true );
			}
			
			return self::$_db;
		}		
		catch (PDOException $e) 
		{
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $var
	 * @return void
	 */
	public static function setDBName($var)
	{
		self::$_DBName = $var;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $var
	 * @return void
	 */
	public static function setDBHost( $var )
	{
		self::$_DBHost = $var;
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 * @var string
	 */
	public static function setDBUser( $var )
	{
		self::$_DBUser = $var;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $var
	 * @return void
	 */
	public static function setDBPass( $var )
	{
		self::$_DBPass = $var;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param array $type
	 * @return PDO_OBJECT
	 */
	private static function _bindparam( $type = array() )
	{
		switch( strtoupper( $type ) )
		{
			case 'INT':
				return \PDO::PARAM_INT;
				break;
				
			case 'STR':
				return \PDO::PARAM_STR;
				break;
		}
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $query
	 * @param array $bindparams
	 * @return object
	 */
	public static function fetch( $query , $bindparams = array() )
	{
		if ( count( $bindparams ) > 0 )
		{
			foreach( $bindparams AS $v )
			{
				$query->bindParam( ":{$v[0]}" , $v[1] , self::_bindparam( $v[2] ) );
			}
		}
		
		$query->execute();
		$row = $query->fetch( \PDO::FETCH_OBJ );
		
		self::$count_select += 1;
		self::$count_query += 1;
		
		return $row;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $query
	 * @param array $bindparams
	 * @return void
	 */
	public static function exec( $query , $bindparams = array() )
	{
		if ( count( $bindparams ) > 0 )
		{
			foreach( $bindparams AS $v )
			{
				$query->bindParam( ":{$v[0]}" , $v[1] , self::_bindparam( $v[2] ) );
			}
		}
		
		$query->execute();
		self::$count_execute += 1;
		self::$count_query += 1;
	}

	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $query
	 * @param array bindparams
	 * @return object
	 */
	public static function fetchAll( $query , $bindparams = array() )
	{
		if ( count( $bindparams ) > 0 )
		{
			foreach( $bindparams AS $v )
			{
				$query->bindParam( ":{$v[0]}" , $v[1] , self::_bindparam( $v[2] ) );
			}
		}
		
		$query->execute();
		$row = $query->fetchAll( \PDO::FETCH_OBJ );
		
		self::$count_select += 1;
		self::$count_query += 1;
		
		return $row;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @return object
	 */
	private static function errorHandler()
	{
		return self::$_db->errorInfo();
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @param string $sql
	 * @return object
	 */
	public static function prepare( $sql )
	{
		if ( ( $s = self::$_db->prepare( $sql ) ) != false )
			return $s;
		else 
			return self::$_errorHandler();
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @return string
	 */
	public static function statistics()
	{
		$content = '
		<code>
			Select: '. self::$count_select .'<br />
			Exec: '. self::$count_execute .'<br />
			Query: '. self::$count_query .'<br />
		</code>';
		
		return $content;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.0.0.2
	 *
	 * @return int
	 */
	public static function lastInsertId()
	{
		return self::$_db->lastInsertId();
	}
}
?>