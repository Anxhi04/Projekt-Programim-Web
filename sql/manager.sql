USE reservation_platform;

INSERT INTO users (firstname, lastname,  email, password_hash, role, is_active)
VALUES ('Manager','demo', 'manager@demo.com', 'x', 'manager', 1);
