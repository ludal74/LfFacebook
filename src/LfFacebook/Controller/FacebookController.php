<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Facebook for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Facebook\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use LfLibrary\AbstractControllerClass;

class FacebookController extends AbstractControllerClass
{
    public function indexAction()
    {
        
    }

    /*
     * 
     * Facebook loginUrl callback
     * @return  a view page with callback JS methods
     */
    public function callbackAction()
    {   
        $config = $this->getServiceLocator()->get('Configuration') ; 
        
        $facebook = $this->getServiceLocator()->get('Facebook\Service\FacebookService');
        $facebook->getUser();

        if( $this->params('error') != '')
        {
        	$this->view->setVariable( 'msg' , 'error');
        	$this->view->setVariable( 'error' , $this->params('error') );
        	$this->view->setVariable( 'errorCallback' , $config["facebook"]["errorCallback"]);
        }
        else
        {     
            $facebook = $this->getServiceLocator()->get('Facebook\Service\FacebookService');
            $facebook->getUser();  
            
            //Debugg   
            //----------------------------------------------------------------   
            //print_r( $facebook->getUser() );
            
            //Mise en session de l'utilisateur facebook
            //----------------------------------------------------------------
            //$this->session->offsetSet('facebookUser', $facebook->getUser() );  
            //$this->session->offsetSet('facebook', $facebook );
            //$this->session->offsetSet('facebookAccesToken', $facebook->getAccessToken() );
      
            $this->view->setVariable( 'successCallback' , $config["facebook"]["successCallback"]);
            $this->view->setVariable( 'msg' , 'success');
        }
        
        return $this->view;   
    }
}
