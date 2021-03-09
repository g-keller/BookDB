<?php
	// secure DB credentials
	require_once('vendor/autoload.php');
	$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
	$dotenv->load();
	
	$servername = $_ENV['dbservername'];
	$username = $_ENV['dbusername'];
	$password = $_ENV['dbpassword'];
	$dbname = 'bookdb';

	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// this may need more or better handling
	if ($conn->connect_error) {
		die("Connection Failed: " . $conn->connect_error);
	}	
	
	function echoBookList() {
		global $conn;
		$sql = "select * from book";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			while ($row) {
				echo $row['title'] . " " . $row['author'] . " " . $row['genre'] . "<br>" . $row['summary'] . "<br><br>";
				$row = $result->fetch_assoc();
			}
		}	
		$result->close();
	}
	
	function insertBook($title, $author, $genre, $summary) {
		// this needs parameterized queries since it handles user input
		global $conn;
		$sql = "insert into book (title, author, genre, summary)
				values ('$title', '$author', '$genre', '$summary')";
		$result = $conn->query($sql);
	}
	
	function updateBook($book_id, $title, $author, $genre, $summary) {
		// this needs parameterized queries since it handles user input
		global $conn;
		$sql = "update book
				set title = '$title', author = '$author', genre = '$genre', summary = '$summary' 
				where id = '$book_id'";
		$result = $conn->query($sql);
	}
	
	function deleteBook($book_id) {
		global $conn;
		$sql = "delete from book where id = $book_id";
		$result = $conn->query($sql);
	}
?>