<?php
    class SendSmsModel {

        function __construct() {
            $this->env = 'sandbox';
        }

        public function handleSms($post) {
            $smsRequest = (object) $post;
            $smsRequest->time = date("Y-m-d H:i:s");

            if (!$this->env == 'sandbox') {
                
                // TDOO : CALL SMS Provider
            }

            $dbResponse =  $this->addSmsToDb($smsRequest);

            $sendResponseArray = [
                "id" => $dbResponse['id'],
                "time" => $smsRequest->time,
                "smsStatus" => $smsRequest->smsStatus,
                'success' => true,
            ];
            return $sendResponseArray;
        }
        
        private function addSmsToDb($smsRequest) {
            include 'src\DB.php';
            $db = new DBobj;
            return $db->addRow($smsRequest);
        }
    }