<?php

require('grooveshark.php');
require('database.php');
  
if (isset($_GET['debug']))
{
    ini_set('display_errors','On');
    error_reporting(E_ALL);
    $debug = true;
}
else 
{
    $debug = false;
}

/*
    1 - token
    2 - sessionID
    2 - key
    3 - "The rest"
  
A - Check session data cache integrety
B - Update session data cache if necessary
C - Get token for this session and cache
D - Foreach broadcast, query with cache

A - Get cached session data
B - Attempt to get token
B1 - If failed, refresh session data
B2 - If success, cache token
C - Foreach broadcast...

A - get broadcaststats
AF - renew token
AFF - renew session

*/

/*   
	DataBaseConnection db = ...
    
    Grooveshark $grooveShark = ...
	
	$grooveShark->SessionData = db->GetSessionData();
	
	if ($grooveShark->SessionData == null)
	{
        // No session data has been cached yet, get it.
        $grooveShark->SessionData = AccquireSessionData();
	}  
       
    if ($grooveShark->SessionData != null)
    {
        $grooveShark->Token = $grooveShark->AccquireToken();
        
        if ($grooveShark->Token == null)
        {
            $grooveShark->SessionData = AccquireSessionData();
            $grooveShark->Token = $grooveShark->AccquireToken();
        }
    
        if ($grooveShark->Token == null)
        {
            // Log message, failed to get token a second time.
        }
        else
        {
            $users = db->GetEnabledBroadcasts();
            foreach ($username in $users)
            {
                try
                {
                    gsData = $grooveShark->GetData();
                        
                    if (gsData != null)
                    {
                        // Parse and write to db
                    }
                    else
                    {
                        throw new Exception("Could not get data for user.");
                    }
                }
                catch ($exception)
                {
                    // Log message for this user
                }
            }
        }
        
        
    }
    
    function AccquireSessionData()
    {
		sessionData = Grooveshark->QuerySessionData();
        
        if (sessionData == null)
        {
            // Trigger some failure
            // email 
        }
        else
        {
            db->SaveSessionData(sessionData);           
        }
        
        return sessionData;
    }

*/
