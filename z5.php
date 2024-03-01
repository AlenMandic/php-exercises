<?php
  /** Za zadnji zadatak, modelirat ćemo i upravljati sa MySQL databazom pomoću PHP klase, prema podacima s vaše slike.
   * Requirements: Local MySQL connection on your machine, and your MySQL connection hostname, username, password and database name.
   */

  class InventoryManager {

    private $conn;

    // we will use the constructor function to establish a connection to the database
    public function __construct($host, $user, $password, $dbname) {

        $this->conn = new mysqli($host, $user, $password, $dbname); // private variable conn holds a new mysql class instance for accessing our MySQL db.
        
        if($this->conn->connect_error) {
            die("Connection to db failed: " . $this->conn->connect_error);
        } else {
            error_log("Connected to db successfully");
        }
    }

    public function createInventoryTable() {

        // modeliranje databaze prema vašoj slici
        $sql = "CREATE TABLE IF NOT EXISTS inventory (
            id INT AUTO_INCREMENT PRIMARY KEY,
            article VARCHAR(255) NOT NULL,
            amount_in_warehouse INT,
            price DECIMAL(5,2),
            need_to_obtain_supply INT,
            purchase_price DECIMAL(5,2),
            deadline_for_procurement DATE
        )";

    // pošalji novi SQL zahtjev u databazu i provjeri je li izvršen.
    if($this->conn->query($sql) === TRUE) {
        echo "Inventory table created successfully";
        } else {
            echo "Error creating inventory table: " . $this->conn->error;
        }
    }

    //ispunjavamo databazu s relevantnim podacima
    public function insertItem($article, $amount_in_warehouse, $price, $need_to_obtain_supply, $purchase_price, $deadline_for_procurement) {

        $sql="INSERT INTO inventory (article, amount_in_warehouse, price, need_to_obtain_supply, purchase_price, deadline_for_procurement)
              VALUES ('$article', '$amount_in_warehouse', '$price', '$need_to_obtain_supply', '$purchase_price', '$deadline_for_procurement')";

    // šaljemo novi SQL zahtjev preko 'mysqli' klase i provjeravamo.
    if ($this->conn->query($sql) === TRUE) {
        echo "Record inserted successfully" . PHP_EOL;
        } else {
            echo "Error inserting record: " . $this->conn->error;
        }
    }

    // Zatvorimo konekciju s databazom nakon što završimo s operacijama.
    public function __destr() {
        $this->conn->close();
    }
  }

  $host = "localhost";
  $user = "Alen";
  $password = "alenmandic556";
  $dbname = "phpTest";

  $inventoryManager = new InventoryManager($host, $user, $password, $dbname);

  $inventoryManager->createInventoryTable();

  $inventoryManager->insertItem("Paprika", 1225.25, 0.89, 0, 0, "2024-05-05");
  $inventoryManager->insertItem("Krumpir Žuti", 0, 0, 1200, 0.48, "2024-05-05");
  $inventoryManager->insertItem("Žarulja 20W", 250, 2.74, 300, 1.25, "2024-05-05");

  $inventoryManager->__destr();
?>