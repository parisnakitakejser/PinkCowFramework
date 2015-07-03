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
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @param int $from
	 * @param int $to
	 * @return array
	 */
	public function getYearInterval($from,$to)
	{
		$array = array();
		
		for( $i = $from; $i < $to; $i++ )
		{
			array_push($array, $i);
		}
		
		return $array;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @return array
	 */
	public function getDayList()
	{
		$array = array();
		
		for( $i = 1; $i <= 31; $i++ )
		{
			array_push( $array, $i );
		}
		
		return $array;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @return array
	 */
	public function getMonthList()
	{
		$array = array();
		
		for( $i = 1; $i <= 12; $i++ )
		{
			array_push( $array, $i );
		}
		
		return $array;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.1
	 * @version 1.1.0.1
	 *
	 * @param string $skip_days
	 * @param string $start
	 * @return string
	 */
	public static function goToNextWorkDay($skip_days=1,$start = null) {
		$start_date = ( $start ? $start : date('Y-m-d') );
		$date = new \DateTime($start_date);
		$_days = 0;

		while($_days !== (int) $skip_days) {
			$date->modify("+1 day");
			$day_number = date('w', $date->getTimestamp());
	
			// Sat & Sun are not a work days - so we want to skip this days
			if ($day_number == 0 || $day_number == 6 ) {
				if($day_number == 0) { // Sun add one day
					$add_to_next_work_day = 1;
				} else { // Sat add two days
					$add_to_next_work_day = 2;
				}
				$date->modify("+$add_to_next_work_day day");
			}
	
			$_days++;
		}
		
		return $date->getTimestamp();
			
	}
}
?>