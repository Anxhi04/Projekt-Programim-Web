USE reservation_platform;

INSERT INTO users (name, email, password_hash, role, is_active)
VALUES ('Manager', 'manager@demo.com', 'x', 'manager', 1);
