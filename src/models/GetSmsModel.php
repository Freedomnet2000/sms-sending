<?php
    class GetSmsModel {

        function __construct() {
        }

        public function getSmsList() {
            include 'src\DB.php';
            $db = new DBobj;
            return ['data' => $db->getRows()];          
        }
    }