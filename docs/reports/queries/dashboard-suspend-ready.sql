-- Dashboard: hitung domain siap suspend (expired 14+ hari sejak email terakhir, belum suspend)
SELECT COUNT(*) AS suspend_ready
FROM dns_server
WHERE tgl_exp IS NOT NULL
  AND DATE(tgl_exp) < CURDATE()
  AND tgl_email IS NOT NULL
  AND DATE(tgl_email) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
  AND (status IS NULL OR LOWER(status) != 'suspend');
