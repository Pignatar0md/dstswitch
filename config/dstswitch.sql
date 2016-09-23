create database dstswitch;

create table destiny (id int primary key auto_increment, description varchar(20) not null);

create table pin (id int primary key auto_increment, pin varchar(8) not null, description varchar(30) not null);

create table profile (id int primary key auto_increment, id_profile_destiny int not null references profile_destiny (id), description varchar(30) not null);

create table grupo (id int primary key auto_increment, pin_list varchar(600), description varchar(30) not null, extension_list varchar(600));

create table permission (id int primary key auto_increment, pin_list varchar(600), id_profile int not null references profile (id), id_group int not null references grupo (id), description varchar(30) not null, extension_list varchar(600));

create table profile_destiny (id int primary key auto_increment, id_profile int not null references profile(id), id_destiny int not null references destiny(id));