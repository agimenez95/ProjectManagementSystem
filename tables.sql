create database if not exists NewStarter;
use NewStarter;
create user if not exists 'newStarterAdmin'@'localhost' identified by 'password';
grant all on NewStarter.* to 'newStarterAdmin'@'localhost';

drop table if exists User;
create table User (
  id int not null auto_increment PRIMARY KEY,
  firstname varchar(25) not null,
  surname varchar(50) not null,
  dateStarted datetime not null,
  email varchar(100) not null,
  pword varchar(60) not null,
  isManager boolean default 0,
  disabled boolean default 0
);

drop table if exists Task;
create table Task (
  id int not null auto_increment PRIMARY KEY,
  title varchar(25) not null,
  body varchar(1000) not null
);

drop table if exists User_Task;
create table User_Task (
  id int not null auto_increment PRIMARY KEY,
  userId int not null,
  taskId int not null,
  lastChanged datetime not null,
  progress varchar(25) not null
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
