<?php

class User {
	
	private $dbh;
	
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
		$this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function getUsers(){				
		$sth = $this->dbh->prepare("SELECT * FROM users");
		$sth->execute();
		return json_encode($sth->fetchAll());
	}

	public function add($user){
		try {
			$sth = $this->dbh->prepare("INSERT INTO users(name, email, mobile, address) VALUES (?, ?, ?, ?)");
			$sth->execute(array($user->name, $user->email, $user->mobile, $user->address));	
		}catch(PDOException $err) {
			file_put_contents('error.log', 'INSERT :' . $err->getMessage(), FILE_APPEND);
		}
		return json_encode($this->dbh->lastInsertId());
	}
	
	public function delete($user){
		try {
			$sth = $this->dbh->prepare("DELETE FROM users WHERE id=?");
			$sth->execute(array($user->id));
		} catch(PDOException $err) {
			file_put_contents('error.log', 'DELETE :' . $err->getMessage(), FILE_APPEND);
		}
		return json_encode(1);
	}
	
	public function updateValue($user){		
		try {
			$sth = $this->dbh->prepare("UPDATE users SET ". $user->field ."=? WHERE id=?");
			$sth->execute(array($user->newvalue, $user->id));
		} catch (PDOException $err) {
			file_put_contents('error.log', 'UPDATE :' . $err->getMessage(), FILE_APPEND);
		}
		return json_encode(1);	
	}
}
?>
