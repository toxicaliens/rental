-- Payment & Bills Modules
-- Payment Modes
DROP TABLE IF EXISTS payment_mode;
CREATE TABLE public.payment_mode (
  payment_mode_id serial PRIMARY KEY NOT NULL,
  payment_mode_name CHARACTER VARYING(50),
  payment_mode_code CHARACTER VARYING(100),
  payment_mode_description TEXT
);

INSERT INTO payment_mode VALUES (1, 'Cash', 'CASH', '');
INSERT INTO payment_mode VALUES (2, 'Mpesa', 'MPESA', '');
INSERT INTO payment_mode VALUES (3, 'Cheque', 'CHEQUE', '');

-- Transaction Changes
ALTER TABLE public.transactions ADD COLUMN payment_mode_id bigint;
ALTER TABLE public.transactions ADD COLUMN payment_reference character varying(255);
ALTER TABLE public.transactions ALTER COLUMN payment_reference SET DEFAULT NULL::character varying;

-- Receipt
CREATE TABLE public.receipts (
  generated_code CHARACTER VARYING(50),
  receipt_type CHARACTER VARYING(50),
  receipt_date TIMESTAMP WITHOUT TIME ZONE DEFAULT now(),
  order_id BIGINT,
  receipt_id serial NOT NULL
);

<<<<<<< HEAD
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
=======
-- Receipt View
DROP VIEW IF EXISTS receipt_data;
CREATE OR REPLACE VIEW public.receipt_data AS
  SELECT t.transaction_id,
    t.cash_paid,
    t.receiptnumber,
    t.transaction_date,
    t.service_account,
    t.details,
    t.transacted_by,
    t.bill_id,
    t.service_id,
    t.reference_code,
    t.otc,
    t.mf_id,
    t.payment_mode,
    t.payment_mode_id,
    t.payment_reference,
    rec.generated_code,
    rec.receipt_type,
    rec.receipt_id,
    concat(m.surname, ' ', m.firstname) AS customer_name
  FROM receipts rec
    LEFT JOIN transactions t ON t.receiptnumber::text = rec.generated_code::text
    LEFT JOIN masterfile m ON t.mf_id = m.mf_id
    LEFT JOIN customer_bills cb ON cb.bill_id = t.bill_id;

-- Bill Data
DROP VIEW IF EXISTS bill_data;
CREATE OR REPLACE VIEW public.bill_data AS
  SELECT cb.bill_id,
    cb.bill_amount,
    cb.bill_date,
    cb.bill_status,
    cb.bill_amount_paid,
    cb.bill_balance,
    cb.billing_file_id,
    cb.mf_id,
    cb.service_channel_id,
    cb.service_account,
    cb.total_cash_received,
    cb.bill_due_date,
    sc.service_option
  FROM customer_bills cb
    LEFT JOIN service_channels sc ON cb.service_channel_id = sc.service_channel_id;
>>>>>>> ce6694a7570de335a014da154df4e13a0c87cc66
