<?php

class SessionData
{
    public $ClientRevision;
    public $SessionID;
    public $SecretKey;
    public $Token;
    public $UUID;
    public $CountryID;
    
    public function __construct(
        $clientRevision,
        $sessionseID,
        $secretKey,
        $token,
        $uuid = "0EF49B00-DD49-4D01-9640-WRITHEMRADIO",
        $countryID = 137438953472
    )
    {
        $this->ClientRevision = $clientRevision;
        $this->SessionID = $sessionID;
        $this->SecretKey = $secretKey;
        $this->Token = $token;
        $this->UUID = $uuid;
        $this->CountryID = $countryID;
    }
}