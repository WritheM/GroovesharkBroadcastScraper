<?php

class QueryParameters
{
    private $parms = array();
    
    public function addParameter($parameterName, $parameterValue)
    {
        $this->parms[$parameterName] = $parameterValue;
    }
    
    public function clear()
    {
        unset($this->parms);
    }
    
    public function getParameterValue($parameterName)
    {
        return $this->parms[$parameterName];
    }

    public function getParameterNames()
    {
        return array_keys($this->parms);
    }
}

class Database
{
    public $MaintenanceMode;
    protected $dbConnection = null;
    
    private function bindParameters($stmt, $parms)
    {
        if ($parms != null)
        {
            print "doing parameter binding...\n";
            foreach($parms->getParameterNames() as $parameterName)
            {
                $stmt->bindValue($parameterName, $parms->getParameterValue($parameterName));
                
                print "binding parameter $parameterName with " . $parms->getParameterValue($parameterName) . "\n";
            }
        }
    }
    
    public function execute($query, QueryParameters $parms = null)
    {
        if ($this->dbConnection == null)
            throw new Exception("Cannot execute a query, no open connection.");
               
        $stmt  = $this->dbConnection->prepare($query);
        $this->bindParameters($stmt, $parms);

        if ($this->MaintenanceMode == false)
            $stmt->execute();
                
        return $stmt;
    }
    
    public function select($query, $parms = array())
    {
        if ($this->dbConnection == null)
            throw new Exception("Cannot execute a query, no open connection.");

        $stmt  = $this->dbConnection->prepare($query);
        $this->bindParameters($stmt, $parms);
        
        if ($this->MaintenanceMode == false)
            $stmt->execute();

        $result = null;
        while ($row = $stmt->fetch())
        {
            if ($result == null)
                $result = array();
                
            $result[] = $row;
        }
        
         return $result;
    }
    
    public function __construct($maintMode = false)
    {
        $this->maintenanceMode = $maintMode;
    }

    public function openConnection($host, $database, $user, $pass)
    {
        if ($this->dbConnection != null)
        {
            throw new Exception("Database connection is already open.");
        }
    
        $cfg['host'] = $host; 
        $cfg['dbase'] = $database; 
        $cfg['user'] = $user; 
        $cfg['pass'] = $pass;
    
        $conn = "mysql:host={$cfg['host']};dbname={$cfg['dbase']}";
        $this->dbConnection = new PDO($conn, $cfg['user'], $cfg['pass']);
        
        /*
        catch (PDOException $e) {
            header(':', true, 503);
            printf("<div id=\"fail_connect\">\n  <error details=\"%s\" />\n</div>\n", $e->getMessage());
        }
        */
    }
    
    public function closeConnection()
    {
        $this->dbConnection = null;
    }
}

