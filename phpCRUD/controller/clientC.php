<?php

require '../config.php';

class ClientC
{

    public function listClients()
    {
        $sql = "SELECT * FROM client";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteClient($ide)
    {
        $sql = "DELETE FROM client WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $ide);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }


    function addClient($client)
    {
        $sql = "INSERT INTO client  
        VALUES (NULL, :fn,:ln, :ad,:dob)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'fn' => $client->getFirstName(),
                'ln' => $client->getLastName(),
                'ad' => $client->getAddress(),
                'dob' => $client->getDob()->format('Y/m/d')
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function showClient($id)
    {
        $sql = "SELECT * from client where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $client = $query->fetch();
            return $client;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function updateClient($client, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE client SET 
                    firstName = :firstName, 
                    lastName = :lastName, 
                    adress = :adress, 
                    dob = :dob
                WHERE id= :id'
            );
            $query->execute([
                'id' => $id,
                'firstName' => $client->getFirstName(),
                'lastName' => $client->getLastName(),
                'adress' => $client->getAddress(),
                'dob' => $client->getDob()->format('Y/m/d')
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
