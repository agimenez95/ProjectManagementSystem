create database if not exists NewStarter;
use NewStarter;
create user if not exists 'newStarterAdmin'@'localhost' identified by 'password';
grant all on NewStarter.* to 'newStarterAdmin'@'localhost';

drop table if exists Manager;
create table Manager (
  id int not null auto_increment PRIMARY KEY,
  firstname varchar(25) not null,
  surname varchar(50) not null,
  dateStarted datetime not null,
  email varchar(100) not null,
  pword varchar(60) not null
);

-- insert into BonusPlayer(name, teamID)
-- values
--   ('Sidney Crosby', 7),
--   ('Nikita Kucherov', 15),
--   ('Auston Matthews', 16),
--   ('Brad Marchand', 9),
--   ('Vladimir Tarasenko', 22),
--   ('Jeff Skinner', 1),
--   ('Patrik Laine', 31);
