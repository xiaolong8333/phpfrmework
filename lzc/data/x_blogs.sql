drop table if exists x_blogs;
create table x_blogs(
id int(11) primary key auto_increment,
author_id int(11) not null default 0,
title varchar(255) not null default '',
category_id tinyint(3) not null default 0,
contents text,
created_at int(13) not null default 0,
updated_at int(13) not null default 0,
key x_blogs_author(author_id)
)engine=innodb default charset=utf8;