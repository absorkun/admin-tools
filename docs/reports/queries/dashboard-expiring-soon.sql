-- Dashboard: hitung domain yang akan expired dalam 30 hari ke depan
SELECT COUNT(*) AS expiring_soon
FROM dns_server
WHERE tgl_exp IS NOT NULL
  AND tgl_exp BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY);
