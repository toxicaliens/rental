
/* Create Tables */

DROP TABLE IF EXISTS address;
CREATE TABLE address
(
	address_id bigserial NOT NULL,
	phone int,
	email character varying(255),
	postal_address character varying,
	address_location character varying(50),
	town character varying(50),
	mf_id bigint NOT NULL,
	address_type_id int NOT NULL,
	PRIMARY KEY (address_id)
) WITHOUT OIDS;


-- CREATE TABLE address_types
-- (
-- 	address_type_id serial NOT NULL,
-- 	address_type_name character varying(100),
-- 	status int,
-- 	PRIMARY KEY (address_type_id)
-- ) WITHOUT OIDS;


CREATE TABLE airtime_claim
(
	airtime_claim_id bigserial NOT NULL,
	airtime_amount double precision,
	airtime_serial_no character varying,
	claimed boolean,
	airtime_claimed_date timestamp,
	customer_account_id bigint NOT NULL,
	bill_id bigint NOT NULL,
	PRIMARY KEY (airtime_claim_id)
) WITHOUT OIDS;


CREATE TABLE attributes
(
	attribute_id bigserial NOT NULL,
	name character varying,
	PRIMARY KEY (attribute_id)
) WITHOUT OIDS;


-- CREATE TABLE audit_trail
-- (
-- 	trail_id serial NOT NULL,
-- 	case_name character varying(100),
-- 	datetime timestamp with time zone,
-- 	session_id bigint,
-- 	mf_id bigint NOT NULL,
-- 	PRIMARY KEY (trail_id)
-- ) WITHOUT OIDS;


CREATE TABLE customer_account
(
	customer_account_id bigserial NOT NULL,
	customer_account_code character varying(100) NOT NULL UNIQUE,
	mf_id bigint NOT NULL,
	device_id bigint NOT NULL,
	first_auth_code character varying(6),
	first_auth_deactivated boolean DEFAULT 'FALSE' NOT NULL,
	issued_phone_number character varying NOT NULL,
	current_phone_number character varying,
	PRIMARY KEY (customer_account_id)
) WITHOUT OIDS;


CREATE TABLE customer_billing_file
(
	created_by bigint NOT NULL,
	billing_file_id bigserial NOT NULL,
	customer_account_id bigint NOT NULL,
	start_date date NOT NULL,
	billing_interval character varying(20) NOT NULL,
	billing_amount double precision NOT NULL,
	billing_amount_balance double precision,
	billing_term_in_years int,
	billing_term_in_months int,
	billing_monthly_due_date int,
	billing_yearly_due_date date,
	billing_weekly_due_day character varying(16),
	created timestamp NOT NULL,
	updated timestamp DEFAULT now(),
	PRIMARY KEY (billing_file_id)
) WITHOUT OIDS;


CREATE TABLE customer_bills
(
	bill_id bigserial NOT NULL,
	bill_due_date date,
	bill_amount double precision,
	bill_date date,
	bill_status character varying(10),
	bill_amount_paid double precision,
	bill_balance double precision,
	billing_file_id bigint NOT NULL,
	service_account bigint,
	PRIMARY KEY (bill_id)
) WITHOUT OIDS;


CREATE TABLE customer_inbox
(
	customer_account_id bigint NOT NULL,
	message_id bigint NOT NULL
) WITHOUT OIDS;


CREATE TABLE customer_refferal
(
	refferal_id bigserial NOT NULL,
	refferal_phone_number character varying,
	refferred_id_no character varying,
	refferred_service_account bigint,
	refferee_service_account bigint,
	refferal_date date NOT NULL,
	refferal_commission double precision,
	refferal_mature_date date,
	refferal_code character varying,
	PRIMARY KEY (refferal_id)
) WITHOUT OIDS;


CREATE TABLE entity_type
(
	entity_id serial NOT NULL,
	entity_type_name character varying(50),
	PRIMARY KEY (entity_id)
) WITHOUT OIDS;


CREATE TABLE faq
(
	faq_id serial NOT NULL,
	status boolean,
	faq_question text,
	faq_answer text,
	created timestamp,
	created_by bigint,
	faq_category character varying(32),
	PRIMARY KEY (faq_id)
) WITHOUT OIDS;


CREATE TABLE gtel_device
(
	device_id bigserial NOT NULL,
	device_model_id int NOT NULL,
	imei character varying NOT NULL UNIQUE,
	PRIMARY KEY (device_id)
) WITHOUT OIDS;


CREATE TABLE gtel_device_attributes
(
	device_id bigint NOT NULL,
	attribute_id bigint NOT NULL,
	attribute_value character varying
) WITHOUT OIDS;


CREATE TABLE gtel_device_model
(
	device_model_id serial NOT NULL,
	model_name character varying,
	model_number character varying,
	PRIMARY KEY (device_model_id)
) WITHOUT OIDS;


CREATE TABLE gtel_device_models_attributes
(
	device_model_id int NOT NULL,
	attribute_id bigint NOT NULL,
	attribute_value character varying
) WITHOUT OIDS;


CREATE TABLE gtel_insurance
(
	insurance_id bigserial NOT NULL,
	insurance_policy character varying(100) NOT NULL UNIQUE,
	insurance_term_in_years int,
	start_date date,
	status boolean,
	customer_account_id bigint NOT NULL,
	transaction_id bigint NOT NULL,
	PRIMARY KEY (insurance_id)
) WITHOUT OIDS;


CREATE TABLE image
(
	image_id bigserial NOT NULL,
	caption character varying,
	entity_type character varying(50),
	image_type character varying,
	entity_id bigserial,
	mf_id bigint NOT NULL,
	device_model_id int NOT NULL,
	image_path character varying,
	local_image_path character varying,
	PRIMARY KEY (image_id)
) WITHOUT OIDS;


CREATE TABLE insurance_claim
(
	claim_id bigserial NOT NULL,
	claim_type character varying(50),
	claim_description text,
	claim_bill_id bigint,
	insurance_id bigint NOT NULL,
	support_ticket_id bigint,
	PRIMARY KEY (claim_id)
) WITHOUT OIDS;


-- CREATE TABLE journal
-- (
-- 	journal_id bigserial NOT NULL,
-- 	amount double precision,
-- 	journal_type int,
-- 	journal_code character varying(30),
-- 	service_account character varying(30),
-- 	particulars text,
-- 	journal_date timestamp,
-- 	stamp bigint,
-- 	dr_cr character varying(4),
-- 	mf_id bigint NOT NULL,
-- 	PRIMARY KEY (journal_id)
-- ) WITHOUT OIDS;


-- CREATE TABLE login_attempts
-- (
-- 	id serial NOT NULL,
-- 	ip character varying(20),
-- 	attempts int,
-- 	last_login timestamp,
-- 	PRIMARY KEY (id)
-- ) WITHOUT OIDS;


-- CREATE TABLE login_sessions
-- (
-- 	login_id bigint,
-- 	login_session_id serial NOT NULL,
-- 	datetime time with time zone,
-- 	session_id character varying,
-- 	mf_id bigint NOT NULL,
-- 	PRIMARY KEY (login_session_id)
-- ) WITHOUT OIDS;

DROP IF EXISTS masterfile;
CREATE TABLE masterfile
(
	mf_id bigserial NOT NULL,
	active boolean,
	b_role character varying(30),
	image_id bigint,
	firstname character varying(50),
	middlename character varying(50),
	surname character varying(50),
	id_passport character varying(20),
	gender character varying(20),
	entity_type_id int NOT NULL,
	PRIMARY KEY (mf_id)
) WITHOUT OIDS;


-- CREATE TABLE menu
-- (
-- 	menu_id serial NOT NULL,
-- 	icon character varying(30),
-- 	menu_class character varying,
-- 	status boolean,
-- 	text character varying(100),
-- 	view_id bigint NOT NULL,
-- 	parent_id int,
-- 	menu_sequence int,
-- 	PRIMARY KEY (menu_id)
-- ) WITHOUT OIDS;


CREATE TABLE message
(
	message_id bigserial NOT NULL,
	body text,
	subject character varying,
	sender bigint NOT NULL,
	recipients bigint[],
	created timestamp DEFAULT now(),
	message_type_id int NOT NULL,
	PRIMARY KEY (message_id)
) WITHOUT OIDS;


CREATE TABLE message_type
(
	message_type_id serial NOT NULL,
	message_type_name character varying(50),
	PRIMARY KEY (message_type_id)
) WITHOUT OIDS;


CREATE TABLE refferal_commissions
(
	id bigint NOT NULL,
	customer_account_id bigint NOT NULL,
	consumed double precision,
	balance double precision,
	total double precision,
	PRIMARY KEY (id)
) WITHOUT OIDS;


CREATE TABLE request_types
(
	request_type_id bigserial NOT NULL,
	request_type_name character varying(50),
	PRIMARY KEY (request_type_id)
) WITHOUT OIDS;

DROP IF EXISTS revenue_channel;
CREATE TABLE revenue_channel
(
	revenue_channel_id serial NOT NULL,
	revenue_channel_name character varying(50),
	revenue_channel_code character varying(50),
	PRIMARY KEY (revenue_channel_id)
) WITHOUT OIDS;

DROP IF EXISTS service_channels;
CREATE TABLE service_channels
(
	service_channel_id bigserial NOT NULL,
	service_option character varying(50),
	option_code character varying(50),
	price double precision,
	status boolean,
	revenue_channel_id int NOT NULL,
	request_type_id bigint NOT NULL,
	parent_id bigint,
	PRIMARY KEY (service_channel_id)
) WITHOUT OIDS;


CREATE TABLE support_ticket
(
	support_ticket_id bigserial NOT NULL,
	customer_account_id bigint NOT NULL,
	subject character varying,
	reported_by bigint,
	status character varying(16),
	body text,
	reported_time timestamp,
	PRIMARY KEY (support_ticket_id)
) WITHOUT OIDS;


CREATE TABLE support_tickets_messages
(
	support_ticket_id bigint NOT NULL,
	message_id bigint NOT NULL
) WITHOUT OIDS;


CREATE TABLE support_ticket_assignment
(
	support_ticket_id bigint NOT NULL,
	assigned_to bigint NOT NULL,
	escalated_level int DEFAULT 0
) WITHOUT OIDS;


-- CREATE TABLE sys_actions
-- (
-- 	sys_action_id bigserial NOT NULL,
-- 	sys_action_description text,
-- 	sys_action_status boolean,
-- 	sys_action_name character varying(20),
-- 	sys_action_code character varying(10),
-- 	sys_action_type character varying(50),
-- 	sys_action_class character varying(50),
-- 	sys_button_type character varying(50),
-- 	others text,
-- 	sys_view_id bigint NOT NULL,
-- 	PRIMARY KEY (sys_action_id)
-- ) WITHOUT OIDS;


-- CREATE TABLE sys_role_views_allocations
-- (
-- 	sys_role_view_id bigserial NOT NULL,
-- 	sys_view_id bigint NOT NULL,
-- 	sys_role_id int NOT NULL,
-- 	PRIMARY KEY (sys_role_view_id)
-- ) WITHOUT OIDS;


-- CREATE TABLE sys_role_view_actions_allocations
-- (
-- 	sys_role_view_id bigint NOT NULL,
-- 	sys_action_id bigint NOT NULL
-- ) WITHOUT OIDS;


-- CREATE TABLE sys_views
-- (
-- 	sys_view_id bigserial NOT NULL,
-- 	sys_view_name character varying(100),
-- 	sys_view_url text,
-- 	sys_view_status boolean,
-- 	sys_view_index character varying(20),
-- 	parent bigint,
-- 	CONSTRAINT sys_views_fkey PRIMARY KEY (sys_view_id),
-- 	sys_views
-- ) WITHOUT OIDS;


CREATE TABLE transactions
(
	transaction_id bigserial NOT NULL,
	cash_paid double precision,
	receiptnumber character varying(50),
	transaction_date timestamp DEFAULT now(),
	service_account character varying(100),
	details text,
	transacted_by bigint,
	bill_id bigint NOT NULL,
	service_id bigint NOT NULL,
	reference_code character varying(100),
	otc boolean,
	payment_type int,
	PRIMARY KEY (transaction_id)
) WITHOUT OIDS;


-- CREATE TABLE unsuccessful_login_attempts
-- (
-- 	attempts_id bigserial NOT NULL,
-- 	username character varying(100),
-- 	user_active boolean,
-- 	password character varying,
-- 	ip character varying,
-- 	datetime time with time zone,
-- 	PRIMARY KEY (attempts_id)
-- ) WITHOUT OIDS;


-- CREATE TABLE users
-- (
-- 	user_id bigserial NOT NULL,
-- 	username character varying NOT NULL UNIQUE,
-- 	password character varying,
-- 	email character varying,
-- 	mf_id bigint NOT NULL,
-- 	user_role int NOT NULL,
-- 	PRIMARY KEY (user_id)
-- ) WITHOUT OIDS;


-- CREATE TABLE user_roles
-- (
-- 	role_id serial NOT NULL,
-- 	role_name character varying(255),
-- 	role_status boolean,
-- 	PRIMARY KEY (role_id)
-- ) WITHOUT OIDS;



/* Create Foreign Keys */

ALTER TABLE address
	ADD FOREIGN KEY (address_type_id)
	REFERENCES address_types (address_type_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_device_attributes
	ADD FOREIGN KEY (attribute_id)
	REFERENCES attributes (attribute_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_device_models_attributes
	ADD FOREIGN KEY (attribute_id)
	REFERENCES attributes (attribute_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE airtime_claim
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_billing_file
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_bills
	ADD FOREIGN KEY (service_account)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_inbox
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_refferal
	ADD FOREIGN KEY (refferee_service_account)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_refferal
	ADD FOREIGN KEY (refferred_service_account)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_insurance
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE refferal_commissions
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE support_ticket
	ADD FOREIGN KEY (customer_account_id)
	REFERENCES customer_account (customer_account_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_bills
	ADD FOREIGN KEY (billing_file_id)
	REFERENCES customer_billing_file (billing_file_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE airtime_claim
	ADD FOREIGN KEY (bill_id)
	REFERENCES customer_bills (bill_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE transactions
	ADD FOREIGN KEY (bill_id)
	REFERENCES customer_bills (bill_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE masterfile
	ADD FOREIGN KEY (entity_type_id)
	REFERENCES entity_type (entity_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE customer_account
	ADD FOREIGN KEY (device_id)
	REFERENCES gtel_device (device_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_device_attributes
	ADD FOREIGN KEY (device_id)
	REFERENCES gtel_device (device_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_device
	ADD FOREIGN KEY (device_model_id)
	REFERENCES gtel_device_model (device_model_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE gtel_device_models_attributes
	ADD FOREIGN KEY (device_model_id)
	REFERENCES gtel_device_model (device_model_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE image
	ADD FOREIGN KEY (device_model_id)
	REFERENCES gtel_device_model (device_model_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE insurance_claim
	ADD FOREIGN KEY (insurance_id)
	REFERENCES gtel_insurance (insurance_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE address
	ADD FOREIGN KEY (mf_id)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


-- ALTER TABLE audit_trail
-- 	ADD FOREIGN KEY (mf_id)
-- 	REFERENCES masterfile (mf_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


ALTER TABLE customer_account
	ADD FOREIGN KEY (mf_id)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE faq
	ADD FOREIGN KEY (created_by)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE image
	ADD FOREIGN KEY (mf_id)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


-- ALTER TABLE journal
-- 	ADD FOREIGN KEY (mf_id)
-- 	REFERENCES masterfile (mf_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE login_sessions
-- 	ADD FOREIGN KEY (mf_id)
-- 	REFERENCES masterfile (mf_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


ALTER TABLE support_ticket_assignment
	ADD FOREIGN KEY (assigned_to)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE transactions
	ADD FOREIGN KEY (transacted_by)
	REFERENCES masterfile (mf_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


-- ALTER TABLE users
-- 	ADD FOREIGN KEY (mf_id)
-- 	REFERENCES masterfile (mf_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE menu
-- 	ADD FOREIGN KEY (parent_id)
-- 	REFERENCES menu (menu_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


ALTER TABLE customer_inbox
	ADD FOREIGN KEY (message_id)
	REFERENCES message (message_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE support_tickets_messages
	ADD FOREIGN KEY (message_id)
	REFERENCES message (message_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE message
	ADD FOREIGN KEY (message_type_id)
	REFERENCES message_type (message_type_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE service_channels
	ADD FOREIGN KEY (request_type_id)
	REFERENCES request_types (request_type_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE service_channels
	ADD FOREIGN KEY (revenue_channel_id)
	REFERENCES revenue_channel (revenue_channel_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE service_channels
	ADD FOREIGN KEY (parent_id)
	REFERENCES service_channels (service_channel_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE transactions
	ADD FOREIGN KEY (service_id)
	REFERENCES service_channels (service_channel_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE insurance_claim
	ADD FOREIGN KEY (support_ticket_id)
	REFERENCES support_ticket (support_ticket_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE support_tickets_messages
	ADD FOREIGN KEY (support_ticket_id)
	REFERENCES support_ticket (support_ticket_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE support_ticket_assignment
	ADD FOREIGN KEY (support_ticket_id)
	REFERENCES support_ticket (support_ticket_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


-- ALTER TABLE sys_role_view_actions_allocations
-- 	ADD FOREIGN KEY (sys_action_id)
-- 	REFERENCES sys_actions (sys_action_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE sys_role_view_actions_allocations
-- 	ADD FOREIGN KEY (sys_role_view_id)
-- 	REFERENCES sys_role_views_allocations (sys_role_view_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE menu
-- 	ADD FOREIGN KEY (view_id)
-- 	REFERENCES sys_views (sys_view_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE sys_actions
-- 	ADD FOREIGN KEY (sys_view_id)
-- 	REFERENCES sys_views (sys_view_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE sys_role_views_allocations
-- 	ADD FOREIGN KEY (sys_view_id)
-- 	REFERENCES sys_views (sys_view_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE sys_views
-- 	ADD FOREIGN KEY (parent)
-- 	REFERENCES sys_views (sys_view_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


ALTER TABLE gtel_insurance
	ADD FOREIGN KEY (transaction_id)
	REFERENCES transactions (transaction_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


-- ALTER TABLE sys_role_views_allocations
-- 	ADD FOREIGN KEY (sys_role_id)
-- 	REFERENCES user_roles (role_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;


-- ALTER TABLE users
-- 	ADD FOREIGN KEY (user_role)
-- 	REFERENCES user_roles (role_id)
-- 	ON UPDATE RESTRICT
-- 	ON DELETE RESTRICT
-- ;



