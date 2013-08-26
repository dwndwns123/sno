# this script should be exectued once the environment.sql & load.sql scripts have executed to create a 'snomedct' database
# Must first combine all RFE & HI refset files, changing reset id of HI from 450994008 to 450994009 (as a temporary measure 

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
Type VARCHAR(18),
refsetid varchar(18) not null
);

CREATE TABLE SCT_Concepts (
concept_id VARCHAR(18) NOT NULL,
label VARCHAR(300),
refset_type_id varchar(18) not null
);

##### Load up Health Issue RefSet
# change file name to the relevant HI refset filename & location
LOAD DATA LOCAL INFILE '/Users/rory/Dev/SCTUtils/all_concepts.txt' INTO TABLE ICPCRefset IGNORE 1 LINES;
CREATE INDEX id2 ON ICPCRefset(referencedcomponentid);


# takes 7 minutes to run
INSERT INTO ICPCSynonyms (DescId, ConceptId, Synonym, Type, refsetid)
SELECT Descriptions.Id AS DescId, Descriptions.ConceptId AS ConceptId, Descriptions.term AS Synonym, Descriptions.typeId AS Type, I.refsetid AS refsetid 
FROM curr_description_s Descriptions, ICPCRefset I 
WHERE I.referencedcomponentid = Descriptions.ConceptId
AND Descriptions.active = '1';

CREATE INDEX id33 ON ICPCSynonyms(DescId);
CREATE INDEX id44 ON ICPCSynonyms(ConceptId);

INSERT INTO SCT_Concepts (concept_id, Label, refset_type_id)
SELECT ICPCSynonyms.ConceptId AS ConceptId, ICPCSynonyms.Synonym AS label, ICPCSynonyms.refsetid AS refset_type_id 
FROM ICPCSynonyms 
INNER JOIN curr_langrefset_s ON curr_langrefset_s.ReferencedComponentId = ICPCSynonyms.DescId
WHERE curr_langrefset_s.AcceptabilityId = "900000000000548007" AND curr_langrefset_s.Active = '1' AND 
curr_langrefset_s.refsetId = "900000000000509007" AND ICPCSynonyms.Type = "900000000000013009";

CREATE INDEX id35 ON SCT_Concepts(concept_id);

#temp reset type id's for applicaiton specific use

UPDATE SCT_Concepts
SET refset_type_id = '0'
WHERE refset_type_id = '450994008';

UPDATE SCT_Concepts
SET refset_type_id = '1'
WHERE refset_type_id = '450994009';
