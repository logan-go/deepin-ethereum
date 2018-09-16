CREATE TABLE `es_block` (
  `number` bigint(20) unsigned NOT NULL COMMENT 'number',
  `hash` char(66) NOT NULL COMMENT 'block hash',
  `author` char(42) NOT NULL COMMENT 'author',
  `miner` char(42) NOT NULL COMMENT 'miner',
  `difficulty` varchar(20) NOT NULL COMMENT 'difficulty',
  `extraData` char(42) NOT NULL COMMENT 'extraData',
  `gasLimit` varchar(40) NOT NULL COMMENT 'gasLimit',
  `gasUsed` varchar(40) NOT NULL COMMENT 'gasUsed',
  `logsBloom` text NOT NULL COMMENT 'logsBloom',
  `mixHash` char(66) NOT NULL COMMENT 'mixHash',
  `nonce` bigint(20) unsigned NOT NULL COMMENT 'nonce',
  `parentHash` char(66) NOT NULL COMMENT 'parentHash',
  `receiptsRoot` char(66) NOT NULL COMMENT 'receiptsRoot',
  `sealFields` text NOT NULL COMMENT 'sealFields',
  `sha3Uncles` char(66) NOT NULL COMMENT 'sha3Uncles',
  `stateRoot` char(66) NOT NULL COMMENT 'stateRoot',
  `size` bigint(20) unsigned NOT NULL COMMENT 'size',
  `timestamp` bigint(20) unsigned NOT NULL COMMENT 'timestamp',
  `totalDifficulty` bigint(20) unsigned NOT NULL COMMENT 'totalDifficulty',
  PRIMARY KEY (`number`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='block';

create table es_transaction(
	`id` bigint unsigned not null primary key auto_increment comment "ID",
	`hash` char(66) not null unique key comment "hash",
	`blockNumber` bigint unsigned not null comment "blockNumber",
	`chainId` int unsigned not null comment "chainId",
	`nonce` int unsigned not null comment "nonce",
	`from` char(66) not null comment "from",
	`to` char(66) not null comment "to",
	`gas` bigint unsigned not null comment "gas",
	`gasPrice` bigint unsigned not null comment "gasPrice",
	`input` text not null comment "input",
	`status` bool not null comment "status",
  	`timestamp` bigint(20) unsigned NOT NULL COMMENT 'timestamp',
	`contract` char(42) comment "contract"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='transaction';

create table es_contract(
	`id` bigint unsigned not null primary key auto_increment comment "ID",
	`address` char(42) not null unique key comment "contract address",
	`name` varchar(30) not null comment "name",
	`symbol` varchar(30) not null comment "symbol",
	`totalSupply` char(40) not null comment "totalSupply",
	`decimal` int unsigned not null comment "decimal",
	`timestamp` int unsigned not null comment "timestamp"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='contract';

create table es_logs(
	`id` bigint unsigned not null primary key auto_increment comment "ID",
	`address` char(42) not null unique key comment "contract address", 
	`transactionHash` char(66) not null unique key comment "transactionHash",
	`blockHash` char(66) not null unique key comment "blockHash",
	`blockNumber` bigint unsigned not null comment "blockNumber",
	`data` char(66) not null unique key comment "blockHash",
	`logIndex` int unsigned not null comment "logIndex",
	`removed` bool not null comment "removed",
	`topics` text not null comment "topics",
	`transactionIndex` int unsigned not null comment "transactionIndex",
	`transactionLogIndex` int unsigned not null comment "transactionLogIndex",
	`type` varchar(20) not null comment "type"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='logs';
