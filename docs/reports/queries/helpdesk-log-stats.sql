-- Helpdesk Log stats: hitung total, baru, proses, selesai
SELECT
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'baru' THEN 1 ELSE 0 END) AS baru,
    SUM(CASE WHEN status = 'proses' THEN 1 ELSE 0 END) AS proses,
    SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) AS selesai
FROM helpdesk_log;
