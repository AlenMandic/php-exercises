<?php

 $odtFilePath = 'C:\Your\Path\Here\makeNewFolderForExtracting';

 $passwordFromQuery = '';
 $queryParamUser = 'user';
 $queryParamValue = 620;

 $url = 'https://url.which_returns/odtFile?'.$queryParamUser.'='.$queryParamValue;
 error_log($url);

 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $getDocumentContent = curl_exec($ch);

 if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
 }

 curl_close($ch);

 if($getDocumentContent !== false) {

    $passwordFromQuery = $getDocumentContent;
    $updatedUrl = $url.'&pass='.$passwordFromQuery;
    error_log($updatedUrl);

    $documentContent = file_get_contents($updatedUrl);
    file_put_contents($odtFilePath.'/odtFileNew', $documentContent);

    $pathToMyFile = $odtFilePath.'/odtFileNew';
    error_log($pathToMyFile);

    $zip = new ZipArchive;

    $result = $zip->open($pathToMyFile);
    error_log($result);

    if ($result === true) {
        $zip->extractTo($odtFilePath);
        $zip->close();

        $documentContent = file_get_contents($odtFilePath.'/content.xml');
        $xml = simplexml_load_string($documentContent);

        $allText = '';

        foreach ($xml->xpath('//text:p') as $paragraph) {
            $allText .= trim((string)$paragraph) . ' ';
        }

        echo $allText;

    } else {
        die('Failed to open the .odt file');
    }
} else {
    die('Failed to fetch document content');
}

     trait InventoryManagerUtils {

        public function getAndCalculateTotalInventoryValue() {
    
            $sql_getValues = "SELECT Artikal, Stanje_na_skladištu, Cijena FROM inventory";
    
            $result = $this->conn->query($sql_getValues);
            $totalValueOfInventory = array();
    
            if($result !== FALSE) {
    
              while($row = mysqli_fetch_assoc($result)) {
    
                $cijena = floatval(str_replace(['€/kg', '€/kom'], '', $row['Cijena']));
                $stanje_na_skladištu = floatval(str_replace([' kg', ' komada'], '', $row['Stanje_na_skladištu']));
    
                $totalValueOfIndividualItem = $cijena * $stanje_na_skladištu;
    
                $totalValueOfInventory[] = $totalValueOfIndividualItem;
              }
    
              $overallTotalValue = array_sum($totalValueOfInventory);
              echo 'Values fetched successfully' . PHP_EOL;
              echo 'Total value of inventory: ' . $overallTotalValue . '€' . PHP_EOL;
    
            } else {
                echo "Error fetching values: " . $this->conn->error;
            }
    
        }
    
        public function checkDeadlineForProcurementValue($targetDate) {
    
            $dateTime = DateTime::createFromFormat('Y-m-d', $targetDate);
    
            if (!$dateTime) {
                echo 'Invalid date format input';
                return;
            }
    
            $formattedDate = $dateTime->format('Y-m-d');

            $sql_nearestDate = "SELECT Krajnji_rok_nabave, SUM(Potrebno_nabaviti * Cijena_u_nabavi) AS Total_nabava FROM inventory
            WHERE Krajnji_rok_nabave <= '$formattedDate'
            GROUP BY Krajnji_rok_nabave
            ORDER BY Krajnji_rok_nabave ASC";
            
            $result = $this->conn->query($sql_nearestDate);

            $totalValue = array();
            $overallTotalValue = 0;
    
            if($result !== FALSE) {
    
               while($row = mysqli_fetch_assoc($result)) {
    
                $date = $row['Krajnji_rok_nabave'];
                $ukupnaNabava = $row['Total_nabava'];
    
                $totalValue[] = $ukupnaNabava;
                $overallTotalValue = array_sum($totalValue);
    
                echo "Do datuma: $date, Iznos za naplatu: €$ukupnaNabava" . PHP_EOL;
               }
    
               echo "Totalni iznos naplate do datuma: $date : €$overallTotalValue" . PHP_EOL;
    
            } else {
                echo "Error fetching total values: " . $this->conn->error;
                return;
            }
    
        }

        public function updateStockStatus($targetItem, $changeAmount) {
    
            $sql_updateStock = "UPDATE inventory SET Stanje_na_skladištu = '$changeAmount' WHERE Artikal = '$targetItem'";
    
            $result = $this->conn->query($sql_updateStock);
    
            if($result !== FALSE) {
                echo "Stock status updated successfully" . PHP_EOL;
            } else {
                echo "Error updating stock status: " . $this->conn->error;
            }
        }
    
    }
    
      class InventoryManager {
    
        use InventoryManagerUtils;
    
        private $conn;
    
        public function __construct($host, $user, $password, $dbname) {
    
            $this->conn = new mysqli($host, $user, $password, $dbname);
            
            if($this->conn->connect_error) {
                die("Connection to db failed: " . $this->conn->connect_error);
            } else {
                error_log("Connected to db successfully");
            }
        }
    
        public function createInventoryTable() {
    
            $sql = "CREATE TABLE IF NOT EXISTS inventory (
                id INT AUTO_INCREMENT PRIMARY KEY,
                Artikal VARCHAR(255) NOT NULL,
                Stanje_na_skladištu VARCHAR(255),
                Cijena VARCHAR(255),
                Potrebno_nabaviti VARCHAR(255),
                Cijena_u_nabavi VARCHAR(255),
                Krajnji_rok_nabave DATE
            )";

        if($this->conn->query($sql) === TRUE) {
            echo "Inventory table created successfully" . PHP_EOL;
            } else {
                echo "Error creating inventory table: " . $this->conn->error;
            }
        }
    
        public function insertItem($Artikal, $Stanje_na_skladištu, $Cijena, $Potrebno_nabaviti, $Cijena_u_nabavi, $Krajnji_rok_nabave) {
    
            $sql="INSERT INTO inventory (Artikal, Stanje_na_skladištu, Cijena, Potrebno_nabaviti, Cijena_u_nabavi, Krajnji_rok_nabave)
                  VALUES ('$Artikal', '$Stanje_na_skladištu', '$Cijena', '$Potrebno_nabaviti', '$Cijena_u_nabavi', '$Krajnji_rok_nabave')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Record inserted successfully" . PHP_EOL;
            } else {
                echo "Error inserting record: " . $this->conn->error;
            }
        }

        public function __destr() {
            $this->conn->close();
        }
      }
      
      // Konfigurirajte vašu MySQL konekciju
      $host = "your-host-name"; // usually localhost or 127.0.0.1
      $user = "root"; // or username if you set one
      $password = "your-password";
      $dbname = "your-db-name";
    
      $inventoryManager = new InventoryManager($host, $user, $password, $dbname);
    
      $inventoryManager->createInventoryTable();
    
      $inventoryManager->insertItem('Paprika', '1225.25kg', '0.89€/kg', '', '', '2024-05-01');
      $inventoryManager->insertItem('Krumpir crveni', '600kg', '0.57€/kg', '3000kg', '0.35€/kg', '2024-05-02');
      $inventoryManager->insertItem("Krumpir Žuti", '0kg', '', '1200kg', '0.48€/kg', "2024-05-03");
      $inventoryManager->insertItem("Žarulja 20W", '250 komada', '2.74€/kom', '300 komada', '1.25€/kom', "2024-05-04");
    
      $inventoryManager->getAndCalculateTotalInventoryValue();
    
      $inventoryManager->checkDeadlineForProcurementValue("2024-05-03");
      $inventoryManager->checkDeadlineForProcurementValue("2024-06-10");
    
      $inventoryManager->updateStockStatus("Paprika", "1000kg");
      $inventoryManager->updateStockStatus("Žarulja 20W", "200 komada");
    
      $inventoryManager->__destr();
    
?>