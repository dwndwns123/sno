# this script should be exectued once the environment.sql & load.sql scripts have executed to create a 'snomedct' database

use snomedct;

DROP TABLE IF EXISTS ICPCSynonyms;
DROP TABLE IF EXISTS  SCT_Concepts;

DROP TABLE IF EXISTS ICPCRefset;
create table ICPCRefset(
id varchar(36) not null,
effectivetime char(8) not null,
active char(1) not null,
moduleid varchar(18) not null,
refsetid varchar(18) not null,
referencedcomponentid varchar(18) not null,
attributeValue varchar(18) not null
);

CREATE TABLE ICPCSynonyms (
DescId VARCHAR(18) NOT NULL,
ConceptId VARCHAR(18) NOT NULL,
Synonym VARCHAR(300),
Type VARCHAR(18)
);

CREATE TABLE SCT_Concepts (
ConceptId VARCHAR(18) NOT NULL,
Label VARCHAR(300),
Type VARCHAR(5)
);

##### Load up Health Issue RefSet
# change file name to the relevant HI refset filename & location
LOAD DATA LOCAL INFILE '/Users/rory/Dev/SCTUtils/HI_refset.txt' INTO TABLE ICPCRefset IGNORE 1 LINES;
CREATE INDEX id2 ON ICPCRefset(referencedcomponentid);

# takes 7 minutes to run
INSERT INTO ICPCSynonyms (DescId, ConceptId, Synonym, Type)
SELECT Descriptions.Id AS DescId, Descriptions.ConceptId AS ConceptId, Descriptions.term AS Synonym, Descriptions.typeId AS Type 
FROM curr_description_f Descriptions 
INNER JOIN ICPCRefset ON ICPCRefset.referencedcomponentid = Descriptions.ConceptId
WHERE Descriptions.active = '1';

CREATE INDEX id33 ON ICPCSynonyms(DescId);
CREATE INDEX id44 ON ICPCSynonyms(ConceptId);

# takes 70 minutes to run
INSERT INTO SCT_Concepts (ConceptId, Label, Type)
SELECT ICPCSynonyms.ConceptId AS ConceptId, ICPCSynonyms.Synonym AS Label, "HI" AS Type 
FROM ICPCSynonyms 
INNER JOIN curr_langrefset_f ON curr_langrefset_f.ReferencedComponentId = ICPCSynonyms.DescId
WHERE curr_langrefset_f.AcceptabilityId = "900000000000548007" AND curr_langrefset_f.Active = '1' AND 
curr_langrefset_f.refsetId = "900000000000509007" AND ICPCSynonyms.Type = "900000000000013009";

CREATE INDEX id5 ON ICPCPTs(ConceptId);



##### Load up REF RefSet
DROP TABLE IF EXISTS ICPCRefset;
create table ICPCRefset(
id varchar(36) not null,
effectivetime char(8) not null,
active char(1) not null,
moduleid varchar(18) not null,
refsetid varchar(18) not null,
referencedcomponentid varchar(18) not null,
attributeValue varchar(18) not null
);

# change file name to the relevant HI refset filename & location
LOAD DATA LOCAL INFILE '/Users/rory/Dev/SCTUtils/HI_refset.txt' INTO TABLE ICPCRefset IGNORE 1 LINES;
CREATE INDEX id3 ON ICPCRefset(referencedcomponentid);

# takes 7 minutes to run
INSERT INTO ICPCSynonyms (DescId, ConceptId, Synonym, Type)
SELECT Descriptions.Id AS DescId, Descriptions.ConceptId AS ConceptId, Descriptions.term AS Synonym, Descriptions.typeId AS Type 
FROM curr_description_f Descriptions 
INNER JOIN ICPCRefset ON ICPCRefset.referencedcomponentid = Descriptions.ConceptId
WHERE Descriptions.active = '1';

CREATE INDEX id33 ON ICPCSynonyms(DescId);
CREATE INDEX id44 ON ICPCSynonyms(ConceptId);

# takes 70 minutes to run
INSERT INTO SCT_Concepts (ConceptId, Label, Type)
SELECT ICPCSynonyms.ConceptId AS ConceptId, ICPCSynonyms.Synonym AS Label, "RFE" AS Type 
FROM ICPCSynonyms 
INNER JOIN curr_langrefset_f ON curr_langrefset_f.ReferencedComponentId = ICPCSynonyms.DescId
WHERE curr_langrefset_f.AcceptabilityId = "900000000000548007" AND curr_langrefset_f.Active = '1' AND 
curr_langrefset_f.refsetId = "900000000000509007" AND ICPCSynonyms.Type = "900000000000013009";
