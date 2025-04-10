CREATE PROCEDURE spUpdateReservation(
    IN reservation_id INT,
    IN ally_number INT,
    IN number_of_persons INT,
    IN reservation_date DATE,
    IN isactive BOOLEAN,
    IN note TEXT
)
BEGIN
    UPDATE reservations
    SET
        ally_number = ally_number,
        number_of_persons = number_of_persons,
        reservation_date = reservation_date,
        isactive = isactive,
        note = note,
        updated_at = NOW()
    WHERE id = reservation_id;
END;
