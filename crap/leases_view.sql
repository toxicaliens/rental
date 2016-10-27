CREATE OR REPLACE VIEW public.leases AS
 SELECT h.house_id,
    h.house_number,
    h.rent_amount,
    h.plot_id,
    h.tenant_mf_id,
    h.attached_to,
    ls.lease_id,
    ls.tenant,
    ls.start_date,
    ls.end_date,
    p.pm_mfid,
    p.landlord_mf_id,
    ls.status
   FROM lease ls
     LEFT JOIN houses h ON h.house_id = ls.house_id
     LEFT JOIN plots p ON p.plot_id = h.plot_id;
