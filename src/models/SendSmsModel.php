<?php
    class SendSmsModel {

        function __construct() {
        }

        public function handleSms($post) {
            $smsRequest = (object) $post;
            $smsRequest->time = date("Y-m-d H:i:s");

            include 'src\models\TelsignProvider.php';
            $sendAction = new TelsignProvider;
            $sendingResponse = $sendAction->sendSms($smsRequest->toNumber,$smsRequest->message);
            $smsRequest->smsStatus = $sendingResponse->status_code == 200 ? true : false;


            $dbResponse =  $this->addSmsToDb($smsRequest);

            $sendResponseArray = [
                "id" => $dbResponse['id'],
                "time" => $smsRequest->time,
                "smsStatus" => $smsRequest->smsStatus,
                'success' => true,
            ];
            return $sendResponseArray;
        }

        /**
         * @param $smsRequest
         * @return array
         */
        private function addSmsToDb($smsRequest) {
            include 'src\DB.php';
            $db = new DBobj;
            return $db->addRow($smsRequest);
        }
    }