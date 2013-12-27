<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Facebook for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace LfFacebook;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap($e)
    {
    	// You may not need to do this if you're doing it elsewhere in your
    	// application
    	$eventManager        = $e->getApplication()->getEventManager();
    	$moduleRouteListener = new ModuleRouteListener();
    	$moduleRouteListener->attach($eventManager);
    	
    	$this->writeCssFile($e);
    	$this->writeJsFile($e);
    }
    
    public function writeCssFile($e)
    {
    	$basePath = $e->getApplication()->getRequest()->getBasePath();
    
    	//add css file to layout
    	$headLink = $e->getApplication()->getServiceManager()->get('viewhelpermanager')->get('headLink');
    	//$headLink->appendStylesheet( $basePath.'/assets/Application/css/main.css');
    }
    
    public function writeJsFile($e)
    {
    	$basePath = $e->getApplication()->getRequest()->getBasePath();
    
    	//add js file to layout
    	$headScript = $e->getApplication()->getServiceManager()->get('viewhelpermanager')->get('headScript');
    	$headScript->prependFile( $basePath."/assets/Facebook/js/libs/Jquery_1.10.2.js" );
    	//$headScript->prependFile( $basePath."/assets/Application/js/facebook.js" );
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    
    public function getServiceConfig() {
    	return array(
    			'factories' => array(
    					'LfFacebookService' => function ($sm) {
    						$config = $sm->get('config');
    						return new \LfFacebook\Service\LfFacebookService($config['facebook']);
    					},
    			),
    	);
    }
    
}
