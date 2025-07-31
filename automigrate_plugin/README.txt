INTRODUCTION
------------

This Migrate module is to create and update the nodes of content type using migration APIs

For the migration, a configuration file is created which contains all the information about the migration, mapping of fields, source, destination and etc

In migration we use ETL process
	
	* Extract - "Source" -> The data can be migrated from a CSV file. 
	* Transforn - "Process" -> The row is sent to the process where it is transformed as needed.
	* Load - "Destination" -> The transformed row is passed to the destination phase where it is loaded into the target. 


MODULES
-------
* Migrate
* Migrate Plus
* Migrate Tools
* Migrate Source CSV
* Migrate Cron
* Migration Query Import

Migrate: Provides the APIs for importing data to drupal 8 from any data source.
Migrate tools: It provide drush commands such as
	* migrate-status
	* migrate-import
	* migrate-rollback
	* migrate-stop
	* migrate-reset-status and etc
Migrate Plus: Provides APIs for grouping migrations as well as facility to manipulate incoming source data in migrations
Mirgrate source CSV: provides a source plugin for utilizing .CSV files as migration source.


MAPPING OF FIELDS
-----------------

The mapping of the fields is done in process section. We use Migrate Process Plugins. There are some process plugins provided by core module Migrate and contributed module Migrate Plus. Some custom migrate plugin have been created according to the requirements.

- uid: By default the value passed is 1(admin).
- type: Default value has been passed as 'content_type'
- status: A custom process plugin has been created to check the contion if firstname,lastname, unique id, email, brand image URL is not empty. Validate the email and the brand image Link.
- title: Core module process plugin has been used name "concat" using firstname and lastname
- field_unique_id: unique id
- field_first_name: First Name
- field_last_name: Last Name
- field_job_title: Two process plugins are used. Custom process plugin to explode the data passed with a delimiter " + ". Core Preprocess plugin for entity generate
- field_address: Job Title Description
- field_mobile: phone_number
- field_email_address: email


UPDATE FEATURE
--------------

The row update feature works with the command "drush migrate-import migrate_id --update".

For updating only a row if it is updated, We have used Nid in process and to get the Nid on the basis of unique ID we have used a Custom Process plugin "map_id". 
The fields which we need to update are written in the destination field.

UNPUBLISH FEATURE
-----------------

For unpublishing the nodes which have been removed from the CSV. The Queue Worker has been used. This Queue up a the data which will be processed once cron is completed.
