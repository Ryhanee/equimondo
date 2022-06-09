<?php
  class Client {
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    public function ajoutClient($data) {
      // Prepare Query
      $this->db->query('INSERT INTO clients (id, nom, prenom, email) VALUES(:id, :nom, :prenom, :email)');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':nom', $data['nom']);
      $this->db->bind(':prenom', $data['prenom']);
      $this->db->bind(':email', $data['email']);

      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }

        $reqConnHist = 'INSERT INTO clients (id, nom, prenom, email) VALUES(:id, :nom, :prenom, :email)';
        $reqConnHistResult = $ConnexionBdd ->query($reqConnHist) or die ('Erreur SQL !'.$reqConnHist.'<br />'.mysqli_error());

    }

    public function getClients() {
      $this->db->query('SELECT * FROM clients ORDER BY date DESC');

      $results = $this->db->resultset();

      return $results;
    }
  }
