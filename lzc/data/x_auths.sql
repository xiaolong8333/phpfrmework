drop table if exists x_auths;
create table x_auths(
id int(5) primary key auto_increment,
a_name varchar(150) not null default '',
request_uri varchar(150) not null default '',
pid tinyint(2) not null default 0,
created_at int(13) not null default 0
)engine=innodb default charset=utf8;

-- 查询总条数

drop procedure if exists x_get_auths_count;

delimiter $$

create procedure x_get_auths_count()
begin
select count(*) as count from x_auths;
end
$$
delimiter 

-- list

drop procedure if exists x_list_auths;

delimiter $$

create procedure x_list_auths(_begin int(11),_limit int(2))
begin
select * from x_auths limit _begin,_limit;
end
$$
delimiter ;

drop procedure if exists x_listpid_auths;

delimiter $$

create procedure x_listpid_auths(_pid int(2))
begin
select id,a_name from x_auths where pid=_pid;
end
$$
delimiter ;

-- add

drop procedure if exists x_add_auths;

delimiter $$

create procedure x_add_auths(_a_name varchar(150),_request_uri varchar(150),_pid tinyint(2))
begin
insert into x_auths set a_name=_a_name,request_uri=_request_uri,pid=_pid;
end
$$
delimiter ;


-- delete

drop procedure if exists x_delete_auths;

delimiter $$

create procedure x_list_auths(_begin int(11),_limit int(2))
begin
select * from x_auths limit _begin,_limit;
end
$$
delimiter ;