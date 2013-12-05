<?php
require_once ('groovesharkdb.php');
require_once ('sessiondata.php');

class Grooveshark
{
    #region Public Properties
    public $SessionData;
    public $Token;
    #endregion

    #region Private Members
    private $_dbConnection;
    #endregion
    
    #region Constructor(s)
    public function __construct()
    {
        $this->_dbConnection = new GroovesharkDatabase(
            $cfg['db']['host'],
            $cfg['db']['dbase'],
            $cfg['db']['user'],
            $cfg['db']['pass']
        );
        
        $this->initialize();
    }
    #endregion

    #region Public Functions
    public function somethingToDoWithGettingAllBroadcastData()
    {
        if ($this->SessionData == null)
            throw new Exception("SessionData is not available.");
            
        if ($this->Token == null)
            throw new Exception("Token is not available.");
        
        // get users
        // loop through users
        // get data for user
    }
    #endregion

    #region Private Functions
    private function initialize()
    {
        $sessionData = $this->_dbConnection->getSessionData();
        if (sessionData == null)
        {
            // No session data has been cached yet, get it
            $sessionData = $this->getSessionDataFromWeb();
        }
        
        if ($sessionData != null)
        {
            $token = $this->getTokenFromWeb($sessionData);
            
            if ($token == null)
            {
                $sessionData = $this->getSessionDataFromWeb();
                $token = $this->getTokenFromWeb($sessionData);
            }
            
            if ($token == null)
            {
                // Give up, cry, log messages.
            }
            else
            {
                $this->SessionData = $sessionData;
                $this->Token = $token;
            }
        }
    }
    
    private function getSessionDataFromWeb()
    {
        $sessionData = null;
        
        // $sessionData = $this->gsWebInterface->QuerySessionData();
        if ($sessionData == null)
        {
            // Trigger some failure
            // Email?
        }
        else
        {
            $this->_dbConnection->saveSessionData($sessionData);
        }
        
        return $sessionData;
    }
    
    private function getTokenFromWeb()
    {
        $token = null;
        
        // MAGIC!
        
        return $token;
    }
    #endregion
    
    
    // public function getBroadcastData($sessionData)
    // {
        // $data = "";
        
        // return $data;
    // }
}