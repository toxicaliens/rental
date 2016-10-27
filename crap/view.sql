CREATE OR REPLACE VIEW unallocated_houses AS
  SELECT h.house_id,
    h.plot_id,
    h.house_number,
    h.tenant_mf_id,
    l.status,
    p.created_by
  FROM houses h
    LEFT JOIN leases l ON l.house_id = h.house_id
    LEFT JOIN plots p ON p.plot_id = h.plot_id
  WHERE h.tenant_mf_id IS NULL AND l.status IS NULL;

DROP TABLE public.user_login2;
CREATE TABLE public.user_login2
(
  user_id integer NOT NULL DEFAULT nextval('user_login2_seq'::regclass),
  username character varying(255) NOT NULL,
  password character varying(40) NOT NULL,
  email character varying(60) NOT NULL,
  user_active boolean NOT NULL,
  user_role integer,
  staff_customer_id integer,
  client_mf_id bigint,
  mf_id bigint,
  status boolean DEFAULT true,
  CONSTRAINT user_login2_pkey PRIMARY KEY (user_id),
  CONSTRAINT user_login2_mf_id_fkey FOREIGN KEY (mf_id)
      REFERENCES public.masterfile (mf_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE public.customer_messages;
CREATE TABLE public.customer_messages
(
  mf_id bigint NOT NULL,
  message_id bigint NOT NULL,
  read boolean DEFAULT false,
  CONSTRAINT customer_inbox_message_id_fkey FOREIGN KEY (message_id)
      REFERENCES public.message (message_id) MATCH SIMPLE
      ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT customer_messages_mf_id_fkey FOREIGN KEY (mf_id)
      REFERENCES public.masterfile (mf_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE public.contractor;
CREATE TABLE public.contractor
(
  mf_id bigint,
  ratings character varying(255),
  skills character varying(255),
  pm_id bigint,
  created_by bigint,
  contractor_id integer NOT NULL DEFAULT nextval('contractor_contractor_id_seq'::regclass),
  CONSTRAINT contractor_pkey PRIMARY KEY (contractor_id),
  CONSTRAINT contractor_mf_id_fkey FOREIGN KEY (mf_id)
      REFERENCES public.masterfile (mf_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT contractor_pm_id_fkey FOREIGN KEY (pm_id)
      REFERENCES public.property_manager (pm_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION
);

DROP TABLE public.landlords;
CREATE TABLE public.landlords
(
  landlord_id integer NOT NULL DEFAULT nextval('landlords_landlord_id_seq'::regclass),
  mf_id bigint,
  bank_acc_id bigint,
  plot_id bigint,
  created_by character varying(255),
  CONSTRAINT landlords_pkey PRIMARY KEY (landlord_id),
  CONSTRAINT landlords_account_id_fkey FOREIGN KEY (bank_acc_id)
      REFERENCES public.bank_account (bank_acc_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION,
  CONSTRAINT landlords_mf_id_fkey FOREIGN KEY (mf_id)
      REFERENCES public.masterfile (mf_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT landlords_plot_id_fkey FOREIGN KEY (plot_id)
      REFERENCES public.plots (plot_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE NO ACTION
);