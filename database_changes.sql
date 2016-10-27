ALTER TABLE device_group_allocations ADD COLUMN client_mfid bigint;
ALTER TABLE device_groups ADD COLUMN client_mfid bigint;
ALTER TABLE phone_list ADD COLUMN phone_name character varying;

-- ALTER TABLE tablename RENAME COLUMN existin_column_name TO new_column_name;

-- Change Column Data Type
-- ALTER TABLE tablename ALTER COLUMN column_name TYPE new_data_type;

ALTER TABLE phone_list ALTER COLUMN description TYPE text;