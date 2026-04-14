-- Dashboard: hitung email log yang terkirim hari ini
SELECT COUNT(*) AS email_log_today
FROM email_log_expired
WHERE DATE(tanggal) = CURDATE();
