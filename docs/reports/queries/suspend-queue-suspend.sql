-- Suspend Queue: tandai domain sebagai suspend
-- Hanya bisa jika domain memenuhi syarat suspend queue
UPDATE dns_server
SET status = 'suspend'
WHERE domain = '{domain}'
  AND tgl_exp IS NOT NULL
  AND DATE(tgl_exp) < CURDATE()
  AND tgl_email IS NOT NULL
  AND DATE(tgl_email) <= DATE_SUB(CURDATE(), INTERVAL 14 DAY);
