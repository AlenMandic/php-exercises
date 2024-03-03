<?php

/**
 * Make a GET request on a first given endpoint, which returns a password which is valid only for 3 seconds.While the password is
 * valid it must be attached onto a second endpoint, which then returns an .odt file. We must save the file onto our pc, unzip and
 * parse/read the XML content inside it, which will reveal 'task-5' requirements.
 */

 // Set your extract path for the .odt document
 $odtFilePath = 'C:\Your\Path\Here\makeNewFolderForExtracting';

 $passwordFromQuery = '';
 $queryParamUser = 'user335';
 $queryParamValue = 335;

 $url = 'https://url-which-returns/odtFile?'.$queryParamUser.'='.$queryParamValue;
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

?>