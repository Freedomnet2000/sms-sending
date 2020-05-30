<?php
            require 'C:\xampp\htdocs\sms\sending2\vendor\autoload.php';
            use telesign\sdk\messaging\MessagingClient;

    class TelsignProvider{
        function __construct() { 
            $this->customer_id = "04FE9291-050F-462A-A8EA-AA50A4C83752";
            $this->api_key = "Kr1YvgDIy2WWEmXo0Ds9byVV2Pa5+49a4F3XbudoRVK4OHq2r+05/uxHZioN/bhVALseddUxRrCWDJ3OuZagQQ==";
        }

        public function sendSms(string $phone_number, string $message) {
            $message_type = "ARN";
            $messaging = new MessagingClient($this->customer_id, $this->api_key);
            $response = $messaging->message($phone_number, $message, $message_type);
            return $response;
        }
    }
