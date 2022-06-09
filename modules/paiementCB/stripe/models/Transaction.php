<?php
  class Transaction {
    private $db;

    function __construct() {
      $this->db = new Database;
    }

    function addTransaction($data) {
      // Prepare Query
      $this->db->query('INSERT INTO transactions (id, client_id, produit, prix, devise, status) VALUES(:id, :client_id, :produit, :prix, :devise, :status)');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':client_id', $data['client_id']);
      $this->db->bind(':produit', $data['produit']);
      $this->db->bind(':prix', $data['prix']);
      $this->db->bind(':devise', $data['devise']);
      $this->db->bind(':status', $data['status']);

      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function getTransactions() {
      $this->db->query('SELECT * FROM transactions ORDER BY created_at DESC');

      $results = $this->db->resultset();

      return $results;
    }
  }
