use `field-test`;

DROP TABLE IF EXISTS ICPC_SCT_Map;
create table ICPC_SCT_Map(
sct_id varchar(18) not null,
icpc_id varchar(10) not null
);

load data local 
	infile '/Users/rory/Dev/SCTUtils/map-20130827.txt' 
	into table ICPC_SCT_Map
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;