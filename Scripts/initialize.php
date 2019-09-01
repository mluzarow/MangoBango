<?php
// Check to see if SQLite3 module is loaded
if (!class_exists(\SQLite3::class)) {
	echo "✗ SQLite3 could not be found.\n";
	return;
}

// Check that server.ini exists and is set up correctly
if (!file_exists('..\\app\\server.ini')) {
	echo "✗ Could not find file ..\\app\\server.ini.\n";
	return;
}

echo "✔ Successfully found server.ini.\n";

$f = parse_ini_file ('..\\app\\server.ini');

if ($f === false) {
	echo "✗ Failed to open file ..\\app\\server.ini.\n";
	return;
}

if (!isset($f['path'])) {
	echo "✗ ini missing \"path\" attribute.\n";
	return;
}

if (empty($f['path'])) {
	echo "✗ ini \"path\" attribute not filled in.\n";
	return;
}

echo "✔ Successfully found db directory setting: {$f['path']}.\n";

$db_filepath = rtrim($f['path'], DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'database.db';

// Check that DB file exists
if (!file_exists($db_filepath)) {
	if (!mkdir($f['path'], 0777, true)) {
		echo "✗ Failed to create directory path: {$f['path']}.\n";
		return;
	}
	
	new \SQLite3($db_filepath);
	
	if (!file_exists($db_filepath)) {
		echo "✗ Failed to create database file: {$db_filepath}.\n";
		return;
	}
	
	echo "✔ Successfully created database file: {$db_filepath}.\n";
} else {
	echo "✔ Found database file: {$db_filepath}.\n";
}

// Set up tables
$db = new \SQLite3($db_filepath);
$n = 0;

$q =
	'CREATE TABLE IF NOT EXISTS metadata_series (
		series_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		name TEXT NOT NULL,
		name_original TEXT NULL DEFAULT NULL,
		summary TEXT NULL DEFAULT NULL,
		genres TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: metadata_series.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS directories_series (
		series_id INTEGER NOT NULL PRIMARY KEY,
		folder_name TEXT NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: directories_series.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS images_series (
		series_id INTEGER NOT NULL PRIMARY KEY,
		cover_ext TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: images_series.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS metadata_chapters (
		chapter_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		global_sort INTEGER NOT NULL,
		chapter_name text NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: metadata_chapters.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS directories_chapters (
		chapter_id INTEGER NOT NULL PRIMARY KEY,
		folder_name TEXT NOT NULL,
		is_archive INTEGER NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: directories_chapters.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS metadata_volumes (
		volume_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		sort INTEGER NOT NULL,
		volume_name TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: metadata_volumes.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS images_volumes (
		volume_id INTEGER NOT NULL PRIMARY KEY,
		cover_ext TEXT NULL DEFAULT NULL,
		index_ext TEXT NULL DEFAULT NULL,
		spine_ext TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: images_volumes.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS connections_series (
		chapter_id INTEGER NOT NULL PRIMARY KEY,
		series_id INTEGER NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: connections_series.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS connections_volumes (
		volume_id INTEGER NOT NULL PRIMARY KEY,
		series_id INTEGER NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: connections_volumes.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS connections_chapters (
		chapter_id INTEGER NOT NULL PRIMARY KEY,
		volume_id INTEGER NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: connections_chapters.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS server_configs (
		config_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		config_name TEXT NOT NULL UNIQUE,
		config_value TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: server_configs.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS statistics (
		stat_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		name TEXT NOT NULL,
		value TEXT NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: statistics.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS users (
		user_id INTEGER NOT NULL AUTOINCREMENT PRIMARY KEY,
		username TEXT NOT NULL UNIQUE,
		password TEXT NOT NULL,
		type TEXT NOT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: users.\n";
}

$q =
	'CREATE TABLE IF NOT EXISTS user_types (
		type_name TEXT NOT NULL PRIMARY KEY,
		permissions TEXT NULL DEFAULT NULL
	)';
$r = $db->query ($q);

if ($r === false) {
	echo "!! Failed to create table: user_types.\n";
}

if (!empty($n)) {
	echo "✗ Failed to create some tables.\n";
}

