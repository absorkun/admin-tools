-- DNS Server stats: hitung total, active, expired, suspend
SELECT
    COUNT(*) AS total,
    SUM(CASE WHEN LOWER(COALESCE(status, '')) = 'active' THEN 1 ELSE 0 END) AS active,
    SUM(CASE WHEN tgl_exp IS NOT NULL AND DATE(tgl_exp) < CURDATE() THEN 1 ELSE 0 END) AS expired,
    SUM(CASE WHEN LOWER(COALESCE(status, '')) = 'suspend' THEN 1 ELSE 0 END) AS suspend
FROM dns_server;
