<?php
class Database
{
    protected $connection = null;
 
    public function __construct()
    {
        try {
            $this->connection = new mysqli('localhost', 'id17487746_banco_gt', '?C~?7]Cqaz12Dz2C', 'id17487746_proyecto2');
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
 
    public function select($query = "", $binder , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query, $binder , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
 
    public function insert($query="", $binder, $params=[])
    {
        try {
            $stmt = $this->executeStatement( $query, $binder , $params );
            $result = array("id"=>$this->connection->insert_id);
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function update($query="", $binder, $params=[])
    {
        try {
            $stmt = $this->executeStatement($query, $binder , $params );
            $result = array("affected"=>$this->connection->affected_rows);
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    private function executeStatement($query = "" , $binder, $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
 
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
 
            if( $params ) {
                $stmt->bind_param($binder, ...$params);
            }
 
            $stmt->execute();
 
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }
}