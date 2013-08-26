
/* loads the SNOMED CT 'Snapshot' release - replace filenames with relevant locations*/

use snomedct;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Terminology/sct2_Concept_Snapshot_INT_20130731.txt' 
	into table curr_concept_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Terminology/sct2_Description_Snapshot-en_INT_20130731.txt' 
	into table curr_description_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Terminology/sct2_TextDefinition_Snapshot-en_INT_20130731.txt' 
	into table curr_textdefinition_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Terminology/sct2_Relationship_Snapshot_INT_20130731.txt' 
	into table curr_relationship_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Terminology/sct2_StatedRelationship_Snapshot_INT_20130731.txt' 
	into table curr_stated_relationship_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Language/der2_cRefset_LanguageSnapshot-en_INT_20130731.txt' 
	into table curr_langrefset_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Content/der2_cRefset_AssociationReferenceSnapshot_INT_20130731.txt' 
	into table curr_associationrefset_d
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Content/der2_cRefset_AttributeValueSnapshot_INT_20130731.txt' 
	into table curr_attributevaluerefset_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Crossmap/der2_sRefset_SimpleMapSnapshot_INT_20130731.txt' 
	into table curr_simplemaprefset_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Content/der2_Refset_SimpleSnapshot_INT_20130731.txt' 
	into table curr_simplerefset_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;

load data local 
	infile '/Users/rory/Dev/SCTUtils/SnomedCT_Release_INT_20130731/RF2Release/Snapshot/Refset/Crossmap/der2_iissscRefset_ComplexMapSnapshot_INT_20130731.txt' 
	into table curr_complexmaprefset_s
	columns terminated by '\t' 
	lines terminated by '\r\n' 
	ignore 1 lines;
























