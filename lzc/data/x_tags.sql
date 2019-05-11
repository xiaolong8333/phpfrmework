drop table if exists x_tags;

create table x_tags(
id int(11) primary key auto_increment,
post_id int(11) not null default 0,
tag_name varchar(150) not null default ''
)engine=innodb default charset=utf8;

drop procedure if exists x_delete_tags;

delimiter $$

create procedure x_delete_tags(_post_id int(11))
begin
   delete from x_tags where post_id = _post_id;
end 
$$
delimiter ;

drop procedure if exists x_add_tags;

delimiter $$

create procedure x_add_tags(_author_id int(11),_tag_name varchar(150))
begin
   declare _post_id int default 0;
   select max(id) into _post_id from x_articles where author_id = _author_id;
   insert into x_tags set post_id = _post_id,tag_name=_tag_name;
end 
$$
delimiter ;

drop procedure if exists x_list_tags;

delimiter $$

create procedure x_list_tags(_limit int(3))
begin
select tag_name from x_tags group by tag_name limit _limit;
end
$$
delimiter ;


