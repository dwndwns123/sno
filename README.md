field-test-tool
===============
This tool and open source code is no longer supported or hosted by SNOMED International
---------------------------------------------------------------------------------------

IHTSDO Field Test Web Tool

The field test is a web based, php/mysql system to test the clinical completeness of the SNOMED CT GP/FP RefSet as a representation of the terms commonly used by Family/General Practitioners in clinical practice with reference to Reasons for Encounter and Health Issues, and of the validity of the map from concepts in the SNOMED CT GP/FP RefSet to the ICPC-2 classification.

Various data assets are not available in the repo due to the licensed nature of SNOMED CT. These can be requested through fieldtesttool@ihtsdo.org

Minimum Specification
---------------------
- PHP v5.2.x (developed in v5.2.17)
- MYSQL v5.5.x

Installation
------------

1. Clone the repo into the directory it will be served from
2. Create the database using _assets/field_test.sql
3. Copy config/field-test-sample.ini to config/field-test.ini
4. Edit config/field-test.ini in a text editor
5. Update the url var in the [enviroment] section with the correct URL for where the site will be served
6. Update the [database] section with the host, user, password and name for your database
7. Correct the [email] section to reflect the username and address that you wish the site to send emails from

That should be it.
