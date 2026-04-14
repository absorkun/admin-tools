-- DNS Server: ambil daftar domain dengan filter search dan limit
-- Search cocokkan ke domain, name_srv, dns_a, website
SELECT d.domain, d.domains_id, d.users_id, d.name_srv, d.status, d.dnssec,
       d.tgl_reg, d.tgl_exp, d.tgl_upd, d.dns_a, d.website,
       d.tgl_exp_domains, d.tgl_email, d.jumlah_notif,
       u.name AS user_name, u.email AS user_email
FROM dns_server d
LEFT JOIN users u ON u.id = d.users_id
WHERE (d.domain LIKE '%{search}%'
    OR d.name_srv LIKE '%{search}%'
    OR d.dns_a LIKE '%{search}%'
    OR d.website LIKE '%{search}%')
ORDER BY d.domain ASC
LIMIT {limit};
