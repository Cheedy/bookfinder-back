<?php
header('Content-Type: application/json; charset=utf-8');
include 'connexion.php';

$word = $_POST['word'];

try{
	// Si la donnée est bien reçue ?
	if(isset($word)) 
	{
		// Requête SELECT si le qrCode existe existe 
		$searchByWord = $db->prepare("SELECT * from book_word INNER JOIN books ON book_word.id_book_word = books.id");
		$searchByWord->execute();
		$existBook = $searchByWord->rowCount();

		while($a = $searchByWord->fetch())
		{
			$result[] = $a;
		}

	}

}
catch(\Throwable $th)
{
	$msg = "Error : ".$th->getMessage();
}
$table = [];
// on rentre dans la requete SQL
foreach ($result as $key => $value) 
{
	// on décode tokenList
	$tokenListDecoded = json_decode($value["tokenList"], true);
	//print_r($value);
	//print_r($value);
	// on rentre dans tokenList
	foreach($tokenListDecoded as $token)
	{	
			// on cherche le mot dans tokenList
			if($token["token"] == $word)
			{
				//$table['id : '.$value["id_book_word"]]= $token['occurence'];
				array_push($table, 
					array(
						"occurence" => $token["occurence"], 
						"id" => $value["id_book_word"], 
						"title" => $value['title'], 
						"authors_name" => $value['authors_name'],
						"authors_birth_year" => $value['authors_birth_year'],
						"authors_death_year" => $value['authors_death_year'],
						"subjects0" => $value['subjects0'],
						"subjects1" => $value['subjects1'],
						"subjects2" => $value['subjects2'],
						"subjects3" => $value['subjects3'],
						"subjects4" => $value['subjects4'],
						"subjects5" => $value['subjects5'],
						"subjects6" => $value['subjects6'],
						"subjects7" => $value['subjects7'],
						"subjects8" => $value['subjects8'],
						"subjects9" => $value['subjects9'],
						"subjects10" => $value['subjects10'],
						"bookshelves0" => $value['bookshelves0'],
						"bookshelves1" => $value['bookshelves1'],
						"bookshelves2" => $value['bookshelves2'],
						"bookshelves3" => $value['bookshelves3'],
						"languages" => $value['languages'],
						"copyright" => $value['copyright'],
						"media_type" => $value['media_type'],
						"formatsimagejpeg" => $value['formatsimagejpeg'],
						"formatstexthtml" => $value['formatstexthtml'],
						"download_count" => $value['download_count'],
						"translators_name" => $value['translators_name'],
						"translators_bith_year" => $value['translators_bith_year'],
						"translators_death_year" => $value['translators_death_year']
					));

			}
			else
			{

			}
	}

}
rsort($table);
$counter = count($table);
if($counter > 0)
{
	$msg = "Livre en rapport avec votre mot";
	$success = 1;
}
else{
	$msg = "Aucun livre en rapport avec votre mot";
	$success = 0;
}

echo json_encode([
			"data"=>[
				$msg,
				$existBook,
				$success,
				$table,
			]
		]);

			
		

?>