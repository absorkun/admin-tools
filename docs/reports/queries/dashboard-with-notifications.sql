-- Dashboard: hitung domain yang jumlah_notif lebih dari 0
SELECT COUNT(*) AS with_notifications
FROM dns_server
WHERE jumlah_notif > 0;
