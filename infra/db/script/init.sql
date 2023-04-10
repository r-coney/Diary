CREATE DATABASE IF NOT EXISTS
	sequence_db;
GRANT
	ALL
ON sequence_db.* TO diary;

use sequence_db;

Create TABLE IF NOT EXISTS
	sequences (
		entity VARCHAR(255) NOT NULL,
		id BIGINT NOT NULL,
		PRIMARY KEY (entity)
	);
