<?php

    /*
    if(!isset($_SERVER['PATH_INFO']))
    {
        echo "Home Page";
        exit();
    }
    */

    $url = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : '/';

    if ($url == '/')
    {

        // This is the path of the home page
        // So firstly the home controller shoud be initiated before everything else
        // Finally render the appropriate home view

        require_once __DIR__.'/FPF-M/index_model.php';
        require_once __DIR__.'/FPF-C/index_controller.php';
        require_once __DIR__.'/FPF-V/index_view.php';

        $indexModel         = New IndexModel();
        $indexController    = New IndexController($indexModel);
        $indexView          = New IndexView($indexController, $indexModel);

        print $indexView->index();
    }
    else
    {
        // This is not the path of home page
        // Initiate the appropriate controller from the url
        // and render the required view

        //The first element should be a controller
        $requestedController = $url[1];

        // If a second url segment is exists in the URI path,
        // it should be a method
        $requestedAction = isset($url[2])? $url[2] :'';

        // The remaining parts if there are any, considered as
        // arguments of the method
        $requestedParams = array_slice($url, 3);

        // Check if controller exists. NB:
        // You have to do that for the model and the view too
        $ctrlPath = __DIR__.'/FPF-C/'.$requestedController.'_controller.php';

        if (file_exists($ctrlPath))
        {

            require_once __DIR__.'/FPF-M/'.$requestedController.'_model.php';
            require_once __DIR__.'/FPF-C/'.$requestedController.'_controller.php';
            require_once __DIR__.'/FPF-V/'.$requestedController.'_view.php';

            $modelName      = ucfirst($requestedController).'Model';
            $controllerName = ucfirst($requestedController).'Controller';
            $viewName       = ucfirst($requestedController).'View';

            $controllerObj  = new $controllerName( new $modelName );
            $viewObj        = new $viewName( $controllerObj, new $modelName );


            // If there is a method - Second parameter
            if ($requestedAction != '')
            {
                // then we call the method via the view
                // dynamic call of the view
                print $viewObj->$requestedAction($requestedParams);

            }

        }
        else
        {
            header('HTTP/1.1 404 Not Found');
            die('404 - The file - '.$ctrlPath.' - not found');
            //require the 404 controller and initiate it
            //Display its view
        }
    }
?>
