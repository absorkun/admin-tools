-- Dashboard: ambil 5 domain yang akan segera expired (30 hari ke depan)
SELECT d.domain, d.users_id, d.tgl_exp, u.name AS user_name
FROM dns_server d
LEFT JOIN users u ON u.id = d.users_id
WHERE d.tgl_exp IS NOT NULL
  AND d.tgl_exp BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
ORDER BY d.tgl_exp ASC
LIMIT 5;
