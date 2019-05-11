drop table if exists x_confs;
create table x_confs(
id int(3) primary key auto_increment,
keyname varchar(150) not null default '',
valuename varchar(150) not null default '',
vcomment varchar(255) not null default '',
created_at int(13) not null default 0,
updated_at int(13) not null default 0
)engine=myisam default charset=utf8;

-- list

drop procedure if exists x_list_confs;

delimiter $$

create procedure x_list_confs()
begin
  select * from x_confs;
end
$$
delimiter ;

-- listOne

drop procedure if exists x_listone_confs;

delimiter $$

create procedure x_listone_confs(_keyname varchar(150))
begin
  select valuename from x_confs where keyname=_keyname;
end
$$
delimiter ;

-- add

drop procedure if exists x_add_confs;

delimiter $$

create procedure x_add_confs(_keyname varchar(150),_valuename varchar(150),_vcomment varchar(255))
begin
  insert into x_confs set keyname=_keyname,valuename=_valuename,vcomment=_vcomment,created_at=unix_timestamp(now());
end
$$
delimiter ;

-- update

drop procedure if exists x_update_confs;

delimiter $$

create procedure x_update_confs(_id int(3),_keyname varchar(150),_valuename varchar(150),_vcomment varchar(255))
begin
   update x_confs set keyname=_keyname,valuename=_valuename,vcomment=_vcomment,updated_at=unix_timestamp(now()) where id=_id;
end
$$
delimiter ;

-- delete

drop procedure if exists x_delete_confs;

delimiter $$

create procedure x_delete_confs(_id int(3))
begin
  delete from x_confs where id=_id;
end
$$
delimiter ;


