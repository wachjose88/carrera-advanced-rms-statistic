CREATE TABLE "cars" (
	"id"	integer NOT NULL,
	"name"	varchar(255) NOT NULL UNIQUE,
	"number"	varchar(255) NOT NULL UNIQUE,
	"image"	varchar(255) DEFAULT NULL,
	"tires"	varchar(255) DEFAULT NULL,
	"scale"	integer DEFAULT NULL,
	PRIMARY KEY("id")
);

CREATE TABLE "competitions" (
	"id"	integer NOT NULL,
	"title"	varchar(255) NOT NULL,
	"time"	datetime NOT NULL,
	"mode"	integer NOT NULL,
	"sortmode"	integer NOT NULL,
	"duration"	integer NOT NULL,
	PRIMARY KEY("id")
);

CREATE TABLE "config" (
	"id"	INTEGER NOT NULL,
	"configkey"	varchar(255) NOT NULL UNIQUE,
	"value"	text NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);

CREATE TABLE "laps" (
	"id"	integer NOT NULL,
	"timestamp"	integer NOT NULL,
	"fuel"	integer NOT NULL,
	"pit"	integer NOT NULL,
	"racingplayer_id"	integer NOT NULL,
	PRIMARY KEY("id")
);

CREATE TABLE "players" (
	"id"	integer NOT NULL,
	"username"	varchar(255) NOT NULL UNIQUE,
	"name"	varchar(255) NOT NULL,
	"image"	varchar(255) DEFAULT NULL,
	PRIMARY KEY("id")
);

CREATE TABLE "racingplayers" (
	"id"	integer NOT NULL,
	"competition_id"	integer NOT NULL,
	"car_id"	integer NOT NULL,
	"player_id"	integer NOT NULL,
	"rank"	varchar(8) DEFAULT NULL,
	"laps"	integer DEFAULT NULL,
	"time"	varchar(255) DEFAULT NULL,
	"bestlap"	varchar(255) DEFAULT NULL,
	"diff"	varchar(255) DEFAULT NULL,
	PRIMARY KEY("id")
);
