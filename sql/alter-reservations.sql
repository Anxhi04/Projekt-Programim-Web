ALTER TABLE reservations
    DROP FOREIGN KEY fk_res_slot;

ALTER TABLE reservations
    DROP INDEX uq_reservation_slot;

ALTER TABLE reservations
    DROP COLUMN slot_id,
    ADD COLUMN date DATE NOT NULL AFTER service_id,
    ADD COLUMN start_time TIME NOT NULL AFTER date;
