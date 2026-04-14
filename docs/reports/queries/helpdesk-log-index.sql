-- Helpdesk Log: ambil daftar laporan dengan filter search, status, dan limit
-- Search cocokkan ke domain, pelapor_nama, pelapor_email, isi_laporan
SELECT hl.helpdesk_log_id, hl.domain, hl.pelapor_nama, hl.pelapor_email,
       hl.sumber, hl.isi_laporan, hl.status, hl.users_id, hl.created_at,
       u.name AS admin_name
FROM helpdesk_log hl
LEFT JOIN users u ON u.id = hl.users_id
WHERE (hl.domain LIKE '%{search}%'
    OR hl.pelapor_nama LIKE '%{search}%'
    OR hl.pelapor_email LIKE '%{search}%'
    OR hl.isi_laporan LIKE '%{search}%')
  AND hl.status = '{status}'  -- opsional: baru / proses / selesai
ORDER BY hl.created_at DESC
LIMIT {limit};
