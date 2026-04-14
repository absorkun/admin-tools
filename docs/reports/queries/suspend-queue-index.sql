-- Suspend Queue: ambil domain yang siap suspend
-- Syarat: expired, sudah dikirim email 14+ hari lalu, bukan suspend, ada email log
SELECT d.domain, d.users_id, d.status, d.tgl_exp, d.tgl_email, d.jumlah_notif
FROM dns_server d
WHERE d.tgl_exp IS NOT NULL
  AND DATE(d.tgl_exp) < CURDATE()
  AND d.tgl_email IS NOT NULL
  AND DATE(d.tgl_email) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
  AND (d.status IS NULL OR LOWER(COALESCE(d.status, '')) <> 'suspend')
  AND EXISTS (SELECT 1 FROM email_log_expired el WHERE el.domain = d.domain)
  AND (d.domain LIKE '%{search}%' OR d.status LIKE '%{search}%')
ORDER BY d.tgl_exp ASC, d.domain ASC
LIMIT {limit};
