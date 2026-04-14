-- Helpdesk Log: simpan laporan baru
INSERT INTO helpdesk_log (domain, pelapor_nama, pelapor_email, pelapor_phone, sumber, isi_laporan, status, users_id, created_at, updated_at)
VALUES ('{domain}', '{pelapor_nama}', '{pelapor_email}', '{pelapor_phone}', '{sumber}', '{isi_laporan}', 'baru', {users_id}, NOW(), NOW());
