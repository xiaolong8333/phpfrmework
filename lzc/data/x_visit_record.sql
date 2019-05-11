drop table if exists x_visit_record;
create table x_visit_record(
id int(11) primary key auto_increment,
ip varchar(50) not null default '',
avatar varchar(150) not null default '',
country varchar(155) not null default '',
area varchar(155) not null default '',
city varchar(155) not null default '',
last_visit_time int(13) not null default 0,
visit_num int(5) not null default 0
)engine=innodb default charset=utf8;

-- 查询总条数

drop procedure if exists x_get_visit_record_count;

delimiter $$

create procedure x_get_x_visit_record_count()
begin
select count(*) as count from x_visit_record;
end
$$
delimiter ;


-- 添加访问记录
drop procedure if exists x_add_visit_record;

delimiter $$

create procedure x_add_visit_record(
_ip varchar(50),
_country varchar(155),
_area varchar(155),
_city varchar(155))
begin
declare __isvip int default 0;
declare __vicit int default 0;
select count(*) into __isvip from x_visit_record where ip = _ip;
select city into __vicit from x_visit_record where ip = _ip;
	if __isvip=0 then
		insert into x_visit_record set ip=_ip,
		avatar=concat('/public/home/images/avatar/',FLOOR(1 + (RAND() * 12)),'.png'),
		country = _country,
		area = _area,
		city = _city,
		last_visit_time = unix_timestamp(now()),
		visit_num=1;
	elseif __isvip != 0 && __vicit='未知地区' then
		update x_visit_record set 
		country = _country,
		area = _area,
		city = _city,
		last_visit_time = unix_timestamp(now()),
		visit_num=visit_num+1
		where ip=_ip;	
	else
		update x_visit_record set last_visit_time = unix_timestamp(now()),visit_num=visit_num+1;
	end if;
end
$$
delimiter ;
