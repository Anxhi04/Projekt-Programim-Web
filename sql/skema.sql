
CREATE DATABASE IF NOT EXISTS reservation_platform
 DEFAULT CHARACTER SET utf8mb4
 DEFAULT COLLATE utf8mb4_unicode_ci;

USE reservation_platform;
# SET FOREIGN_KEY_CHECKS = 0;
#
# DROP TABLE IF EXISTS third_party_logs;
# DROP TABLE IF EXISTS payments;
# DROP TABLE IF EXISTS activity_logs;
# DROP TABLE IF EXISTS password_resets;
# DROP TABLE IF EXISTS remember_tokens;
# DROP TABLE IF EXISTS login_attempts;
# DROP TABLE IF EXISTS reservations;
# DROP TABLE IF EXISTS service_schedule_slots;
# DROP TABLE IF EXISTS services;
# DROP TABLE IF EXISTS businesses;
# DROP TABLE IF EXISTS users;
# SET FOREIGN_KEY_CHECKS = 1;

-- 1) USERS
CREATE TABLE IF NOT EXISTS users (
                       id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                       firstname            VARCHAR(100) NOT NULL,
                       lastname        varchar(100) Not NULL ,
                       email           VARCHAR(190) NOT NULL,
                       password_hash   VARCHAR(255) NOT NULL,
                       email_code      varchar(20),
                       code_date       datetime,
                       email_token     varchar(255),
                       token_date      datetime,
                       email_verified  varchar(5),
                       email_verified_at datetime,
                       role            ENUM('user','employee','manager','admin') NOT NULL DEFAULT 'user',
                       is_active       TINYINT(1) NOT NULL DEFAULT 1,

    -- For lock after failed logins (7 attempts -> locked for 30 minutes)
                       locked_until    DATETIME NULL,
                       created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                       UNIQUE KEY uq_users_email (email),
                       KEY idx_users_role (role),
                       KEY idx_users_active (is_active)
) ENGINE=InnoDB;

-- 2) BUSINESSES
-- At the moment we will be having only one bussnees but this is nedeed in case we decide to add other bussnesses
CREATE TABLE  IF NOT EXISTS businesses (
                            id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            manager_user_id  INT UNSIGNED NOT NULL,
                            name             VARCHAR(150) NOT NULL,
                            description      TEXT NULL,
                            address          VARCHAR(255) NULL,
                            phone            VARCHAR(50) NULL,
                            status           ENUM('active','blocked') NOT NULL DEFAULT 'active',

                            created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                            CONSTRAINT fk_business_manager
                                FOREIGN KEY (manager_user_id) REFERENCES users(id)
                                    ON UPDATE CASCADE
                                    ON DELETE RESTRICT,

                            KEY idx_business_status (status),
                            KEY idx_business_manager (manager_user_id)
) ENGINE=InnoDB;

-- 3) SERVICES
CREATE TABLE IF NOT EXISTS services (
                          id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          business_id      INT UNSIGNED NOT NULL,
                          employee_user_id INT UNSIGNED NOT NULL,

                          name             VARCHAR(150) NOT NULL,
                          category         VARCHAR(50),
                          description      TEXT NULL,
                          duration_minutes SMALLINT UNSIGNED NOT NULL,
                          price            DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                          is_active        TINYINT(1) NOT NULL DEFAULT 1,

                          created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                          CONSTRAINT fk_services_business
                              FOREIGN KEY (business_id) REFERENCES businesses(id)
                                  ON UPDATE CASCADE
                                  ON DELETE RESTRICT,

                          CONSTRAINT fk_services_employee_user
                              FOREIGN KEY (employee_user_id) REFERENCES users(id)
                                  ON UPDATE CASCADE
                                  ON DELETE RESTRICT,

    -- One employee can be assigned to only one service:
                          UNIQUE KEY uq_services_employee (employee_user_id),

                          KEY idx_services_business (business_id),
                          KEY idx_services_active (is_active)
) ENGINE=InnoDB;

-- 4) SERVICE SCHEDULE SLOTS
CREATE TABLE IF NOT EXISTS service_schedule_slots (
                                        id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                        service_id  INT UNSIGNED NOT NULL,

                                        date        DATE NOT NULL,
                                        start_time  TIME NOT NULL,
                                        end_time    TIME NOT NULL,
                                        status      ENUM('free','booked') NOT NULL DEFAULT 'free',

                                        created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                                        CONSTRAINT fk_slots_service
                                            FOREIGN KEY (service_id) REFERENCES services(id)
                                                ON UPDATE CASCADE
                                                ON DELETE CASCADE,

    -- Prevent duplicate same slot for the same service
                                        UNIQUE KEY uq_service_slot (service_id, date, start_time),

                                        KEY idx_slots_service_date (service_id, date),
                                        KEY idx_slots_status (status)
) ENGINE=InnoDB;

-- 5) RESERVATIONS
CREATE TABLE IF NOT EXISTS reservations (
                              id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                              client_user_id  INT UNSIGNED NOT NULL,
                              service_id      INT UNSIGNED NOT NULL,
                              date            datetime,
                              start_time       time,

                              status          ENUM('pending','confirmed','canceled') NOT NULL DEFAULT 'pending',
                              created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                              CONSTRAINT fk_res_client
                                  FOREIGN KEY (client_user_id) REFERENCES users(id)
                                      ON UPDATE CASCADE
                                      ON DELETE RESTRICT,

                              CONSTRAINT fk_res_service
                                  FOREIGN KEY (service_id) REFERENCES services(id)
                                      ON UPDATE CASCADE
                                      ON DELETE RESTRICT,

                              KEY idx_res_client (client_user_id),
                              KEY idx_res_service (service_id),
                              KEY idx_res_status (status),
                              KEY idx_res_created (created_at)
) ENGINE=InnoDB;

-- 6) LOGIN ATTEMPTS
CREATE TABLE IF NOT EXISTS login_attempts (
                                id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                user_id       INT UNSIGNED NULL,          -- nullable if email doesn't exist
                                email_entered VARCHAR(190) NOT NULL,
                                ip_address    VARCHAR(45) NULL,
                                success       TINYINT(1) NOT NULL DEFAULT 0,
                                attempt_time  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                                CONSTRAINT fk_login_attempts_user
                                    FOREIGN KEY (user_id) REFERENCES users(id)
                                        ON UPDATE CASCADE
                                        ON DELETE SET NULL,

                                KEY idx_login_attempts_user_time (user_id, attempt_time),
                                KEY idx_login_attempts_email_time (email_entered, attempt_time),
                                KEY idx_login_attempts_ip_time (ip_address, attempt_time)
) ENGINE=InnoDB;

-- 7) REMEMBER TOKENS
CREATE TABLE IF NOT EXISTS remember_tokens (
                                 id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                 user_id     INT UNSIGNED NOT NULL,
                                 token_hash  VARCHAR(255) NOT NULL,
                                 expires_at  DATETIME NOT NULL,
                                 created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                 revoked_at  DATETIME NULL,

                                 CONSTRAINT fk_remember_user
                                     FOREIGN KEY (user_id) REFERENCES users(id)
                                         ON UPDATE CASCADE
                                         ON DELETE CASCADE,

                                 KEY idx_remember_user_expires (user_id, expires_at)
) ENGINE=InnoDB;

-- 8) PASSWORD RESETS
CREATE TABLE IF NOT EXISTS password_resets (
                                 id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                 user_id          INT UNSIGNED NOT NULL,
                                 reset_token_hash VARCHAR(255) NOT NULL,
                                 expires_at       DATETIME NOT NULL,
                                 used_at          DATETIME NULL,
                                 created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                                 CONSTRAINT fk_pwreset_user
                                     FOREIGN KEY (user_id) REFERENCES users(id)
                                         ON UPDATE CASCADE
                                         ON DELETE CASCADE,

                                 KEY idx_pwreset_user_expires (user_id, expires_at)
) ENGINE=InnoDB;

-- 9) ACTIVITY LOGS
CREATE TABLE IF NOT EXISTS activity_logs (
                               id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                               user_id     INT UNSIGNED NULL,
                               action      VARCHAR(80) NOT NULL,       -- e.g. LOGIN_SUCCESS, LOGIN_LOCKED, CREATE_RESERVATION
                               entity      VARCHAR(50) NULL,           -- users/reservations/payments/...
                               ip_address  VARCHAR(45) NULL,
                               created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                               CONSTRAINT fk_activity_user
                                   FOREIGN KEY (user_id) REFERENCES users(id)
                                       ON UPDATE CASCADE
                                       ON DELETE SET NULL,

                               KEY idx_activity_user_time (user_id, created_at),
                               KEY idx_activity_entity (entity),
                               KEY idx_activity_action_time (action, created_at)
) ENGINE=InnoDB;

-- 10) PAYMENTS
CREATE TABLE IF NOT EXISTS payments (
                          id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          reservation_id          INT UNSIGNED NOT NULL,
                          provider                ENUM('stripe','paypal') NOT NULL,
                          amount                  DECIMAL(10,2) NOT NULL,
                          currency                CHAR(3) NOT NULL DEFAULT 'EUR',
                          status                  ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
                          provider_transaction_id VARCHAR(120) NULL,
                          created_at              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                          CONSTRAINT fk_payments_reservation
                              FOREIGN KEY (reservation_id) REFERENCES reservations(id)
                                  ON UPDATE CASCADE
                                  ON DELETE CASCADE,

                          UNIQUE KEY uq_payment_reservation (reservation_id),
                          KEY idx_payment_status (status),
                          KEY idx_payment_provider (provider)
) ENGINE=InnoDB;

-- 11) THIRD PARTY LOGS
CREATE TABLE IF NOT EXISTS third_party_logs (
                                  id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                  provider         ENUM('stripe','paypal') NOT NULL,
                                  payment_id       INT UNSIGNED NULL,
                                  request_payload  JSON NULL,
                                  response_payload JSON NULL,
                                  status_code      INT NULL,
                                  created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                                  CONSTRAINT fk_tpl_payment
                                      FOREIGN KEY (payment_id) REFERENCES payments(id)
                                          ON UPDATE CASCADE
                                          ON DELETE SET NULL,

                                  KEY idx_tpl_provider_time (provider, created_at),
                                  KEY idx_tpl_payment (payment_id)
) ENGINE=InnoDB;


