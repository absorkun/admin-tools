-- Email Log Expired: ambil daftar log dengan filter search, periode, dan limit
-- Search cocokkan ke domain, email, status
-- Periode: today, 7_days, atau custom (date_from / date_to)
SELECT el.email_log_id, el.domain, el.email, el.tanggal, el.tgl_exp, el.selisih, el.status
FROM email_log_expired el
WHERE (el.domain LIKE '%{search}%'
    OR el.email LIKE '%{search}%'
    OR el.status LIKE '%{search}%')
  AND DATE(el.tanggal) = CURDATE()  -- contoh: periode today
ORDER BY el.email_log_id DESC
LIMIT {limit};
