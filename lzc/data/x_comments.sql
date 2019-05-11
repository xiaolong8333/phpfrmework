drop table if exists x_comments;
create table x_comments(
id int(11) primary key auto_increment,
author varchar(150) not null default '',
author_id int(11) not null default 0,
author_img varchar(150) not null default '',
contents text,
post_id int(11) not null default 0,
pid int(11) not null default 0,
created_at int(13) not null default 0
)engine=innodb default charset=utf8;

-- 查询评论条数

drop procedure if exists x_get_comments_count;

delimiter $$

create procedure x_get_comments_count(_post_id int(11))
begin

select count(*) as count from x_comments where post_id = _post_id;
end
$$
delimiter ;


-- 文章评论

drop procedure if exists x_get_comments_article;

delimiter $$

create procedure x_get_comments_article(_post_id int(11))
begin

select * from x_comments where post_id = _post_id;
end
$$
delimiter ;

-- 添加评论

drop procedure if exists x_add_comments_article;

delimiter $$

create procedure x_add_comments_article(
_author varchar(150),
_author_id int(11),
_author_img varchar(150),
_contents text,
_post_id int(11))
begin

insert into  x_comments set 
author=_author,
author_id=_author_id,
author_img=_author_img,
contents=_contents,
post_id=_post_id,
created_at=unix_timestamp(now());
end
$$
delimiter ;



