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
	DataBaseConnection db = ...
    
    
	
	SessionData sessionData = sessionData = db->GetSessionData();
	
	if (sessionData == null)
	{
        sessionData = AccquireSessionData();
	}  
       
    if (sessionData != null)
    {
        $users = db->GetEnabledBroadcasts();
        foreach ($username in users)
        {
            for (int i = 0; i < 2; i++)
            {
                gsData = GrooveShark->GetData(sessionData);
                
                if (gsData != null)
                {
                    // Parse and write to db
                    break;
                }
                else
                {
                    sessionData = AccquireSessionData();
                    if (sessionData == null)
                        break;
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
