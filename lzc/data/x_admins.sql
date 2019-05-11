drop table if exists x_admins;
create table x_admins(
id int(11) primary key auto_increment,
avatar varchar(150) not null default '',
username varchar(150) not null default '',
password varchar(150) not null default '',
nickname varchar(255) not null default '',
introduction text,
last_login_ip varchar(150) not null default '',
role_id tinyint(3) not null default 1,
created_at int(13) not null default 0,
updated_at int(13) not null default 0
)engine=innodb default charset=utf8;

-- 查询数据条数

drop procedure if exists x_get_admins_count;

delimiter $$

create procedure x_get_admins_count()
begin
select count(*) as count from x_admins;
end
$$
delimiter ;


drop procedure if exists x_admins_login;
delimiter $$
create procedure x_admins_login(_username varchar(150),_password varchar(150),_ip varchar(150))
	begin
	select id,username,avatar,last_login_ip,nickname from x_admins where username = _username && password = _password;
	update x_admins set last_login_ip = _ip,updated_at = unix_timestamp(now()) where username = _username && password = _password;
	end 
	$$
delimiter ;

drop procedure if exists x_add_admins;
delimiter $$
create procedure x_add_admins(_username varchar(150),_password varchar(150))
	begin
	insert into x_admins set username = _username , password = _password;
	end 
	$$
delimiter ;