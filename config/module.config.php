<?php
namespace Facebook;

return array(
    
    //----------------------------------------------
    // CONTROLLERS CONFIGURATION
    //-----------------------------------------------
    'controllers' => array(
        'invokables' => array(
            'LfFacebook\Controller\Facebook' => 'LfFacebook\Controller\FacebookController',
        ),
    ),
    
    //----------------------------------------------
    // ROUTER CONFIGURATION
    //-----------------------------------------------
    'router' => array(
        'routes' => array(
            
            'facebook' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/facebook[/:action]',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Facebook\Controller',
                        'controller'    => 'Facebook',
                        'action'        => 'index',
                    ),
                ),
                /*
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
                */
            ),
        ),
    ),
    
    //----------------------------------------------
    // VIEW MANAGER CONFIGURATION
    //-----------------------------------------------
    'view_manager' => array(
        'template_map' => array(
        		'layout/facebook_layout'           => __DIR__ . '/../view/layout/layout.phtml',
        		'facebook/index/index' => __DIR__ . '/../view/facebook/index/index.phtml',
        		//'error/404'               => __DIR__ . '/../view/error/404.phtml',
        		//'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'Facebook' => __DIR__ . '/../view',
        ),
    ),
    
    //ASSETS MANAGER
    //-----------------------
    'asset_manager' => array(
    
    		'resolver_configs' => array(
    				'paths' => array(
    						__NAMESPACE__ => __DIR__ . '/../public',
    				),
    		),
    
    		// Must be overriden in local.php file ( FileSystem on Dev environnement AND FilePath in Production environement )
    		'caching' => array(
    
    				'default' => array(
    						'cache'     => 'FilePath',
    						'options' => array(
    								'dir' => 'public',
    						),
    				),
    		),
    ),
    
    //----------------------------------------------
    // FACEBOOK CONFIGURATION
    //-----------------------------------------------
    'facebook' => array(
    	'appId'            => 'YOUR_API_ID',
    	'secret-key'       => 'YOUR_SECRET_KEY',	
        'permissions'      => array(
                               //'email', 
                               //'publish_stream', 
                               //'user_likes',
                                ),
        'redirect-url'     => '/YOUR_SPECIFIC_PATH/facebook/callback',
        'errorCallback'    => 'facebookUserErrorCallback()',
        'successCallback'  => 'facebookUserErrorCallback()',
    ),
);
