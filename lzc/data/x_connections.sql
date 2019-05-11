
drop table if exists x_connections;
create table x_connections(
id int(11) primary key auto_increment,
name varchar(50) not null default '',
url varchar(150) not null default '',
sort tinyint(2) not null default 0
)engine=myisam default charset=utf8;
insert into x_connections values(1,'阿里云','https://cn.aliyun.com/',0);
insert into x_connections values(2,'百度','https://www.baidu.com/',1);
insert into x_connections values(3,'今日头条','https://www.toutiao.com/',2);	

drop procedure if exists x_show_connections;
delimiter $$
create procedure x_show_connections()
	begin
	select * from x_connections order by sort;
	end
	$$
delimiter ;