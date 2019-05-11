
drop table if exists x_navs; 

create table x_navs(
id int(11) primary key auto_increment,
name varchar(50) not null default '',
sort tinyint(1) not null default 0,
url varchar(150) not null default '',
pid int(5) not null default 0,
second tinyint(1) not null default 0
)engine=innodb default charset=utf8; 


INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (1, '首页', 0, '\\', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (2, '关于我', 0, '\\About\\show', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (3, '博客', 0, '\\Blog\\show', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (4, '投资组合', 0, '', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (5, '网页', 0, '', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (6, '联系我', 0, '', 0);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (7, '服务', 0, '', 2);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (8, 'Single', 0, '', 3);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (9, '专栏1', 0, '', 4);
INSERT INTO `x_navs`(`id`, `name`, `sort`, `url`, `pid`) VALUES (10, '专栏2', 0, '', 4);
drop procedure if exists x_get_navs;

delimiter $$

create procedure x_get_navs()
begin
select id,name,url,pid,second from x_navs  order by sort;
end
$$
delimiter ;