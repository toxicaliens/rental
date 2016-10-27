CREATE VIEW customers_and_accounts AS
 SELECT ca.customer_code,
    ca.status,
    ca.referee_mf_id,
    ca.issued_phone_number,
    ca.current_phone_number,
    gd.imei,
    concat(m.surname, ' ', m.firstname, ' ', m.middlename) AS customer_name,
    gdm.device_model_id,
    gdm.model,
    gd.device_id
   FROM (((customer_account ca
     LEFT JOIN gtel_device gd ON ((gd.device_id = ca.device_id)))
     LEFT JOIN masterfile m ON ((m.mf_id = ca.mf_id)))
     LEFT JOIN gtel_device_model gdm ON ((gdm.device_model_id = gd.device_model_id)));