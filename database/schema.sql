create table salary(
	ID int(11) not null auto_increment,
	USER_SALARY varchar(255),
	USERNAME varchar(20),
	primary key (id)
);

create table late(
	ID int(11) not null auto_increment,
	LATE_VALUE int(100),
	primary key(id)
);

alter table user_role add SALARY varchar(255);