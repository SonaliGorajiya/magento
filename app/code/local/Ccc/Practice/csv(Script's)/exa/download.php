<pre>
<?php 

$system = array();

$sample = "North Shore Brown Bedroom Set";
echo microtime();
for($i=0; $i<5000000; $i++)
{	
	$sample = trim($sample);
	$sample = str_replace("-", "", $sample);
	$sample = strtolower($sample);

	$random = trim("North Shore ".rand(100,999)." Bedroom Set");
	$random = str_replace("-", "", $random);
	$random = strtolower($random);
	
	similar_text($sample, $random, $percent);
	
	$system[] = $percent;
}
echo "done";
echo microtime();
//print_r($system);




?>