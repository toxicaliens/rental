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