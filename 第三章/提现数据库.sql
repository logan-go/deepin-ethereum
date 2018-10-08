CREATE TABLE `add_transaction` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
    `user_address` char(42) NOT NULL COMMENT '提现地址',
    `create_time` int(10) unsigned NOT NULL COMMENT '创建请求时间',
    `token_type` tinyint(1) unsigned NOT NULL COMMENT '提现种类',
    `status` tinyint(1) unsigned NOT NULL COMMENT '提现状态：1、提交。2、成功。3、失败。4、审核中。5、Pendding',
    `value` int(10) unsigned NOT NULL COMMENT '提现数额，单位：ether',
    `hash` char(66) DEFAULT NULL COMMENT '交易Hash',
    `block_timestamp` int(10) unsigned DEFAULT NULL COMMENT '交易成功时的块时间',
    `blocknumber` int(10) unsigned DEFAULT NULL COMMENT '交易成功的所在块',
    `success_time` int(10) unsigned DEFAULT NULL COMMENT '获取到交易成功的时间',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现表';
