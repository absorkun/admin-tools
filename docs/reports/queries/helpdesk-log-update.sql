-- Helpdesk Log: update status dan catatan admin
UPDATE helpdesk_log
SET status = '{status}',
    catatan_admin = '{catatan_admin}',
    updated_at = NOW()
WHERE helpdesk_log_id = {id};
