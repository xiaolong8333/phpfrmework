-- trueName
drop procedure if exists create_order;
delimiter $$
create procedure create_order(
    _user_name varchar(255),
	_mer_orde_no varchar(155),
	_amount double(10,2),
	_order_detail varchar(200),
	_pay_type varchar(155),
	_plaOrderNo varchar(155)
)
	begin
	declare _user_id int default 0;
	declare _order_no varchar(155) default '';
	declare _before_coin decimal(12,3) default 0.00;
	DECLARE t_error INTEGER DEFAULT 0;    
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;
	START TRANSACTION;
	select orderNo into _order_no from blast_member_accessmoney where state = 0 && orderNo = _mer_orde_no;
	if _order_no = '' then
	    select uid into _user_id from blast_members where username = _user_name;
	    insert into  blast_member_accessmoney set 
		uid = _user_id,
		trueName = _user_name,
		orderNo = _mer_orde_no,
		state = 0,
		amount = _amount,
		accessType = 1,
		depostitType = _pay_type,
		remarks = _order_detail,
		actionTime = unix_timestamp(now());
	else
	    select uid into _user_id from blast_member_accessmoney where state = 0 && orderNo = _mer_orde_no;
	    update blast_member_accessmoney set
	     state = 1,
	     coin = _amount,
	     payAmount = _amount,
	     payTime = unix_timestamp(now()),
	     rechargeNo = _plaOrderNo
	     where state = 0 && uid = _user_id && orderNo = _mer_orde_no;
		 select coin into _before_coin from blast_members where uid = _user_id;
         update blast_members set coin = coin + ifnull(_amount,0) where uid = _user_id;
		 insert into blast_coin_log set 
		 type=0, 
		 uid = _user_id,
		 info='线上直充',
		 coin = _amount,
		 beforecoin = _before_coin,
		 userCoin = _before_coin+_amount,
		 liqType = 102,
		 actionTime = unix_timestamp(now());
        	end if;
	IF t_error = 1 THEN    
		ROLLBACK;    
	ELSE    
		COMMIT;    
	END IF; 
	select t_error;
	end
	$$
	delimiter ;