drop table if exists x_categorys;
create table x_categorys(
id tinyint(3) primary key auto_increment,
name varchar(50) not null default ''
)engine = myisam default charset=utf8;

drop procedure if exists x_list_categorys;
delimiter $$
create procedure x_list_categorys()
begin 
select * from x_categorys;
end
$$
delimiter ;