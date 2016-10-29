DROP VIEW service_bills_and_options;
CREATE VIEW service_bills_and_options AS
 SELECT sb.product_id,
    sc.price AS loan_amount
   FROM (revenue_service_bill sb
     LEFT JOIN service_channels sc ON ((sc.service_channel_id = sb.service_channel_id)));


DROP TABLE IF EXISTS revenue_service_bill;

CREATE TABLE public.revenue_service_bill
(
  bill_name character varying(50),
  bill_description character varying(30),
  bill_category character varying(30),
  bill_type character varying(30),
  amount_type character varying(30),
  amount double precision,
  bill_code character varying(30),
  bill_due_time character varying(30),
  revenue_channel_id integer,
  bill_interval character varying(255),
  service_channel_id bigint,
  product_id bigint,
  plot_id bigint,
  revenue_bill_id serial NOT NULL,
  CONSTRAINT revenue_service_bill_pkey PRIMARY KEY (revenue_bill_id)
)
WITH (
  OIDS=FALSE
);

DROP VIEW all_masterfile;
CREATE OR REPLACE VIEW all_masterfile AS
 SELECT m.surname,
    m.active,
    m.mf_id,
    m.firstname,
    m.middlename,
    m.id_passport,
    m.gender,
    m.images_path,
    m.regdate_stamp,
    m.b_role,
    m.dob,
    m.time_stamp,
    m.customer_type_id,
    m.email,
    m.company_name,
    ul.username,
    c.customer_type_name,
    ul.user_role,
    concat(m.surname, ' ', m.firstname, ' ', m.middlename) AS full_name
   FROM masterfile m
     LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
     LEFT JOIN customer_types c ON c.customer_type_id = m.customer_type_id;

ALTER TABLE all_masterfile
  OWNER TO postgres;

-- from eric
DROP VIEW contractors_quotes;
CREATE OR REPLACE VIEW contractors_quotes AS
  SELECT q.qoute_id,
    q.bid_amount,
    q.bid_date,
    q.bid_status,
    q.job_status,
    concat(m.surname, ' ', m.firstname, ' ', m.middlename) AS full_name,
    q.maintainance_id,
    mv.maintenance_name
  FROM quotes q
    LEFT JOIN masterfile m ON m.mf_id = q.contractor_mf_id
    LEFT JOIN maintenance_vouchers mv ON mv.voucher_id = q.maintainance_id;

-- create the following user roles
INSERT INTO user_roles(role_name, role_status) VALUES('Property Manager(Client Admin)', '1');
INSERT INTO user_roles(role_name, role_status) VALUES('Tenant', '1');
INSERT INTO user_roles(role_name, role_status) VALUES('Landlord', '1');
INSERT INTO user_roles(role_name, role_status) VALUES('Contractor', '1');

-- landlord file
DROP TABLE IF EXISTS landlords;
CREATE TABLE landlords
(
  landlord_id serial NOT NULL,
  mf_id bigint,
  bank_acc_id bigint,
  plot_id bigint,
  pin_no character varying(255),
  CONSTRAINT landlords_pkey PRIMARY KEY (landlord_id),
  CONSTRAINT landlords_account_id_fkey FOREIGN KEY (bank_acc_id)
  REFERENCES bank_account (bank_acc_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT landlords_mf_id_fkey FOREIGN KEY (mf_id)
  REFERENCES masterfile (mf_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT landlords_plot_id_fkey FOREIGN KEY (plot_id)
  REFERENCES plots (plot_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION
);

-- tenant file
DROP TABLE IF EXISTS tenants;
CREATE TABLE tenants
(
  tenant_id serial NOT NULL,
  mf_id bigint,
  house_id bigint,
  CONSTRAINT tenants_pkey PRIMARY KEY (tenant_id),
  CONSTRAINT tenants_house_id_fkey FOREIGN KEY (house_id)
  REFERENCES houses (house_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT tenants_mf_id_fkey FOREIGN KEY (mf_id)
  REFERENCES masterfile (mf_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION
);

-- contractor file
DROP TABLE IF EXISTS contractor;
CREATE TABLE contractor
(
  contractor_id serial NOT NULL,
  mf_id bigint,
  ratings character varying(255),
  skills character varying(255),
  pm_id bigint,
  CONSTRAINT contracor_pkey PRIMARY KEY (contractor_id),
  CONSTRAINT contracor_mf_id_fkey FOREIGN KEY (mf_id)
  REFERENCES masterfile (mf_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT contractor_pm_id_fkey FOREIGN KEY (pm_id)
  REFERENCES property_manager (pm_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION
);

-- pm
DROP TABLE IF EXISTS property_manager;
CREATE TABLE property_manager
(
  pm_id serial NOT NULL,
  mf_id bigint,
  plot_id bigint,
  CONSTRAINT property_manager_pkey PRIMARY KEY (pm_id),
  CONSTRAINT property_manager_mf_id_fkey FOREIGN KEY (mf_id)
  REFERENCES masterfile (mf_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT property_manager_plot_id_fkey FOREIGN KEY (plot_id)
  REFERENCES plots (plot_id) MATCH SIMPLE
  ON UPDATE CASCADE ON DELETE NO ACTION
);

-- views
DROP VIEW IF EXISTS houses_and_plots;
CREATE OR REPLACE VIEW houses_and_plots AS
  SELECT p.plot_name,
    h.house_id,
    h.house_number,
    h.tenant_mf_id,
    p.plot_id
  FROM houses h
    LEFT JOIN plots p ON p.plot_id = h.plot_id;


DROP VIEW IF EXISTS bank_and_branches;
CREATE OR REPLACE VIEW bank_and_branches AS
  SELECT b.bank_name,
    br.branch_name,
    b.bank_id,
    br.branch_id,
    br.branch_code,
    br.status
  FROM banks b
    LEFT JOIN bank_branch br ON br.bank_id = b.bank_id;

-- plot database changes
ALTER TABLE plots ADD COLUMN lr_no character varying(255);
ALTER TABLE plots
  ADD CONSTRAINT plots_lr_no_key UNIQUE(lr_no);


-- ALTER TABLE property_manager;
ALTER TABLE property_manager ADD COLUMN created_by bigint;

-- ALTER TABLE tenants;
ALTER TABLE tenants ADD COLUMN created_by bigint;

-- ALTER TABLE contractor;
ALTER TABLE contractor ADD COLUMN created_by bigint;

-- ALTER TABLE landlords;
ALTER TABLE landlords ADD COLUMN created_by bigint;
-- add lease table
CREATE TABLE lease
(
  lease_id serial NOT NULL,
  tenant bigint,
  house_number character varying(255),
  start_date date,
  end_date date,
  CONSTRAINT lease_pkey PRIMARY KEY (lease_id)
);
-- DROP VIEW public.service_bills_and_options;

-- deleted view
--CREATE OR REPLACE VIEW public.service_bills_and_options AS
  SELECT sb.product_id,
    sc.price AS loan_amount
  FROM revenue_service_bill sb
    LEFT JOIN service_channels sc ON sc.service_channel_id = sb.service_channel_id;