<?php

namespace LfFacebook\Service;

/**
 * Facebook\Service\Facebook
 *
 * Zend Framework2 Facebook Class
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * Facebook tools
 *
 * @package                Zend Framework 2
 * @author                LF DEVELOPPEMENT
 */

use LfFacebook\Classes\Facebook as Facebook;

class LfFacebookService
{
    /*
    public static  $appId = null;
    public static  $secret_key = null;
    public static  $permissions = array();
    public static  $redirect_url = null;
    public static  $facebook = null;
    */
    
    protected $appId = null;
    protected $secret_key = null;
    protected $permissions = array();
    protected $redirect_url = null; 
    protected $accessToken = null;
    
    
   
    protected $facebook;
    
    protected $config;

	/**
	 * Constructor
	*/
	function __construct( $config )
	{    
		$this->appId          = $config["appId"];
		$this->secret_key     = $config["secret-key"];
		$this->permissions    = implode( "," , $config["permissions"] );
		$this->redirect_url   = $config["redirect-url"];

		$this->initializeFacebookObject();
	}
	
	private function initializeFacebookObject()
	{       
	    $config = array();
	    $config["appId"] = $this->appId;
	    $config["secret"] = $this->secret_key;
	    $config["cookie"] = true;
	    $config["fileUpload"] = false; // optional
	    $this->config = $config;
	    $this->facebook = new Facebook($this->config);
	}
	
	/**
	 * Get appId
	 */
	public function getAppId()
	{
	    $this->facebook = new Facebook($this->config);
	    return $this->facebook->getAppId();
	} 

    /**
     * Get login URL
     * @return Ambigous <string, multitype:string >
     */
	public function getLoginUrl()
	{ 
	    //$this->destroySession();
	    $this->facebook = new Facebook($this->config);
	    
	    $params = array('canvas' => 1, 'fbconnect' => 0, 'scope' => $this->permissions, 'display' => 'popup' , 'redirect_uri' => 'http://'.$_SERVER['HTTP_HOST'].$this->redirect_url );
	    $url = $this->facebook->getLoginUrl($params);   
        return $url;
	}
	
	/**
	 * 
	 */
	public function getSignedRequest()
	{  
	   $this->facebook = new Facebook($this->config);
	   return $this->facebook->getSignedRequest();
	}

	/**
	 * Get connected facebook user
	 * @return NULL
	 */
	public function getUser(  $jsonFormat = false )
	{
	    //$this->destroySession();
	    $this->facebook = new Facebook($this->config);
	    
		try
		{
			$user = $this->facebook->getUser();
			 
			if ( $user != 0 )
			{
			     $user_profile = $this->facebook->api('/me' );
			}
			 
		}
		catch (FacebookApiException $e) 
		{
		    $this->sendError( new \Exception( $e ) );
			$user_profile = null;
		}
		
		if( !isset( $user_profile ) )
		{
			$result = 0;
		}
		else 
		{
		    $result = $user_profile;
		}
		
		
		if( $jsonFormat )
		{
			$return = json_encode( $result );
		}
		else
		{
		    $return = $result;
		}

		return $return;
	}
	
	/**
	 * Check if user likes a Facebook page
	 * 
	 */
	public function getUserLikeFacebookPage( $pageId )
	{
	    //$this->destroySession();
	    $this->facebook = new Facebook($this->config);
	    
		$user = $this->facebook->getUser();
	
		if ( $user != 0 ) {
	
			try{
			    
			    $user_profile = $this->facebook->api('/me' );
			    
			    if( !array_key_exists('error',  $user_profile ) )
			    {
    				$user_profile = $this->facebook->api('/me' );
    	
    				$likeID = $this->facebook->api(array(
    						'method' => 'fql.query',
    						'query' => 'SELECT page_id FROM page_fan WHERE uid = "'.$user_profile['id'].'" AND page_id="'.$pageId.'"'  ));
			    }
			}
			catch(FacebookApiException $e) 
			{ 
			    $this->sendError( new \Exception( $e ) );
			}
		}
	
		if( isset( $likeID ) )
		{   
    		if( count($likeID)>0 )
    		{
    			$result = true;
    		}
    		else
    		{
    			$result = false;
    		}
		}
		else
		{
		    $result = false;
		}
		return $result;
	}
	
	/**
	 * Check if user likes a specific URL
	 * 
	 */
	public function getUserLikeUrl( $url )
	{
	    //$this->destroySession();
	    $this->facebook = new Facebook($this->config);
		
	    $user = $this->facebook->getUser();

		if ($user != 0 ) {
	
			try{

				$user_profile = $this->facebook->api('/me' );

				if( !array_key_exists('error',  $user_profile ) )
				{
    				//$likePageFan = 'SELECT page_id FROM page_fan WHERE uid = "'.$user_profile['id'].'" AND page_id="'.$this->jpgPageId.'"';    	
    				
    				$likeID = $this->facebook->api(array(
    						'method' => 'fql.query',
    						'query' => 'SELECT url FROM url_like WHERE user_id = "'.$user_profile['id'].'" AND url="'.$url.'"' ));
				}	

			}
			catch(FacebookApiException $e) 
			{ 
			    $this->sendError( new \Exception( $e ) );
			}
		}
	
		if( isset( $likeID ) )
		{
		    if( count( $likeID ) > 0 )
		    {
			    $result = true;
		    }
		    else
		    {
		        $result = false;
		    }
		}
		else
		{
			$result = false;
		}
			
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $error
	 */
	private function sendError( $error )
	{
	    throw new \Exception( "FacebookService :: ".$error );
	}
	
	/**
	 * 
	 */
	
	private function destroySession()
	{
	    $this->facebook->destroySession();
	}
	
}