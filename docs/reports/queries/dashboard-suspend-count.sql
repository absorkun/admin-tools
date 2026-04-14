-- Dashboard: hitung domain berstatus suspend (case-insensitive)
SELECT COUNT(*) AS suspend
FROM dns_server
WHERE LOWER(COALESCE(status, '')) = 'suspend';
