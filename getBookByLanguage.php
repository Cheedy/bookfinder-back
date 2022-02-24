<?php
header('Content-Type: application/json; charset=utf-8');
include 'connexion.php';

$word = $_POST['word'];

try{
	// Si la donnée est bien reçue ?
	if(isset($word)) 
	{
		// Requête SELECT si le qrCode existe existe 
		$searchByWord = $db->prepare("SELECT * FROM `books` WHERE `languages` LIKE :word ORDER BY `languages` ASC");
		$searchByWord->bindValue(":word", $word);
		$searchByWord->execute();
		$existBook = $searchByWord->rowCount();
		while($a = $searchByWord->fetch())
		{
			$result[] = $a;
		}

		// Si l'immeuble existe
		if($existBook > 0)
		{
			$msg = "Livres existants";
			$success = 1;
		}
		else
		{
			$msg = "Aucun livre n'existe pour le moment";
			$success = 0;
		}
	}
	else
	{
		$msg = "Nous n'arrivons pas à avoir vos mots";
			$success = 0;

	}

}
catch(\Throwable $th)
{
	$msg = "Error : ".$th->getMessage();
}

echo json_encode([
			"data"=>[
				$msg,
				$existBook,
				$success,
				$result,
			]
		]);

?>