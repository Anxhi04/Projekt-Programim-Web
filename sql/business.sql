USE reservation_platform;


INSERT INTO businesses (manager_user_id, name, description, address, phone, status)
SELECT id, 'Salon Demo', 'Demo business', 'Tirane', '0000000', 'active'
FROM users
WHERE email = 'manager@demo.com';
