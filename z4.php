<?php
 /**
  * Napravio sam skriptu koja dohvaća sadržaj ODT dokumenta, sprema dokument na moj kompjuter, i ispisuje text u konzoli.
  */

 $odtFilePath = 'C:\Users\Alen\Desktop\ODTextracts';

 $passwordFromQuery = '';
 $queryParamUser = 'user';
 $queryParamValue = 620;

 $url = 'https://api.adriatic.hr/test/it?'.$queryParamUser.'='.$queryParamValue;
 error_log($url);

 // open and configure a new fetch request using cURL
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 $getDocumentContent = curl_exec($ch);

 if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
 }

 curl_close($ch);

 // Check if the document content was fetched successfully
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

    // Check if the .odt file was opened successfully
    if ($result === true) {
        // Extract the contents to the specified path
        $zip->extractTo($odtFilePath);
        $zip->close();

        $documentContent = file_get_contents($odtFilePath.'/content.xml');
        $xml = simplexml_load_string($documentContent);

        // format XML text and hold it all in $allText variable. Grab every text:p element.
        $allText = '';

        foreach ($xml->xpath('//text:p') as $paragraph) {
            $allText .= trim((string)$paragraph) . ' ';
        }

        // Output the extracted text
        echo $allText;

    } else {
        die('Failed to open the .odt file');
    }
} else {
    die('Failed to fetch document content');
}

?>