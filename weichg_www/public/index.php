<?php

try {
	//Read the configuration
	$config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');
	
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views');
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "atnaer" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/weichg/');
        return $url;
    });
    
    //Start the session the first time a component requests the session service
    $di->set('session', function() {
    	$session = new Phalcon\Session\Adapter\Files();
    	$session->start();
    	return $session;
    });

    // Database connection is created based on parameters defined in the configuration file
    $di->set('db', function() use ($config) {
    	return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
    			"host" => $config->database->host,
    			"username" => $config->database->username,
    			"password" => $config->database->password,
    			"dbname" => $config->database->name
    	));
    });
    	
    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}