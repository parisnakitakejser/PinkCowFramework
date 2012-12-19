<?php
namespace PinkCow;

class Date
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 * 
	 * @param int $number
	 * @return string
	 */
	private function _convertToDecimal($number)
	{
		
		if ( $number <= 9 )
		{
			$decimal = '0'. $number;
		}
		else
		{
			$decimal = $number;
		}
		
		return $decimal;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @param date $birthday
	 * @return int
	 */
	public function getBirthdayYear( $birthday )
	{
		list($year,$month,$day) = explode("-",$birthday);
		
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		
		if ($day_diff < 0 || $month_diff < 0)
			$year_diff--;
			
		return $year_diff;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @param int $decimal
	 * @return array
	 */
	public function getHourInterval( $decimal = 2 )
	{
		$hourArray = array();
		
		for( $i = 0; $i <= 23; $i++ )
		{
			if ( $decimal == 2 )
				$hour = $this->_convertToDecimal( $i );
			else
				$hour = $i;
			
			array_push( $hourArray, $hour );
		}
		
		return $hourArray;
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @param int split 
	 * @return array
	 */
	public function getMinutesInterval( $split = 0 )
	{
		$minutesArray = array();
		
		$iLoop = 1;
		$iReset = 1;
		
		for( $i = 0; $i <= 59; $i++ )
		{
			if ( $split != 0 )
			{
				if ( $i == 0 )
				{
					array_push( $minutesArray , $this->_convertToDecimal(0) );
				}
				
				if ( $iLoop == $split && ( 60 / $split ) > $iReset )
				{
					array_push( $minutesArray , $this->_convertToDecimal( ( $iReset * $split ) ) );
					$iLoop = 1;
					$iReset++;
				}
				else
				{
					$iLoop++;
				}
			}
			else
			{
				array_push( $minutesArray , $this->_convertToDecimal( $i ) );
			}
		}
		
		return $minutesArray;
	}
}
?>