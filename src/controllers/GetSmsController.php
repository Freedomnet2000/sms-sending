<?php
    class GetSmsController {

        function __construct() {
        }

        public function getSmsList() {
            require 'src\models\GetSmsModel.php';
            $model = new GetSmsModel;
            $list = $model->getSmsList();
            return $list;
        }
    }
?>