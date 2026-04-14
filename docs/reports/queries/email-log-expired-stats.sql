-- Email Log Expired stats: hitung total, ok, total hari ini, ok hari ini
SELECT
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'Ok' THEN 1 ELSE 0 END) AS ok,
    SUM(CASE WHEN DATE(tanggal) = CURDATE() THEN 1 ELSE 0 END) AS total_today,
    SUM(CASE WHEN status = 'Ok' AND DATE(tanggal) = CURDATE() THEN 1 ELSE 0 END) AS ok_today
FROM email_log_expired;
