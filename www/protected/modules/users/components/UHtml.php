<?php
class UHtml extends CHtml
{
        public static function activeTimeField($model,$attribute,$htmlOptions=array())
        {
                // SET UP ARRAYS OF OPTIONS FOR DAY, MONTH, YEAR
                $x = 0;
                
                $hourOptions = array('0'=>' - ');
                while ($x < 24)
                {
                        $hourOptions[$x] = (($x<10)?'0':'').$x;
                        $x++;
                }
                
                $x = 0;
                $minuteOptions = array('0'=>' - ');
                while ($x < 61)
                {
                        $minuteOptions[$x] = (($x<10)?'0':'').$x;
                        $x++;
                }
                
                $x = 0;
                $secondOptions = array('0'=>' - ');
                while ($x < 61)
                {
                        $secondOptions[$x] = (($x<10)?'0':'').$x;
                        $x++;
                }
                
                $x = 1;
                $dayOptions = array('0'=>' - ');
                while ($x < 31)
                {
                        $dayOptions[$x] = $x;
                        $x++;
                }

                $monthOptions = array(
					'0' => ' - ',
					'1'=> Users::t('January'),
					'2'=> Users::t('February'),
					'3'=> Users::t('March'),
					'4'=> Users::t('April'),
					'5'=> Users::t('May'),
					'6'=> Users::t('June'),
					'7'=> Users::t('July'),
					'8'=> Users::t('August'),
					'9'=> Users::t('September'),
					'10'=> Users::t('October'),
					'11'=> Users::t('November'),
					'12'=> Users::t('December'),
                );

                $yearOptions = array('0'=>' - ');
                $x = 1901;
                while ($x < 2030)
                {
                        $yearOptions[$x] = $x;
                        $x++;
                }


                parent::resolveNameID($model,$attribute,$htmlOptions);
                
                if (is_array($model->$attribute)) {
                	$arr = $model->$attribute;
                	$model->$attribute = mktime($arr['hour'],$arr['minute'],$arr['second'],$arr['month'],$arr['day'],$arr['year']);
                }
                
                if ($model->$attribute != '0' && isset($model->$attribute))
                {
                		//echo "<pre>"; print_r(date('Y-m-d',$model->$attribute)); die();
                        // intval removes leading zero
                        $day = intval(date('j',$model->$attribute));
                        $month = intval(date('m',$model->$attribute));
                        $year = intval(date('Y',$model->$attribute));
                        
                        $hour = intval(date('H',$model->$attribute));
                        $minute = intval(date('i',$model->$attribute));
                        $second = intval(date('s',$model->$attribute));
                } else
                {
                        // DEFAULT TO 0 IF THERE IS NO DATE SET
                        $day = intval(date('j',time()));
                        $month = intval(date('m',time()));
                        $year = intval(date('Y',time()));
                        
                        $hour = intval(date('H',time()));
                        $minute = intval(date('i',time()));
                        $second = intval(date('s',time()));
                        /*
                        $day = 0;
                        $month = 0;
                        $year = 0;
                        $hour = 0;
                        $minute = 0;
                        $second = 0;//*/
                }
                

                $return  = parent::dropDownList($htmlOptions['name'].'[day]', $day,$dayOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[month]', $month,$monthOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[year]', $year,$yearOptions);
                $return .= ' Time:';
                $return .= parent::dropDownList($htmlOptions['name'].'[hour]', $hour,$hourOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[minute]', $minute,$minuteOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[second]', $second,$secondOptions);
                return $return;
		}

		public static function activeDateField($model,$attribute,$htmlOptions=array())
        {
                // SET UP ARRAYS OF OPTIONS FOR DAY, MONTH, YEAR
                $x = 1;
                $dayOptions = array('00'=>' - ');
                while ($x < 31)
                {
                        $dayOptions[(($x<10)?'0':'').$x] = $x;
                        $x++;
                }

                $monthOptions = array(
					'00' => ' - ',
					'01'=> Users::t('January'),
					'02'=> Users::t('February'),
					'03'=> Users::t('March'),
					'04'=> Users::t('April'),
					'05'=> Users::t('May'),
					'06'=> Users::t('June'),
					'07'=> Users::t('July'),
					'08'=> Users::t('August'),
					'09'=> Users::t('September'),
					'10'=> Users::t('October'),
					'11'=> Users::t('November'),
					'12'=> Users::t('December'),
                );

                $yearOptions = array('0000'=>' - ');
                $x = 1901;
                while ($x < 2030)
                {
                        $yearOptions[$x] = $x;
                        $x++;
                }


                parent::resolveNameID($model,$attribute,$htmlOptions);
                
                if ($model->$attribute != '0000-00-00' && isset($model->$attribute))
                {
                        if (is_array($model->$attribute)) {
                        	$new = $model->$attribute;
                        	
	                        $day = $new['day'];
	                        $month = $new['month'];
	                        $year = $new['year'];
                        	
                        } else {
                        	$new = explode('-',$model->$attribute);
                			// intval removes leading zero
	                        $day = $new[2];
	                        $month = $new[1];
	                        $year = $new[0];
                        }
                } else {
                        // DEFAULT TO 0 IF THERE IS NO DATE SET
                        $day = '00';
                        $month = '00';
                        $year = '0000';
                }
                
                //echo "<pre>"; print_r(array($day,$month,$year)); die();

                $return  = parent::dropDownList($htmlOptions['name'].'[day]', $day,$dayOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[month]', $month,$monthOptions);
                $return .= parent::dropDownList($htmlOptions['name'].'[year]', $year,$yearOptions);
                return $return;
}


}