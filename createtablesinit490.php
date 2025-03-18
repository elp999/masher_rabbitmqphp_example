#!/usr/bin/php
<?php

$db1 = 'mysql';
$db2 = 'it490';
require __DIR__ . "/database.php";
$t_api_table = 'api_teams';
$p_api_table = 'api_players';
$u_log = 'user_login';
$sesh = 'sessions';
$l_nme = 'league_name';
$u_tem = 'user_teams';
$t_ply = 'team_players';

if ($mysqli->errno != 0)
{
        echo "failed to connect to database: ". $mysqli->error . PHP_EOL;
        exit(0);
}

echo "successfully connected to database: ".$db1.PHP_EOL;

$checkuser = 'bobby';

$query1 = "select user from mysql.user where user = ?";
$stmt = $mysqli->prepare($query1);
$stmt->bind_param("s", $checkuser);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
	echo "User: $checkuser exists\n";
} else {
        echo "User does not exist\n";
}

if ($mysqli->errno != 0)
{
        echo "failed to connect to database: ". $mysqli->error . PHP_EOL;
        exit(0);
}

echo "successfully connected to database: ".$db2.PHP_EOL;


$query2 = "CREATE TABLE IF NOT EXISTS ".$u_log."(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	f_name VARCHAR(255) NOT NULL,
	l_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	username VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at INT(11) NOT NULL
	)";
if ( $mysqli->query($query2)== TRUE){
	echo "table: ".$u_log." created successfully\n";
} else {
	echo "Error: " . $mysqli->error;
}

$query3 = "CREATE TABLE IF NOT EXISTS ".$l_nme." (
        league_id INT PRIMARY KEY AUTO_INCREMENT,
        league_name VARCHAR(255) NOT NULL UNIQUE,
        league_password_hash VARCHAR(255),
        league_owner VARCHAR(255) UNIQUE,
        owner_id INT,
        FOREIGN KEY (owner_id) REFERENCES user_login(user_id) ON DELETE CASCADE
        )";
if ($mysqli->query($query3) == TRUE){
        echo "table: ".$l_nme." created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}

$query4 = "CREATE TABLE IF NOT EXISTS ".$u_tem." (
        team_id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        league_ID INT,
        team_name VARCHAR(255) UNIQUE,
        FOREIGN KEY (user_id) REFERENCES user_login(user_id) ON DELETE CASCADE,
        FOREIGN KEY (league_id) REFERENCES league_name(league_id) ON DELETE CASCADE
        )";
if ($mysqli->query($query4) == TRUE){
        echo "table: ".$u_tem." created successfully\n";
} else {
        echo "Error: " . $mysqli->error; 
}

$query5 = "CREATE TABLE IF NOT EXISTS ".$t_api_table." (
	team_id INT PRIMARY KEY AUTO_INCREMENT,
	team_name VARCHAR(255) UNIQUE,
	team_id_api INT,
	stadium VARCHAR(255),
	league VARCHAR(255)
    )";
if ( $mysqli->query($query5)== TRUE){
        echo "table: ".$t_api_table." created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}

$query6 = "CREATE TABLE IF NOT EXISTS ".$p_api_table." (
	player_id INT PRIMARY KEY AUTO_INCREMENT,
	player_name VARCHAR(255),
	player_id_api INT UNIQUE,
	player_position VARCHAR(255),
	team_name VARCHAR(255),
	goals_scored INT,
	pass_percent INT,
	clean_sheets INT,
	point_earned INT
	)";
if ( $mysqli->query($query6)== TRUE){
        echo "table: ".$p_api_table." created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}

$query7 = "CREATE TABLE IF NOT EXISTS ".$t_ply." (
        team_player_id INT PRIMARY KEY AUTO_INCREMENT,
        team_id INT,
        player_id INT,
	position VARCHAR(255),
	is_bench BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (team_id) REFERENCES user_teams(team_id) ON DELETE CASCADE,
        FOREIGN KEY (player_id) REFERENCES api_players(player_id_api) ON DELETE CASCADE
        )";
if ($mysqli->query($query7) == TRUE){
        echo "table: ".$t_ply." created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}

$query8 = "CREATE TABLE IF NOT EXISTS ".$sesh." (
        session_id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        session_data TEXT,
        session_start INT(11) NOT NULL,
        session_expires INT(11),
        FOREIGN KEY (user_id) REFERENCES user_login(user_id) ON DELETE CASCADE
    )";
if ( $mysqli->query($query8)== TRUE){
        echo "table: ".$sesh." created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}

$query9 = "CREATE TABLE IF NOT EXISTS 2fa (
        num_id INT PRIMARY KEY AUTO_INCREMENT,
	rand_num INT    
	)";
if ( $mysqli->query($query9)== TRUE){
        echo "table: 2fa created successfully\n";
} else {
        echo "Error: " . $mysqli->error;
}


$mysqli->close();
?>
