<?php
require_once ('database.php');
require_once ('sessiondata.php');

class GroovesharkDatabase extends Database
{   
    public function getSessionData()
    {
        $sessionData = null;
        
        // Get from db
        $query = "SELECT * FROM cacheSessionData";
        $rows = $this->select($query);
        
        $sessionStuff = array();
        foreach($rows as $key=>$val) 
        {
            $sessionStuff[$val['name']] = $val['value'];
        }
        
        $sessionData = new SessionData(
            $sessionStuff['clientRevision'],
            $sessionStuff['sessionID'],
            $sessionStuff['secretKey'],
            $sessionStuff['token'],
            $sessionStuff['uuid'],
            $sessionStuff['countryID']
        );
        
        return $sessionData;
    }
    
    private function executeKeyValueInsert($name, $value)
    {
        $query = "INSERT INTO cacheSessionData(name, value) VALUES (:name, :value) ON DUPLICATE KEY UPDATE value=:value";
        $parms = new QueryParameters();
        $parms->addParameter(':name', $name);
        $parms->addParameter(':value', $value);
        $stmt = $this->execute($query, $parms);
        //print_r($stmt);
        //print_r($parms);
        //printf("%d rows affected\n",$stmt->rowCount());
    }
    
    public function saveSessionData($sessionData)
    {
        if ($this->dbConnection != null)
        {
            $this->executeKeyValueInsert("clientRevision", $sessionData->ClientRevision);
            $this->executeKeyValueInsert("sessionID", $sessionData->SessionID);
            $this->executeKeyValueInsert("secretKey", $sessionData->SecretKey);
            $this->executeKeyValueInsert("token", $sessionData->Token);
            $this->executeKeyValueInsert("uuid", $sessionData->UUID);
            $this->executeKeyValueInsert("countryID", $sessionData->CountryID);
        }
        else
        {
            print "break..\n";
        }
    }
        
    public function saveSongHistory($play)
    {
        $r = array('class'=>null,'code'=>null,'details'=>null,'debug'=>null);
        { // validate the object
            if ((isset($play) && is_array($play))
                && (isset($play['queueSongID']) && is_int($play['queueSongID']))
                && (isset($play['SongID']) && is_int($play['SongID']))
                && (isset($play['SongName']) && is_string($play['SongName']))
                && (isset($play['ArtistID']) && is_int($play['ArtistID']))
                && (isset($play['ArtistName']) && is_string($play['ArtistName']))
                && (isset($play['EstimateDuration']) && is_int($play['EstimateDuration']))
                && (isset($play['broadcastUpVotes']) && is_int($play['broadcastUpVotes']))
                && (isset($play['broadcastDownVotes']) && is_int($play['broadcastDownVotes']))
                && (isset($play['broadcastListens']) && is_int($play['broadcastListens']))
                && (isset($play['broadcastID']) && is_int($play['broadcastID']))
                && (isset($play['broadcastHash']) && is_string($play['broadcastHash']))
                ) 
            {
                // pass, it's a valid object!
            }
            else
            {
                $r['class'] = 'fail_object';
                $r['code'] = 500;
                $r['detail'] = 'The provided playObject does not appear valid.';
                $r['debug'] = $play;
            }
        }
        
        { // build the query
            $parms = array();
            $query = "INSERT INTO `grooveshark`.`songHistory` (`queueSongID`, `SongID`, `SongName`, `ArtistID`, `ArtistName`, `EstimateDuration`, `broadcastUpVotes`, `broadcastDownVotes`, `broadcastListens`, `broadcastID`, `broadcastHash`) VALUES (:queueSongID, :SongID, :SongName, :ArtistID, :ArtistName, :EstimateDuration, :broadcastUpVotes, :broadcastDownVotes, :broadcastListens, :broadcastID, :broadcastHash) 
            ON DUPLICATE KEY UPDATE `EstimateDuration`=:EstimateDuration, `broadcastUpVotes`=:broadcastUpVotes, `broadcastDownVotes`=:broadcastDownVotes, `broadcastListens`=:broadcastListens, `broadcastID`=:broadcastID, `broadcastHash`=:broadcastHash";
            $parms[] = array(':queueSongID',$play['queueSongID']);
            $parms[] = array(':SongID',$play['SongID']);
            $parms[] = array(':SongName',$play['SongName']);
            $parms[] = array(':ArtistID',$play['ArtistID']);
            $parms[] = array(':ArtistName',$play['ArtistName']);
            $parms[] = array(':EstimateDuration',$play['EstimateDuration']);
            $parms[] = array(':broadcastUpVotes',$play['broadcastUpVotes']);
            $parms[] = array(':broadcastDownVotes',$play['broadcastDownVotes']);
            $parms[] = array(':broadcastListens',$play['broadcastListens']);
            $parms[] = array(':broadcastID',$play['broadcastID']);
            $parms[] = array(':broadcastHash',$play['broadcastHash']);
                
            $stmt = $dbConnection->prepare($query);
            foreach($parms as $parm) {
                $stmt->bindValue($parm[0], $parm[1]);    
            }
        }

        { // execute the insert/update
            try 
            {
                if (!$this->MaintenanceMode)
                    $stmt->execute();
                ob_start();
                    echo "play :";
                    print_r($play);
                    echo "parms :";
                    print_r($parms);
                    echo "stmt :";
                    print_r($stmt);
                $r['debug'] = ob_get_clean();
                
                if ($stmt->rowCount() > 0) 
                {
                    $r['class'] = 'success';
                    $r['code'] = 201;
                    $r['detail'] = 'play log updated';
                } 
                else
                {
                    $r['class'] = 'warn_insert';
                    $r['code'] = 206;
                    $r['detail'] = 'play log already exists.';
                }
            }
            catch (PDOException $e)
            {
                $r['class'] = 'fail_query';
                $r['code'] = 500;
                $r['detail'] = $e->getMessage();
            }
        }
        
        return $r;
    }
}