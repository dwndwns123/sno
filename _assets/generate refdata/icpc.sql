use `field-test`;

DROP TABLE IF EXISTS ICPC_Codes;
create table ICPC_Codes(
id varchar(10) not null,
title varchar(50) not null
);

load data local 
	infile '/Users/rory/Dev/SCTUtils/icpc.txt' 
	into table ICPC_Codes
	columns terminated by ';' 
	lines terminated by '\r\n' 
	ignore 7 lines;