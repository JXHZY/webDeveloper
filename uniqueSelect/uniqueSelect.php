<?php
/*
  Use PHP 5.3.

  "records.csv" contains CSV-delimited records on each line in the
  following format:
    
    2,070843201,18594,28,1

  Use the following framework to read "records.csv" and output
  "records_pruned.csv" such that each record in the output file
  has a one record for each ID in the second field (the 9-digit
  ID). For records in "records.csv" that share the same 9-digit
  ID, transfer only the first to "records_pruned.csv".

  For example:

  records.csv
    2,111111111,AAAAA,28,1
    2,222222222,BBBBB,28,1
    2,111111111,CCCCC,28,1
    2,333333333,DDDDD,28,1
    2,222222222,AAAAA,28,1

  should output records_pruned.csv
    2,111111111,AAAAA,28,1
    2,222222222,BBBBB,28,1
    2,333333333,DDDDD,28,1

  Sorting is not important.

  Solution will be evaluated for efficiency of algorithm and
  clarity of code.
*/

/*Way1: but not the best, because when the data is large, it will take long time and not working*/
/*$finalCsvData = array();
$inputCsvData = array();

if (($handle = fopen("./csv/records.csv", "r")) !== FALSE) {
  while(!feof($handle))
  {
    array_push($inputCsvData,fgetcsv($handle));
  }
  for ($i = 0; $i<(count($inputCsvData)); $i++) 
  {
    $id = $inputCsvData[$i][1];
    $singal = true;
    if($i == 0)
    {
      array_push($finalCsvData,$inputCsvData[$i]);
    }
    else
    {
      for ($j = 0; $j<(count($finalCsvData)); $j++)
      {
        if($finalCsvData[$j][1] == $id)
        {
          $singal = FALSE;
          break;
        }
      }
      if($singal == true)
      {
        array_push($finalCsvData,$inputCsvData[$i]);
      }
    }
  } 
  fclose($handle);
}

if (($handle = fopen("./csv/records_pruned.csv", "w")) !== FALSE) {
  foreach ($finalCsvData as $csvLine) {
      fputcsv($handle, $csvLine);
  }  
  fclose($handle);
}*/

/*Way2: can solve the above problem*/
$finalCsvData = array();
$inputCsvData = array();
$tmp = array();

if (($handle = fopen("./csv/records.csv", "r")) !== FALSE) {
  while(!feof($handle))
  {
    array_push($inputCsvData,fgetcsv($handle));
  }
  for ($i = 0; $i<(count($inputCsvData)); $i++) 
  {
    $sizeB = count($tmp);
    $id = $inputCsvData[$i][1];
    $tmp[$id] = $inputCsvData[$i][2];

    $sizeA = count($tmp);
    if($sizeA > $sizeB)
    {
      array_push($finalCsvData,$inputCsvData[$i]);
    }
  } 
  array_pop($finalCsvData);
  fclose($handle);
}

if (($handle = fopen("./csv/records_pruned.csv", "w")) !== FALSE) {
  foreach ($finalCsvData as $csvLine) {
      fputcsv($handle, $csvLine);
  }
  print_r("Success!!!");
  fclose($handle);
}
?>