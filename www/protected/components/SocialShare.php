<?php
class SocialShare extends CWidget {
    
    public $title;
    
    public function run() {
        $this->render('socialShare');
    }
    
    public function share_url($type='', $args=array()){
		$url = $this->_share_check( $type );

		$params = array();
		if( $type == 'twitter' ){
			foreach( explode(' ', 'url via text related count lang counturl') as $v ){
				if( isset($args[$v]) ) $params[$v] = $args[$v];
			}
		}elseif( $type == 'facebook' ){
			$params['u']		= $args['url'];
			$params['t']		= $args['text'];
		}elseif( $type == 'buzz'){
			$params['url']		= $args['url'];
			$params['imageurl']	= $args['image'];
			$params['message']	= $args['text'];
		}elseif( $type == 'vkontakte'){
			$params['url']		= $args['url'];
		} elseif($type == 'moimir'){
            $params['url'] = $args['url'];
		}

		$param = '';
		foreach( $params as $k=>$v ) $param .= '&'.$k.'='.urlencode($v);
		return $url.'?'.trim($param, '&');
	}
    
    private function _share_check( $type='' ){
		$url = array(
			'twitter'	=> 'http://twitter.com/share',
			'facebook'	=> 'http://facebook.com/sharer.php',
			'buzz'		=> 'http://www.google.com/buzz/post',
			'vkontakte'	=> 'http://vkontakte.ru/share.php',
            'moimir'    => 'http://connect.mail.ru/share'
		);
		return (isset($url[$type])) ? $url[$type] : FALSE;
	}
}
?>