-- Dashboard: hitung domain yang sudah expired (tgl_exp < hari ini)
SELECT COUNT(*) AS expired
FROM dns_server
WHERE tgl_exp IS NOT NULL
  AND DATE(tgl_exp) < CURDATE();
