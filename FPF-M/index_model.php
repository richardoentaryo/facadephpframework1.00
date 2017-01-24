<?php

    /**
    * The home page model
    */
    class IndexModel
    {

        private $message = 'Welcome to Facade PHP Framework';

        function __construct()
        {

        }

        public function welcomeMessage()
        {
            return $this->message;
        }

    }
