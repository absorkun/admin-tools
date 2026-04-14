-- Dashboard: hitung domain dengan status active (case-insensitive)
SELECT COUNT(*) AS active
FROM dns_server
WHERE LOWER(COALESCE(status, '')) = 'active';
