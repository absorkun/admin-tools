-- Dashboard: ambil 5 domain baru expired, urutkan dari yang paling baru
SELECT d.domain, d.users_id, d.status, d.tgl_exp, u.name AS user_name
FROM dns_server d
LEFT JOIN users u ON u.id = d.users_id
WHERE d.tgl_exp IS NOT NULL
  AND DATE(d.tgl_exp) < CURDATE()
ORDER BY d.tgl_exp DESC
LIMIT 5;
