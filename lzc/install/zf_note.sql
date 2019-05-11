-- 支付订单表
drop table if exists zf_note;

create table zf_note(
id int(11) primary key auto_increment,
user_id int(11) not null default 0 comment '支付',
pla_order_no varchar(155) not null default '' comment '平台支付订单号',
mer_orde_no varchar(155) not null default '' comment '本地支付订单号',
amount double(10,2) not null default 0.00 comment '支付金额',
service varchar(155) not null default '' comment '服务类型',
company_no varchar(155) not null default '' comment '商户ID',
order_detail text,
pay_type varchar(50) not null default '' comment '支付类型',
version varchar(100) not null default '1.0.0' comment '支付版本号',
created_at varchar(50) not null default 0 comment '订单创建时间',
pay_time varchar(50) not null default 0 comment '支付完成时间',
is_pay tinyint(1) not null default 0 comment '是否已支付 0=>未支付 1=>已支付',
key zf_note_user_id(`user_id`) 
)engine=innodb default charset = utf8 comment '支付订单表';

-- 生成订单

drop procedure if exists create_order;

delimiter $$

create procedure create_order(
    _user_id int(11),
	_mer_orde_no varchar(155),
	_amount double(10,2),
	_service varchar(155),
	_company_no varchar(155),
	_order_detail text,
	_version varchar(100),
	_pay_type varchar(155)
)
begin
    insert into zf_note set 
	user_id=_user_id,
	mer_orde_no=_mer_orde_no,
	amount=_amount,
	service=_service,
	company_no=_company_no,
	order_detail=_order_detail,
	version=_version,
	pay_type = _pay_type,
	created_at = date_format(now(),'%y%m%d%H%i%s');
end
$$
delimiter ;

-- 订单支付完成

drop procedure if exists update_order;

delimiter $$

create procedure update_order(
    _pla_order_no varchar(155),
	_mer_orde_no varchar(155),
	_pay_time varchar(50)
)
begin
    declare or_isset int default 0;
	select id into or_isset from zf_note where 	mer_orde_no=_mer_orde_no;
	if or_isset != 0 then
    update zf_note set 
    pla_order_no=_pla_order_no,
	pay_time=_pay_time,
	is_pay = 1
	where mer_orde_no = _mer_orde_no;
	else
	select 0;
	end if;
end
$$
delimiter ;


  
