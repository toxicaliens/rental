CREATE TABLE public.houses
(
house_id integer NOT NULL DEFAULT nextval('houses_house_id_seq'::regclass),
house_number character varying(25),
rent_amount double precision,
plot_id integer,
tenant_mf_id integer,
attached_to integer,
rent_rate character varying(50),
square_footage integer,
rate_per_square_footage integer,
service_charge character varying(50),
service_charge_rate double precision,
total_service_charge double precision,
CONSTRAINT houses_pkey PRIMARY KEY (house_id),
CONSTRAINT houses_plot_id_fkey FOREIGN KEY (plot_id)
REFERENCES public.plots (plot_id) MATCH SIMPLE
ON UPDATE CASCADE ON DELETE NO ACTION,
CONSTRAINT houses_house_number_key UNIQUE (house_number)
)
WITH (
OIDS=FALSE
);
ALTER TABLE public.houses
OWNER TO postgres;