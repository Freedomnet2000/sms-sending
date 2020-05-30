<?php
    require 'src\models\SendSmsModel.php';
    const key = 'security111333';

    class SendSmsController {

        function __construct() {
        }

        public function fireSms($post) {
            $responseArray = [];

            if ($post['key'] != key) {
                $responseArray['msg'] = 'sending sms is not allowed';
                $responseArray['status'] = false;
                 return $responseArray;
            }

            $model = new SendSmsModel;
            $dbUpdate = $model->handleSms($post);

            if ($dbUpdate['success'] == true) {
                 return $dbUpdate;
            } else {
                $responseArray['msg'] = 'unable to save the record to the table';
                $responseArray['status'] = false;
                return $responseArray;
            }
        }
    }