<?php
class CaptchaAction extends CCaptchaAction
{
	
	/**
     * Validates the input to see if it matches the generated code.
     * @param string user input
     * @param boolean whether the comparison should be case-sensitive
     * @return whether the input is valid
     */
    public function validate($input,$caseSensitive)
    {
    	$code=$this->getVerifyCode();
        $valid=$caseSensitive?($input===$code):!strcasecmp($input,$code);
		// Следующей строчки кода и не хватает
		// Эта строчка проверяет что запрос на проверку - аякс, и не нужно перегенерировать капчу.
        if(Yii::app()->request->isAjaxRequest) return $valid;
        $session=Yii::app()->session;
        $session->open();
        $name=$this->getSessionKey().'count';
        $session[$name]=$session[$name]+1;
        if($session[$name]>$this->testLimit && $this->testLimit>0)
            $this->getVerifyCode(true);
        return $valid;
    }
	
	protected function generateVerifyCode()
	{
	    if($this->minLength<3)
	        $this->minLength=3;
	    if($this->maxLength>20)
	        $this->maxLength=20;
	    if($this->minLength>$this->maxLength)
	        $this->maxLength=$this->minLength;
	    $length=rand($this->minLength,$this->maxLength);    

		$letters = 'bcdfghjklmnpqrstvwxyz';
		$vowels = 'aeiou';
		$code = '';
		for($i = 0; $i < $length; ++$i)
		{
			$code.=$letters[mt_rand(0,20)];
		}

		return $code;
	}
}
?>