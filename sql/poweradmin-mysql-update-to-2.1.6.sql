SET SESSION SQL_MODE='ANSI,ANSI_QUOTES,TRADITIONAL';
ALTER TABLE users MODIFY username VARCHAR(64) NOT NULL;
ALTER TABLE users MODIFY "password" VARCHAR(128) NOT NULL;
