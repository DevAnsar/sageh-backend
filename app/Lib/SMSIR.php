<?php
namespace App\Lib;
class SMSIR
{
    protected $APIKey;
    protected $SecretKey;
    protected $LineNumber;

    function __construct($APIKey, $SecretKey, $LineNumber)
    {
        $this->APIKey = $APIKey;
        $this->SecretKey = $SecretKey;
        $this->LineNumber = $LineNumber;

    }

    public function SendMessage($MobileNumbers, $Messages, $SendDateTime = '')
    {

        $token = $this->GetToken();
        if ($token != false) {
            $postData = array(
                'Messages' => $Messages,
                'MobileNumbers' => $MobileNumbers,
                'LineNumber' => $this->LineNumber,
                'SendDateTime' => $SendDateTime,
                'CanContinueInCaseOfError' => 'false'
            );

            $url = $this->getAPIMessageSendUrl();
            $SendMessage = $this->execute($postData, $url, $token);
            $object = json_decode($SendMessage);
            if (is_object($object)) {
                $array = get_object_vars($object);
                if (is_array($array)) {
                    $result = $array['Message'];
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function GetToken()
    {
        $postData = array(
            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_1_2'
        );
        $postString = json_encode($postData);
//        return strlen($postString );
        $ch = curl_init($this->getApiTokenUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, strlen($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        if (is_object($response)) {
            $resultVars = get_object_vars($response);
            if (is_array($resultVars)) {
                @$IsSuccessful = $resultVars['IsSuccessful'];
                if ($IsSuccessful == true) {
                    @$TokenKey = $resultVars['TokenKey'];
                    $resp = $TokenKey;
                } else {
                    $resp = false;
                }
            }
        }

        return $resp;
    }

    /**
     * gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl()
    {
        return "http://RestfulSms.com/api/Token";
    }

    /**
     * gets API Message Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageSendUrl()
    {
        return "http://RestfulSms.com/api/MessageSend";
    }

    /**
     * executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string $url url
     * @param string $token token string
     * @return string Indicates the curl execute result
     */
    private function execute($postData, $url, $token)
    {

        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-sms-ir-secure-token: ' . $token
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, strlen($postString));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Verification Code.
     *
     * @param string $Code Code
     * @param string $MobileNumber Mobile Number
     * @return string Indicates the sent sms result
     */
    public function VerificationCode($Code, $MobileNumber)
    {

        $token = $this->GetToken();
        if ($token != false) {
            $postData = array(
                'Code' => $Code,
                'MobileNumber' => $MobileNumber,
            );

            $url = $this->getAPIVerificationCodeUrl();
            $VerificationCode = $this->execute($postData, $url, $token);
            $object = json_decode($VerificationCode);

            if (is_object($object)) {
                $array = get_object_vars($object);
                if (is_array($array)) {
                    $result = $array['Message'];
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * gets API Verification Code Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIVerificationCodeUrl()
    {
        return "http://RestfulSms.com/api/VerificationCode";
    }

    /**
     * Ultra Fast Send Message.
     *
     * @param data[] $data array structure of message data
     * @return string Indicates the sent sms result
     */
    public function UltraFastSend($data)
    {

        $token = $this->GetToken();
        if ($token != false) {
            $postData = $data;

            $url = $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->execute($postData, $url, $token);
            $object = json_decode($UltraFastSend);

            if (is_object($object)) {
                $array = get_object_vars($object);
                if (is_array($array)) {
                    $result = $array['Message'];
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * gets API Ultra Fast Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIUltraFastSendUrl()
    {
        return "http://RestfulSms.com/api/UltraFastSend";
    }
//$data = array(
//"ParameterArray" => array(
//array(
//"Parameter" => "FirstVariable",
//"ParameterValue" => "xxxx"
//),
//array(
//"Parameter" => "SecondVariable",
//"ParameterValue" => "xxxx"
//),
//array(
//"Parameter" => "ThirdVariable",
//"ParameterValue" => "xxxx"
//)
//),
//"Mobile" => "091xxxxxxxx",
//"TemplateId" => "26"
//);


}