-- Dashboard: hitung domain yang sudah pernah dikirim email (tgl_email terisi)
SELECT COUNT(*) AS with_email
FROM dns_server
WHERE tgl_email IS NOT NULL;
