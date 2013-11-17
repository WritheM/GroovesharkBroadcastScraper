<?php
require_once ('groovesharkdb.php');
require_once ('sessiondata.php');

class Grooveshark
{
    // Get data from GS using the supplied session data object
    public function getBroadcastData($sessionData)
    {
        $data = "";
        
        return $data;
    }
    
    public function querySessionData()
    {
        $sessionData = null;
        
        if ($this->dbConnection != null)
        {
        }
        // $sessionData['clientRevision'] = "20120830";
        // $sessionData['sessionID'] = 'notarealsessionidorsecret';
        // $sessionData['secretKey'] = 'efb0554935f4f1899378697f9fe90a29';
        // $sessionData['token'] = '525e2236b300b';
        // $userID = 21133592;
        // $broadcastID = 'xxx';


        return $sessionData;
    }
}