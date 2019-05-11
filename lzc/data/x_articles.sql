drop table if exists x_articles;
create table x_articles(
id int(11) primary key auto_increment,
author_id int(11) not null default 0,
title varchar(255) not null default '',
category_id tinyint(3) not null default 0,
title_img varchar(150) not null default '',
iip varchar(150) not null default '',
contents text,
tags varchar(255) not null default '',
clicknum int(11) not null default 0,
created_at int(13) not null default 0,
updated_at int(13) not null default 0
)engine = innodb default charset=utf8;

-- 查询总条数

drop procedure if exists x_get_articles_count;

delimiter $$

create procedure x_get_x_articles_count()
begin
select count(*) as count from x_articles;
end
$$
delimiter ;

-- 一篇文章

drop procedure if exists x_listone_articles;
delimiter $$
create procedure x_listone_articles (_post_id int(11))
begin

     select a.author_id,a.title,
	 a.id,
	 a.category_id,
	 a.title_img,
	 a.iip,
	 a.tags,
	 a.contents,
	 a.clicknum,
	 a.created_at,
	 b.username,
     c.name as category_name,
	 count(d.id) as ccount
	 from x_articles a
	 left join x_admins b on a.author_id=b.id
	 left join x_categorys c on a.category_id=c.id
	 left join x_comments d on  a.id = d.post_id && d.pid=0
	 where  a.id=_post_id;
end
$$
delimiter ;

-- 文章列表

drop procedure if exists x_list_articles;
delimiter $$
create procedure x_list_articles (_begin int(11),_limit int(2))
begin
     declare __count int default 0;
     select count(*) into __count from x_articles;
	 if _begin>= __count then
	 set _begin = 0;
	 end if;
 select a.author_id,a.title,
	 a.id,
	 a.category_id,
	 a.title_img,
	 a.iip,
	 a.tags,
     a.contents,
	 a.clicknum,
	 a.created_at,
	 b.username,
     c.name as category_name,
     count(d.id) as ccount	 
	 from x_articles a
	 left join x_admins b on a.author_id=b.id
	 left join x_categorys c on a.category_id=c.id
	 left join x_comments d on  a.id = d.post_id && d.pid=0
	 group by a.id
	 limit _begin,_limit;
end
$$
delimiter ;


-- 添加文章

drop procedure if exists x_add_articles;

delimiter $$

create procedure x_add_articles
(
_author_id int(11),
_title varchar(255),
_category_id tinyint(3),
_title_img varchar(150),
_iip varchar(150),
_contents text,
_tags varchar(255)
)
begin
  insert into x_articles set 
    author_id=_author_id,
    title=_title,
    category_id=_category_id,
	title_img=_title_img,
	iip=_iip,
	contents=_contents,
	tags=_tags,
	created_at=unix_timestamp(now());
end
$$
delimiter ;

-- 文章修改

drop procedure if exists x_update_articles;

delimiter $$

create procedure x_update_articles
(
_post_id int(11),
_author_id int(11),
_title varchar(255),
_category_id tinyint(3),
_title_img varchar(150),
_iip varchar(150),
_contents text,
_tags varchar(255)
)
begin
  update x_articles set 
    author_id=_author_id,
    title=_title,
    category_id=_category_id,
	title_img=_title_img,
	iip=_iip,
	contents=_contents,
	tags=_tags,
	updated_at=unix_timestamp(now())
	where id = _post_id;
end
$$
delimiter ;

-- 文章删除

drop procedure if exists x_delete_articles;

delimiter $$

create procedure x_delete_articles(_post_id int(11))
begin 
   delete from x_articles where id = _post_id;
end
$$
delimiter ;