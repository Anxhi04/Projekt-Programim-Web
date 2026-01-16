USE reservation_platform;


INSERT INTO businesses (manager_user_id, name, description, address, phone, status)
SELECT id, 'Salon Demo', 'Demo business', 'Tirane', '0000000', 'active'
FROM users
WHERE email = 'manager@demo.com';

UPDATE businesses b
SET b.name = 'Luxe Hair Studio'
WHERE b.manager_user_id = (
    SELECT u.id
    FROM users u
    WHERE u.email = 'manager@demo.com'
);
