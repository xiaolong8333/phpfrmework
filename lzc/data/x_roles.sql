drop table if exists x_roles;
create table x_roles(
id tinyint(3) primary key auto_increment,
rname varchar(150) not null default '',
auth_id varchar(255) not null default '',
created_at int(13) not null default 0,
status tinyint(1) not null default 0
)engine=innodb default charset=utf8;


-- 查询总条数

drop procedure if exists x_get_roles_count;

delimiter $$

create procedure x_get_roles_count()
begin
select count(*) as count from x_roles;
end
$$
delimiter 

-- list

drop procedure if exists x_list_roles;

delimiter $$

create procedure x_list_roles(_begin int(11),_limit int(2))
begin
select * from x_roles limit _begin,_limit;
end
$$
delimiter ;